<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CourseSection;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Program;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class SectionCrud extends Component
{
    use WithPagination;

    











































//     public function render()
//     {
//         // Paginate CourseSection with filters and search
//         $sections = CourseSection::query()
//             // Join
//             ->leftJoin('courses', 'course_sections.course_id', '=', 'courses.course_id')
//             ->leftJoin('programs', 'course_sections.program_id', '=', 'programs.program_id')
//             ->leftJoin('faculties', 'course_sections.faculty_id', '=', 'faculties.faculty_id')
            
//             // Select specific columns
//             ->select(
//                 'course_sections.*',
//                 'courses.course_name as course_name',
//                 'programs.program_name as program_name',
//                 DB::raw("CONCAT(faculties.first_name, ' ', faculties.last_name) as faculty_name")
//             )

//             ->when($this->search, function ($query) {
//                 $query->where('course_sections.section', 'like', '%' . $this->search . '%');
//             })
//             // Apply course filter
//             ->when($this->selectedCourse, function ($query) {
//                 $query->where('courses.course_id', $this->selectedCourse);
//             })
//             // Apply program filter
//             ->when($this->selectedProgram, function ($query) {
//                 $query->where('programs.program_id', $this->selectedProgram);
//             })
//             // Apply faculty filter
//             ->when($this->selectedFaculty, function ($query) {
//                 $query->where('faculties.faculty_id', $this->selectedFaculty);
//             })
//             // Apply sorting
//             ->orderByRaw("faculty_name IS NULL, $this->sortField $this->sortDirection")
//             // Pagination
//             ->paginate(12);
    
//         return view('livewire.section-crud', compact('sections'));
//     }
    
//     public $course_section_id, $course_id, $program_id, $faculty_id, $section;
//     public $showDeleteConfirmation = false;
//     public $showEditForm = false, $showEditConfirmation = false;
//     public $showAddForm = false, $showAddConfirmation = false;
//     public $search = null, $deleteId, $selectedCourse = null, $selectedProgram = null, $selectedFaculty = null;
//     public $sortField = 'created_at', $sortDirection = 'asc';

//     protected $listeners = [
//         'courseSelected' => 'courseSearch',
//         'facultySelected' => 'facultySearch',
//         'programSelected' => 'programSearch',
//         'searchPerformed' => 'searchPerformed'
//     ];

//     protected $rules = [
//         'section' => 'required|string|max:10',
//         'faculty_id' => 'nullable|exists:faculties,faculty_id',  
//         'program_id' => 'required|exists:programs,program_id',  
//         'course_id' => 'required|exists:courses,course_id',
//     ];
    

//     public function searchPerformed($searchTerm)
//     {
//         $this->search = $searchTerm;
//         $this->resetPage();
//     }

//     public function courseSearch($courseId)
//     {
//         $this->selectedCourse = $courseId;
//         $this->resetPage();
//     }

//     public function programSearch($programId)
//     {
//         $this->selectedProgram = $programId;
//         $this->resetPage();
//     }

//     public function facultySearch($facultyId)
//     {
//         $this->selectedFaculty = $facultyId;
//         $this->resetPage();
//     }

//     public function sortBy($field)
//     {
//         $this->sortField = $this->sortField === $field ? $this->sortField : $field;
//         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
//     }

//     public function clearFilters()
//     {
//         $this->search = '';
//         $this->selectedCourse = '';
//         $this->selectedProgram = '';
//         $this->selectedFaculty = '';
//         $this->resetPage();
//         $this->dispatch('clearFilters');
//     }

//     public function getCourses()
//     {
//         return Course::orderBy('course_name', 'asc')->get();
//     }

//     public function getPrograms()
//     {
//         return Program::orderBy('program_name', 'asc')->get();
//     }

//     public function getFaculties()
//     {
//         return Faculty::orderBy('first_name', 'asc')->get();
//     }

//     public function getDepartments()
//     {
//         return Department::all();
//     }

//     public function clearMessage()
//     {
//         session()->forget(['success', 'error', 'info', 'deleted']);
//     }








//     public function edit($id)
//     {
//         $this->resetErrorBag(); 
//         try {
//             $courseSection = CourseSection::findOrFail($id);

//             $this->course_section_id = $courseSection->course_section_id;
//             $this->section = $courseSection->section;
//             $this->faculty_id = $courseSection->faculty_id;
//             $this->course_id = $courseSection->course_id;
//             $this->program_id = $courseSection->program_id;

//             $this->showEditForm = true;
//         } catch (ModelNotFoundException $e) {
//             $this->logSystemError('Course section not found', $e);
//         } catch (Exception $e) {
//             $this->logSystemError('Failed to load course section', $e);
//         }
//     }

//     public function updateConfirmation()
//     {
//         if (!$this->isUpdated()) {
//             session()->flash('info', 'No changes were made to the course section.');
//             $this->showEditForm = false;
//             $this->showEditConfirmation = false;
//             return;
//         }

//         $this->showEditForm = false;
//         $this->showEditConfirmation = true;
//     }

//     private function isUpdated()
//     {
//         $courseSection = CourseSection::find($this->course_section_id);
//         return $courseSection && (
//             $courseSection->faculty_id !== $this->faculty_id ||
//             $courseSection->section !== $this->section 
//         );
//     }

//     public function confirmUpdate()
//     {
//         $this->update();
//         $this->closeEdit();
//     }

//     public function cancelUpdate()
//     {
//         $this->showEditConfirmation = false;
//         $this->showEditForm = true;
//         $this->resetErrorBag();
//     }

//     public function update()
//     {
//         try {
//             if (!$this->isUpdated()) {
//                 session()->flash('info', 'No changes were made to the course section.');
//                 return;
//             }

//             $this->validateQueryEdit();
//         } catch (Exception $e) {
//             $this->logSystemError('An error occurred while updating the course section.', $e);
//         } finally {
//             $this->resetInputFields();
//         }
//     }

//     public function validateQueryEdit()
//     {
//         $courseSection = $this->editCourseSection();
        
//         try {
//             $this->validate($this->rules);

//             $courseSection->save();

//             return $this->logEdit('Course section successfully updated!', $courseSection, 200);
//         } catch (ValidationException $e) {
//             return $this->logEditError('Invalid inputs!' . $e, $courseSection, 422);
//         } catch (QueryException $e) {
//             if ($e->errorInfo[1] == 1062) {
//                 return $this->logEditError('Course section already exists!', $courseSection, 400);
//             }
//             return $this->logEditError('Database error: ' . $e->getMessage(), $courseSection, 500);
//         }
//     }

//     private function editCourseSection()
//     {
//         $courseSection = CourseSection::find($this->course_section_id);
    
//         if (!$courseSection) {
//             throw new ModelNotFoundException('Course section not found!');
//         }
    
//         $this->oldValues = $courseSection->getOriginal();
    
//         $courseSection->faculty_id = ($this->faculty_id === '' || $this->faculty_id === 'null') ? NULL : $this->faculty_id;
    
//         $courseSection->section = $this->section;
    
//         $courseSection->save();
    
//         return $courseSection;
//     }    

//     private function logEdit($message, $courseSection, $statusCode)
//     {
//         session()->flash('success', $message);

//         $changes = $this->compareChanges($this->oldValues, $courseSection->getAttributes());

//         activity()
//             ->performedOn($courseSection)
//             ->causedBy(auth()->user())
//             ->withProperties([
//                 'status' => 'success',
//                 'course_section_id' => $this->course_section_id,
//                 'status_code' => $statusCode,
//                 'changes' => $changes,
//             ])
//             ->event('Edit')
//             ->log($message);
//     }

//     private function compareChanges($oldValues, $newValues)
//     {
//         $changes = [];

//         foreach ($oldValues as $key => $oldValue) {
//             if (array_key_exists($key, $newValues) && $oldValue !== $newValues[$key]) {
//                 $changes[$key] = [
//                     'old' => $oldValue,
//                     'new' => $newValues[$key]
//                 ];
//             }
//         }

//         return $changes;
//     }

//     private function logEditError($message, $courseSection, $statusCode)
//     {
//         session()->flash('error', $message);

//         activity()
//             ->performedOn($courseSection)
//             ->causedBy(auth()->user())
//             ->withProperties([
//                 'status' => 'error',
//                 'course_section_id' => $this->course_section_id,
//                 'status_code' => $statusCode,
//             ])
//             ->event('Failed Edit')
//             ->log($message);
//     }

//     public function closeEdit()
//     {
//         $this->showEditForm = false;
//         $this->showEditConfirmation = false;
//         $this->resetErrorBag();
//     }





//     public function delete($id)
// {
//     $this->deleteId = $id;
//     $this->showDeleteConfirmation = true;
// }

// public function confirmDelete()
// {
//     $this->remove();
//     $this->resetDeleteState();
// }

// public function cancelDelete()
// {
//     $this->resetDeleteState();
// }

// private function resetDeleteState()
// {
//     $this->showDeleteConfirmation = false;
//     $this->deleteId = null;
// }

// public function remove()
// {
//     try {
//         $this->validateQueryRemove();
//     } catch (Exception $e) {
//         $this->logSystemError('An error occurred while deleting the section.', $e);
//     } finally {
//         session()->forget('deleteId');
//     }
// }

// public function validateQueryRemove()
// {
//     try {
//         $section = CourseSection::find($this->deleteId);

//         if (!$section) {
//             return $this->logRemoveError('Section not found!', $section, 404);
//         }

//         if ($section->faculty_id) {
//             return $this->logRemoveError('Cannot delete the section as it is currently being taught by a faculty member.', $section, 400);
//         }

//         if ($section->students()->exists()) {
//             return $this->logRemoveError('Cannot delete the section as students are enrolled in it.', $section, 400);
//         }

//         $this->deleteSection($section);

//     } catch (QueryException $e) {
//         return $this->logRemoveError('Database error: ' . $e->getMessage(), $section, 500);
//     }
// }

// private function deleteSection($section)
// {
//     $section->delete();

//     return $this->logRemove('Section successfully deleted!', $section, 200);
// }

// private function logRemove($message, $section, $statusCode)
// {
//     session()->put('deleted_record_id', $this->deleteId);
//     session()->flash('deleted', $message);

//     activity()
//         ->performedOn($section)
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'status' => 'success',
//             'section' => $section->section,
//             'status_code' => $statusCode,
//         ])
//         ->event('Section Removed')
//         ->log($message);
// }

// private function logRemoveError($message, $section, $statusCode)
// {
//     session()->flash('error', $message);

//     activity()
//         ->performedOn($section)
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'status' => 'error',
//             'section' => $section->section,
//             'status_code' => $statusCode,
//         ])
//         ->event('Failed to Remove Section')
//         ->log($message);
// }






// public function undoDelete()
// {
//     $sectionId = session()->get('deleted_record_id');

//     if ($sectionId) {
//         try {
//             $section = CourseSection::withTrashed()->findOrFail($sectionId);
//             $this->checkIfRestored($section);
//         } catch (ModelNotFoundException $e) {
//             $this->logSystemError('Section not found for restoration!', $e);
//         } catch (Exception $e) {
//             $this->logSystemError('Failed to restore section', $e);
//         }
//     } else {
//         session()->flash('error', 'No section available to restore!');
//     }
// }

// private function checkIfRestored($section)
// {
//     if (!$section->trashed()) {
//         $this->logRestorationError('Section is already active', $section);
//         return;
//     } else {
//         $this->restoreSection($section);
//     }
// }

// private function restoreSection($section)
// {
//     try {
//         $section->restore();
//         session()->forget('deleted_record_id');
//         $this->logRestoration('Section successfully restored!', $section, 200);
//     } catch (Exception $e) {
//         $this->logRestorationError('Failed to restore section', $section, 500);
//     }
// }

// private function logRestoration($message, $section, $statusCode)
// {
//     session()->flash('success', $message);

//     activity()
//         ->performedOn($section)
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'status' => 'success',
//             'section' => $section->section,
//             'status_code' => $statusCode,
//         ])
//         ->event('Restore')
//         ->log('Section restored');
// }

// private function logRestorationError($message, $section, $statusCode)
// {
//     session()->flash('error', $message);

//     activity()
//         ->performedOn($section)
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'status' => 'error',
//             'section' => $section->section,
//             'status_code' => $statusCode,
//         ])
//         ->event('Restore')
//         ->log('Failed to restore section');
// }













// public function add()
// {
//     $this->resetErrorBag();
//     $this->resetInputFields();
//     $this->showAddForm = true;
// }

// public function store()
// {
//     try {
//         $this->validateQueryStore();
//     } catch (Exception $e) {
//         $this->logSystemError('An error occurred while storing the section.', $e);
//     } finally {
//         $this->resetInputFields();
//     }
// }

// public function storeConfirmation() 
// {
//     if ($this->isPopulated()) {
//         $this->showAddForm = false;
//         $this->showAddConfirmation = true;
//     } else {
//         session()->flash('info', 'Please fill in all required fields before proceeding.');
//         $this->showAddForm = false;
//     }
// }

// public function isPopulated()
// {
//     return !empty($this->section) ||
//         !empty($this->course_id) ||
//         !empty($this->program_id);
// }

// public function confirmStore() 
// {
//     $this->store();
//     $this->showAddConfirmation = false;
//     $this->showAddForm = false;
//     $this->resetInputFields();
// }

// public function cancelStore() 
// {
//     $this->showAddConfirmation = false;
//     $this->showAddForm = true;
//     $this->resetErrorBag();
// }

// public function validateQueryStore() 
// {
//     $section = new CourseSection([
//         'section' => $this->section,
//         'course_id' => $this->course_id,
//         'faculty_id' => $this->faculty_id,
//         'program_id' => $this->program_id,
//     ]);

//     try {
//         $this->validate($this->rules);

//         $existingSection = CourseSection::where('section', $this->section)
//             ->where('course_id', $this->course_id)
//             ->first();

//         if ($existingSection) {
//             return $this->logAddError('Section already exists!', $section, 409);
//         }

//         $section = $this->createSection();

//         return $this->logAdd('Section successfully added!', $section, 201);

//     } catch (ValidationException $e) {
//         return $this->logAddError('Invalid inputs!', $section, 422);

//     } catch (QueryException $e) {
//         if ($e->errorInfo[1] == 1062) {
//             return $this->logAddError('Section code or name already exists!', $section, 400);
//         }

//         return $this->logAddError('Database error: ' . $e->getMessage(), $section, 500);
//     }
// }

// private function createSection()
// {
//     return CourseSection::create([
//         'section' => $this->section,
//         'course_id' => $this->course_id,
//         'faculty_id' => $this->faculty_id,
//         'program_id' => $this->program_id,
//     ]);
// }

// private function logAdd($message, $section, $statusCode)
// {
//     session()->flash('success', $message);

//     activity()
//         ->performedOn($section)
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'status' => 'success',
//             'section' => $this->section,
//             'status_code' => $statusCode,
//         ])
//         ->event('Section Created')
//         ->log($message);
// }

// private function logAddError($message, $statusCode)
// {
//     session()->flash('error', $message);

//     activity()
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'status' => 'error',
//             'status_code' => $statusCode,
//         ])
//         ->event('Failed to Add Section')
//         ->log($message);
// }

// public function closeAdd() 
// {
//     $this->showAddForm = false;
//     $this->showAddConfirmation = false;
//     $this->resetInputFields();
//     $this->resetErrorBag();
// }

// private function logSystemError($message, Exception $e)
// {
//     $errorMessage = $e->getMessage();
//     $errorCode = $e->getCode();
//     $errorTrace = $e->getTraceAsString();

//     session()->flash('error', $message);

//     activity()
//         ->causedBy(auth()->user())
//         ->withProperties([
//             'error_message' => $errorMessage,
//             'error_code' => $errorCode,
//             'error_stack' => $errorTrace,
//             'status' => 'error',
//         ])
//         ->event('System Error')
//         ->log($message);

//     \Log::error($message, [
//         'exception' => [
//             'message' => $errorMessage,
//             'code' => $errorCode,
//             'trace' => $errorTrace
//         ]
//     ]);
// }

// private function resetInputFields()
// {
//     $this->reset(['faculty_id', 'section', 'course_id', 'program_id']);
// }
}