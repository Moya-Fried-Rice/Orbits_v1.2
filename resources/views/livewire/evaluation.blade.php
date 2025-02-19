<!-- Evaluation Section -->
<div class="bg-white">

    <x-system-notification />

    <div class="p-4 sm:p-6 md:p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            📜 Pending Evaluations
        </h2>

        <!-- Multiple Evaluation Boxes -->
        <div class="space-y-4">
            @foreach($evaluations as $evaluation)
                <div class="bg-white rounded-lg p-4 sm:p-6 border-0 sm:border border-gray-200">
                    <h3 class="text-lg font-semibold text-[#923534] mb-2">
                        📘 {{ $evaluation->evaluation->courseSection->course->course_code }} | {{ $evaluation->evaluation->courseSection->course->course_name }}
                    </h3>
                    <p class="text-gray-600 mb-1">📑 Survey: <span class="font-medium">{{ $evaluation->evaluation->survey->survey_name }}</span></p>
                    <p class="text-gray-600 mb-3">👨‍🏫 Faculty: <span class="font-medium">{{ $evaluation->evaluation->courseSection->facultyCourses->first()->faculty->faculty_name ?? 'No Faculty' }}</span></p>
                    <a 
                        href="{{ route('evaluate', ['uuid' => $evaluation->uuid]) }}" 
                        class="inline-block bg-[#923534] text-white px-6 py-2 text-sm font-medium rounded-full hover:bg-[#7A2C2B] transition-colors"
                    >
                        Evaluate
                    </a>
                </div>
            @endforeach

            @if($evaluations->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No pending evaluations.</p>
                </div>
            @endif
        </div>
    </div>

</div>

