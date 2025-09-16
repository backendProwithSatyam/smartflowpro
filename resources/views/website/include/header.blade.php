<header class="header">
    <div class="main-header" data-animate="fadeInUp" data-delay=".9">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-9">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{url('/')}}">
                            <img src="{{asset('img/logo2.png')}}" class="site-logo" data-rjs="2" alt="VPNet">
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-5 col-sm-2 col-3">
                    <nav>
                        <!-- Header-menu -->
                        <div class="header-menu">
                            <ul>
                                <li class="active"><a href="{{url('/')}}">Home</a></li>
                                <li class=""><a href="">Features</a></li>
                                <li class=""><a href="{{route('blog')}}">Blogs</a></li>
                                <li class=""><a href="">Industries</a></li>
                                <li class=""><a href="">Pricing</a></li>
                            </ul>
                        </div>
                        <!-- End of Header-menu -->
                    </nav>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 d-none d-sm-block">
                    <!-- Header Call -->
                    <div class="header-call text-right">
                        <div
                            class="header-top-right d-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="client-area position-relative">
                                <span id="dropdownMenuButton" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">My Account <i class="fa fa-caret-down"></i></span>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Sign In</a>
                                    <a class="dropdown-item" href="#">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>