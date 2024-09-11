<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.png') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/home/images/favicon.ico') }}">

    <title>Register</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('assets/auth/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}">
</head>
<body>
{{--<h2>Register</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label>Name</label>
        <input type="text" name="name">
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">
    </div>
    <button type="submit">Register</button>
</form>--}}
<div class="main">

    <!-- Sign up form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Register</h2>
                    <form method="POST" class="register-form" id="register-form" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="first_name"><i class="zmdi zmdi-pin-account material-icons-name"></i></label>
                            <input type="text" name="first_name" id="first_name" placeholder="first name" required/>
                        </div>
                        <div class="form-group">
                            <label for="last_name"><i class="zmdi zmdi-pin-account material-icons-name"></i></label>
                            <input type="text" name="last_name" id="last_name" placeholder="last name" required/>
                        </div>
                        <div class="form-group">
                            <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="username" placeholder="username" required/>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="email" required/>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="password" required/>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="repeat your password" required/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" checked required/>
                            <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="{{ asset('assets/auth/images/signup-image.jpg') }}" alt="sing up image"></figure>
                    <a href="{{route('login')}}" class="signup-image-link">I am already member</a>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- JS -->
<script src="{{ asset('assets/auth/vendor/jquery/jquery.min.js') }}"></script>
</body>
</html>
