<div class="bg-white">

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 p-10 gap-10">
        
        {{-- Student Feedback --}}
        <div class="w-full col-span-1 lg:col-span-2 xl:col-span-1 xl:order-first order-last">
            <span>Student Feedback</span>
            <div class="border border-[#DDD] p-2 h-[800px] overflow-y-auto"> <!-- Set a fixed height -->
                @foreach($evaluationData['comments_data'] as $index => $comment)
                    <p class="break-words {{ $index % 2 === 0 ? 'bg-[#F8F8F8]' : 'bg-white' }}">{{ $comment }}</p>
                @endforeach
            </div>            
        </div>
        
        {{-- Profile and Rating --}}
        <div class="flex flex-col items-center justify-start gap-5">
            
            <div class="gap-2 flex flex-col flex-wrap items-center justify-start">
                <img src="{{ asset('storage/' . $faculty->user->profile_image) }}" alt="Profile Image" class="
                ring-1 ring-[#DDD] border-8 border-[#F8F8F8]
                object-cover rounded-full w-40 h-40">

                <div class="flex items-center flex-col md:flex-row w-full md:w-auto">
                    <div class="ml-0 md:ml-5 flex-col flex gap-5 w-full">
                        <!-- Name and Action Buttons -->
                        <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 md:mt-0 mt-5">
                            <span class="font-silka font-semibold text-[#2A2723] text-xl md:text-3xl">{{ $faculty->user->user_name }}</span>
                        </div>

                        <!-- Profile Details -->
                        <div class="text-gray-600">
                            <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/message.svg') }}" alt="Email">: <span>{{ $faculty->user->email }}</span></span>
                            <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/call.svg') }}" alt="Number">: <span>{{ $faculty->user->phone_number }}</span></span>
                            <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/department.svg') }}" alt="Department">: <span>{{ $faculty->department->department_name }}</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center w-full">
                <div class="w-full">
                    <div>

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
                                <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                                    <th class="border border-[#DDD] py-2 px-4 font-light">Evaluators</th>
                                    <th class="border border-[#DDD] py-2 px-4 font-light">AVG</th>
                                    <th class="border border-[#DDD] py-2 px-4 font-light">Scoring</th>
                                    <td class="border border-[#DDD] py-2 px-4 font-light">Totals</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluationData['role_data'] as $role => $data)
                                    <tr>
                                        <td class="border border-[#DDD] py-2 px-4 font-light">{{ ucwords(str_replace('_', ' ', $role)) }}</td>
                                        <td class="border border-[#DDD] py-2 px-4 font-light">{{ $data['total_avg'] }}</td>
                                        <td class="border border-[#DDD] py-2 px-4 font-light">{{ $data['percentage'] }}%</td>
                                        <td class="border border-[#DDD] py-2 px-4 font-light">{{ $data['computed_avg'] }}</td>
                                    </tr>
                                @endforeach
                                <tr class="font-bold">
                                    <td class="border border-[#DDD] py-2 px-4 font-light text-right" colspan="3">Total Rating:</td>
                                    <td class="border border-[#DDD] py-2 px-4 font-light">{{ $overall }}</td>
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
        <div class="flex items-center justify-center w-full h-[400px] md:h-[500px] lg:h-[600px] ">
            <div id="radar-chart" class="w-full h-full"></div>
        </div>
        
    </div>  

    @foreach ($evaluationData['data'] as $role => $roleData)
        <div>
            {{-- <div class="xl:bg-red-200 lg:bg-blue-200 md:bg-yellow-200 sm:bg-green-200 bg-orange-200">Red is xl, Blue is lg, Yellow is md, Green is sm, Orange is default</div> --}}
            <div class="text-lg pl-5 pt-5">{{ ucwords(str_replace('_', ' ', $role)) }} Evaluations</div>

            {{-- Full Table with All Ratings --}}
            <div class="p-5 pt-0 pb-0 overflow-x-auto w-full">
                <table class="table table-bordered font-TT w-full table-auto">
                    <thead>
                        <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                            <th class="border border-[#DDD] py-2 px-4 font-light">Subject</th>
                            <th class="border border-[#DDD] py-2 px-4 font-light">Section</th>
                            <th class="border border-[#DDD] py-2 px-4 font-light">N</th>

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
                                <th class="border border-[#DDD] px-2 text-[#666] text-xs font-light whitespace-nowrap truncate max-w-2" colspan="{{ count($questions) }}">{{ $criteria }}</th>
                            @endforeach

                            <th class="border border-[#DDD] py-2 px-4 font-light">AVG</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th colspan="3" class="border border-[#DDD] font-light"></th>
                            @foreach ($criteriaQuestions as $questions)
                                @foreach ($questions as $questionCode)
                                    <th class="border border-[#DDD] font-light">{{ $questionCode }}</th>
                                @endforeach
                            @endforeach
                            <th class="border border-[#DDD] font-light"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleData['sections'] as $index => $section)
                            <tr id="row-{{ $role }}-{{ $loop->index }}" class="transition duration-100">
                                <td class="border border-[#DDD] py-2 px-4 font-light">{{ $section['subject'] }}</td>
                                <td class="border border-[#DDD] py-2 px-4 font-light">{{ $section['section'] }}</td>
                                <td class="border border-[#DDD] py-2 px-4 font-light text-center">{{ $section['N'] }}</td>

                                @foreach ($criteriaQuestions as $criteria => $questions)
                                    @foreach ($questions as $questionCode)
                                        @php
                                            $rating = $section['ratings'][$criteria][$questionCode] ?? null;
                                            $textColorClass = '';
                                        
                                            // Apply text color based on rating value
                                            if ($rating !== null) {
                                                if ($rating >= 4.5) {
                                                    $textColorClass = 'text-green-600'; // Outstanding
                                                } elseif ($rating >= 3.5) {
                                                    $textColorClass = 'text-green-500'; // Exceeds Standard
                                                } elseif ($rating >= 2.5) {
                                                    $textColorClass = 'text-yellow-500'; // Meets Standard
                                                } elseif ($rating >= 1.5) {
                                                    $textColorClass = 'text-red-500'; // Partially Meets Standard
                                                } else {
                                                    $textColorClass = 'text-red-600'; // Does not Meet Standard
                                                }
                                            }
                                        @endphp
                                        
                                        <td class="border border-[#DDD] py-2 px-4 font-light text-xs text-center {{ $textColorClass }}">
                                            {{ $rating ?? '-' }}
                                            
                                        </td>
                                    @endforeach
                            
                                @endforeach

                                <td class="border border-[#DDD] py-2 px-4 font-light text-center">{{ $section['AVG'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col justify-center xl:flex-row overflow-x-auto">

                <div class="flex justify-center flex-col md:flex-row">
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
                        <div class="p-5 overflow-x-auto justify-center flex">
                            <table class="table table-bordered font-TT table-auto">
                                <thead>
                                    <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                                        <th class="border border-[#DDD] py-2 px-4 font-light">Subject</th>
                                        <th class="border border-[#DDD] py-2 px-4 font-light">Section</th>
                                        <th class="border border-[#DDD] py-2 px-4 font-light">AVG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roleData['sections'] as $section)
                                        <tr id="row-{{ $role }}-{{ $loop->index }}">
                                            <td class="border border-[#DDD] py-2 px-4 font-light">{{ $section['subject'] }}</td>
                                            <td class="border border-[#DDD] py-2 px-4 font-light">{{ $section['section'] }}</td>
                                            <td class="border border-[#DDD] py-2 px-4 font-light text-center text-xs">{{ $section['AVG'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="border border-[#DDD] py-2 px-4 font-light text-right" colspan="2">Overall Average</td>
                                        <td class="border border-[#DDD] py-2 px-4 font-light text-center"> {{ $roleData['overall_avg'] }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 {{-- Bar Chart --}}
                 <div>
                    <div id="chart-{{ $role }}" class="overflow-x-auto overflow-y-hidden m-5 p-2 border border-[#DDD] justify-start flex"></div>
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
