@extends('back.layout.auth-layout')
@section('pagetitle',isset($pagetitle)?$pagetitle:'page title');
@section('content')

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('admin.send-password-reset-link')}}">
                                        @csrf
                                        @if (Session::get('fail'))
                                        <div class="alert alert-danger">
                                            {{Session::get('fail')}}
                                            <button type="button" class="close" data-dismiss="alert" aris-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{Session::get('fail')}}
                                            <button type="button" class="close" data-dismiss="alert" aris-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="email">
                                        </div>
                                            @error('email')
                                            <div class="d-block text-danger">{{ $message }}</div>
                                            @enderror
                                        <button class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
@endsection
