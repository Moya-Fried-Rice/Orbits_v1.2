@extends('layouts.master')

@section('title')
    <title>Orbits | Student Dashboard</title>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 animate-fade-in">
    <div class="font-tt mb-6 flex justify-between items-center p-4 bg-white shadow-sm animate-slide-down">
        <div class="text-2xl font-bold text-gray-800">
            Student Dashboard
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
            <!-- Same stat cards with Tailwind animations -->
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534] hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:100ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">My Active Courses</p>
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ \App\Models\StudentCourse::where('student_id', auth()->user()->student->student_id)->count() }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/80 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:200ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Pending Evaluations</p>
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', false)->count() }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/60 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:300ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Completed Evaluations</p>
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', true)->count() }}</h3>
            </div>
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border-l-4 border-[#923534]/40 hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:400ms]">
                <p class="text-[#923534] font-tt font-semibold mb-1">Participation Rate</p>
                @php
                    $total = \App\Models\UserEvaluation::where('user_id', auth()->id())->count();
                    $completed = \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', true)->count();
                    $rate = $total > 0 ? round(($completed / $total) * 100) : 0;
                @endphp
                <h3 class="text-2xl lg:text-3xl font-tt font-bold text-gray-900">{{ $rate }}%</h3>
            </div>
        </div>

        <!-- Progress and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:500ms]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534]">Evaluation Progress</h2>
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
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    @foreach(\App\Models\UserEvaluation::where('user_id', auth()->id())
                            ->orderBy('evaluated_at', 'desc')
                            ->take(5)
                            ->get() as $evaluation)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 mt-2 rounded-full {{ $evaluation->is_completed ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                            </div>
                            <div>
                                <p class="font-tt font-medium text-gray-900">
                                    {{ $evaluation->evaluation->courseSection->course->course_code }} - 
                                    {{ $evaluation->evaluation->courseSection->section->section_name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $evaluation->is_completed ? 'Completed' : 'Pending' }} | 
                                    {{ $evaluation->evaluated_at ? $evaluation->evaluated_at->diffForHumans() : 'Not started' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Course Schedule and Pending Tasks -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:700ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">My Courses</h2>
                <div class="space-y-4">
                    @foreach(\App\Models\StudentCourse::where('student_id', auth()->user()->student->student_id)
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
            <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-150 opacity-0 animate-fade-in-up [animation-delay:800ms]">
                <h2 class="text-lg lg:text-xl font-tt font-bold text-[#923534] mb-4">Pending Evaluations</h2>
                <div class="space-y-4">
                    @foreach(\App\Models\UserEvaluation::where('user_id', auth()->id())
                            ->where('is_completed', false)
                            ->with(['evaluation.courseSection.course', 'evaluation.courseSection.section'])
                            ->get() as $pending)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 mt-2 rounded-full bg-yellow-500"></div>
                            </div>
                            <div>
                                <p class="font-tt font-medium text-gray-900">
                                    {{ $pending->evaluation->courseSection->course->course_code }} - 
                                    {{ $pending->evaluation->courseSection->section->section_name }}
                                </p>
                                <p class="text-sm text-gray-500">Faculty Evaluation Pending</p>
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

    // Progress Chart
    var totalEvals = {{ \App\Models\UserEvaluation::where('user_id', auth()->id())->count() }};
    var completedEvals = {{ \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', true)->count() }};
    var completionRate = totalEvals > 0 ? (completedEvals / totalEvals) * 100 : 0;
    
    var optionsProgress = {
        series: [completionRate],
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

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        new ApexCharts(document.querySelector("#progressChart"), optionsProgress).render();
    });
</script>
@endsection
