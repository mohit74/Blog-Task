@extends('layout.auth')
@section('title')
    Login
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100" style="background-image: url('asset/auth/images/bg-01.jpg');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <span class="login100-form-logo">
                        <i class="zmdi zmdi-landscape"></i>
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Log in
                    </span>

                    <div class="wrap-input100 validate-input" data-validate = "Enter Email">
                        <input class="input100" type="email" name="email" placeholder="example@gmail.com" required>
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-90">
                        <a class="txt1" href="{{ route('signUp') }}">
                            Register
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
