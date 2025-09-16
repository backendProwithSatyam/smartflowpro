@extends('website.include.master')
@section('content')
    <!-- Page Title -->
    <section class="page-title-wrap" data-bg-img="{{asset('img/hills.jpg')}}" data-rjs="2">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title" data-animate="fadeInUp" data-delay="1.2">
                        <h2>Blog Details</h2>
                        <ul class="list-unstyled m-0 d-flex">
                            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="{{url('/blogs')}}">Blog</a></li>
                            <li><a href="#">Blog Details</a></li>
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
                <div class="col-lg-10 offset-lg-1">
                    <div class="blog-details mb-55">
                        <!-- Post Info -->
                        <div class="single-news">
                            <img src="{{asset('img/posts/post.jpg')}}" data-rjs="2" alt="" data-animate="fadeInUp"
                                data-delay=".1">
                            <ul class="list-unstyled d-flex align-items-center" data-animate="fadeInUp" data-delay=".2">
                                <li><img src="{{asset('img/authors/female.png')}}" alt=""></li>
                                <li>by <a href="#">Zane M. Frye</a></li>
                                <li><a href="#">January 19, 2018</a></li>
                                <li><a href="#" class="tip">News</a></li>
                            </ul>
                        </div>

                        <!-- Post Contents -->
                        <div class="post-content mb-55 clearfix" data-animate="fadeInUp" data-delay=".1">
                            <h1 class="h2">Three privacy tools that block your Internet provider from tracking your computer
                            </h1>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                                voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati
                                cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id
                                est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam
                                libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                                maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                                Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut
                                et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a
                                sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis
                                doloribus asperiores repellat."</p>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati
                                cupiditate non rovident, minus id quod <strong>maxime placeat facere possimus</strong>,
                                omnis voluptas assumenda est, omnis dolor repellendus. mporibus autem quibusdam et aut
                                officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et
                                molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus.</p>
                            <blockquote class="d-md-flex align-items-center">
                                <div class="quote-content">
                                    <p><i>“Ptatum deleniti atque corrupti quos dolores molestias excepturi sint occaecati
                                            cupiditate non rovident, minus id quod maxime eceat facere possimus, omnis
                                            voluptas assumenda est, omnis dolor ndus”</i></p>
                                    <p class="mb-md-0"><span><i>- Joseph K. Reneau</i></span></p>
                                </div>
                                <div class="quote-img">
                                    <img src="{{asset('img/posts/quote.jpg')}}" alt="">
                                </div>
                            </blockquote>
                            <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled
                                and demoralized by the charms of pleasure of the moment, so blinded by desire, that they
                                cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to
                                those who fail in their duty through weakness of will, which is the same as saying from toil
                                and pain. <span class="primary-bg text-white">These cases are perfectly simple and easy to
                                    distinguish.</span> In a free hour, when our power of choice is untrammeled and when
                                nothing prevents our being able to do what we like best, every pleasure is to be welcomed
                                and every pain avoided. But in certain circumstances and owing to the laims secure other
                                greater pleasures, or else he endures pains to avoid worse pains.</p>
                            <h3 class="h5">1914 translation by H. Rackham</h3>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati
                                cupiditate non rovident, minus id quod maxime placeat facere possimus, omnis voluptas
                                assumenda est, omnis dolor repellendus. mporibus autem quibusdam et aut officiis debitis aut
                                rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non
                                recusandae. Itaque earum rerum hic tenetur a sapiente delectus.</p>
                        </div>

                        <div class="tags-and-share light-bg mb-55 d-md-flex align-items-md-center justify-content-md-between"
                            data-animate="fadeInUp" data-delay=".1">
                            <div class="tags d-flex flex-wrap align-items-center">
                                <i class="fa fa-tags"></i>
                                <a href="#">envato</a>
                                <a href="#">internet</a>
                                <a href="#">technology</a>
                            </div>
                            <div class="post-share text-md-right">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-vimeo"></i></a>
                                <a href="#"><i class="fa fa-share-alt"></i></a>
                            </div>
                        </div>

                        <!-- Post Author -->
                        <div class="post-author mb-55 d-flex align-items-center" data-animate="fadeInUp" data-delay=".1">
                            <div class="post-author-img">
                                <img src="{{asset('img/authors/female.png')}}" alt="">
                            </div>
                            <div class="post-author-details">
                                <h5>About The Author</h5>
                                <p>Cupiditate non rovident, minus id quod maxime placeat facere possimus, omnis voluptas
                                    umenda omnis dolor repellendus. mporibus molestiae non recusandae.</p>
                                <a href="#">- Barbara S. Pickerel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Blog -->
@endsection