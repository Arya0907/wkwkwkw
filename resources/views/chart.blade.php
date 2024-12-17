@extends('templates.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/echarts@5"></script>

<body>
<div class="col-md-12">
    <h1 class="text-center">Grafik Report dan Response</h1>
    <div class="col-md-8 col-md-offset-2">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="bars_basic" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var bars_basic_element = document.getElementById('bars_basic');
    if (bars_basic_element) {
        var bars_basic = echarts.init(bars_basic_element);
        bars_basic.setOption({
            title: {
                text: 'Grafik Report dan Response', // Judul chart
                left: 'center',
                textStyle: {
                    fontSize: 18,
                    fontWeight: 'bold'
                }
            },
            color: ['#3398DB'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['Report Count', 'Response Count'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: 'Total Count',
                    type: 'bar',
                    barWidth: '20%',
                    data: [
                        {{$report_count}}, // Data untuk Report Count
                        {{$response_count}} // Data untuk Response Count
                    ]
                }
            ]
        });

        // Resize chart to fit container
        bars_basic.resize();
    }
</script>

<style>
    /* Styling untuk halaman secara keseluruhan */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa; /* Warna latar belakang */
        margin: 0;
        padding: 0;
    }

    /* Styling untuk heading */
    h1.text-center {
        font-size: 2rem;
        font-weight: bold;
        color: #343a40; /* Warna teks */
        margin-bottom: 20px;
    }

    /* Styling container untuk chart */
    .chart-container {
        padding: 20px;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        background-color: #ffffff; /* Warna latar kartu */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Bayangan */
    }

    /* Styling untuk elemen chart */
    .chart {
        border-radius: 8px;
        overflow: hidden;
    }

    /* Styling untuk card */
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        margin: 20px 0;
        background-color: #ffffff; /* Warna latar */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan */
    }

    .card-body {
        padding: 20px;
    }

    /* Ukuran kolom agar responsive */
    .col-xl-6 {
        max-width: 600px;
        margin: 0 auto; /* Center the card */
    }

    /* Grid responsif untuk semua ukuran layar */
    @media (max-width: 768px) {
        .col-xl-6 {
            padding: 10px;
        }

        h1.text-center {
            font-size: 1.5rem;
        }
    }
</style>


@endsection