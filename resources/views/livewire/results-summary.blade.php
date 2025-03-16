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
