@extends('layouts.master')

@section('title')
    <title>Orbits | Program Chair Dashboard</title>
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="flex flex-col gap-1 mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-silka">Program Chair Dashboard</h1>
    <p class="text-gray-500 font-TT">Overview of department performance and faculty evaluations</p>
</div>

@php
    $department = auth()->user()->programChair->department->department_code ?? 'Unknown Department';
@endphp

<!-- Statistics Cards Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Department Faculty</dt>
                        <dd class="flex items-baseline">
                            @php
                                $departmentId = auth()->user()->programChair->department_id;
                                $facultyCount = \App\Models\Faculty::where('department_id', $departmentId)->count();
                            @endphp
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ $facultyCount }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1"></div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Total Programs</dt>
                        <dd class="flex items-baseline">
                            @php
                                $programCount = \App\Models\Program::where('department_id', $departmentId)->count();
                            @endphp
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ $programCount }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1 opacity-75"></div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Active Evaluations</dt>
                        <dd class="flex items-baseline">
                            @php
                                $activeEvals = \App\Models\Evaluation::whereHas('courseSection.course', function($query) use ($departmentId) {
                                    $query->where('department_id', $departmentId);
                                })->count();
                            @endphp
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ $activeEvals }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1 opacity-50"></div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Department Response Rate</dt>
                        <dd class="flex items-baseline">
                            @php
                                $deptUserEvals = \App\Models\UserEvaluation::whereHas('evaluation.courseSection.course', function($query) use ($departmentId) {
                                    $query->where('department_id', $departmentId);
                                });
                                $deptTotal = $deptUserEvals->count();
                                $deptCompleted = $deptUserEvals->where('is_completed', true)->count();
                                $deptRate = $deptTotal > 0 ? round(($deptCompleted / $deptTotal) * 100) : 0;
                            @endphp
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ $deptRate }}%</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-[#923534] h-1 opacity-25"></div>
    </div>
</div>

<!-- Charts Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Department Progress Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                {{ $department }} - Evaluation Progress
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Overall Progress
            </div>
        </div>
        <div id="progressChart" class="w-full h-80"></div>
    </div>

    <!-- Department Programs -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Department Programs
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Active Programs
            </div>
        </div>
        <div class="space-y-4">
            @foreach(\App\Models\Program::where('department_id', $departmentId)->get() as $program)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 mt-2 rounded-full bg-[#923534]"></div>
                    </div>
                    <div>
                        <p class="font-tt font-medium text-gray-900">{{ $program->program_name }}</p>
                        <p class="text-sm text-gray-500">{{ $program->program_code }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Faculty Response Rates -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Faculty Response Rates
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                By Faculty
            </div>
        </div>
        <div id="facultyChart" class="w-full h-80"></div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Recent Activity
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Last 5 Evaluations
            </div>
        </div>
        <div class="space-y-4">
            @php
                $recentEvals = \App\Models\UserEvaluation::where('user_id', auth()->id())
                ->where('is_completed', true)
                ->orderBy('evaluated_at', 'desc')
                ->take(5)
                ->get();
            @endphp
            @forelse($recentEvals as $eval)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                    </div>
                    <div>
                        <p class="font-tt font-medium text-gray-900">
                            {{ $eval->evaluation->courseSection->course->course_code }} - 
                            {{ $eval->evaluation->courseSection->section->section_name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Evaluation completed 
                            @if($eval->evaluated_at)
                                {{ date('M d, Y h:i A', strtotime($eval->evaluated_at)) }}
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
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Common chart theme
    const theme = {
        fontFamily: {
            title: 'Silka, sans-serif',
            body: 'TT, sans-serif'
        },
        foreColor: '#4B5563',
        primaryColor: '#923534',
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

    // Department Progress Chart
    var optionsProgress = {
        series: [{{ $deptRate }}],
        chart: {
            type: 'radialBar',
            height: 320,
            ...theme.chart
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 15,
                    size: '70%'
                },
                track: {
                    background: '#F3F4F6',
                    strokeWidth: '97%',
                    margin: 5,
                    dropShadow: {
                        enabled: false
                    }
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: theme.primaryColor,
                        fontSize: '14px',
                        fontFamily: theme.fontFamily.body,
                        fontWeight: 600
                    },
                    value: {
                        offsetY: 5,
                        fontSize: '24px',
                        fontFamily: theme.fontFamily.title,
                        fontWeight: 700,
                        formatter: function(val) {
                            return val.toFixed(1) + '%';
                        }
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'horizontal',
                shadeIntensity: 0.5,
                gradientToColors: ['#923534'],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
            }
        },
        stroke: {
            lineCap: 'round'
        },
        labels: ['Completion Rate'],
        colors: [theme.primaryColor]
    };

    // Faculty Response Rates Chart
    @php
        $faculty = \App\Models\Faculty::where('department_id', $departmentId)->get();
        
        $facultyLabels = $faculty->map(function($f) {
            return $f->user->name;
        })->toJson();

        $facultyRates = $faculty->map(function($f) {
            $total = \App\Models\UserEvaluation::whereHas('evaluation.courseSection', function($query) use ($f) {
                $query->whereIn('course_section_id', 
                    \App\Models\FacultyCourse::where('faculty_id', $f->faculty_id)->pluck('course_section_id')
                );
            })->count();
            
            $completed = \App\Models\UserEvaluation::whereHas('evaluation.courseSection', function($query) use ($f) {
                $query->whereIn('course_section_id', 
                    \App\Models\FacultyCourse::where('faculty_id', $f->faculty_id)->pluck('course_section_id')
                );
            })->where('is_completed', true)->count();
            
            return $total > 0 ? round(($completed / $total) * 100) : 0;
        })->toJson();
    @endphp

    var optionsFaculty = {
        series: [{
            name: 'Response Rate',
            data: {{ $facultyRates }}
        }],
        chart: {
            type: 'bar',
            height: 320,
            ...theme.chart
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                horizontal: true,
                distributed: true,
                dataLabels: {
                    position: 'top'
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val + '%';
            },
            style: {
                fontSize: '12px',
                fontFamily: theme.fontFamily.body,
                fontWeight: 'bold',
                colors: ['#fff']
            },
            background: {
                enabled: true,
                foreColor: '#fff',
                padding: 4,
                borderRadius: 2,
                borderWidth: 0,
                opacity: 0.9,
                dropShadow: {
                    enabled: false
                }
            }
        },
        xaxis: {
            categories: {{ $facultyLabels }},
            labels: {
                style: {
                    fontSize: '12px',
                    fontFamily: theme.fontFamily.body
                }
            }
        },
        colors: [theme.primaryColor]
    };

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        new ApexCharts(document.querySelector("#progressChart"), optionsProgress).render();
        new ApexCharts(document.querySelector("#facultyChart"), optionsFaculty).render();
    });
</script>
@endsection
