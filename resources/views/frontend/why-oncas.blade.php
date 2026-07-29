@extends('layouts.frontend')

@section('meta_info')
    @php
        $metaTitle = '';
        $metaDescription = '';
        $metaImage = '';
    @endphp
@endsection

@section('page_title')
    Why ONCAS
@endsection

@section('breadcrumb_title')
    Why ONCAS
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
                        <h2 class="sec-title line primary">Why Choose ONCAS Cricket Academy?</h2>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Expert Coaching</h4>
                        <ul class="mt-3">
                            <li>Train under experienced coaches focused on developing every aspect of your game.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Skill Development</h4>
                        <ul class="mt-3">
                            <li>Comprehensive training in batting, bowling, wicketkeeping, fielding, fitness, and match awareness.</li>
                        </ul>
                    </div>

                    <div class="text-left mb-5 tab-txt">
                        <h4>Personalized Attention</h4>
                        <ul class="mt-3">
                            <li>Small training groups ensure every player receives individual coaching and constructive feedback.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Performance Tracking</h4>
                        <ul class="mt-3">
                            <li>Regular assessments help players monitor progress and identify areas for improvement.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Character Building</h4>
                        <ul class="mt-3">
                            <li>Learn teamwork, discipline, leadership, confidence, and respect—qualities that extend beyond the cricket field.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Competitive Opportunities</h4>
                        <ul class="mt-3">
                            <li>Participate in practice matches, tournaments, and cricket camps to gain valuable match experience.</li>
                        </ul>
                    </div>



                </div>
            </div>
        </div>

        <div class="text-center bg-primary py-4 my-5">
            <h3 class="line primary text-white mb-0">Our Training Programs</h3>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="text-left mb-5 tab-txt">
                        <h4>Beginners Program</h4>
                        <ul class="mt-3">
                            <li>Perfect for young players who are new to cricket and want to learn the fundamentals.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Intermediate Program</h4>
                        <ul class="mt-3">
                            <li>Enhance your technique, fitness, and tactical understanding of the game.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Advanced Program</h4>
                        <ul class="mt-3">
                            <li>High-performance training for competitive players aiming for school, club, district, or national-level cricket.</li>
                        </ul>
                    </div>
                    <div class="text-left mb-5 tab-txt">
                        <h4>Holiday Cricket Camps</h4>
                        <ul class="mt-3">
                            <li>Fun, intensive coaching camps during school holidays featuring skill development and exciting cricket activities.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="text-center bg-primary py-4 my-5">
            <h3 class="line primary text-white mb-0">What We Teach</h3>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="text-left mb-5 tab-txt">
                        <ul class="mt-3">
                            <li>Batting Techniques</li>
                            <li>Fast & Spin Bowling</li>
                            <li>Wicketkeeping Skills</li>
                            <li>Fielding & Catching Drills</li>
                            <li>Strength & Conditioning</li>
                            <li>Agility & Speed Training</li>
                            <li>Match Strategy & Game Awareness</li>
                            <li>Mental Toughness & Confidence</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="text-center bg-primary py-4 my-5">
            <h3 class="line primary text-white mb-0">Who Can Join?</h3>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="text-left mb-5 tab-txt">
                        <p class="text-black">Our academy welcomes aspiring cricketers of all abilities.</p>
                        <ul class="mt-3">
                            <li>Boys & Girls</li>
                            <li>Ages 8+</li>
                            <li>Beginners to Advanced Players</li>
                            <li>School & Club Cricketers</li>
                        </ul>
                        <p class="text-black">No previous experience is required for beginner programs.</p>
                    </div>

                    <div class="text-center my-5">
                        <a href="{{ url('/join-academy') }}" class="btn btn-primary wow fadeInUp mb-4 me-0 me-sm-3" data-wow-delay=".4s">Join Academy</a>
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
