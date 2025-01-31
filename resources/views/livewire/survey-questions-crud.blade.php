<div class="bg-white pb-5">

    <x-system-notification />

    <div class="p-5 pb-0 flex flex-wrap items-center md:justify-between justify-center relative">
        
        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">

            <div class="ml-0 md:ml-5 flex-col flex w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-start w-full items-center border-b border-[#DDD] gap-2 md:gap-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-3xl">{{ $survey->survey_name }}</span>
                    <div class="flex items-center justify-end space-x-2">
                    </div>
                    <span class="flex items-center gap-2 justify-start">
                        
                        Target Roles: 
                        @foreach ($survey->surveyRole as $index => $surveyRole)
                            {{ ucfirst(str_replace('_', ' ', $surveyRole->role->role_name)) }}@if(!$loop->last), @endif
                        @endforeach

                    </span>
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit()"  class="w-8 h-8">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#F8F8F8] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </div>

            </div>

        </div>
        {{-- <x-add-button add="Add Course" /> --}}
    </div>  
    
    <div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] p-5 gap-5">
       
        <div class="order-1 xl:order-2">

            <div class="text-sm text-gray-500 mt-1">
                Select a <span class="font-bold">criteria</span> to display the relevant questions.
            </div>

            <x-table :action="false">
                <x-slot name="header">

                    <x-table-header
                    :allowSort="false"
                    label="Criteria List"/>

                </x-slot>
                <x-slot name="body">

                    <tr class="font-normal border border-[#DDD] text-[#666]-100">
                        <td class="p-2">

                            <x-table :action="true">

                                <x-slot name="header">
                
                                    <x-table-header
                                    :allowSort="false"
                                    label="Criteria Name"/>

                                    <x-table-header
                                    :allowSort="false"
                                    label="Updated At"/>
                
                                </x-slot>
                                <x-slot name="body">

                                    <button class="bg-green-100 hover:bg-green-200 transition duration-100 w-full rounded flex justify-center p-1 mb-2 border">
                                        <img src="{{ asset('assets/icons/add-black.svg') }}" class="opacity-50" alt="Add">
                                    </button>

                                    @foreach($survey->surveyCriteria as $criteria)
                                    <tr class="font-normal border border-[#DDD] text-[#666]-100 
                                        {{ $selectedCriteria == $criteria->criteria_id ? 'bg-blue-50' : '' }}">
                                        <td class="p-2 whitespace-nowrap px-4 truncate max-w-xs">
                                            {{ $criteria->questionCriteria->description ?? 'No Description' }}
                                        </td>
                                        <td class="p-2 whitespace-nowrap px-4 truncate max-w-xs">
                                            {{ $criteria->updated_at }}
                                        </td>
                                        <td class="py-2 whitespace-nowrap px-4 w-24">
                                            <div class="flex items-center justify-end space-x-2">
                                                <button wire:click="selectCriteria({{ $criteria->criteria_id }})" class="w-8 h-8">
                                                    <img src="{{ asset('assets/icons/menu2.svg') }}" alt="Edit"
                                                         class="hover:transform hover:rotate-12 bg-[#F8F8F8] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                                </button>
                                                <button wire:click="edit({{ $criteria->criteria_id }})" class="w-8 h-8">
                                                    <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit"
                                                         class="hover:transform hover:rotate-12 bg-[#F8F8F8] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                                </button>
                                                <button wire:click="delete({{ $criteria->criteria_id }})" class="w-8 h-8">
                                                    <img src="{{ asset('assets/icons/minus.svg') }}" alt="Delete"
                                                         class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach     

                                </x-slot>
                            </x-table>

                        </td>
                    </tr>
                </x-slot>
            </x-table>
        </div>
    
        <!-- Survey Criteria section -->
        <div class="order-2 xl:order-1">
            @foreach($survey->surveyCriteria->where('criteria_id', $selectedCriteria) as $criterion)
            <div>
                <x-table :action="false">
                    <x-slot name="header">
                        <x-table-header
                                :allowSort="false"
                                label="{{ $criterion->questionCriteria->description ?? 'No Title' }}"/>
                    </x-slot>
                    <x-slot name="body">
                        <tr class="font-normal border border-[#DDD] text-[#666]-100">
                            <td class="p-2">
    
                                <x-table :action="true">
                                    <x-slot name="header">
                                        <x-table-header
                                            :allowSort="false"
                                            label="Q. Code"/>
                                        
                                        <x-table-header
                                            :allowSort="false"
                                            label="Question Text"/>

                                        {{-- <x-table-header
                                            :allowSort="false"
                                            label=" "/> --}}
    
                                    </x-slot>
                                    <x-slot name="body">

                                        <button class="bg-green-100 hover:bg-green-200 transition duration-100 w-full rounded flex mb-2 justify-center p-1 border">
                                            <img src="{{ asset('assets/icons/add-black.svg') }}" class="opacity-50" alt="Add">
                                        </button>

                                        @foreach($criterion->questionCriteria->questions ?? [] as $question)
                                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                                            <td class="py-2 whitespace-nowrap px-4 truncate w-20">{{ $question->question_code }}</td>
                                            <td class="py-2 whitespace-nowrap px-4 truncate min-w-[20rem] max-w-[25rem]">{{ $question->question_text }}</td>
                                            {{-- <td class="py-2 whitespace-nowrap px-4 truncate min-w-[20rem] max-w-[25rem]">
                                                <div class="opacity-50 flex gap-5 items-center justify-center">
                                                    <i class="fa-regular fa-circle"></i>
                                                    <i class="fa-regular fa-circle"></i>
                                                    <i class="fa-regular fa-circle"></i>
                                                    <i class="fa-regular fa-circle"></i>
                                                    <i class="fa-regular fa-circle"></i>
                                                </div>
                                            </td> --}}
                                            <td class="py-2 whitespace-nowrap px-4 w-24">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <button wire:click="edit({{ $question->question_id }})" class="w-8 h-8">
                                                        <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#F8F8F8] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                                    </button>
                                                    <button wire:click="delete({{ $question->question_id }})" class="w-8 h-8">
                                                        <img src="{{ asset('assets/icons/minus.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </x-slot>
                                </x-table>
                            </td>
                        </tr>
                    </x-slot>
                </x-table>
            </div>    
            @endforeach
        </div>
    </div>

</div>
