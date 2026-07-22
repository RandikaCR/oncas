@extends('layouts.frontend')

@section('page_title')
    Welcome
@endsection

@section('css')
@endsection

@section('style')
    <style type="text/css">
        .jarallax{
            z-index: 1;
        }
    </style>
@endsection

@section('content')

    <section class="cricket-banner bg-dark position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="banner-txt text-center jarallax">
                        <p class="lead text-gr wow fadeInUp">Cricket we love you</p>
                        <h1 class="text-info text-uppercase text-anim">Practice with a purpose
                            play with a passion</h1>
                        <a href="{{ url('join-academy') }}" class="btn btn-primary wow fadeInUp" data-wow-delay=".15s">Start Practice Today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="banner-gallery">
        <div class="container-fluid">
            <div class="row g-3 gallery-wrap">
                <div class="col">
                    <a class="my-image-links" data-gall="gallery01" href="{{ asset('assets/frontend/images/crick1.jpg') }}">
                        <img class="img-fluid" src="{{ asset('assets/frontend/images/crick1.jpg') }}" alt="Cricket">
                    </a>
                </div>
                <div class="col">
                    <a class="my-image-links" data-gall="gallery01" href="{{ asset('assets/frontend/images/crick2.jpg') }}">
                        <img class="img-fluid" src="{{ asset('assets/frontend/images/crick2.jpg') }}" alt="Cricket">
                    </a>
                </div>
                <div class="col">
                    <a class="my-image-links" data-gall="gallery01" href="{{ asset('assets/frontend/images/crick3.jpg') }}">
                        <img class="img-fluid" src="{{ asset('assets/frontend/images/crick3.jpg') }}" alt="Cricket">
                    </a>
                </div>
                <div class="col">
                    <a class="my-image-links" data-gall="gallery01" href="{{ asset('assets/frontend/images/crick4.jpg') }}">
                        <img class="img-fluid" src="{{ asset('assets/frontend/images/crick4.jpg') }}" alt="Cricket">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section Start -->
    <section class="about-sec">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="about-txt">
                        <p class="lead text-success">Know About Us</p>
                        <h2 class="sec-title line-left green">Keep moving forward that’s how winning</h2>
                        <p class="wow fadeInUp">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <ul class="my-5 wow fadeInUp" data-wow-delay=".2s">
                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                        </ul>
                        <a href="{{ url('/join-academy') }}" class="btn btn-primary wow fadeInUp" data-wow-delay=".4s">Join Academy</a>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 order-1 order-lg-2 mb-5 mb-lg-0 col-sm-10">
                    <div class="about-img position-relative text-center">
                        <img class="img-fluid" src="{{ asset('assets/frontend/images/batter.jpg') }}" alt="">
                        <div class="d-sm-flex justify-content-between counter-wrap">
                            <div class="counter-card bg-dark p-4">
                                <div class="text-gr"><span data-purecounter-start="0" data-purecounter-end="15"
                                                           class="purecounter">0</span>K</div>
                                <p>Years of
                                    Experience Recorded</p>
                            </div>
                            <div class="counter-card bg-dark p-4">
                                <div class="text-gr"><span data-purecounter-start="0" data-purecounter-end="110"
                                                           class="purecounter">0</span>+</div>
                                <p>Skilled and
                                    Professional Trainers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->


    <!-- Team Section Start -->
    <section class="team2-sec sec-padding bg-mute">
        <div class="container">
            <div class="row pb-4">
                <div class="col-lg-6 mx-auto text-center">
                    <p class="lead wow fadeInUp text-success">Our Coaches</p>
                    <h2 class="sec-title line green">Experts in Coaching</h2>
                </div>
            </div>
            <div class="row mt-lg-5 gy-5 gy-md-0 justify-content-center">
                <div class="col-md-4">
                    <div class="team-member2 text-center">
                        <div class="team-img mb-4">
                            <img class="img-fluid" src="{{ asset('assets/common/images/user.png') }}" alt="Coach">
                        </div>
                        <h3 class="text-uppercase mb-0"><a href="javascript:void(0);">Aruna Weerasinghe</a></h3>
                        <p>Head Coach</p>
                    </div>
                </div>
            </div>
            <div class="row mt-lg-5 gy-5 gy-md-0 justify-content-center">
                <div class="col-md-4">
                    <div class="team-member2 text-center">
                        <div class="team-img mb-4">
                            <img class="img-fluid" src="{{ asset('assets/common/images/user.png') }}" alt="Coach">
                        </div>
                        <h3 class="text-uppercase mb-0"><a href="javascript:void(0);">Dilan Madhushanka</a></h3>
                        <p>Assistant Coach</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member2 text-center">
                        <div class="team-img mb-4">
                            <img class="img-fluid" src="{{ asset('assets/common/images/user.png') }}" alt="Coach">
                        </div>
                        <h3 class="text-uppercase mb-0"><a href="javascript:void(0);">Bavindu Chamod</a></h3>
                        <p>Assistant Coach</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member2 text-center">
                        <div class="team-img mb-4">
                            <img class="img-fluid" src="{{ asset('assets/common/images/user.png') }}" alt="Coach">
                        </div>
                        <h3 class="text-uppercase mb-0"><a href="javascript:void(0);">Nuwan Hewawasam</a></h3>
                        <p>Assistant Coach</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


    <!-- CTA Section Start -->
    <section class="cta-sec2 sec-padding bg-success">
        <div class="container">
            <div class="row g-0 align-items-center">
                <div class="col-lg-7 col-md-7">
                    <div class="cta-txt">
                        <p class="lead wow fadeInUp text-success">Know About Us</p>
                        <h2 class="sec-title line-left green text-info">
                            Keep moving forward that’s how winning
                        </h2>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 col-md-5">
                    <div class="cta-actions ms-xl-5 ps-md-5">
                        <div class="d-flex">
                     <span class="icon-sm text-success bg-info rounded-circle"><i
                             class="feather-icon icon-phone-call"></i></span>
                            <div class="ms-4 text-info">
                                <span>Call Us Anytime</span>
                                <h4 class="mt-1"><a href="tel:+94713114480">071 311 4480</a></h4>
                            </div>
                        </div>
                        <a href="{{ url('/contact') }}" class="btn btn-info mt-4">Contact Academy</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA Section End -->


    <!-- Text Slide Section Start -->
    <div class="text-slide cricket-text overflow-hidden my-5">
        <div class="slide-bar green-slide position-relative">
            <div class="box d-flex">
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>Hooked With The Hoop</span>
                </div>
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>Stay At The Winning Side</span>
                </div>
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>Bring Home The Ball</span>
                </div>
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>We love to focus</span>
                </div>
            </div>
        </div>
        <div class="slide-bar green-slide reverse position-relative">
            <div class="box d-flex">
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>Bring Home The Ball</span>
                </div>
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>Dribble the dream</span>
                </div>
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>The Basics Of Winning</span>
                </div>
                <div class="box-item">
                    <span><img src="{{ asset('assets/common/images/red-leather-ball.png') }}" alt="Star"></span>
                    <span>Stay At The Winning Side</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Text Slide Section End -->

@endsection

@section('js')
@endsection

@section('script')
@endsection
