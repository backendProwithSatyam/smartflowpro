@extends('website.include.master')
@section('content')
    <!-- Page Title -->
    <section class="page-title-wrap" data-bg-img="{{asset('img/hills.jpg')}}" data-rjs="2">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title" data-animate="fadeInUp" data-delay="1.2">
                        <h2>Blog</h2>
                        <ul class="list-unstyled m-0 d-flex">
                            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Page Title -->

    <!-- Blog -->
    <section class="pt-120 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog">
                        <div class="row isotope">
                            <!-- Single Post -->
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post4.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/author1.jpg')}}" alt=""></li>
                                        <li>by <a href="#">Zane M. Frye</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Everything you need to know to cut
                                            the cord
                                            and ditch cable to order now</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <!-- End of Single Post -->

                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post5.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/male.png')}}" alt=""></li>
                                        <li>by <a href="#">Zane M. Frye</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Why the FCC's latest net neutrality
                                            defense
                                            is hollow on the flow</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post6.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/female.png')}}" alt=""></li>
                                        <li>by <a href="#">Zane M. Frye</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Why the FCC's latest net neutrality
                                            defense
                                            is hollow on the flow</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post7.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/male.png')}}" alt=""></li>
                                        <li>by <a href="#">Foster B. Severson</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Three privacy tools that block your
                                            Internet
                                            provider from tracking your computer</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post9.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/male.png')}}" alt=""></li>
                                        <li>by <a href="#">Foster B. Severson</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Three privacy tools that block your
                                            Internet
                                            provider from tracking your computer</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post10.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/female.png')}}" alt=""></li>
                                        <li>by <a href="#">Barbara S. Pickerel</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Powered Enterprise IT: Cloud
                                            implementation
                                            built for the future</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post11.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/author1.jpg')}}" alt=""></li>
                                        <li>by <a href="#">Zane M. Frye</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Everything you need to know to cut
                                            the cord
                                            and ditch cable to order now</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post12.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/female.png')}}" alt=""></li>
                                        <li>by <a href="#">Barbara S. Pickerel</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Powered Enterprise IT: Cloud
                                            implementation
                                            built for the future</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post13.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/male.png')}}" alt=""></li>
                                        <li>by <a href="#">Foster B. Severson</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Three privacy tools that block your
                                            Internet
                                            provider from tracking your computer</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post14.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/male.png')}}" alt=""></li>
                                        <li>by <a href="#">Foster B. Severson</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Three privacy tools that block your
                                            Internet
                                            provider from tracking your computer</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post15.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/male.png')}}" alt=""></li>
                                        <li>by <a href="#">Foster B. Severson</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Three privacy tools that block your
                                            Internet
                                            provider from tracking your computer</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-news mb-55" data-animate="fadeInUp" data-delay=".1">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post7.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/female.png')}}" alt=""></li>
                                        <li>by <a href="#">Barbara S. Pickerel</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Powered Enterprise IT: Cloud
                                            implementation
                                            built for the future</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination blog-pagination align-items-center justify-content-center mb-55"
                            data-animate="fadeInUp" data-delay=".1">
                            <li><a href="#"><img src="{{asset('img/icons/left-arrow')}}.svg" alt="" class="svg"></a></li>
                            <li class="active"><a href="#">01</a></li>
                            <li><a href="#">02</a></li>
                            <li><a href="#">03</a></li>
                            <li><a href="#">04</a></li>
                            <li><a href="#">05</a></li>
                            <li><a href="#"><img src="{{asset('img/icons/right-arrow')}}.svg" alt="" class="svg"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Blog -->
@endsection