<div class="bg-white">

    <div class="p-5">

        @foreach($evaluations as $evaluation)
            <div class="bg-white border p-4 mb-4 border-[#DDD]">
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ $evaluation->evaluation->courseSection->course->course_code }} | {{ $evaluation->evaluation->courseSection->course->course_name }}
                </h3>
                <p class="text-gray-600">Survey: {{ $evaluation->evaluation->survey->survey_name }}</p>
                <p class="text-gray-600">
                    Faculty: {{ $evaluation->evaluation->courseSection->facultyCourses->first()->faculty->faculty_name ?? 'No Faculty' }}
                </p>
                <br>
                <a 
                href="{{ route('evaluate', ['uuid' => $evaluation->uuid]) }}" 
                class="bg-[#F8F8F8] text-[#2A2723] px-3 py-1 text-sm transition duration-100 border hover:border-[#923534]"
                >
                    Evaluate
                </a>            
                
            </div>
        @endforeach

        @if($evaluations->isEmpty())
            <p class="text-gray-500 mt-4">No pending evaluations.</p>
        @endif

    </div>

</div>
