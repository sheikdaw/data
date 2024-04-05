@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'page title')
@section('content')

<form id="update-gis" enctype="multipart/form-data" method="POST">
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
        <label for="point_gis">point_gis</label>
        <input type="text" class="form-control" id="point_gis" style="padding: 3px;" value="{{ old('point_gis') }}" name="point_gis" required />
    </div>
    <button type="submit" class="btn btn-success" name="upload">Survey</button>
</form>
<div id="data"></div>
<script>
    $(document).ready(function(){
        $("#update-gis").submit(function(e){
            e.preventDefault(); // prevent the form from submitting normally
            $.ajax({
                type: "POST",
                url: "{{ route('point-gis-edit') }}",
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    $('#data').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while processing your request. Please try again.');
                }
            });
        });
    });
</script>

@endsection
