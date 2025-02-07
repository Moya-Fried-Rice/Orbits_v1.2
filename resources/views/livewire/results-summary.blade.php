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

    <div class="p-5 overflow-x-auto w-full">
        <table class="table table-bordered font-TT w-full table-auto">
            <thead>
                <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                    <th class="border border-[#DDD] py-2 px-4 font-light">Subject</th>
                    <th class="border border-[#DDD] py-2 px-4 font-light">Section</th>
                    <th class="border border-[#DDD] py-2 px-4 font-light">N</th>
                    
                    @foreach ($evaluationData['criteriaQuestions'] as $criteria => $questions)
                        <th class="border border-[#DDD] py-2 px-4 font-light" colspan="{{ count($questions) }}">{{ $criteria }}</th>
                    @endforeach
                    
                    <th class="border border-[#DDD] py-2 px-4 font-light">AVG</th>
                </tr>
                <tr class="bg-gray-100">
                    <th colspan="3" class="border border-[#DDD] font-light"></th>
                    @foreach ($evaluationData['criteriaQuestions'] as $questions)
                        @foreach ($questions as $questionCode => $value)
                            <th class="border border-[#DDD] font-light">{{ $questionCode }}</th>
                        @endforeach
                    @endforeach
                    <th class="border border-[#DDD] font-light"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluationData['data'] as $row)
                    <tr>
                        <td class="border border-[#DDD] py-2 px-4 font-light">{{ $row['subject'] }}</td>
                        <td class="border border-[#DDD] py-2 px-4 font-light">{{ $row['section'] }}</td>
                        <td class="border border-[#DDD] py-2 px-4 font-light text-center">{{ $row['N'] }}</td>
                        
                        @foreach ($evaluationData['criteriaQuestions'] as $questions)
                            @foreach ($questions as $questionId)
                                <td class="border border-[#DDD] py-2 px-4 font-light text-center">
                                    {{ $row['ratings'][$questionId] ?? '-' }}
                                </td>
                            @endforeach
                        @endforeach
                        
                        <td class="border border-[#DDD] py-2 px-4 font-light text-center">{{ $row['AVG'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
