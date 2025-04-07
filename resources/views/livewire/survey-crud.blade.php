<div class="bg-gray-50">

    <x-system-notification />

    <div class="font-TT p-6 flex flex-wrap justify-center md:justify-start gap-6 items-center">

        @if($surveys->isEmpty())
            <div class="text-gray-500 font-silka text-lg p-4 bg-white rounded-xl shadow-sm w-full text-center">No surveys found.</div>
        @else
        @foreach ($surveys as $survey)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 w-72 h-64 relative">
            <div class="flex justify-between items-center p-3 border-b border-gray-100">
                <div class="flex items-center justify-end space-x-2">
                    <a 
                        href="{{ route('survey.questions', ['uuid' => $survey->uuid]) }}" 
                        class="bg-gray-50 text-gray-800 px-3 py-1.5 text-sm font-silka rounded-md transition duration-200 hover:bg-[#923534]/10 hover:text-[#923534]"
                    >
                        View Survey
                    </a>
                    <button wire:click="delete({{ $survey->survey_id }})" class="w-8 h-8">
                        <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#923534] p-1.5 w-8 h-8 rounded-md transition duration-100 border border-[#923534] hover:opacity-80">
                    </button>
                </div>
            </div>
            <div class="text-center flex items-center justify-center h-[120px] px-4">
                <h2 class="text-xl font-silka font-semibold text-gray-900 line-clamp-2 overflow-hidden">{{ $survey->survey_name }}</h2>
            </div>
            <div class="bg-gray-50 border-t border-gray-100 flex rounded-b-xl absolute bottom-0 w-full">
                <div class="border-r border-gray-100 py-3 px-4 w-1/3 justify-center flex flex-col items-center text-center">
                    <span class="text-[#923534] font-silka font-semibold text-lg">{{ $survey->surveyRoles->count() }}</span>
                    <span class="text-xs font-silka text-gray-500">Roles</span>
                </div>
                <div class="py-3 px-4 w-1/3 justify-center flex flex-col items-center text-center">
                    <span class="text-[#923534] font-silka font-semibold text-lg">{{ $survey->questionCriterias->count() }}</span>
                    <span class="text-xs font-silka text-gray-500">Criterias</span>
                </div>
                <div class="border-l border-gray-100 py-3 px-4 w-1/3 justify-center flex flex-col items-center text-center">
                    <span class="text-[#923534] font-silka font-semibold text-lg">
                        {{ $survey->total_questions }}
                    </span>
                    <span class="text-xs font-silka text-gray-500">Questions</span>
                </div>
            </div>                 
        </div>
        @endforeach
        @endif
        <div class="bg-white bg-opacity-50 border-2 border-dashed border-gray-200 rounded-xl hover:border-[#923534] transition-colors duration-200 flex items-center justify-center w-72 h-64">
            <button wire:click="add()" class="group">
                <div class="flex-shrink-0 bg-[#923534]/10 p-4 rounded-lg group-hover:bg-[#923534]/20 transition-colors duration-200">
                    <img src="{{ asset('assets/icons/add-black.svg') }}" alt="Add" class="group-hover:scale-110 transition duration-150 w-10 h-10">
                </div>
            </button>
        </div>
    </div>

<x-delete-modal label="survey"/>

<x-add-modal label="survey">

        <x-add-modal-data name="survey_name" label="Survey Name:">
            <input 
                class="px-4 bg-gray-50 w-full p-2 border rounded-md border-gray-200 focus:ring-2 focus:ring-[#923534]/20 focus:border-[#923534] outline-none transition-all duration-200" 
                type="text" 
                maxlength="255"
                id="survey_name" 
                wire:model="survey_name">
        </x-add-modal-data>

        <x-add-modal-data name="role_id" label="Target Roles:">

            <x-select-role :roles="$this->getRoles()" :role_id="$role_id" />
    
        </x-add-modal-data>

</x-add-modal>

</div>

