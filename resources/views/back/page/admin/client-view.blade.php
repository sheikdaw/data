@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Client view')
@section('content')
<a href="{{route('admin.Add-Client')}}" class="btn btn-primary">Add Surveyer</a>
<div class="card p-3">
    <div class="row">
        @foreach ($totalclient as $client)
        <div class="card p-3 m-2">
            <p class="text-dark">Surveyor Name: {{ $client->name }}</p>
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('admin.client-edit-view', ['id' => $client->id]) }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.client-remove', ['id' => $client->id]) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
