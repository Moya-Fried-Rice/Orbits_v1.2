@extends('layouts.master')

@section('title')
    <title>Orbits | Admin Dashboard</title>
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="flex flex-col gap-1 mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-silka">Admin Dashboard</h1>
    <p class="text-gray-500 font-TT">Overview of evaluation metrics and performance</p>
</div>

<!-- Statistics Cards Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
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
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Total Evaluations</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ \App\Models\UserEvaluation::count() }}</div>
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
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ \App\Models\UserEvaluation::where('is_completed', false)->count() }}</div>
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
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ \App\Models\UserEvaluation::where('is_completed', true)->count() }}</div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate font-TT">Total Users</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 font-silka">{{ \App\Models\User::count() }}</div>
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
    
    <!-- Monthly Growth Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Daily Evaluation Growth
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Growth Rate
            </div>
        </div>
        <div id="lineChart2" class="w-full h-80"></div>
    </div>
    
    <!-- Department Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Evaluations by Department
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Total Count
            </div>
        </div>
        <div id="barChart" class="w-full h-80"></div>
    </div>
    
    <!-- Trends Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-2 sm:mb-0 flex items-center font-silka">
                <div class="w-1 h-6 bg-[#923534] rounded-full mr-3"></div>
                Evaluation Trends Over Time
            </h2>
            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#923534]/10 text-[#923534] font-TT">
                Monthly Progress
            </div>
        </div>
        <div id="lineChart" class="w-full h-80"></div>
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
        grid: {
            borderColor: '#E5E7EB',
            padding: {
                top: 10,
                right: 25,
                bottom: 10,
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

    // Progress Chart - Using actual completion percentages
    var totalEvals = {{ \App\Models\UserEvaluation::count() }};
    var completedEvals = {{ \App\Models\UserEvaluation::where('is_completed', true)->count() }};
    var completionRate = totalEvals > 0 ? (completedEvals / totalEvals) * 100 : 0;
    
    var optionsProgress = {
        ...theme,
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
        series: [completionRate],
        labels: ['Completion Rate'],
        colors: [theme.primaryColor],
        stroke: {
            lineCap: 'round'
        }
    };
    new ApexCharts(document.querySelector("#progressChart"), optionsProgress).render();

    // Monthly Growth Line Chart
    var currentYear = new Date().getFullYear();
    // Get hourly data for today
    var hours = Array.from({length: 24}, (_, i) => {
        let d = new Date();
        d.setHours(i, 0, 0, 0);
        return d;
    });

    var optionsLine2 = {
        ...theme,
        chart: { 
            type: 'area',
            height: 320,
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
                    {{ \App\Models\UserEvaluation::whereDate('evaluated_at', now())
                        ->whereRaw('HOUR(evaluated_at) = ?', [$i])
                        ->count() }}{{ $i < 23 ? ',' : '' }}
                @endfor
            ]
        }],
        xaxis: {
            type: 'category',
            categories: hours.map(hour => hour.getHours() + ':00'),
            labels: {
                style: {
                    fontSize: '12px',
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
                    return val.toFixed(0);
                }
            }
        },
        colors: [theme.primaryColor],
        title: {
            text: 'Today\'s Hourly Evaluation Activity',
            align: 'left',
            style: {
                fontSize: '14px',
                fontWeight: '500',
                fontFamily: theme.fontFamily.title
            }
        },
        tooltip: {
            theme: 'light',
            x: {
                formatter: function(val) {
                    // Convert 24-hour format to 12-hour format
                    let hour = parseInt(val);
                    return (hour % 12 || 12) + (hour < 12 ? ' AM' : ' PM');
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#lineChart2"), optionsLine2).render();

    // Department Bar Chart
    var departmentData = [
        @foreach(\App\Models\Department::orderBy('department_code')->get() as $department)
            {
                code: '{{ $department->department_code }}',
                count: {{ \App\Models\UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                    ->join('course_sections', 'evaluations.course_section_id', '=', 'course_sections.course_section_id')
                    ->join('courses', 'course_sections.course_id', '=', 'courses.course_id')
                    // ->where('courses.department_id', $department->department_id)
                    ->where('user_evaluations.is_completed', 1) // uncomment to show only completed
                    ->count() }}
            },
        @endforeach
    ];

    var optionsBar = {
        ...theme,
        chart: { 
            type: 'bar',
            height: 320,
            ...theme.chart
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                distributed: false
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val;
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
                borderColor: '#fff',
                opacity: 0.9,
                dropShadow: {
                    enabled: false
                }
            }
        },
        series: [{
            name: 'Evaluations',
            data: departmentData.map(d => d.count)
        }],
        xaxis: {
            categories: departmentData.map(d => d.code),
            labels: {
                style: {
                    fontSize: '12px',
                    fontFamily: theme.fontFamily.body
                },
                rotate: -45,
                rotateAlways: true
            }
        },
        colors: [theme.primaryColor],
        legend: {
            show: false
        },
        title: {
            text: 'Evaluations by Department',
            align: 'left',
            style: {
                fontSize: '14px',
                fontWeight: '500',
                fontFamily: theme.fontFamily.title
            }
        },
        tooltip: {
            theme: 'light',
            y: {
                formatter: function(val) {
                    return val + " evaluations";
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#barChart"), optionsBar).render();

    // Evaluation Trends Line Chart - Current Year
    var optionsLine = {
        ...theme,
        chart: { 
            type: 'line',
            height: 320,
            ...theme.chart
        },
        stroke: {
            curve: 'straight',
            width: 3,
            colors: [theme.primaryColor]
        },
        markers: {
            size: 5,
            colors: [theme.primaryColor],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: {
                size: 7
            }
        },
        series: [{
            name: 'Completed Evaluations',
            data: [
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 1)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 2)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 3)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 4)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 5)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 6)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 7)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 8)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 9)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 10)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 11)->count() }},
                {{ \App\Models\UserEvaluation::where('is_completed', true)->whereYear('evaluated_at', now()->year)->whereMonth('evaluated_at', 12)->count() }}
            ]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                style: {
                    fontSize: '12px',
                    fontFamily: theme.fontFamily.body
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    return val.toFixed(0);
                }
            }
        },
        grid: {
            borderColor: '#E5E7EB',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        colors: [theme.primaryColor],
        title: {
            text: currentYear + ' Monthly Completed Evaluations',
            align: 'left',
            style: {
                fontSize: '14px',
                fontWeight: '500',
                fontFamily: theme.fontFamily.title
            }
        },
        tooltip: {
            theme: 'light',
            x: {
                format: 'MMM yyyy'
            }
        }
    };
    new ApexCharts(document.querySelector("#lineChart"), optionsLine).render();

    // Responsive adjustments
    function handleResize() {
        const charts = document.querySelectorAll('.apexcharts-canvas');
        if (window.innerWidth < 768) {
            charts.forEach(chart => {
                chart.style.height = 'auto';
            });
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize();
</script>
@endsection
