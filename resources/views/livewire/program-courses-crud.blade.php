<div class="bg-white">
    
    <x-system-notification />

    <div class="p-5 pb-0 flex flex-wrap items-center md:justify-between justify-center relative">
        
        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">

            <div class="ml-0 md:ml-5 flex-col flex w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-start w-full items-center border-b border-[#DDD] gap-2 md:gap-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-3xl">{{ $program->program_code }}</span>
                    <div class="flex items-center justify-end space-x-2">
                    </div>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/program.svg') }}" alt="Course">: <span>{{ $program->program_name }}</span></span>
                    
                </div>
                <span>{{ $program->program_description }}</span>
            </div>

        </div>
        <x-add-button add="Add Course" />
    </div>  

</div>
