<div class="p-4 bg-white shadow-md rounded-lg space-y-4">
    @if (session()->has('message'))
        <div class="text-green-600 font-semibold">{{ session('message') }}</div>
    @endif

    
    

    <div wire:loading wire:target="createRandomCourseSections, createRandomCourseSectionsForStudent, completeRandomEvaluations">
        <p>Processing...</p>
    </div>
    
    
    <!-- Your normal content goes here (will show after action completes) -->
    <div wire:loading.remove wire:target="createRandomCourseSections, createRandomCourseSectionsForStudent, completeRandomEvaluations" class="p-4 bg-white shadow-md rounded-lg space-y-4">

        {{-- Faculty Section --}}
        <div class="flex items-center gap-4">
            <label for="count" class="font-semibold">Faculty Course Count:</label>
            <input type="number" id="count" min="1" wire:model="count"
                class="border border-gray-300 rounded px-2 py-1 w-20">
            <button type="button"
                    wire:click="createRandomCourseSections"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Simulate Faculty
            </button>
        </div>

        {{-- Student Section --}}
        <div class="flex items-center gap-4">
            <label for="student_count" class="font-semibold">Student Course Count:</label>
            <input type="number" id="student_count" min="1" wire:model="student_count"
                class="border border-gray-300 rounded px-2 py-1 w-20">
            <button type="button"
                    wire:click="createRandomCourseSectionsForStudent"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Simulate Student
            </button>
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
