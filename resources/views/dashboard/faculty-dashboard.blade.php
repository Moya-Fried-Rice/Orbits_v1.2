@extends('layouts.master')

@section('title')
    <title>Orbits | Faculty Dashboard</title>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 animate-fade-in">
    <div class="font-tt mb-6 flex justify-between items-center p-4 bg-white shadow-sm animate-slide-down">
        <div class="text-2xl font-bold text-gray-800">
            Faculty Dashboard
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
                <p class="text-[#923534] font-tt font-semibold mb-1">My Courses</p>
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ \App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)->count() }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/80 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:200ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Total Students</p>
                @php
                    $studentCount = \App\Models\StudentCourse::whereHas('courseSection', function($query) {
                        $query->whereIn('course_section_id', 
                            \App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)
                                ->pluck('course_section_id')
                        );
                    })->count();
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $studentCount }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/60 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:300ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Evaluations</p>
                @php
                    $evaluationCount = \App\Models\Evaluation::whereIn('course_section_id', 
                        \App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)
                            ->pluck('course_section_id')
                    )->count();
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $evaluationCount }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/40 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:400ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Response Rate</p>
                @php
                    $userEvals = \App\Models\UserEvaluation::whereHas('evaluation', function($query) {
                        $query->whereIn('course_section_id', 
                            \App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)
                                ->pluck('course_section_id')
                        );
                    });
                    $total = $userEvals->count();
                    $completed = $userEvals->where('is_completed', true)->count();
                    $rate = $total > 0 ? round(($completed / $total) * 100) : 0;
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $rate }}%</h3>
            </div>
        </div>

        <!-- Progress and Classes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:500ms]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534]">Evaluation Response Rate</h2>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-[#923534]"></span>
                        <span class="text-sm font-tt text-gray-600">Response Rate</span>
                    </div>
                </div>
                <div class="relative min-h-[350px] lg:min-h-[400px] w-full">
                    <div class="absolute inset-0" id="responseChart"></div>
                </div>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:600ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">My Classes</h2>
                <div class="space-y-4">
                    @foreach(\App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)
                            ->with(['courseSection.course', 'courseSection.section'])
                            ->get() as $course)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 mt-2 rounded-full bg-[#923534]"></div>
                            </div>
                            <div>
                                <p class="font-tt font-medium text-gray-900">
                                    {{ $course->courseSection->course->course_code }} - 
                                    {{ $course->courseSection->course->course_name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Section: {{ $course->courseSection->section->section_name }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Response Distribution and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:700ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Response Distribution</h2>
                <div class="relative min-h-[350px] lg:min-h-[400px] w-full">
                    <div class="absolute inset-0" id="distributionChart"></div>
                </div>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:800ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Recent Evaluation Activity</h2>
                <div class="space-y-4">
                    @php
                        $recentEvals = \App\Models\UserEvaluation::whereHas('evaluation', function($query) {
                            $query->whereIn('course_section_id', 
                                \App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)
                                    ->pluck('course_section_id')
                            );
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

    // Response Rate Chart
    var optionsResponse = {
        series: [{{ $rate }}],
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
        labels: ['Response Rate'],
        colors: [theme.primaryColor]
    };

    // Distribution Chart
    @php
        $courseSections = \App\Models\FacultyCourse::where('faculty_id', auth()->user()->faculty->faculty_id)
            ->with(['courseSection.course'])
            ->get();
        
        $courseLabels = $courseSections->map(function($fc) {
            return $fc->courseSection->course->course_code;
        })->toJson();

        $responseRates = $courseSections->map(function($fc) {
            $total = \App\Models\UserEvaluation::whereHas('evaluation', function($query) use ($fc) {
                $query->where('course_section_id', $fc->course_section_id);
            })->count();
            
            $completed = \App\Models\UserEvaluation::whereHas('evaluation', function($query) use ($fc) {
                $query->where('course_section_id', $fc->course_section_id);
            })->where('is_completed', true)->count();
            
            return $total > 0 ? round(($completed / $total) * 100) : 0;
        })->toJson();
    @endphp

    var optionsDistribution = {
        series: [{
            name: 'Response Rate',
            data: {{ $responseRates }}
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
            categories: {{ $courseLabels }},
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
        new ApexCharts(document.querySelector("#responseChart"), optionsResponse).render();
        new ApexCharts(document.querySelector("#distributionChart"), optionsDistribution).render();
    });
</script>
@endsection
