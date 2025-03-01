@extends('layouts.master')

@section('title')
    <title>Orbits | Student Dashboard</title>
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="flex flex-col gap-1 mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-silka">Student Dashboard</h1>
    <p class="text-gray-500 font-TT">Overview of your evaluation progress and courses</p>
</div>

<!-- Statistics Cards Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#923534]/10 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#923534]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">My Active Courses</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 font-silka">
                                {{ \App\Models\StudentCourse::where('student_id', auth()->user()->student->student_id)->count() }}
                            </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Pending Evaluations</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 font-silka">
                                {{ \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', false)->count() }}
                            </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Completed Evaluations</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 font-silka">
                                {{ \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', true)->count() }}
                            </div>
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
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Participation Rate</dt>
                        <dd class="flex items-baseline">
                            @php
                                $total = \App\Models\UserEvaluation::where('user_id', auth()->id())->count();
                                $completed = \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', true)->count();
                                $rate = $total > 0 ? round(($completed / $total) * 100) : 0;
                            @endphp
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ $rate }}%</div>
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
    <!-- Progress Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Evaluation Progress
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Completion Rate
            </div>
        </div>
        <div id="progressChart" class="w-full h-80"></div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Recent Activity
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Last 5 Activities
            </div>
        </div>
        <div class="space-y-4">
            @php
                $recentEvals = \App\Models\UserEvaluation::where('user_id', auth()->id())
                    ->orderBy('evaluated_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            @forelse($recentEvals as $evaluation)
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
                            {{ $evaluation->is_completed ? 'Completed' : 'Pending' }}
                            @if($evaluation->evaluated_at)
                                | {{ date('M d, Y h:i A', strtotime($evaluation->evaluated_at)) }}
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

    <!-- My Courses -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                My Courses
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Current Semester
            </div>
        </div>
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

    <!-- Pending Evaluations -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Pending Evaluations
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Action Required
            </div>
        </div>
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

    // Progress Chart
    var totalEvals = {{ \App\Models\UserEvaluation::where('user_id', auth()->id())->count() }};
    var completedEvals = {{ \App\Models\UserEvaluation::where('user_id', auth()->id())->where('is_completed', true)->count() }};
    var completionRate = totalEvals > 0 ? (completedEvals / totalEvals) * 100 : 0;
    
    var optionsProgress = {
        series: [completionRate],
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

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        new ApexCharts(document.querySelector("#progressChart"), optionsProgress).render();
    });
</script>
@endsection
