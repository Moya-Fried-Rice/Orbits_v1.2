<div class="bg-white">

    <x-system-notification />

    <div class="font-TT p-5 flex flex-wrap justify-center md:justify-start gap-5 items-center">

        @if($surveys->isEmpty())
            No surveys found.
        @else
        @foreach ($surveys as $survey)
        <div class="border border-[#D4D4D4] transition ease-out duration-300">
            <div class="flex justify-between items-center pb-2 m-2 mb-0 border-b border-[#D4D4D4]">
                <div class="flex items-center justify-end space-x-2">
                    <a 
                        href="{{ route('survey.questions', ['uuid' => $survey->uuid]) }}" 
                        class="bg-[#F8F8F8] text-[#2A2723] px-3 py-1 text-sm transition duration-100 border hover:border-[#923534]"
                    >
                        View Survey
                    </a>
                    <button wire:click="delete({{ $survey->survey_id }})" class="w-8 h-8">
                        <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                    </button>
                </div>
                {{-- <img src="{{ asset('assets/icons/info2.svg') }}" alt="Edit" class="p-1 w-8 h-8 "> --}}
            </div>
            <div class="text-center py-8 px-2 text-2xl">
                {{ $survey->survey_name }}
            </div>
            <div class="bg-[#F8F8F8] border-t border-[#D4D4D4] flex">
                <div class="border-r border-[#D4D4D4] py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->surveyRole->count() }}</span>
                    <span class="text-xs">Roles</span>
                </div>
                <div class="py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->questionCriteria->count() }}</span>
                    <span class="text-xs">Criterias</span>
                </div>
                <div class="border-l border-[#D4D4D4] py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">
                        {{ $survey->total_questions }}
                    </span>
                    <span class="text-xs">Questions</span>
                </div>
            </div>                 
        </div>
        @endforeach
        @endif
        <div class="border-[#DDD] border border-dashed">
            <button wire:click="add()">
                <img src="{{ asset('assets/icons/add-black.svg') }}" alt="Delete" class="hover:scale-110 hover:border-[#923534] transition duration-100 mx-16 my-8 bg-green-100 border border-[#666] p-3 w-12 h-12 rounded-full">
            </button>
        </div>
    </div>

<x-delete-modal label="survey"/>

<x-add-modal label="survey">

        <x-add-modal-data name="survey_name" label="Survey Name:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="survey_name" 
                wire:model="survey_name">
        </x-add-modal-data>

        <x-add-modal-data name="role_id" label="Target Roles:">

            <x-select-role :roles="$this->getRoles()" :role_id="$role_id" />
    
        </x-add-modal-data>

</x-add-modal>

</div>
