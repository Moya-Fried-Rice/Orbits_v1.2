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
                    <span class="flex items-center gap-2 justify-start">Target Roles: 
                        <span>{{ $survey->role->map(fn($role) => Str::title(str_replace('_', ' ', $role->role_name)))->implode(', ') }}</span>
                    </span>
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit()"  class="w-8 h-8">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </div>

            </div>

        </div>
        <x-add-button add="Add Course" />
    </div>  

<div class="grid grid-cols-1 xl:grid-cols-2 p-5 gap-5">
    @foreach($survey->surveyCriteria as $criterion)
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

                            </x-slot>
                            <x-slot name="body">
                                @foreach($criterion->questionCriteria->questions ?? [] as $question)
                                <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                                    <td class="py-2 whitespace-nowrap px-4 truncate w-20">{{ $question->question_code }}</td>
                                    <td class="py-2 whitespace-nowrap px-4 truncate min-w-[20rem] max-w-[25rem]">{{ $question->question_text }}</td>
                                    <td class="py-2 whitespace-nowrap px-4 w-24">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button wire:click="edit({{ $question->question_id }})" class="w-8 h-8">
                                                <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                            </button>
                                            <button wire:click="delete({{ $question->question_id }})" class="w-8 h-8">
                                                <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
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
