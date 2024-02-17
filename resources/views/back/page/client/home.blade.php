@extends('back.layout.page-layout')

@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Page Title')

@section('content')
<style>
    .map {
        width: 100%;
        height: 600px;
    }

    .ol-popup {
        position: absolute;
        background-color: white;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        left: -50px;
        min-width: 280px;
    }

    .ol-popup:after,
    .ol-popup:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .ol-popup:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
    }

    .ol-popup:before {
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
    }

    .ol-popup-closer {
        text-decoration: none;
        position: absolute;
        top: 2px;
        right: 8px;
    }

    .ol-popup-closer:after {
        content: "✖";
    }
</style>

<div class="card shadow p-3">
    <div class="row p-2 g-3">
        @foreach($streetsNotInSurveyed as $street)
        <div class="card col-md-3 mb-3 shadow-lg">
            <div class="card-body">
                <h5 class="card-title">{{ $street->road_name }}</h5>
                <p class="card-text">Balance Count: {{ $street->road_count }}</p>
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
@endsection
