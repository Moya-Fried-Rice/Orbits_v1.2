@extends('layouts.master')

@section('title')
    <title>Orbits | Evaluation Monitoring</title>
@endsection

@section('content')
<!-- Breadcrumb Navigation -->
<div class="font-TT mb-6 flex justify-between items-center gap-2 text-sm text-gray-600">
    <div class="opacity-70 hidden md:block">
        Evaluation Monitoring
    </div>
    <div class="flex justify-between items-center gap-2">
        <a href="{{ route('dashboard') }}" class="opacity-70 hover:opacity-100 hover:text-[#923534] transition-all duration-200">
            Home
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('monitor') }}" class="opacity-70 hover:opacity-100 hover:text-[#923534] transition-all duration-200">
            Monitor
        </a>
    </div>
</div>

<!-- Dashboard Header -->
<div class="flex flex-col gap-2 mb-10">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 font-silka">Evaluation Monitoring</h1>
    <p class="text-gray-500 font-TT text-sm md:text-base">Real-time tracking of evaluation progress and metrics</p>
</div>

<!-- Statistics Cards Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Total Evaluations</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-800 font-silka">{{ \App\Models\UserEvaluation::count() }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1"></div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Ongoing Evaluations</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-800 font-silka">{{ \App\Models\UserEvaluation::where('is_completed', false)->count() }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1 opacity-75"></div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Completed Today</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-800 font-silka">{{ \App\Models\UserEvaluation::where('is_completed', true)->whereDate('evaluated_at', today())->count() }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1 opacity-50"></div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        @php
                            $totalStudents = \App\Models\Student::count();
                            $participatingStudents = \App\Models\UserEvaluation::distinct('user_id')->count();
                            $participationRate = $totalStudents > 0 ? ($participatingStudents / $totalStudents) * 100 : 0;
                        @endphp
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Participation Rate</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-800 font-silka">{{ number_format($participationRate, 1) }}%</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1 opacity-25"></div>
    </div>
</div>

<!-- Department Progress -->
<div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 mb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-2 sm:mb-0 flex items-center font-silka">
            <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
            Department Evaluation Progress
        </h2>
        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
            Completion Rate
        </div>
    </div>
    <div class="space-y-6">
        @foreach(\App\Models\Department::all() as $dept)
            @php
                $totalDeptEvals = \App\Models\UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                    ->join('course_sections', 'evaluations.course_section_id', '=', 'course_sections.course_section_id')
                    ->join('courses', 'course_sections.course_id', '=', 'courses.course_id')
                    ->where('courses.department_id', $dept->department_id)
                    ->count();
                $completedDeptEvals = \App\Models\UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                    ->join('course_sections', 'evaluations.course_section_id', '=', 'course_sections.course_section_id')
                    ->join('courses', 'course_sections.course_id', '=', 'courses.course_id')
                    ->where('courses.department_id', $dept->department_id)
                    ->where('user_evaluations.is_completed', 1)
                    ->count();
                $completionRate = $totalDeptEvals > 0 ? ($completedDeptEvals / $totalDeptEvals) * 100 : 0;
            @endphp
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">{{ $dept->department_name }}</span>
                    <span class="text-sm font-medium text-gray-700">{{ number_format($completionRate, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-[#923534] h-2.5 rounded-full transition-all duration-500" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Monitoring Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Evaluations -->
    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Recent Evaluations
            </h2>
            <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Last 24 Hours
            </div>
        </div>
        
        <!-- Evaluation Line Chart with fixed height to match faculty table -->
        <div id="recentEvaluationsChart" class="w-full h-[300px] mb-6 flex justify-center items-center"></div>
        
        <!-- Recent evaluations list with fixed height and scrolling -->
        <div class="h-[212px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <div class="space-y-4">
                @foreach(\App\Models\UserEvaluation::with(['user', 'evaluation.courseSection.course', 'evaluation.courseSection.facultyCourses.faculty'])
                    ->where('is_completed', true)
                    ->whereDate('evaluated_at', '>=', now()->subDay())
                    ->latest('evaluated_at')
                    ->take(10)
                    ->get() as $eval)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 rounded-full p-2.5 flex items-center justify-center">
                                <i class="fa-solid fa-user-graduate text-gray-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $eval->user->user_name ?? 'Student' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $eval->evaluation->courseSection->course->course_code ?? '' }} - 
                                    {{ $eval->evaluation->courseSection->facultyCourses->first()?->faculty->faculty_name ?? '' }}
                                </p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $eval->evaluated_at ? $eval->evaluated_at->diffForHumans() : 'Recently' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Faculty Status -->
    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Faculty Completion Status
            </h2>
            <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Current Semester
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    id="facultySearch" 
                    class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-lg block w-full pl-10 p-3 focus:ring-[#923534] focus:border-[#923534] transition-colors duration-200" 
                    placeholder="Search faculty name or department..."
                    onkeyup="searchFaculty()"
                >
            </div>
        </div>
        
        <!-- Faculty Table with fixed height and scrolling -->
        <div class="overflow-x-auto h-[400px] overflow-y-auto w-full rounded-lg shadow-sm scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <table class="min-w-full divide-y divide-gray-200" id="facultyTable">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Faculty Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dept
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Completion
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        // Use the same query approach as in FacultyCrud.php
                        $faculties = \App\Models\Faculty::selectRaw('faculties.*, departments.department_name, departments.department_code')
                            ->leftJoin('departments', 'faculties.department_id', '=', 'departments.department_id')
                            ->with('user')
                            ->orderBy('departments.department_code')
                            ->get();
                    @endphp
                    
                    @foreach($faculties as $faculty)
                        @php
                            try {
                                // Get faculty courses for evaluations
                                $facultyCourses = \App\Models\FacultyCourse::where('faculty_id', $faculty->faculty_id)->pluck('course_section_id');
                                
                                // Count total evaluations for this faculty's courses
                                $totalFacultyEvals = \App\Models\UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                                    ->whereIn('evaluations.course_section_id', $facultyCourses)
                                    ->count();
                                
                                // Count completed evaluations for this faculty's courses
                                $completedFacultyEvals = \App\Models\UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                                    ->whereIn('evaluations.course_section_id', $facultyCourses)
                                    ->where('user_evaluations.is_completed', true)
                                    ->count();
                                
                                $completionPercentage = $totalFacultyEvals > 0 ? ($completedFacultyEvals / $totalFacultyEvals) * 100 : 0;
                                $status = $totalFacultyEvals > 0 ? 
                                    ($completedFacultyEvals >= $totalFacultyEvals ? 'Completed' : 'In Progress') : 
                                    'Not Started';
                            } catch (\Exception $e) {
                                $totalFacultyEvals = 0;
                                $completedFacultyEvals = 0;
                                $completionPercentage = 0;
                                $status = 'Not Started';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 bg-gray-100 rounded-full flex items-center justify-center">
                                        @if($faculty->user && $faculty->user->profile_image)
                                            <img src="{{ asset('storage/' . $faculty->user->profile_image) }}" alt="Profile" class="h-9 w-9 rounded-full object-cover">
                                        @else
                                            <i class="fa-solid fa-user text-gray-500"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-800">
                                            {{ $faculty->user ? $faculty->user->first_name . ' ' . $faculty->user->last_name : 'Unknown' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534]">
                                    {{ $faculty->department_code ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status === 'Completed' ? 'bg-green-100 text-green-800' : ($status === 'In Progress' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1.5">
                                    <div class="bg-[#923534] h-2.5 rounded-full transition-all duration-500" style="width: {{ $completionPercentage }}%"></div>
                                </div>
                                <span class="text-xs">{{ number_format($completionPercentage, 1) }}% ({{ $completedFacultyEvals }}/{{ $totalFacultyEvals }})</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Common chart theme based on admin dashboard
    const theme = {
        fontFamily: {
            title: 'Silka, sans-serif',
            body: 'TT, sans-serif'
        },
        foreColor: '#4B5563',
        primaryColor: '#923534',
        grid: {
            borderColor: '#E5E7EB',
            padding: {
                top: 20,
                right: 25,
                bottom: 20,
                left: 25
            }
        },
        chart: {
            background: '#FFFFFF',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        }
    };

    // Recent Evaluations Line Chart - Last 24 hours by hour
    var optionsRecentEvals = {
        ...theme,
        chart: { 
            type: 'area',
            height: 300, // Adjusted to match container height
            ...theme.chart
        },
        stroke: {
            curve: 'smooth',
            width: 3,
            colors: [theme.primaryColor]
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100, 100, 100]
            }
        },
        series: [{
            name: 'Evaluations',
            data: [
                @for($i = 0; $i < 24; $i++)
                    {{ \App\Models\UserEvaluation::where('is_completed', true)
                        ->where('evaluated_at', '>=', now()->subHours(24))
                        ->whereRaw('HOUR(evaluated_at) = ?', [$i])
                        ->count() }}{{ $i < 23 ? ',' : '' }}
                @endfor
            ]
        }],
        xaxis: {
            type: 'category',
            categories: [
                @for($i = 0; $i < 24; $i++)
                    '{{ $i }}:00'{{ $i < 23 ? ',' : '' }}
                @endfor
            ],
            labels: {
                style: {
                    fontSize: '10px',
                    fontFamily: theme.fontFamily.body
                },
                formatter: function(val) {
                    // Convert 24-hour format to 12-hour format
                    let hour = parseInt(val);
                    return (hour % 12 || 12) + (hour < 12 ? ' AM' : ' PM');
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    return Math.round(val);
                }
            }
        },
        colors: [theme.primaryColor],
        tooltip: {
            theme: 'light',
            x: {
                formatter: function(val) {
                    // Convert 24-hour format to 12-hour format
                    let hour = parseInt(val);
                    return (hour % 12 || 12) + (hour < 12 ? ' AM' : ' PM');
                }
            },
            y: {
                formatter: function(val) {
                    return val + " evaluations";
                }
            }
        },
        markers: {
            size: 4,
            colors: [theme.primaryColor],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: {
                size: 6
            }
        }
    };
    
    // Initialize chart
    setTimeout(function() {
        const chart = new ApexCharts(document.querySelector("#recentEvaluationsChart"), optionsRecentEvals);
        chart.render();
        
        // Center the chart in its container
        const chartContainer = document.querySelector('#recentEvaluationsChart');
        if (chartContainer) {
            const apexChart = chartContainer.querySelector('.apexcharts-canvas');
            if (apexChart) {
                apexChart.style.margin = '0 auto';
            }
        }
    }, 100);

    // Responsive adjustments
    function handleResize() {
        const charts = document.querySelectorAll('.apexcharts-canvas');
        if (window.innerWidth < 768) {
            charts.forEach(chart => {
                chart.style.height = 'auto';
            });
        }
        
        // Center the chart after resize
        const chartContainer = document.querySelector('#recentEvaluationsChart');
        if (chartContainer) {
            const apexChart = chartContainer.querySelector('.apexcharts-canvas');
            if (apexChart) {
                apexChart.style.margin = '0 auto';
            }
        }
    }

    window.addEventListener('resize', handleResize);
    window.addEventListener('load', handleResize);
    handleResize();

    // Faculty search function
    function searchFaculty() {
        const input = document.getElementById('facultySearch');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('facultyTable');
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
            const nameCell = rows[i].getElementsByTagName('td')[0];
            const deptCell = rows[i].getElementsByTagName('td')[1];
            
            if (nameCell && deptCell) {
                const nameValue = nameCell.textContent || nameCell.innerText;
                const deptValue = deptCell.textContent || deptCell.innerText;
                
                if (nameValue.toUpperCase().indexOf(filter) > -1 || deptValue.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>
@endsection

