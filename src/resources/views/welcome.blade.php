
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AlphaMovers</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">



</head>

<body class="h-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->





    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <div class="text-center">
                                    <div style="width: 40%; margin: 0 auto;">
                                        <img src="{{ asset('img/movers_logo.png') }}" alt="" style="width: 100%;">
                                    </div>
                                </div>

                                <form class="mt-5 mb-5 login-input ml-5 mr-5" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" class="form-control block mt-1 w-full pl-2" placeholder="Email" id="email" name="email" :value="old('email')" required autocomplete="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control block mt-1 w-full pl-2" placeholder="Параль" id="password"
                                        name="password" required autocomplete="current-password">
                                    </div>
                                    <button class="btn login-form__btn submit w-100" action="{{ route('login') }}">Вхід</button>
                                </form>

                                <p class="mt-5 login-form__footer">Dont have account? <a href="page-register.html" class="text-primary">Sign Up</a> now</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--**********************************
        Scripts
    ***********************************-->


    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>


</body>
</html>





