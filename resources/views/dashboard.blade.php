@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="row">
    <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Total Invoices</h4>
                </div>
                <div class="card-body">
                    <h2><strong>10</strong></h2>
                    <div class="icon-container">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Total Paid Invoices</h4>
                </div>
                <div class="card-body">
                    <h2><strong>5</strong></h2>
                    <div class="icon-container">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Total Quotes</h4>
                </div>
                <div class="card-body">
                    <h2><strong>20</strong></h2>
                    <div class="icon-container">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
        body {
            background-color: #000;
            color: #fff;
        }

        .card {
            background-color: #333;
            border-color: #222;
            color: #fff;
            border-radius: 10px;
        }

        .card-header {
            background-color: #222;
            color: #fff;
            border-bottom: 1px solid #444;
        }

        .card-body {
            padding: 20px;
        }
    </style>

    <div class="col-lg-12">
        <div class="card card-chart">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <h5 class="card-category"></h5>
                        <h2 class="card-title">Dashboard</h2>
                    </div>

                    <div class="col-sm-6">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-primary btn-sm active" onclick="updateChart('weekly')">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Weekly</span>
                            </label>
                            <label class="btn btn-primary btn-sm" onclick="updateChart('monthly')">
                                <input type="radio" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Monthly</span>
                            </label>
                            <label class="btn btn-primary btn-sm" onclick="updateChart('quarterly')">
                                <input type="radio" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Quarterly</span>
                            </label>
                            <label class="btn btn-primary btn-sm" onclick="updateChart('yearly')">
                                <input type="radio" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Yearly</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="invoicesChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-chart">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <h5 class="card-category"></h5>
                        <h2 class="card-title">Cash Flow</h2>
                    </div>

                   
                </div>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>

      
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>

<script>
    // Your existing data initialization
    var invoicesChartData = @json($invoicesChartData);
    var quoteChartData = @json($quotesChartData);

    // Define the date range based on the selected filter
    function getDateRange(filter) {
        var endDate = moment();
        var startDate;

        switch (filter) {
            case 'weekly':
                startDate = moment(endDate).subtract(7, 'days');
                break;
            case 'monthly':
                startDate = moment(endDate).subtract(1, 'months');
                break;
            case 'quarterly':
                startDate = moment(endDate).subtract(3, 'months');
                break;
            case 'yearly':
                startDate = moment(endDate).subtract(1, 'years');
                break;
            default:
                startDate = moment(endDate).subtract(7, 'days');
        }

        var dateRange = [];
        var currentDate = moment(startDate);

        while (currentDate.isSameOrBefore(endDate)) {
            dateRange.push(currentDate.format('YYYY-MM-DD')); // Use the same format as your datasets
            currentDate.add(1, 'day');
        }

        return dateRange;
    }

    // Update the chart based on the selected filter
    function updateChart(filter) {
        var dateRange = getDateRange(filter);

        // Filter the data based on the selected date range
        var filteredInvoices = invoicesChartData.filter(data => dateRange.includes(moment(data.date).format('YYYY-MM-DD')));
        var filteredQuotes = quoteChartData.filter(data => dateRange.includes(moment(data.date).format('YYYY-MM-DD')));

        // Map the counts to the corresponding dates in the range
        var invoiceCounts = dateRange.map(date => {
            var matchingData = filteredInvoices.find(data => moment(data.date).format('YYYY-MM-DD') === date);
            return matchingData ? matchingData.count : 0;
        });

        var quoteCounts = dateRange.map(date => {
            var matchingData = filteredQuotes.find(data => moment(data.date).format('YYYY-MM-DD') === date);
            return matchingData ? matchingData.count : 0;
        });

        // Update the chart with the filtered and mapped data
        myChart.data.labels = dateRange;
        myChart.data.datasets[0].data = invoiceCounts;
        myChart.data.datasets[1].data = quoteCounts;
        myChart.update();
    }

    // Your existing chart initialization
    var ctx = document.getElementById('invoicesChart').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Invoice Count',
                    data: [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false,
                },
                {
                    label: 'Quote Count',
                    data: [],
                    borderColor: 'rgba(75, 192, 100, 1)',
                    borderWidth: 1,
                    fill: false,
                },
            ],
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        parser: 'YYYY-MM-DD',
                        tooltipFormat: 'YYYY-MM-DD',
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM D',
                        },
                    },
                    title: {
                        display: true,
                        text: 'Date',
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count',
                    },
                },
            },
        },
    });

    // Initialize the chart with the default filter
    updateChart('weekly');
</script>


<script>
        var mergedData = @json($result);

        // Get the canvas element
        var ctx = document.getElementById('monthlyChart').getContext('2d');

        // Create a bar chart
        var flowChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: mergedData.map(data => data.month),
                datasets: [{
                    label: 'Total Amount',
                    data: mergedData.map(data => data.total_amount),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Adjust the color as needed
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Amount'
                        }
                    }
                }
            }
        });
    </script>


@endpush
