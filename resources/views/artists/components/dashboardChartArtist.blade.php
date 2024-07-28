<div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 dash-card">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between dash-card">
                    <h6 class="m-0 font-weight-bold text-white">
                        {{__('Overview Statistic')}}
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="artistEarningsChart"></canvas>
                        {{-- <canvas id="myAreaChart"></canvas> --}}
                    </div>
                    <div class="my-4">
                        <label for="yearSelect">{{__('Select Year:')}}</label>
                        <select id="year" wire:model="year" wire:change="loadChartData">
                            @for($y = date('Y'); $y >= 2022; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{-- @push('scripts') --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log('Initial');
        const colors = ['#e74a3b', '#e83e8c', '#6f42c1', '#4e73df', '#1cc88a', '#f6c23e', '#6610f2', '#fd7e14', '#36b9cc']; // Red, Green, Blue, Yellow

        var combinedChart;
            var combinedChart;
            function createOrUpdateChart(chartData) {
                console.log(chartData);
                if (combinedChart) {
                    console.log('destroy');
                    combinedChart.destroy();
                }

                var ctx = document.getElementById("artistEarningsChart").getContext('2d');
                combinedChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Month labels
                    datasets: Object.entries(chartData).map(([artist, earnings], index) => ({
                        label: artist, // Artist name as label
                        data: earnings, // Array of earnings data for each month
                        borderColor: colors[index % colors.length], // Use colors cyclically
                        backgroundColor: colors[index % colors.length] + '10', // Background color with opacity
                        borderWidth: 2,
                        fill: true
                    }))
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0,
                            },
                        },
                        showLines: true,
                        scales: {
                            x: {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                },
                                ticks: {
                                    color: "#fff",
                                    maxTicksLimit: 12,
                                },
                            },
                            y: {
                                maxTicksLimit: 5,
                                padding: 10,
                                ticks: {
                                    color: "#fff",
                                    maxTicksLimit: 12,
                                    callback: function (value) {
                                        return value.toFixed(1);
                                    },
                                },
                                grid: {
                                    color: "#fff",
                                    borderColor: "#fff",
                                    drawBorder: true,
                                    borderDash: [2],
                                    borderDashOffset: [2],
                                },
                            },
                        },

                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: "rgb(255, 255, 255)",
                                }
                        },
                            colors: {
                                forceOverride: false
                            },
                            tooltip: {
                                backgroundColor: "#333",
                                bodyFontColor: "#eee",
                                titleFontColor: "#eee",
                                borderColor: "#eee",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: true,
                                intersect: true,
                                mode: "index",
                                caretPadding: 10,
                                callbacks: {
                                    label: function (context) {
                                        var label = context.dataset.label || "";
                                        if (label) {
                                            label += ": ";
                                        }
                                        if (context.parsed.y !== null) {
                                            label += "$" + context.parsed.y.toFixed(2);
                                        }
                                        return label;
                                    },
                                },
                            },
                        },
                    }
                });
            }
  </script>

@script
<script>
    $wire.on('chartDataUpdated', (event) => {
        createOrUpdateChart(event[0].chartData);
    });
</script>
@endscript
</div>
