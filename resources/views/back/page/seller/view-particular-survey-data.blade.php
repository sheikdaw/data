@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Surveyed data')
@section('content')
<div>
    
    @livewire('particular-data')
    @livewireScripts
</div>

@endsection
