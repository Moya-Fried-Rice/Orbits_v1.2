<div class="bg-white h-full">
    <div class="font-TT p-5 flex flex-wrap justify-start gap-5 items-center">
        
        @if($surveys->isEmpty())
            No surveys found.
        @else
        @foreach ($surveys as $survey)
        <div class="border border-[#D4D4D4] transition ease-out duration-300  hover:shadow-lg">
            <div class="flex justify-between items-center pb-2 m-2 mb-0 border-b border-[#D4D4D4]">
                <div class="flex items-center justify-end space-x-2">
                    <button wire:click="edit()" class="w-8 h-8">
                        <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                    </button>
                    <button wire:click="delete()" class="w-8 h-8">
                        <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                    </button>
                </div>
                <img src="{{ asset('assets/icons/info2.svg') }}" alt="Edit" class="p-1 w-8 h-8 ">
            </div>
            <div class="text-center py-8 text-2xl">
                {{ $survey->survey_name }}
            </div>
            <div class="bg-[#F8F8F8] border-t border-[#D4D4D4] flex">
                <div class="border-r border-[#D4D4D4] py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->role->count() }}</span>
                    <span class="text-xs">Roles</span>
                </div>
                <div class="py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->criteria->count() }}</span>
                    <span class="text-xs">Criterias</span>
                </div>
                <div class="border-l border-[#D4D4D4] py-2 px-4 w-24 justify-center flex flex-col items-center text-center">
                    <span class="text-black">{{ $survey->criteria->flatMap->question->count() }}</span>
                    <span class="text-xs">Questions</span>
                </div>
            </div>                 
        </div>
        @endforeach
        @endif

    </div>

    @foreach ($this->test() as $item)
        {{ $item->department->department_name }}
        @foreach ($item->courseSection as $courseSection)
            <pre>
                {{ $courseSection->course->course_code }} <!-- Adjust property name if needed -->
            </pre>
        @endforeach
    @endforeach


</div>
