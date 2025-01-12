<div class="relative group w-full sm:w-[250px]">
    <!-- Search Input -->
    <input 
        wire:model.live="searchCourse"
        type="text"
        class="px-5 py-2 pr-20 border border-[#DDD] rounded appearance-none w-full bg-[#F8F8F8] transition-all duration-200 group-hover:border-[#923534]"
        placeholder="Filter Course..."
        onfocus="this.parentElement.querySelector('.dropdown').style.display = 'block';"
        onblur="setTimeout(() => this.parentElement.querySelector('.dropdown').style.display = 'none', 100);"
    />

    <!-- Dropdown of Filtered Courses -->
    <div class="dropdown absolute left-0 right-0 mt-1 bg-white border border-[#DDD] rounded max-h-60 overflow-y-auto z-10"
         style="display: {{ strlen($searchCourse) > 0 ? 'block' : 'none' }};">
        @foreach($courses as $course)
            <div wire:click="selectCourse({{ $course->course_id }})"
               class="block px-5 py-2 hover:bg-[#f1f1f1] cursor-pointer">
                {{ $course->course_code }} - {{ $course->course_name }}
            </div>
        @endforeach
    </div>

    <!-- Course Dropdown Arrow -->
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer hover:text-blue-500 transition-colors duration-200">
        <img class="w-6 h-6 group-hover:transform group-hover:-translate-x-1 transition-transform duration-200" src="{{ asset('assets/icons/arrow1.svg') }}" alt="Arrow">
    </div>
</div>
