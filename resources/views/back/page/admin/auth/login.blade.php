@extends('back.layout.auth-layout')
@section('pagetitle',isset($pagetitle)?$pagetitle:'page title');
@section('content')
<div class="col-lg-6">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Welcome Again!</h1>
        </div>
        <form class="user" action="login_handler" method="POST">
            @csrf
            @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{Session::get('fail')}}
                <button type="button" class="close" data-dismiss="alert" aris-label="close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            @endif
            <div class="form-group">
                <input type="text" class="form-control form-control-user"
                    id="login_id" aria-describedby="login_id"
                    placeholder="login_id" name="login_id" value="{{ old('login_id')}}">
            </div>
            @error('login_id')
            <div class="d-block text-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <input type="password" class="form-control form-control-user"
                    id="exampleInputPassword" placeholder="Password" name="password" value="{{ old('passwords')}}">
            </div>
            @error('password')
            <div class="d-block text-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="customCheck">
                    <label class="custom-control-label" for="customCheck">Remember
                        Me</label>
                </div>
            </div>
            <button class="btn btn-primary btn-user btn-block">
                Login
            </button>
            <hr>
        </form>
        <hr>
        <div class="text-center">
            <a class="small" href="{{route('admin.forgot-password')}}">Forgot Password?</a>
        </div>
    </div>
</div>
@endsection
