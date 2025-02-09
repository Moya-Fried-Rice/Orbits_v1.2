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
        <div class="text-lg pl-5 pt-5">{{ ucfirst($role) }} Evaluations</div>

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
                    @foreach ($roleData['sections'] as $section)
                        <tr>
                            <td class="border border-[#DDD] py-2 px-4 font-light">{{ $section['subject'] }}</td>
                            <td class="border border-[#DDD] py-2 px-4 font-light">{{ $section['section'] }}</td>
                            <td class="border border-[#DDD] py-2 px-4 font-light text-center">{{ $section['N'] }}</td>

                            @foreach ($criteriaQuestions as $criteria => $questions)
                                @foreach ($questions as $questionCode)
                                    <td class="border border-[#DDD] py-2 px-4 font-light text-xs text-center">
                                        {{ $section['ratings'][$criteria][$questionCode] ?? '-' }}
                                    </td>
                                @endforeach
                            @endforeach

                            <td class="border border-[#DDD] py-2 px-4 font-light text-center">{{ $section['AVG'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary Table with Only Subject, Section, and AVG --}}
        <div class="p-5 overflow-x-auto w-full">
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
                        <tr>
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
@endforeach

</div>
