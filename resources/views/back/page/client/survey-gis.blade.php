@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'page title')
@section('content')

<form action="{{ route('client.Survey-Form') }}" enctype="multipart/form-data" method="POST">
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @php
        $status = isset($status) ? $status : 0;
        $error = isset($error) ? $error : ''; // Define $error if not set
    @endphp

    @if ($status === 0 && $error !== '')
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif

    @csrf
    <div class="col-lg-12 py-3">
        <label for="assessment">Assessment</label>
        <input type="text" class="form-control" style="padding: 3px;" value="{{ old('assessment') }}" name="assessment" required />
    </div>
    <button type="submit" class="btn btn-success" name="upload">Survey</button>
</form>

@endsection
