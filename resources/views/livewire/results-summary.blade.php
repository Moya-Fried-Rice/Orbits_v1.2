<div class="bg-white">

    <div class="p-5 pb-0 gap-2 flex flex-wrap items-center md:justify-start justify-center relative">
        <img src="{{ asset('storage/' . $faculty->profile_image) }}" alt="Profile Image" class="
        ring-1 ring-[#DDD] border-8 border-[#F8F8F8]
        object-cover rounded-full w-40 h-40">

        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">
            <div class="ml-0 md:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 md:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl md:text-3xl">{{ $faculty->faculty_name }}</span>
                </div>

                <!-- Profile Details -->
                <div class="text-gray-600">
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/message.svg') }}" alt="Email">: <span>{{ $faculty->user->email }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/call.svg') }}" alt="Number">: <span>{{ $faculty->phone_number }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/department.svg') }}" alt="Department">: <span>{{ $faculty->department->department_name }}</span></span>
                </div>
            </div>
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

            <div class="flex flex-col xl:flex-row overflow-x-auto">

                <div class="flex justify-center flex-col md:flex-row">

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

                    {{-- Rating --}}
                    <div class="flex flex-col items-center m-5 p-2 text-center flex">
                        
                        {{-- Rating Role --}}
                        <span class="text-md font-semibold ">Overall {{ ucwords(str_replace('_', ' ', $role)) }} Rating</span>

                        <!-- Large Rating Number -->
                        <div class="text-5xl font-bold font-TT text-[#2A2723]">
                            {{ number_format($roleData['overall_avg'], 1) }}
                        </div>

                        @php
                            $totalN = array_sum(array_column($roleData['sections'], 'N'));
                            $rating = $roleData['overall_avg']; // Example: 4.3
                            $fillPercentage = ($rating / 5) * 100; // Convert rating to percentage
                        @endphp

                        <!-- Star Rating (Single SVG with Fill Percentage) -->
                        <div class="mt-2">
                            <svg width="150" height="30" viewBox="0 0 100 20" class="block">
                                <!-- Full Star Shape -->
                                <defs>
                                    <path id="starShape" d="M10 15l-5.09 2.67 1.38-5.9L2 7.24l6.18-.53L10 1.5l1.82 5.21 6.18.53-4.29 4.53 1.38 5.9z"></path>
                                </defs>

                                <!-- Empty Stars (Gray) -->
                                <g fill="#DDD">
                                    <use href="#starShape"/>
                                    <use href="#starShape" x="20"/>
                                    <use href="#starShape" x="40"/>
                                    <use href="#starShape" x="60"/>
                                    <use href="#starShape" x="80"/>
                                </g>

                                <!-- Filled Stars (Red) -->
                                <g fill="#923534" clip-path="url(#clipPath)">
                                    <rect width="{{ $fillPercentage }}%" height="20" fill="#923534"/>
                                </g>

                                <!-- Clipping Path for Partial Fill -->
                                <clipPath id="clipPath">
                                    <use href="#starShape"/>
                                    <use href="#starShape" x="20"/>
                                    <use href="#starShape" x="40"/>
                                    <use href="#starShape" x="60"/>
                                    <use href="#starShape" x="80"/>
                                </clipPath>
                            </svg>
                        </div>

                        {{-- Based on N --}}
                        <span class="text-sm text-gray-600">Based on {{ $totalN }} reviews</span>

                        {{-- Rating summary --}}
                        @php
                            $overallAvg = $roleData['overall_avg'] ?? 0;  // Get the overall average rating
                            $ratingMessage = '';
                            $textColorClass = '';

                            // Apply text color and message based on overall average rating
                            if ($overallAvg >= 4.5) {
                                $textColorClass = 'text-green-100'; // Outstanding
                                $ratingMessage = 'Outstanding. Exceeds expectations in all areas.';
                            } elseif ($overallAvg >= 3.5) {
                                $textColorClass = 'text-green-50'; // Exceeds Standard
                                $ratingMessage = 'Exceeds Standard. Meets and often exceeds expectations.';
                            } elseif ($overallAvg >= 2.5) {
                                $textColorClass = 'text-yellow-100'; // Meets Standard
                                $ratingMessage = 'Meets Standard. Meets expectations adequately.';
                            } elseif ($overallAvg >= 1.5) {
                                $textColorClass = 'text-red-50'; // Partially Meets Standard
                                $ratingMessage = 'Partially Meets Standard. Falls short of expectations in some areas.';
                            } else {
                                $textColorClass = 'text-red-100'; // Does not Meet Standard
                                $ratingMessage = 'Does not Meet Standard. Does not meet expectations.';
                            }
                        @endphp

                        @if ($ratingMessage)
                            <div class="m-2 text-sm text-gray-600 w-48">
                                <span>{{ $ratingMessage }}</span>
                            </div>
                        @endif

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
