@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Client home')
@section('content')
<style>.map {
    width: 100%;
    height: 600px;
}</style>
{{-- <div class="card p-3">
    <div class="row">
        <div class="col-sm-12 col-md-6 mb-4 "> <!-- Added 'mb-4' class for margin-bottom -->
            <p>Total Count of Records in Mis: {{ $totalMisCount }}</p>
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
</div> --}}




<script>
    // Bar Chart
   console.log(@json($point_data));
   console.log(@json($crcount));
   console.log(@json($rccount));
    // var barChartCtx = document.getElementById('barChart').getContext('2d');
    // var barLabels = @json($labels);
    // var barValues = @json($values);

    // var barChart = new Chart(barChartCtx, {
    //     type: 'bar',
    //     data: {
    //         labels: barLabels,
    //         datasets: [{
    //             label: 'Count of Road Names',
    //             data: barValues,
    //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
    //             borderColor: 'rgba(75, 192, 192, 1)',
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    // // Pie Chart
    // var pieChartCtx = document.getElementById('pieChart').getContext('2d');
    // var pieLabels = @json($labels);
    // var pieValues = @json($values);

    // var pieChart = new Chart(pieChartCtx, {
    //     type: 'pie',
    //     data: {
    //         labels: barLabels,
    //         datasets: [{
    //             label: 'Count of surveyed Road Names',
    //             data: pieValues,
    //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
    //             borderColor: 'rgba(75, 192, 192, 1)',
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         responsive: true, // This option maintains the aspect ratio while resizing
    //         maintainAspectRatio: false, // Set this to false to customize the size
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });
</script>
@livewire('client-map')
<div>
    @foreach ($misdata as $mis)
        @foreach ($point_data as $point)
            @if ($mis->assessment == $point->assessment)
                {{-- @if ($mis->building_usage == "Residential" && $point->building_usage == "Commercial")
                    <h2>R to c</h2>
                @elseif ($mis->building_usage == "Commercial" && $point->building_usage == "Residential")
                    <h2>c to R</h2>
                @endif --}}
                <h2>point</h2>
            @endif
        @endforeach
    @endforeach
</div>
@endsection
