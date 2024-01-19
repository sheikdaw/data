@extends('back.layout.page-layout') <!-- Extends the 'back.layout.page-layout' layout -->

@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Page Title') <!-- Defines the 'pagetitle' section with a default value -->

@section('content') <!-- Defines the 'content' section -->
<style>
    .avatar-photo {
        width: 100px; /* Set the desired width */
        height: 100px; /* Set the desired height */
        object-fit: cover; /* Maintain aspect ratio and cover the container */
        border-radius: 50%; /* Optional: Add rounded corners for a circular effect */
    }
</style>
<div class="col-xl-12 col-md-12 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xl font-weight-bold text-dark px-3">
                    Profile
                </div>
                <!-- Breadcrumb navigation -->
                <nav aria-label="breadcrumb" role="navigation" class="px-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Profile
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row container d-flex align-items-stretch">
    <div class="col-xl-4 col-lg-4 col-sm-12 col-md-4 mb-30 card border-left-primary shadow">
        <div class="pd-20 card-box height-100-p justify-content-center text-center"> <!-- Added text-center class -->
            <div class="profile-photo">
                <img src="{{ $admin->picture }}" alt="" class="avatar-photo rounded-circle" id="adminProfilePicture">
                <a href="javascript:;" class="edit-avatar" onclick="event.preventDefault();document.getElementById('adminProfilePictureFile').click();">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <input type="file" name="adminProfilePictureFile" id="adminProfilePictureFile" class="form-control-file mt-3 d-none">
            </div>
            <h5 class="text-center h5 mb-0" id="adminProfileName">{{ $admin->name }}</h5>
            <p class="text-center text-muted font-14" id="adminProfileEmail">{{ $admin->email }}</p>
            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Contact information</h5>
                <ul>
                    <li>
                        <span>Email</span>
                        {{ $admin->email }}
                    </li>
                    <li>
                        <span>Phone</span>
                        3333333333
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30 card border-left-primary shadow">
        <div class="card-box height-100-p overflow-hidden">
            @livewire('admin-profile-tabs')
        </div>
    </div>
</div>

@endsection <!-- End of 'content' section -->

@push('script')
<script>
    window.addEventListener('updateAdminInfo', function (event) {
        $('#adminProfileName').html(event.detail[0].adminName);
        $('#adminProfileEmail').html(event.detail[0].adminEmail);
    });
    window.addEventListener('updatePassword', function (event) {
        alert(event.detail[0].success);
        $('#password').val("");
        $('#newpassword').val("");
        $('#confirmpassword').val("");

    });

    $('#adminProfilePictureFile').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:1,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CROP','QUIT'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:'{{ route("admin.change-profile-picture") }}',
          withCSRF:['_token','{{ csrf_token() }}'],
          onSuccess:function(message, element, status){
            updateProfilePicture();
          },
          onError:function(message, element, status){
            alert(message);
          }
       });
       function updateProfilePicture() {
        $.ajax({
            type: 'GET',
            url: '{{ route("admin.get-profile-picture") }}',
            success: function (response) {
                console.log('Update Profile Picture Response:', response);
                if (response.status === 1 && response.picture) {
                    $('#adminProfilePicture').attr('src', response.picture);
                    $('#profile-picture').attr('src', response.picture);
                } else {
                    console.error('Invalid response format:', response);
                }
            },
            error: function (error) {
                console.error('Error fetching updated image path:', error);
            },
        });
    }

</script>

@endpush
