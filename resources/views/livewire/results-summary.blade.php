<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
    <!-- Dashboard Header -->
    <div class="flex flex-col gap-1 mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-silka">Faculty Evaluation Results</h1>
        <p class="text-gray-500 font-TT">Comprehensive summary of faculty evaluation metrics and feedback</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        
        {{-- Student Feedback --}}
        <div class="w-full col-span-1 lg:col-span-2 xl:col-span-1 xl:order-first order-last bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Student Feedback
            </h2>
            <div class="border border-[#DDD] rounded-lg p-4 h-[600px] overflow-y-auto">
                @foreach($evaluationData['comments_data'] as $index => $comment)
                    <p class="break-words p-3 mb-2 rounded-lg font-TT {{ $index % 2 === 0 ? 'bg-[#F8F8F8]' : 'bg-white border border-[#DDD]' }}">{{ $comment }}</p>
                @endforeach
            </div>            
        </div>
        
        {{-- Profile and Rating --}}
        <div class="flex flex-col items-center justify-start gap-5 bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center font-silka self-start">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Faculty Profile
            </h2>
            
            <div class="gap-4 flex flex-col flex-wrap items-center justify-start w-full">
                <img src="{{ asset('storage/' . $faculty->user->profile_image) }}" alt="Profile Image" class="
                ring-2 ring-[#923534]/20 border-8 border-[#F8F8F8]
                object-cover rounded-full w-40 h-40 shadow-sm">

                <div class="flex items-center flex-col md:flex-row w-full">
                    <div class="flex-col flex gap-4 w-full">
                        <!-- Name and Action Buttons -->
                        <div class="py-3 flex justify-between w-full items-center border-b border-[#DDD] gap-5">
                            <span class="font-silka font-bold text-gray-900 text-xl md:text-2xl">{{ $faculty->user->user_name }}</span>
                        </div>

                        <!-- Profile Details -->
                        <div class="text-gray-600 font-TT space-y-2">
                            <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/message.svg') }}" alt="Email"> <span>{{ $faculty->user->email }}</span></span>
                            <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/call.svg') }}" alt="Number"> <span>{{ $faculty->user->phone_number }}</span></span>
                            <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/department.svg') }}" alt="Department"> <span>{{ $faculty->department->department_name }}</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center w-full mt-4">
                <div class="w-full">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center font-silka">
                        <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                        Overall Rating
                    </h2>

                    <div class="mb-4">
                    @php
                        $overall = $evaluationData['final_overall_avg'];
                    @endphp

                    <x-rating-card 
                        label='Overall' 
                        :rating="$overall" 
                        :totalN="2" 
                    />
                    </div>
                    <div class="overflow-x-auto w-full">
                        <table class="table table-bordered font-TT w-full table-auto">
                            <thead>
                                <tr class="uppercase font-normal bg-[#F8F8F8] text-gray-700">
                                    <th class="border border-[#DDD] py-2 px-4 font-medium">Evaluators</th>
                                    <th class="border border-[#DDD] py-2 px-4 font-medium">AVG</th>
                                    <th class="border border-[#DDD] py-2 px-4 font-medium">Scoring</th>
                                    <td class="border border-[#DDD] py-2 px-4 font-medium">Totals</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluationData['role_data'] as $role => $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-[#DDD] py-2 px-4">{{ ucwords(str_replace('_', ' ', $role)) }}</td>
                                        <td class="border border-[#DDD] py-2 px-4 text-center">{{ $data['total_avg'] }}</td>
                                        <td class="border border-[#DDD] py-2 px-4 text-center">{{ $data['percentage'] }}%</td>
                                        <td class="border border-[#DDD] py-2 px-4 text-center">{{ $data['computed_avg'] }}</td>
                                    </tr>
                                @endforeach
                                <tr class="font-bold bg-gray-50">
                                    <td class="border border-[#DDD] py-2 px-4 text-right" colspan="3">Total Rating:</td>
                                    <td class="border border-[#DDD] py-2 px-4 text-center">{{ $overall }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
        <div class="flex flex-col bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Performance by Criteria
            </h2>
            <div class="flex items-center justify-center w-full h-[400px] md:h-[500px]">
                <div id="radar-chart" class="w-full h-full"></div>
            </div>
        </div>
        
    </div>  

    @foreach ($evaluationData['data'] as $role => $roleData)
        <div class="mt-8 bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                {{ ucwords(str_replace('_', ' ', $role)) }} Evaluations
            </h2>

            {{-- Full Table with All Ratings --}}
            <div class="mb-6 overflow-x-auto w-full">
                <table class="table table-bordered font-TT w-full table-auto">
                    <thead>
                        <tr class="uppercase font-normal bg-[#F8F8F8] text-gray-700">
                            <th class="border border-[#DDD] py-2 px-4 font-medium">Subject</th>
                            <th class="border border-[#DDD] py-2 px-4 font-medium">Section</th>
                            <th class="border border-[#DDD] py-2 px-4 font-medium">N</th>

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
                                <th class="border border-[#DDD] px-2 text-gray-700 text-xs font-medium whitespace-nowrap truncate max-w-2" colspan="{{ count($questions) }}">{{ $criteria }}</th>
                            @endforeach

                            <th class="border border-[#DDD] py-2 px-4 font-medium">AVG</th>
                        </tr>
                        <tr class="bg-gray-50">
                            <th colspan="3" class="border border-[#DDD] font-medium"></th>
                            @foreach ($criteriaQuestions as $questions)
                                @foreach ($questions as $questionCode)
                                    <th class="border border-[#DDD] font-medium">{{ $questionCode }}</th>
                                @endforeach
                            @endforeach
                            <th class="border border-[#DDD] font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleData['sections'] as $index => $section)
                            <tr id="row-{{ $role }}-{{ $loop->index }}" class="transition duration-100 hover:bg-gray-50">
                                <td class="border border-[#DDD] py-2 px-4">{{ $section['subject'] }}</td>
                                <td class="border border-[#DDD] py-2 px-4">{{ $section['section'] }}</td>
                                <td class="border border-[#DDD] py-2 px-4 text-center">{{ $section['N'] }}</td>

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
                                        
                                        <td class="border border-[#DDD] py-2 px-4 text-xs text-center {{ $textColorClass }} {{ $bgColorClass }}">
                                            {{ $rating ?? '-' }}
                                        </td>
                                    @endforeach
                            
                                @endforeach

                                <td class="border border-[#DDD] py-2 px-4 text-center font-medium">{{ $section['AVG'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
                <div class="bg-white rounded-lg border border-[#DDD] p-4">
                    <div class="flex justify-center flex-col md:flex-row gap-6">
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
                                <table class="table table-bordered font-TT table-auto">
                                    <thead>
                                        <tr class="uppercase font-normal bg-[#F8F8F8] text-gray-700">
                                            <th class="border border-[#DDD] py-2 px-4 font-medium">Subject</th>
                                            <th class="border border-[#DDD] py-2 px-4 font-medium">Section</th>
                                            <th class="border border-[#DDD] py-2 px-4 font-medium">AVG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roleData['sections'] as $section)
                                            <tr id="row-{{ $role }}-{{ $loop->index }}" class="hover:bg-gray-50">
                                                <td class="border border-[#DDD] py-2 px-4">{{ $section['subject'] }}</td>
                                                <td class="border border-[#DDD] py-2 px-4">{{ $section['section'] }}</td>
                                                <td class="border border-[#DDD] py-2 px-4 text-center">{{ $section['AVG'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50 font-medium">
                                            <td class="border border-[#DDD] py-2 px-4 text-right" colspan="2">Overall Average</td>
                                            <td class="border border-[#DDD] py-2 px-4 text-center"> {{ $roleData['overall_avg'] }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                </div>
                
                {{-- Bar Chart --}}
                <div class="bg-white rounded-lg border border-[#DDD] p-4">
                    <h3 class="text-md font-semibold text-gray-700 mb-3 font-silka">Performance by Section</h3>
                    <div id="chart-{{ $role }}" class="overflow-x-auto overflow-y-hidden justify-start flex h-64"></div>
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
