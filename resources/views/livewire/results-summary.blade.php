<div class="bg-white rounded-xl shadow-md p-4 md:p-8 hover:shadow-lg transition-all duration-300">
    <!-- Dashboard Header -->
    <div class="flex flex-col gap-2 mb-6 md:mb-10 pb-4 md:pb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-silka">Faculty Evaluation Results</h1>
        <p class="text-gray-500 font-TT">Comprehensive summary of faculty evaluation metrics and feedback</p>
    </div>

    {{-- Faculty Profile - Horizontal Card --}}
    <div class="mb-8 bg-gradient-to-r from-white to-gray-50 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
        <h2 class="text-lg font-bold text-gray-900 p-4 md:p-5 flex items-center font-silka">
            <div class="w-1 md:w-1.5 h-6 md:h-8 bg-[#923534] rounded-full mr-2 md:mr-3"></div>
            Faculty Profile
        </h2>
        
        <div class="flex flex-col md:flex-row w-full p-4 md:p-6 gap-4 md:gap-8">
            {{-- Left Column: Profile Image --}}
            <div class="flex justify-center md:justify-start items-center">
                <img src="{{ asset('storage/' . $faculty->user->profile_image) }}" alt="Profile Image" class="
                ring-2 md:ring-4 ring-[#923534]/20 object-cover rounded-full w-32 h-32 md:w-48 md:h-48 shadow-sm md:shadow-md hover:shadow-lg transition-all duration-300">
            </div>
            
            {{-- Middle Column: Profile Details --}}
            <div class="flex-1 flex flex-col justify-center">
                <div class="mb-3 pb-2 md:pb-3">
                    <span class="font-silka font-bold text-gray-900 text-xl md:text-3xl">{{ $faculty->user->user_name }}</span>
                </div>
                
                <div class="text-gray-700 font-TT grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
                    <span class="flex items-center gap-2 md:gap-3"><img class="w-5 md:w-6" src="{{ asset('assets/icons/message.svg') }}" alt="Email"> <span class="text-sm md:text-base">{{ $faculty->user->email }}</span></span>
                    <span class="flex items-center gap-2 md:gap-3"><img class="w-5 md:w-6" src="{{ asset('assets/icons/call.svg') }}" alt="Number"> <span class="text-sm md:text-base">{{ $faculty->user->phone_number }}</span></span>
                    <span class="flex items-center gap-2 md:gap-3 md:col-span-2"><img class="w-5 md:w-6" src="{{ asset('assets/icons/department.svg') }}" alt="Department"> <span class="text-sm md:text-base">{{ $faculty->department->department_name }}</span></span>
                </div>
            </div>
            
            {{-- Right Column: Overall Rating --}}
            <div class="flex-1 bg-white sm:bg-transparent md:bg-white p-3 md:p-4 rounded-lg shadow-sm sm:shadow-none md:shadow-sm flex flex-col justify-center mt-3 md:mt-0">
                <h3 class="text-md font-bold text-gray-800 mb-2 md:mb-3 flex items-center font-silka">
                    <div class="w-1 h-5 bg-[#923534] rounded-full mr-2"></div>
                    Overall Rating
                </h3>
                
                @php
                    $overall = $evaluationData['final_overall_avg'];
                @endphp

                <x-rating-card 
                    label='Overall' 
                    :rating="$overall" 
                    :totalN="2" 
                />
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-8">
        {{-- Rating Details Table --}}
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-bold text-gray-900 mb-3 md:mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-2 md:mr-3"></div>
                Evaluation Summary
            </h2>
            
            <div class="overflow-x-auto w-full">
                <table class="table font-TT w-full table-auto">
                    <thead>
                        <tr class="uppercase font-normal bg-gray-50 text-gray-700">
                            <th class="py-2 md:py-3 px-2 md:px-4 font-medium">Evaluators</th>
                            <th class="py-2 md:py-3 px-2 md:px-4 font-medium">AVG</th>
                            <th class="py-2 md:py-3 px-2 md:px-4 font-medium">Scoring</th>
                            <td class="py-2 md:py-3 px-2 md:px-4 font-medium">Totals</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluationData['role_data'] as $role => $data)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 border-t border-gray-100">
                                <td class="py-2.5 px-4">{{ ucwords(str_replace('_', ' ', $role)) }}</td>
                                <td class="py-2.5 px-4 text-center">{{ $data['total_avg'] }}</td>
                                <td class="py-2.5 px-4 text-center">{{ $data['percentage'] }}%</td>
                                <td class="py-2.5 px-4 text-center">{{ $data['computed_avg'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-bold bg-gray-50 border-t border-gray-200">
                            <td class="py-3 px-4 text-right" colspan="3">Total Rating:</td>
                            <td class="py-3 px-4 text-center">{{ $overall }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Student Feedback --}}
        <div class="w-full bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-bold text-gray-900 mb-3 md:mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-2 md:mr-3"></div>
                Student Feedback
            </h2>
            <div class="rounded-lg p-2 md:p-5 h-[400px] md:h-[600px] overflow-y-auto bg-gray-50/30">
                @foreach($evaluationData['comments_data'] as $index => $comment)
                    <p class="break-words p-3 md:p-4 mb-2 md:mb-3 rounded-lg font-TT {{ $index % 2 === 0 ? 'bg-gray-50 md:bg-white shadow-sm' : 'bg-white md:bg-gray-50' }}">{{ $comment }}</p>
                @endforeach
            </div>            
        </div>
        
        {{-- Sentiment Analysis --}}
        <div class="w-full bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition-all duration-300" x-data="{ tab: 'positive' }">
            <h2 class="text-lg font-bold text-gray-900 mb-3 md:mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-2 md:mr-3"></div>
                Sentiment Analysis
            </h2>
        
            <div class="mb-4 font-TT">
                {{-- Simple directly-rendered donut chart using Tailwind and HTML --}}
                @php
                    $totalComments = $positiveCommentCount + $negativeCommentCount;
                    $positivePercentage = $totalComments > 0 ? ($positiveCommentCount / $totalComments) * 100 : 0;
                    $negativePercentage = $totalComments > 0 ? ($negativeCommentCount / $totalComments) * 100 : 0;

                    $radius = 16;
                    $strokeWidth = 4.5; // Increased stroke width for a thicker donut
                    $circumference = 2 * pi() * $radius;

                    $positiveArc = ($positivePercentage / 100) * $circumference;
                    $negativeArc = ($negativePercentage / 100) * $circumference;
                @endphp

                <div class="flex flex-col items-center justify-center space-y-3">
                    {{-- SVG Donut Chart --}}
                    <div class="relative w-40 h-40">
                        <svg viewBox="0 0 36 36" class="w-full h-full">
                            {{-- Background circle (track color from admin dashboard) --}}
                            <circle cx="18" cy="18" r="{{ $radius }}" fill="none" stroke="#F3F4F6" stroke-width="{{ $strokeWidth }}"></circle>
                            
                            @if($totalComments > 0)
                                {{-- Positive segment (green) --}}
                                @if($positivePercentage > 0)
                                    <circle cx="18" cy="18" r="{{ $radius }}" fill="none" stroke="#10B981" stroke-width="{{ $strokeWidth }}"
                                            stroke-dasharray="{{ $positiveArc }} {{ $circumference }}"
                                            stroke-dashoffset="0"
                                            transform="rotate(-90 18 18)"></circle>
                                @endif
                            
                                {{-- Negative segment (red) --}}
                                @if($negativePercentage > 0)
                                    <circle cx="18" cy="18" r="{{ $radius }}" fill="none" stroke="#923534" stroke-width="{{ $strokeWidth }}"
                                            stroke-dasharray="{{ $negativeArc }} {{ $circumference }}"
                                            stroke-dashoffset="{{ -$positiveArc }}" {{-- Offset by positive arc length --}}
                                            transform="rotate(-90 18 18)"></circle>
                                @endif
                                
                                {{-- Handle 100% cases to ensure full circle stroke without artifacts from dasharray --}}
                                @if($positivePercentage >= 99.9 && $negativePercentage < 0.1)
                                    <circle cx="18" cy="18" r="{{ $radius }}" fill="none" stroke="#10B981" stroke-width="{{ $strokeWidth }}"></circle>
                                @elseif($negativePercentage >= 99.9 && $positivePercentage < 0.1)
                                    <circle cx="18" cy="18" r="{{ $radius }}" fill="none" stroke="#923534" stroke-width="{{ $strokeWidth }}"></circle>
                                @endif
                            @endif
                            
                            {{-- Center text (Label above, Value below - similar to admin dashboard) --}}
                            <text x="18" y="16.5" text-anchor="middle" fill="#6B7280" font-size="3.5">Total</text>
                            <text x="18" y="22.5" text-anchor="middle" fill="#374151" font-size="7" font-weight="bold">{{ $totalComments }}</text>
                        </svg>
                    </div>
                    
                    {{-- Legend --}}
                    <div class="flex space-x-8">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm">Positive: {{ $positiveCommentCount }} ({{ round($positivePercentage) }}%)</span>
                        </div>
                        <div class="w-8"> </div> 
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-[#923534] rounded-full mr-2"></div>
                            <span class="text-sm">Negative: {{ $negativeCommentCount }} ({{ round($negativePercentage) }}%)</span>
                        </div>
                    </div>
                </div>

                {{-- Fallback container for JS-based chart (hidden by default) --}}
                <div id="sentiment-donut-chart" class="hidden mt-4"></div>
            </div>
        
            <div class="mb-4 border-b border-gray-200">
                <nav class="flex space-x-1 md:space-x-2" aria-label="Tabs">
                    <button @click="tab = 'positive'"
                            :class="{ 'border-b-2 border-[#923534] text-[#923534]': tab === 'positive', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'positive' }"
                            class="px-2 py-2 md:px-3 font-medium text-sm rounded-t-md focus:outline-none font-silka whitespace-nowrap">
                        Positive Comments
                    </button>
                    <button @click="tab = 'negative'"
                            :class="{ 'border-b-2 border-[#923534] text-[#923534]': tab === 'negative', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'negative' }"
                            class="px-2 py-2 md:px-3 font-medium text-sm rounded-t-md focus:outline-none font-silka whitespace-nowrap">
                        Negative Comments
                    </button>
                </nav>
            </div>
        
            <div class="rounded-lg p-2 md:p-5 h-[320px] md:h-[520px] overflow-y-auto bg-gray-50/30">
                <div x-show="tab === 'positive'">
                    @if (!empty($positiveCommentsForView))
                        @foreach($positiveCommentsForView as $index => $comment)
                            <p class="break-words p-3 md:p-4 mb-2 md:mb-3 rounded-lg font-TT {{ $index % 2 === 0 ? 'bg-gray-50 md:bg-white shadow-sm' : 'bg-white md:bg-gray-50' }}">{{ $comment }}</p>
                        @endforeach
                    @else
                        <p class="text-gray-500 font-TT text-center py-4">No positive comments to display.</p>
                    @endif
                </div>
                <div x-show="tab === 'negative'">
                    @if (!empty($negativeCommentsForView))
                        @foreach($negativeCommentsForView as $index => $comment)
                            <p class="break-words p-3 md:p-4 mb-2 md:mb-3 rounded-lg font-TT {{ $index % 2 === 0 ? 'bg-gray-50 md:bg-white shadow-sm' : 'bg-white md:bg-gray-50' }}">{{ $comment }}</p>
                        @endforeach
                    @else
                        <p class="text-gray-500 font-TT text-center py-4">No negative comments to display.</p>
                    @endif
                </div>
            </div>
        </div>

        @push('chartData')
            <script>
                // Ensure the global chart data object exists
                window.sentimentChartData = window.sentimentChartData || {};
                // Assign data for the sentiment counts chart
                window.sentimentChartData.counts = {
                    positive: {{ $positiveCommentCount ?? 0 }},
                    negative: {{ $negativeCommentCount ?? 0 }}
                };
            </script>
        @endpush

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize the sentiment donut chart
                if (typeof ApexCharts !== 'undefined') {
                    const sentimentData = window.sentimentChartData.counts;
                    
                    // Check if we have data to display
                    if (sentimentData && (sentimentData.positive > 0 || sentimentData.negative > 0)) {
                        const options = {
                            series: [sentimentData.positive, sentimentData.negative],
                            chart: {
                                type: 'donut',
                                height: '100%',
                            },
                            labels: ['Positive', 'Negative'],
                            colors: ['#10B981', '#EF4444'], // green and red
                            legend: {
                                position: 'bottom',
                                fontFamily: 'Inter, sans-serif',
                                itemMargin: {
                                    horizontal: 12,
                                    vertical: 5
                                },
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '60%',
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                fontSize: '14px',
                                                fontFamily: 'Inter, sans-serif',
                                                fontWeight: 500,
                                            },
                                            value: {
                                                show: true,
                                                fontSize: '16px',
                                                fontFamily: 'Inter, sans-serif',
                                                fontWeight: 600,
                                                formatter: function(val) {
                                                    return val;
                                                }
                                            },
                                            total: {
                                                show: true,
                                                fontSize: '14px',
                                                fontFamily: 'Inter, sans-serif',
                                                label: 'Total',
                                                formatter: function(w) {
                                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        height: 200
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };

                        const chart = new ApexCharts(document.querySelector("#sentiment-donut-chart"), options);
                        chart.render();
                    } else {
                        // Display a message if there's no data
                        document.querySelector("#sentiment-donut-chart").innerHTML = '<p class="text-center text-gray-500 pt-12">No sentiment data available.</p>';
                    }
                } else {
                    console.warn('ApexCharts library is not loaded. The sentiment chart cannot be displayed.');
                    document.querySelector("#sentiment-donut-chart").innerHTML = '<p class="text-center text-gray-500 pt-12">Chart cannot be displayed. ApexCharts library is missing.</p>';
                }
            });
        </script>
        @endpush

        {{-- Convert Data for Chart --}}
        @php
            $criteriaLabels = [];
            $shortCriteriaLabels = []; // For the short version (e.g., "CM")
            $criteriaValues = [];
            
            foreach ($evaluationData['criteria_avg'] as $criteria => $average) {
                // Remove content inside parentheses using regular expression
                $criteriaWithoutParentheses = preg_replace('/\([^)]*\)/', '', $criteria);

                // Trim whitespace and check if the string is not empty
                $criteriaWithoutParentheses = trim($criteriaWithoutParentheses);
                
                if (!empty($criteriaWithoutParentheses)) {
                    // Split the criteria by space to get individual words
                    $criteriaParts = explode(' ', $criteriaWithoutParentheses);
                    
                    // Ensure there are words to process
                    if (count($criteriaParts) == 1) {
                        // If only one word, take the first and second letter
                        $shortLabel = strtoupper(substr($criteriaParts[0], 0, 1) . substr($criteriaParts[0], 1, 1));
                    } else {
                        // If multiple words, take the first letter of the first and last word
                        $shortLabel = strtoupper(substr($criteriaParts[0], 0, 1) . substr(end($criteriaParts), 0, 1));
                    }
                    
                    // Store both the full label and the short label
                    $criteriaLabels[] = $criteria;       // Full label (e.g., "Classroom Management")
                    $shortCriteriaLabels[] = $shortLabel; // Shortened label (e.g., "CM")
                    $criteriaValues[] = (float) $average; // Ensure numeric format
                }
            }
        @endphp


        
        @push('chartData')
            <script>
                window.criteriaChartData = window.criteriaChartData || {};
                window.criteriaChartData = {
                    labels: @json($criteriaLabels),
                    data: @json($criteriaValues),
                    shortLabels: @json($shortCriteriaLabels)
                };
            </script>
        @endpush
        
        {{-- Radar chart --}}
        <div class="flex flex-col bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-bold text-gray-900 mb-3 md:mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-2 md:mr-3"></div>
                Performance by Criteria
            </h2>
            <div class="flex items-center justify-center w-full h-[350px] md:h-[500px] bg-gray-50/30 rounded-lg p-2 md:p-3">
                <div id="radar-chart" class="w-full h-full"></div>
            </div>
        </div>
        
    </div>  

    @foreach ($evaluationData['data'] as $role => $roleData)
        <div class="mt-6 md:mt-10 bg-white rounded-xl shadow-md p-4 md:p-7 hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-bold text-gray-900 mb-4 md:mb-6 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-2 md:mr-3"></div>
                {{ ucwords(str_replace('_', ' ', $role)) }} Evaluations
            </h2>

            {{-- Full Table with All Ratings --}}
            <div class="mb-5 md:mb-8 overflow-x-auto w-full rounded-lg shadow-sm">
                <table class="table font-TT w-full table-auto">
                    <thead>
                        <tr class="uppercase font-normal bg-gray-50 text-gray-700">
                            <th class="py-3 px-4 font-medium">Subject</th>
                            <th class="py-3 px-4 font-medium">Section</th>
                            <th class="py-3 px-4 font-medium">N</th>

                            @php
                                // ✅ Extract criteria and questions dynamically
                                $criteriaQuestions = [];
                                foreach ($roleData['sections'] as $section) {
                                    foreach ($section['ratings'] as $criteria => $questions) {
                                        $criteriaQuestions[$criteria] = array_unique(array_merge($criteriaQuestions[$criteria] ?? [], array_keys($questions)));
                                    }
                                }
                            @endphp

                            @foreach ($criteriaQuestions as $criteria => $questions)
                                <th class="px-3 text-gray-700 text-xs font-medium whitespace-nowrap truncate max-w-2" colspan="{{ count($questions) }}">{{ $criteria }}</th>
                            @endforeach

                            <th class="py-3 px-4 font-medium">AVG</th>
                        </tr>
                        <tr class="bg-gray-50 border-t border-gray-100">
                            <th colspan="3" class="font-medium"></th>
                            @foreach ($criteriaQuestions as $questions)
                                @foreach ($questions as $questionCode)
                                    <th class="font-medium">{{ $questionCode }}</th>
                                @endforeach
                            @endforeach
                            <th class="font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleData['sections'] as $index => $section)
                            <tr id="row-{{ $role }}-{{ $loop->index }}" class="transition duration-150 hover:bg-gray-50 border-t border-gray-100">
                                <td class="py-2.5 px-4">{{ $section['subject'] }}</td>
                                <td class="py-2.5 px-4">{{ $section['section'] }}</td>
                                <td class="py-2.5 px-4 text-center">{{ $section['N'] }}</td>

                                @foreach ($criteriaQuestions as $criteria => $questions)
                                    @foreach ($questions as $questionCode)
                                        @php
                                            $rating = $section['ratings'][$criteria][$questionCode] ?? null;
                                            $textColorClass = '';
                                            $bgColorClass = '';
                                        
                                            // Apply text color based on rating value
                                            if ($rating !== null) {
                                                if ($rating >= 4.5) {
                                                    $textColorClass = 'text-green-700';
                                                    $bgColorClass = 'bg-green-50';
                                                } elseif ($rating >= 3.5) {
                                                    $textColorClass = 'text-green-600';
                                                    $bgColorClass = 'bg-green-50';
                                                } elseif ($rating >= 2.5) {
                                                    $textColorClass = 'text-yellow-600';
                                                    $bgColorClass = 'bg-yellow-50';
                                                } elseif ($rating >= 1.5) {
                                                    $textColorClass = 'text-red-500';
                                                    $bgColorClass = 'bg-red-50';
                                                } else {
                                                    $textColorClass = 'text-red-600';
                                                    $bgColorClass = 'bg-red-50';
                                                }
                                            }
                                        @endphp
                                        
                                        <td class="py-2.5 px-4 text-xs text-center {{ $textColorClass }} {{ $bgColorClass }}">
                                            {{ $rating ?? '-' }}
                                        </td>
                                    @endforeach
                            
                                @endforeach

                                <td class="py-2.5 px-4 text-center font-medium">{{ $section['AVG'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 md:gap-8 mt-4 md:mt-6">
                <div class="bg-white rounded-lg p-3 md:p-5 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex justify-center flex-col md:flex-row gap-4 md:gap-8">
                        {{-- Rating --}}
                        @php
                            $label = ucwords(str_replace('_', ' ', $role));
                            $rating = number_format($roleData['overall_avg'], 2);
                            $totalN = array_sum(array_column($roleData['sections'], 'N'));
                        @endphp

                        <x-rating-card 
                            :label="$label" 
                            :rating="$rating" 
                            :totalN="$totalN" 
                        />

                        {{-- Summary Table --}}
                        <div>
                            <div class="overflow-x-auto justify-center flex">
                                <table class="table font-TT table-auto">
                                    <thead>
                                        <tr class="uppercase font-normal bg-gray-50 text-gray-700">
                                            <th class="py-2.5 px-4 font-medium">Subject</th>
                                            <th class="py-2.5 px-4 font-medium">Section</th>
                                            <th class="py-2.5 px-4 font-medium">AVG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roleData['sections'] as $section)
                                            <tr id="row-{{ $role }}-{{ $loop->index }}" class="hover:bg-gray-50 transition-colors duration-150 border-t border-gray-100">
                                                <td class="py-2.5 px-4">{{ $section['subject'] }}</td>
                                                <td class="py-2.5 px-4">{{ $section['section'] }}</td>
                                                <td class="py-2.5 px-4 text-center">{{ $section['AVG'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50 font-medium border-t border-gray-200">
                                            <td class="py-3 px-4 text-right" colspan="2">Overall Average</td>
                                            <td class="py-3 px-4 text-center"> {{ $roleData['overall_avg'] }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Bar Chart --}}
                <div class="bg-white rounded-lg p-3 md:p-5 shadow-sm hover:shadow-md transition-all duration-300">
                    <h3 class="text-md font-semibold text-gray-800 mb-3 md:mb-4 font-silka">Performance by Section</h3>
                    <div id="chart-{{ $role }}" class="overflow-x-auto overflow-y-hidden justify-start flex h-56 md:h-64 bg-gray-50/30 rounded-lg p-0 md:p-2"></div>
                </div>
            </div>
    
            {{-- Convert Data for Chart --}}
            @php
                $chartLabels = [];
                $chartData = [];
                foreach ($roleData['sections'] as $section) {
                    $chartLabels[] = $section['subject'] . '-' . $section['section'];
                    $chartData[] = (float) $section['AVG']; // Ensure numeric format
                }
            @endphp

            @push('chartData')
                <script>
                    window.chartData = window.chartData || {};
                    window.chartData["{{ $role }}"] = {
                        labels: @json($chartLabels),
                        data: @json($chartData)
                    };
                </script>
            @endpush

        </div>
    @endforeach

</div>
