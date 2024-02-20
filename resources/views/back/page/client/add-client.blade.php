@extends('back.layout.page-layout')

@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Page Title')

@section('content')
<div class="col-lg-6 bordered">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Welcome Again!</h1>
        </div>
        <form class="user" action="{{route ('client.login_handler')}}" method="POST">
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
                    id="name" aria-describedby="name"
                    placeholder="name" name="name" value="{{ old('name')}}">
            </div>
            @error('name')
            <div class="d-block text-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <input type="text" class="form-control form-control-user"
                    id="user_name" aria-describedby="user_name"
                    placeholder="user_name" name="user_name" value="{{ old('user_name')}}">
            </div>
            @error('user_name')
            <div class="d-block text-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <input type="text" class="form-control form-control-user"
                    id="email" aria-describedby="email"
                    placeholder="email" name="email" value="{{ old('email')}}">
            </div>
            @error('email')
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

        </form>
        <hr>
        <div class="text-center">
            <a class="small" href="{{route('client.forgot-password')}}">Forgot Password?</a>
        </div>
    </div>
</div>
@endsection
