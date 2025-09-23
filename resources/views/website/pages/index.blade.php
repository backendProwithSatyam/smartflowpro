@extends('website.include.master')
@push('styles')
    <style>
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #60c2a4;
        }

        .industries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .industry-tag {
            padding: 10px 15px;
            background-color: #ffffff;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .video-section {
            position: relative;
            height: 500px;
            overflow: hidden;
        }

        .video-section video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }

        .cta-section {
            background-color: #60c2a4;
            padding: 80px 0;
            color: white;
        }

        .pricing-card {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .pricing-header {
            padding: 2rem;
            background-color: #60c2a4;
            color: white;
        }

        .pricing-body {
            padding: 2rem;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 700;
        }
    </style>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush
@section('content')
    <!-- Banner -->
    <section>
        <div class="main-slider swiper-container">
            <div class="swiper-wrapper">
                <!-- Single slide -->
                <div class="swiper-slide position-relative">
                    <img src="{{asset('img/slide1.jpg')}}" data-rjs="2" alt="">
                    <div class="slide-content container">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-8">
                                <div class="slide-content-inner">
                                    <h4 data-animate="fadeInUp" data-delay=".05">Best Internet Service Provider In USA</h4>
                                    <h2 data-animate="fadeInUp" data-delay=".3">Don’t Suffer The Buffer Speeds Up to 1 Gbps
                                        with Unlimited Data</h2>
                                    <a data-animate="fadeInUp" data-delay=".6" href="#" class="btn">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Single slide -->

                <!-- Single slide -->
                <div class="swiper-slide position-relative">
                    <img src="{{asset('img/slide2.jpg')}}" data-rjs="2" alt="">
                    <div class="slide-content container">
                        <div class="row align-items-center">
                            <div class=" col-xl-6 col-lg-8">
                                <div class="slide-content-inner">
                                    <h4 data-animate="fadeInUp" data-delay=".05">There is Now Way to Become a Internet User
                                    </h4>
                                    <h2 data-animate="fadeInUp" data-delay=".3">Now a Days Internet Is a Useful Thing, Not
                                        Passion</h2>
                                    <a data-animate="fadeInUp" data-delay=".6" href="#" class="btn">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Single slide -->
            </div>
            <!-- Banner Pagination -->
            <div class="swiper-pagination main-slider-pagination"></div>
        </div>
    </section>
    <!-- End of Banner -->

    <!-- Feature Section -->
    <section class="pt-30 pb-55">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-5">Powerful Features for Your Service Business</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <h4 class="card-title">Automated Scheduling</h4>
                            <p class="card-text">Easily manage appointments, avoid double bookings, and send automatic
                                reminders to reduce no-shows.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa fa-dollar"></i>
                            </div>
                            <h4 class="card-title">Invoicing & Payments</h4>
                            <p class="card-text">Create professional invoices, accept online payments, and track payment
                                status all in one place.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <h4 class="card-title">Real-Time Job Tracking</h4>
                            <p class="card-text">Monitor job progress in real-time, assign technicians, and provide
                                customers with status updates.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa fa-quote-right"></i>
                            </div>
                            <h4 class="card-title">Quote to Job Conversion</h4>
                            <p class="card-text">Seamlessly convert approved quotes into jobs with all details automatically
                                transferred.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <h4 class="card-title">Client Portal</h4>
                            <p class="card-text">Provide your clients with a dedicated portal to view quotes, schedule
                                services, and make payments.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fa fa-line-chart"></i>
                            </div>
                            <h4 class="card-title">Business Analytics</h4>
                            <p class="card-text">Gain insights into your business performance with detailed reports and
                                analytics dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Feature Section -->

    <!-- Blogs -->
    <section class="light-bg pt-30 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="section-title text-center" data-animate="fadeInUp" data-delay=".1">
                        <h2>Latest From Our Blogs</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                            alteration in some form by injected humour</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="latest-news-wraper position-relative">
                        <div class="swiper-container news-slider">
                            <div class="swiper-wrapper">
                                <div class="single-news swiper-slide">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post1.jpg')}}" data-rjs="2" alt="">
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
                                <div class="single-news swiper-slide">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post2.jpg')}}" data-rjs="2" alt="">
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
                                <div class="single-news swiper-slide">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post3.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/female.png')}}" alt=""></li>
                                        <li>by <a href="#">Zane M. Frye</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Powered Enterprise IT: Cloud
                                            implementation
                                            built for the future</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                                <div class="single-news swiper-slide">
                                    <a class="tip" href="#">News</a>
                                    <img src="{{asset('img/posts/post1.jpg')}}" data-rjs="2" alt="">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li><img src="{{asset('img/authors/author1.jpg')}}" alt=""></li>
                                        <li>by <a href="#">Zane M. Frye</a></li>
                                        <li><a href="#">January 19, 2018</a></li>
                                    </ul>
                                    <h3 class="h5"><a href="{{route('blog-details')}}">Three privacy tools that block your
                                            Internet
                                            provider from tracking your computer</a></h3>
                                    <a href="{{route('blog-details')}}">Continue Reading <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next next-news">
                            <img src="{{asset('img/icons/right-arrow')}}.svg" alt="" class="svg">
                        </div>
                        <div class="swiper-button-prev prev-news">
                            <img src="{{asset('img/icons/left-arrow')}}.svg" alt="" class="svg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Blogs -->

    <!-- Services -->
    <section class="pt-20 pb-90">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold">Industries We Work With</h2>
                    <p class="lead">Our platform is designed to serve a wide range of service businesses</p>
                </div>
            </div>
            <div class="industries-grid">
                <div class="industry-tag">Plumbing</div>
                <div class="industry-tag">Electrical</div>
                <div class="industry-tag">HVAC</div>
                <div class="industry-tag">Cleaning Services</div>
                <div class="industry-tag">Landscaping</div>
                <div class="industry-tag">Locksmiths</div>
                <div class="industry-tag">Auto Repair</div>
                <div class="industry-tag">IT Services</div>
                <div class="industry-tag">Security Systems</div>
                <div class="industry-tag">Painting</div>
                <div class="industry-tag">Moving Services</div>
                <div class="industry-tag">Handyman</div>
            </div>
        </div>
    </section>
    <!-- End of Services -->

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Start Managing Your Service Business Like a Pro</h2>
            <p class="lead mb-5">Join thousands of service businesses that use SmartFlowPro to streamline their operations
            </p>
            <a href="#" class="btn btn-light btn-lg">Create My Free Account</a>
            <p class="mt-3">No credit card required.</p>
        </div>
    </section>
    
    <!-- Packages Wrap -->
    <section class="pt-120 pb-55">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold">Simple, Transparent Pricing</h2>
                    <p class="lead">Choose the plan that works best for your business</p>
                    <div class="d-flex justify-content-center align-items-center my-4">
                        <span class="mr-3">Monthly</span>
                        <label class="switch">
                            <input type="checkbox" id="billingToggle" style="width: 3rem; height: 1.5rem;">
                            <span class="slider round"></span>
                        </label>
                        <span class="ml-3">Yearly <span class="badge bg-success text-white">20% off</span></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="pricing-card card h-100 shadow">
                        <div class="pricing-header">
                            <h3 class="h4">Basic</h3>
                            <p class="opacity-75">For small businesses getting started</p>
                            <div class="pricing-price">
                                <span class="monthly-price">$29</span>
                                <span class="yearly-price d-none">$23</span>
                                <span class="fs-6">/month</span>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Up to 5 users</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> 100 jobs per month
                                </li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Basic scheduling</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Email support</li>
                                <li class="mb-2"><i class="fa fa-times-circle text-muted me-2"></i> Advanced reporting</li>
                                <li class="mb-2"><i class="fa fa-times-circle text-muted me-2"></i> Client portal</li>
                            </ul>
                            <a href="#" class="btn btn-outline-primary w-100">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="pricing-card card h-100 shadow border-primary">
                        <div class="position-absolute top-0 end-0 bg-primary text-white py-1 px-3 rounded-bottom-left">Most
                            Popular</div>
                        <div class="pricing-header bg-primary">
                            <h3 class="h4">Pro</h3>
                            <p class="opacity-75">For growing businesses</p>
                            <div class="pricing-price">
                                <span class="monthly-price">$79</span>
                                <span class="yearly-price d-none">$63</span>
                                <span class="fs-6">/month</span>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Up to 15 users</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> 500 jobs per month
                                </li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Advanced scheduling
                                </li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Priority support</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Advanced reporting
                                </li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Client portal</li>
                            </ul>
                            <a href="#" class="btn btn-primary w-100">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="pricing-card card h-100 shadow">
                        <div class="pricing-header">
                            <h3 class="h4">Enterprise</h3>
                            <p class="opacity-75">For large businesses with complex needs</p>
                            <div class="pricing-price">
                                <span class="monthly-price">$199</span>
                                <span class="yearly-price d-none">$159</span>
                                <span class="fs-6">/month</span>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Unlimited users</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Unlimited jobs</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Premium scheduling
                                </li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> 24/7 support</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> Custom reporting</li>
                                <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i> White-label portal
                                </li>
                            </ul>
                            <a href="#" class="btn btn-outline-primary w-100">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- End of Packages Wrap -->
    <!-- Video Section -->
    <section class="video-section">
        <video
            poster="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
            playsinline muted loop>
            <source src="https://www.pexels.com/download/video/4124024/" type="video/mp4">
        </video>
        <div class="video-overlay">
            <div class="container text-center">
                <h2 class="display-5 fw-bold mb-4">See How SmartFlowPro Works</h2>
                <p class="lead mb-5">Watch our short product tour to see how we can transform your service business</p>
                <button class="btn btn-primary btn-lg play-button">
                    <i class="fa fa-play me-2"></i> Play Video
                </button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        const billingToggle = document.getElementById('billingToggle');
        const monthlyPrices = document.querySelectorAll('.monthly-price');
        const yearlyPrices = document.querySelectorAll('.yearly-price');

        billingToggle.addEventListener('change', function () {
            if (this.checked) {
                monthlyPrices.forEach(price => price.classList.add('d-none'));
                yearlyPrices.forEach(price => price.classList.remove('d-none'));
            } else {
                monthlyPrices.forEach(price => price.classList.remove('d-none'));
                yearlyPrices.forEach(price => price.classList.add('d-none'));
            }
        });
        const video = document.querySelector('.video-section video');
        const playButton = document.querySelector('.play-button');

        playButton.addEventListener('click', function () {
            if (video.paused) {
                video.play();
                playButton.innerHTML = '<i class="fa fa-pause me-2"></i> Pause Video';
                document.querySelector('.video-overlay').style.backgroundColor = 'rgba(0,0,0,0.2)';
            } else {
                video.pause();
                playButton.innerHTML = '<i class="fa fa-play me-2"></i> Play Video';
                document.querySelector('.video-overlay').style.backgroundColor = 'rgba(0,0,0,0.5)';
            }
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    video.play();
                    playButton.innerHTML = '<i class="fa fa-pause me-2"></i> Pause Video';
                    document.querySelector('.video-overlay').style.backgroundColor = 'rgba(0,0,0,0.2)';
                } else {
                    video.pause();
                    playButton.innerHTML = '<i class="fa fa-play me-2"></i> Play Video';
                    document.querySelector('.video-overlay').style.backgroundColor = 'rgba(0,0,0,0.5)';
                }
            });
        }, { threshold: 0.5 });

        observer.observe(document.querySelector('.video-section'));
    </script>
@endpush