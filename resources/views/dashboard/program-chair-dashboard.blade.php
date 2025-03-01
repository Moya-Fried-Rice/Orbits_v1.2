@extends('layouts.master')

@section('title')
    <title>Orbits | Program Chair Dashboard</title>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 animate-fade-in">
    <div class="font-tt mb-6 flex justify-between items-center p-4 bg-white shadow-sm animate-slide-down">
        <div class="text-2xl font-bold text-gray-800">
            Program Chair Dashboard
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 transition-all duration-150">
                Home
            </a>
        </div>
    </div>

    <div class="p-4 lg:p-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534] hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:100ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Department Faculty</p>
                @php
                    $departmentId = auth()->user()->programChair->department_id;
                    $facultyCount = \App\Models\Faculty::where('department_id', $departmentId)->count();
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $facultyCount }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/80 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:200ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Total Programs</p>
                @php
                    $programCount = \App\Models\Program::where('department_id', $departmentId)->count();
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $programCount }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/60 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:300ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Active Evaluations</p>
                @php
                    $activeEvals = \App\Models\Evaluation::whereHas('courseSection.course', function($query) use ($departmentId) {
                        $query->where('department_id', $departmentId);
                    })->count();
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $activeEvals }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/40 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:400ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Department Response Rate</p>
                @php
                    $deptUserEvals = \App\Models\UserEvaluation::whereHas('evaluation.courseSection.course', function($query) use ($departmentId) {
                        $query->where('department_id', $departmentId);
                    });
                    $deptTotal = $deptUserEvals->count();
                    $deptCompleted = $deptUserEvals->where('is_completed', true)->count();
                    $deptRate = $deptTotal > 0 ? round(($deptCompleted / $deptTotal) * 100) : 0;
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $deptRate }}%</h3>
            </div>
        </div>

        <!-- Department Progress and Programs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:500ms]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534]">Department Progress</h2>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-[#923534]"></span>
                        <span class="text-sm font-tt text-gray-600">Completion Rate</span>
                    </div>
                </div>
                <div class="relative min-h-[350px] lg:min-h-[400px] w-full">
                    <div class="absolute inset-0" id="progressChart"></div>
                </div>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:600ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Department Programs</h2>
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
        </div>

        <!-- Faculty Performance and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:700ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Faculty Response Rates</h2>
                <div class="relative min-h-[350px] lg:min-h-[400px] w-full">
                    <div class="absolute inset-0" id="facultyChart"></div>
                </div>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:800ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Recent Evaluation Activity</h2>
                <div class="space-y-4">
                    @php
                        $recentEvals = \App\Models\UserEvaluation::whereHas('evaluation.courseSection.course', function($query) use ($departmentId) {
                            $query->where('department_id', $departmentId);
                        })
                        ->where('is_completed', true)
                        ->orderBy('evaluated_at', 'desc')
                        ->take(5)
                        ->get();
                    @endphp
                    @foreach($recentEvals as $eval)
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
                                    Evaluation completed {{ $eval->evaluated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
        fontFamily: 'TT, sans-serif',
        foreColor: '#4B5563',
        primaryColor: '#923534',
        chart: {
            background: 'transparent',
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
            ...theme.chart
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 225,
                hollow: {
                    margin: 15,
                    size: '70%'
                },
                track: {
                    background: '#F3F4F6',
                    strokeWidth: '100%',
                    margin: 5
                },
                dataLabels: {
                    show: true,
                    name: {
                        offsetY: -10,
                        show: true,
                        color: theme.primaryColor,
                        fontSize: '16px',
                        fontFamily: theme.fontFamily,
                        fontWeight: 600
                    },
                    value: {
                        formatter: function(val) {
                            return val.toFixed(1) + '%';
                        },
                        color: '#111827',
                        fontSize: '36px',
                        fontFamily: theme.fontFamily,
                        fontWeight: 600,
                        show: true
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
            ...theme.chart
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
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
            offsetX: 30,
            style: {
                fontSize: '12px',
                colors: [theme.foreColor]
            }
        },
        xaxis: {
            categories: {{ $facultyLabels }},
            labels: {
                style: {
                    colors: theme.foreColor,
                    fontSize: '12px',
                    fontFamily: theme.fontFamily
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: theme.foreColor,
                    fontSize: '12px',
                    fontFamily: theme.fontFamily
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
