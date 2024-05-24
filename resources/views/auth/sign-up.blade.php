@extends('layout.auth')
@section('title')
    Register
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100" style="background-image: url('asset/auth/images/bg-01.jpg');">
            <div class="wrap-login100">
                <form class="login100-form" action="{{ route('register') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <span class="login100-form-logo">
                        <i class="zmdi zmdi-landscape"></i>
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Register
                    </span>

                    <div class="wrap-input100">
                        <input class="input100" type="text" name="name" placeholder="Name" required>
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="wrap-input100">
                        <input class="input100" type="text" name="mobile" placeholder="mobile" required>
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="wrap-input100" >
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

                    <div class="wrap-input100">
                        <input class="input100" type="password" name="confirm_password" placeholder="Confirm Password"
                            required>
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>
                    @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="wrap-input100">
                        <input class="input100" type="file" name="image" accept="image/*" onchange="loadFile(event)"
                            id="image">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <img id="output" class="img-fluid">

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Register
                        </button>
                    </div>

                    <div class="text-center p-t-90 mt-3">
                        <a class="txt1" href="{{ route('signIn') }}">
                            Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extra-script')
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endsection
