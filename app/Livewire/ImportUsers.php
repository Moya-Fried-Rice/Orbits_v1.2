<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Student;
use App\Models\Faculty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\Welcome;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportUsers extends Component
{
    use WithFileUploads;

    public $showImportForm = false;
    public $showImportConfirmation = false;
    public $file;
    public $userType; // 'student' or 'faculty'

    protected $rules = [
        'file' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        'userType' => 'required|in:student,faculty'
    ];

    public function mount($userType)
    {
        $this->userType = $userType;
    }

    public function render()
    {
        return view('livewire.import-users');
    }

    public function import()
    {
        $this->resetErrorBag();
        $this->clearMessage();
        $this->showImportForm = true;
    }

    public function importConfirmation()
    {
        $this->validate();
        $this->showImportForm = false;
        $this->showImportConfirmation = true;
    }

    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    public function confirmImport()
    {
        try {
            DB::beginTransaction();

            $spreadsheet = IOFactory::load($this->file->path());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            if (empty($rows)) {
                throw new \Exception('File is empty');
            }

            // Remove header row
            array_shift($rows);
            
            $importCount = 0;
            foreach ($rows as $row) {
                if (empty($row[0])) continue; // Skip empty rows
                
                $password = 'LPUeval_' . Str::random(8);
                
                $user = User::create([
                    'first_name' => $row[0],
                    'last_name' => $row[1],
                    'email' => $row[2],
                    'password' => Hash::make($password),
                    'phone_number' => $row[3] ?? null,
                    'profile_image' => 'default_images/default_profile.png',
                    'role_id' => $this->userType === 'student' ? 1 : 2,
                ]);

                // Create the specific user type record
                if ($this->userType === 'student') {
                    Student::create([
                        'user_id' => $user->user_id,
                        'program_id' => $row[4],
                    ]);
                } else {
                    Faculty::create([
                        'user_id' => $user->user_id,
                        'department_id' => $row[4],
                    ]);
                }

                // mailer off temporarily for testing
                // Mail::to($user->email)->send(new Welcome($user, $password));
                $importCount++;
            }

            DB::commit();

            $message = ucfirst($this->userType) . 's imported successfully! (' . $importCount . ' records)';
            $this->logImport($message, $importCount, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            $message = 'Error importing ' . $this->userType . 's: ' . $e->getMessage();
            $this->logImportError($message, $e, 500);
        }

        $this->closeImport();
        $this->dispatch('users-imported');
    }

    public function cancelImport()
    {
        $this->showImportConfirmation = false;
        $this->showImportForm = true;
        $this->resetErrorBag();
    }

    public function closeImport()
    {
        $this->showImportForm = false;
        $this->showImportConfirmation = false;
        $this->file = null;
        $this->resetErrorBag();
    }

    private function logImport($message, $count, $statusCode)
    {
        session()->flash('success', $message);

        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'records_imported' => $count,
                'user_type' => $this->userType,
                'status_code' => $statusCode,
            ])
            ->event(ucfirst($this->userType) . 's Imported')
            ->log($message);
    }

    private function logImportError($message, \Exception $e, $statusCode)
    {
        session()->flash('error', $message);

        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_stack' => $e->getTraceAsString(),
                'user_type' => $this->userType,
                'status' => 'error',
                'status_code' => $statusCode,
            ])
            ->event('Import ' . ucfirst($this->userType) . 's Failed')
            ->log($message);
    }
}
