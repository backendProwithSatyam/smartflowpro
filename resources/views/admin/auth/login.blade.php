<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SignIn | Smartflow Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('assets/layouts/vertical-light-menu/css/light/loader.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('assets/layouts/vertical-light-menu/css/dark/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/layouts/vertical-light-menu/loader.js')}}"></script>
    <link href="{{asset('assets/src/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/layouts/vertical-light-menu/css/light/plugins.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('assets/src/assets/css/light/authentication/auth-boxed.css')}}" rel="stylesheet"
        type="text/css" />

    <link href="{{asset('assets/layouts/vertical-light-menu/css/dark/plugins.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('assets/src/assets/css/dark/authentication/auth-boxed.css')}}" rel="stylesheet"
        type="text/css" />
</head>

<body class="form">
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <div class="auth-container d-flex">
        <div class="container mx-auto align-self-center">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h2>Sign In</h2>
                                    <p>Enter your email and password to login</p>
                                    
                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                    
                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                </div>
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-secondary w-100" type="submit">SIGN IN</button>
                                    </div>
                                </div>
                                </form>
                                <div class="col-12 mb-4">
                                    <div class="">
                                        <div class="seperator">
                                            <hr>
                                            <div class="seperator-text"> <span>Or continue with</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="mb-4">
                                        <a href="{{ route('auth.google') }}" class="btn btn-social-login w-100 text-decoration-none">
                                            <img src="https://designreset.com/cork/html/src/assets/img/google-gmail.svg"
                                                alt="Google" class="img-fluid">
                                            <span class="btn-text-inner">Google</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="mb-4">
                                        <a href="{{ route('auth.linkedin') }}" class="btn btn-social-login w-100 text-decoration-none">
                                            <img src="{{ asset('img/linkedin-icon.svg') }}"
                                                alt="LinkedIn" class="img-fluid" style="width: 20px; height: 20px;">
                                            <span class="btn-text-inner">LinkedIn</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Dont't have an account ? <a href="javascript:void(0);"
                                                class="text-warning">Sign Up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>