@extends('back.layout.page-layout')

@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Page Title')

@section('content')
@livewireStyles
    <div class="card shadow p-3">
        <div class="row p-2 g-3">
            @foreach ($streetsNotInSurveyed as $street)
                <div class="card col-md-3 mb-3 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">{{ $street->road_name }}</h5>
                        <p class="card-text">Balance Count: {{ $street->road_count }}</p>
                        @foreach ($totalRoadCount as $totalRoad)
                            @if ($totalRoad->road_name == $street->road_name)
                                <p class="card-text">Total Count: {{ $totalRoad->total_road_count }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@livewire('client-map')
@livewireScripts
@endsection
