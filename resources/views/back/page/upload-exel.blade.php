@extends('back.layout.page-layout')
@section('pagetitle',isset($pagetitle)?$pagetitle:'page title');
@section('content')

<form action="{{ route('admin.uploadusers') }}" enctype="multipart/form-data" method="POST">
   
@if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif

    @csrf
    <div class="col-lg-12 py-3">
        <label for="file">Upload Users File</label>
        <input type="file" class="form-control" style="padding: 3px;" name="file" required />
    </div>
    <button type="submit" class="btn btn-success" name="upload">Upload</button>
</form>

@endsection
