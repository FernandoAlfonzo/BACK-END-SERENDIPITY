<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

    <!-- Scripts -->
    {{-- {!! NoCaptcha::renderJs() !!} --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="{{ route('login') }}"><img class="logo-img" src="../assets/images/logo.png" width="300" alt="logo"></a>
                <span class="splash-description">Ingrese su información de usuario</span></div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" type="text" placeholder="Email" required autocomplete="off" autofocus>
                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Password" required>
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="remember" name="remember"{{--  {{ old('remember') ? 'checked' : '' }} --}}><span class="custom-control-label">
                                Recordarme
                            </span>
                        </label>
                    </div>
                    <div class="form-group">
                        <div  id="gwd-reCAPTCHA_2" class="g-recaptcha" data-callback="imNotARobot" data-sitekey="6LebJhEUAAAAAOgztebEPyr6sWoJHWa6s3mUGkVn"></div>
                    </div>
                    
                        <span id="Error"></span>
                 
                    <br/>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>
                    
                </form>
            </div>
            <div class="card-footer bg-white p-0 text-center">
                {{-- <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Registrarse</a>
                </div> --}}
                <div class="card-footer-item card-footer-item-bordered">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="footer-link">¿Olvidó su contraseña?</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

    <script>

        grecaptcha.ready(function () {
            var $form = $("#Error");
            document.getElementById('loginForm').addEventListener("submit", function (event) {
                event.preventDefault();
                var response = grecaptcha.getResponse();
                if (response.length != 0) {
                    document.getElementById('loginForm').submit();
                   
                } else {
                    $form.find("#Error").remove();
                    $form.prepend('<div id="Error" class="alert alert-danger">*Verifique el captcha</div>');
                }

            }, false);
        });

    </script>
</body>
 
</html>
