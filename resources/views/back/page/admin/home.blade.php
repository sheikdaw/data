@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Admin home')
@section('content')
<div class="card p-3">
    <div class="row">
        <div class="col-sm-12 col-md-6 mb-4 "> <!-- Added 'mb-4' class for margin-bottom -->
            <p class="text-dark">Total Count of Records in Mis: {{ $totalMisCount }}</p>
            <div class="card shadow p-5">               
                <canvas id="barChart" width="100" height="100"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mb-4 "> <!-- Added 'mb-4' class for margin-bottom -->
            <p>Total Count of Records in Surveyed: {{ $totalSueveyCount }}</p>
            <div class="card shadow p-5">
                <canvas id="pieChart" width="50" height="50"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="card shadow p-3">
    <div class="row p-2 g-3">
        @foreach($streetsNotInSurveyed as $street)
            <div class="card col-md-3 mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $street->road_name }}</h5>
                    <p class="card-text">Pending: {{ $street->road_count }}</p>
                    @foreach($totalRoadCount as $totalRoad)
                        @if($totalRoad->road_name == $street->road_name)
                            <p class="card-text">Total Count: {{ $totalRoad->total_road_count }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>


<script>
    // Bar Chart
    var barChartCtx = document.getElementById('barChart').getContext('2d');
    var barLabels = @json($labels);
    var barValues = @json($values);

    var barChart = new Chart(barChartCtx, {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Count of Total MIS based on Street',
                data: barValues,
                backgroundColor: 'rgb(255, 64, 0)',
                borderColor: 'rgb(255, 255, 255)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    var pieChartCtx = document.getElementById('pieChart').getContext('2d');
    var pieLabels = @json($comlabels);
    var pieValues = @json($comvalues);

    var pieChart = new Chart(pieChartCtx, {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                label: 'Count of surveyed Counts bassed on street name and employee',
                data: pieValues,
                backgroundColor: 'rgb(255, 204, 204)',
                borderColor: 'rgb(153, 0, 0)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // This option maintains the aspect ratio while resizing
            maintainAspectRatio: false, // Set this to false to customize the size
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
