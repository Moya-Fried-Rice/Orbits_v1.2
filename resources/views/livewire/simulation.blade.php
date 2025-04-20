<div class="p-4 bg-white shadow-md rounded-lg space-y-4">
    @if (session()->has('message'))
        <div class="text-green-600 font-semibold">{{ session('message') }}</div>
    @endif

    
    

    <div wire:loading wire:target="createRandomCourseSections, createRandomCourseSectionsForStudent, completeRandomEvaluations">
        <p>Processing...</p>
    </div>
    
    
    <!-- Your normal content goes here (will show after action completes) -->
    <div wire:loading.remove wire:target="createRandomCourseSections, createRandomCourseSectionsForStudent, completeRandomEvaluations" class="p-4 bg-white shadow-md rounded-lg space-y-4">

       {{-- Faculty Simulation --}}
        <div class="space-y-2">
            <label class="font-semibold">Faculty Simulation:</label>
            <div class="flex items-center gap-4">
                <label for="faculty_total"># of Faculty:</label>
                <input type="number" id="faculty_total" min="1" wire:model="faculty_total"
                    class="border border-gray-300 rounded px-2 py-1 w-20">

                <label for="faculty_section_count">Sections per Faculty:</label>
                <input type="number" id="faculty_section_count" min="1" wire:model="faculty_section_count"
                    class="border border-gray-300 rounded px-2 py-1 w-20">

                <button type="button"
                        wire:click="createRandomCourseSections"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Simulate Faculty
                </button>
            </div>
        </div>

        {{-- Student Simulation --}}
        <div class="space-y-2">
            <label class="font-semibold">Student Simulation:</label>
            <div class="flex items-center gap-4">
                <label for="student_total"># of Students:</label>
                <input type="number" id="student_total" min="1" wire:model="student_total"
                    class="border border-gray-300 rounded px-2 py-1 w-20">

                <label for="student_section_count">Sections per Student:</label>
                <input type="number" id="student_section_count" min="1" wire:model="student_section_count"
                    class="border border-gray-300 rounded px-2 py-1 w-20">

                <button type="button"
                        wire:click="createRandomCourseSectionsForStudent"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Simulate Student
                </button>
            </div>
        </div>


        {{-- Complete Evaluations --}}
        <div class="flex items-center gap-4">
            <label for="evaluation_count" class="font-semibold">Number of Evaluations to Complete:</label>
            <input type="number" id="evaluation_count" min="1" wire:model="evaluation_count"
                    class="border border-gray-300 rounded px-2 py-1 w-20">
            <button wire:click="completeRandomEvaluations"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Complete Evaluations
            </button>
        </div>

    </div>
    
    
    
</div>
