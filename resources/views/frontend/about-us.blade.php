@extends('layouts.frontend')

@section('meta_info')
    @php
        $metaTitle = '';
        $metaDescription = '';
        $metaImage = '';
    @endphp
@endsection

@section('page_title')
    About ONCAS
@endsection

@section('breadcrumb_title')
    About ONCAS
@endsection

@section('css')
@endsection

@section('style')
@endsection

@section('content')

    @include('partials.frontend.breadcrumb')

    <section class="account-sec sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="text-center mb-5">
                        <h2 class="sec-title line primary">Building Tomorrow's Cricket Stars</h2>
                        <p>At <span class="fw-bold">ONCAS Cricket Academy</span>, we believe talent grows through discipline, dedication, and the right guidance. Our mission is to create a supportive environment where young cricketers can develop their technical skills, physical fitness, mental strength, and sportsmanship.</p>
                        <p class="mb-4">Every training session is carefully designed to help players improve while enjoying the game they love.</p>

                        <a href="{{ url('/join-academy') }}" class="btn btn-primary wow fadeInUp mb-4 me-0 me-sm-3" data-wow-delay=".4s">Join Academy</a>
                        <a href="{{ url('/contact') }}" class="btn btn-primary wow fadeInUp mb-4" data-wow-delay=".4s">Contact Us</a>
                    </div>

                    <div class="row about-tab">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" tabindex="-1">Our Mission</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Our Vision</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-5" id="myTabContent">
                                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-txt ps-lg-4">
                                                <p>To inspire, develop, and empower young cricketers by providing professional coaching, quality training, and opportunities to achieve excellence both on and off the field.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-txt ps-lg-4">
                                                <p>To become one of the leading cricket academies by producing skilled, disciplined, and confident players who excel at every level of the game.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
@endsection

@section('script')

    <script>
        $(document).ready(function(){
        });
    </script>

@endsection
