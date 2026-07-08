<footer class="footer footer2 bg-dark">
    <div class="container">
        <div class="row mb-lg-5">
            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget touch-widget green">
                    <h3 class="widget-title text-uppercase text-white">Get In Touch</h3>

                    <ul class="mt-5">
                        <li class="d-flex align-items-center">
                            <span><i class="feather-icon icon-mail"></i></span>
                            <a href="mailto:info@oncas.lk">info@oncas.lk</a>
                        </li>
                        <li class="d-flex align-items-center">
                            <span><i class="feather-icon icon-phone-call"></i></span>
                            <a href="tel:+94713114480">071 311 4480</a>
                        </li>
                        <li class="d-flex align-items-center">
                            <span><i class="feather-icon icon-phone-call"></i></span>
                            <a href="tel:+94789542590">078 954 2590</a>
                        </li>
                        <li class="d-flex align-items-center">
                            <span><i class="feather-icon icon-phone-call"></i></span>
                            <a href="tel:+94767366971">076 736 6971</a>
                        </li>
                        <li class="d-flex align-items-center">
                            <span><i class="feather-icon icon-phone-call"></i></span>
                            <a href="tel:+94710100666">071 010 0666</a>
                        </li>

                    </ul>
                </div>
            </div><!--  Widget End -->
            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget">
                    <h3 class="widget-title text-uppercase text-white">Help Center</h3>
                    <ul>
                        <li><a href="{{ url('join-academy') }}">Join Academy</a></li>
                        <li><a href="{{ url('contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div><!--  Widget End -->

            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget instagram-widget">
                    <div class="instagrame-posts">
                        <img class="img-fluid" src="{{ asset('assets/common/images/logo-full.png') }}" alt="Oncas">
                    </div>
                </div>
            </div><!--  Widget End -->
        </div>
        <div class="row pt-lg-5">
            <div class="col-lg-12 pt-4 copy-right">
                <p class="m-0 text-center">Copyright © {{ date('Y', time()) }} Admin @ ONCAS. All Rights Reserved
                </p>
            </div>
        </div>
    </div>
</footer>
