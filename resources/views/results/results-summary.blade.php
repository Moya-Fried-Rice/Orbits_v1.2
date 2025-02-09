@extends('layouts.master')

@section('content')

<div class="font-TT mb-2 flex justify-between items-center gap-2 hover:opacity-100 transition-all duration-100">

    <div class="opacity-50 hidden md:block">
    Faculty Evaluation Summary
    </div>

    <div class="flex justify-between items-center gap-2">
        <a href="{{ route('dashboard') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Home
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('results') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Faculties
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('summary', ['uuid' => $uuid]) }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Summary
        </a>
    </div>
</div>
    
    <livewire:results-summary :uuid="$uuid" />

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('chartData')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (!window.chartData) {
                console.error("window.chartData is undefined.");
                return;
            }

            Object.keys(window.chartData).forEach(function (role) {
                let numBars = window.chartData[role].data.length; // Get number of bars
                let barWidth = 150; // Approximate width per bar in pixels
                let minWidth = 200; // Ensure a minimum width
                let chartWidth = Math.max(minWidth, numBars * barWidth); // Dynamically calculate width

                var chartOptions = {
                    chart: {
                        type: 'bar',
                        height: 250,
                        width: chartWidth, // Auto-adjust width
                        fontFamily: 'TT',
                        events: {
                            click: function(event, chartContext, opts) {
                                if (opts.dataPointIndex !== undefined) {
                                    let clickedIndex = opts.dataPointIndex;
                                    let clickedRole = role;

                                    let rowId = "row-" + clickedRole + "-" + clickedIndex; // Ensure row IDs match
                                    console.log("Row ID:", rowId);

                                    document.querySelectorAll("tr").forEach(row => row.classList.remove("bg-blue-50"));

                                    let selectedRow = document.getElementById(rowId);
                                    if (selectedRow) {
                                        selectedRow.classList.add("bg-blue-50");
                                    }
                                }
                            }
                        }
                    },
                    colors: ['#923534'],
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '0.75rem',
                            fontFamily: 'TT',
                            colors: ['#FFFFFF']
                        }
                    },
                    states: {
                        active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none', // You can use 'darken' as well
                            value: 0.5, // Adjust intensity
                        }
                        }
                    },
                    xaxis: {
                        categories: window.chartData[role].labels,
                        labels: {
                            style: {
                                fontSize: '0.75rem',
                                fontFamily: 'TT',
                                colors: ['#4B5563'],
                                whiteSpace: 'pre-line'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 5,
                        tickAmount: 5,
                        labels: {
                            style: {
                                fontSize: '0.75rem',
                                fontFamily: 'TT',
                                colors: ['#4B5563']
                            },
                            formatter: function (val) {
                                return val.toFixed(1);
                            }
                        }
                    },
                    series: [{
                        name: "Average Rating",
                        data: window.chartData[role].data
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart-" + role), chartOptions);
                chart.render();
            });
        });

        document.addEventListener("click", function(event) {
            // Select all chart containers by their common prefix "chart-"
            let chartContainers = document.querySelectorAll("[id^='chart-']");
            
            // Check if the clicked target is inside any chart container
            let clickedInsideChart = Array.from(chartContainers).some(chart => chart.contains(event.target));

            if (!clickedInsideChart) {
                document.querySelectorAll("tr").forEach(row => row.classList.remove("bg-blue-50"));
            }
        });
    </script>
@endsection
