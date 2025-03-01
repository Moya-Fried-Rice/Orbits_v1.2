// ... (keep all previous content the same, only updating the Recent Activity part)

    <!-- Recent Activity -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Recent Activity
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Last 5 Activities
            </div>
        </div>
        <div class="space-y-4">
            @php
                $recentEvals = \App\Models\UserEvaluation::where('user_id', auth()->id())
                    ->orderBy('evaluated_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            @forelse($recentEvals as $evaluation)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-3 h-3 mt-2 rounded-full {{ $evaluation->is_completed ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                    </div>
                    <div>
                        <p class="font-tt font-medium text-gray-900">
                            {{ $evaluation->evaluation->courseSection->course->course_code }} - 
                            {{ $evaluation->evaluation->courseSection->section->section_name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $evaluation->is_completed ? 'Completed' : 'Pending' }}
                            @if($evaluation->evaluated_at)
                                | {{ \Carbon\Carbon::parse($evaluation->evaluated_at)->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-4 font-tt">
                    No recent evaluation activities
                </div>
            @endforelse
        </div>
    </div>

// ... (keep rest of the content the same)
