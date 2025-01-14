<div class="bg-white h-full">
    <div class="font-TT p-5 flex flex-wrap justify-start gap-5 items-center">
        
        @if($surveys->isEmpty())
            No surveys found.
        @else
        @foreach ($surveys as $survey)
        <div class="border border-[#D4D4D4] p-3 rounded-lg transition ease-out duration-300  hover:shadow-lg hover:scale-105">
            <div class="flex justify-between pb-3 border-b border-[#D4D4D4]">
                <img src="{{ asset('assets/icons/survey.svg') }}" alt="Edit" class="w-8 h-8">
                <div class="flex items-center justify-end space-x-2">
                    
                    <button wire:click="edit()">
                        <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                    </button>
                    <button wire:click="delete()">
                        <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                    </button>
                </div>
            </div>
            <div class="text-center py-8 text-2xl">
                {{ $survey->survey_name }}
            </div>
            <div class="bg-[#F8F8F8] border border-[#D4D4D4] flex rounded-xl">
                <div class="border-r border-[#D4D4D4] py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->roles->count() }}</span>
                    <span class="text-xs">Roles</span>
                </div>
                <div class="py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->criterias->count() }}</span>
                    <span class="text-xs">Criterias</span>
                </div>
                <div class="border-l border-[#D4D4D4] py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->criterias->flatMap->questions->count() }}</span>
                    <span class="text-xs">Questions</span>
                </div>
            </div>                 
        </div>
        @endforeach
        @endif
        
    </div>
</div>
