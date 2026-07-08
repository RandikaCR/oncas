@extends('layouts.frontend')

@section('page_title')
    Contact Us
@endsection

@section('breadcrumb_title')
    Contact Us
@endsection

@section('css')
@endsection

@section('style')
@endsection

@section('content')

    @include('partials.frontend.breadcrumb')

    <section class="contact-card-sec sec-padding">
        <div class="container">
            <div class="row gy-3 gy-md-0">
                <div class="col-md-4">
                    <div class="contact-card text-center rounded-3">
                        <span class="icon rounded-pill"><i class="feather-icon icon-mail"></i></span>
                        <h3>Email Us</h3>
                        <ul class="list-unstyled">
                            <li>
                                <a href="mailto:info@oncas.lk">info@oncas.lk</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Card End -->
                </div>
                <div class="col-md-8">
                    <div class="contact-card text-center rounded-3">
                        <span class="icon rounded-pill"><i class="feather-icon icon-phone"></i></span>
                        <h3>Call Us</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled">
                                    <li><a href="tel:+94713114480">071 311 4480</a></li>
                                    <li><a href="tel:+94710100666">071 010 0666</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled">
                                    <li><a href="tel:+94789542590">078 954 2590</a></li>
                                    <li><a href="tel:+94767366971">076 736 6971</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card End -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection

@section('script')
@endsection
