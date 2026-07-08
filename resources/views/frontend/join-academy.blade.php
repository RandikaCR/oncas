@extends('layouts.frontend')

@section('page_title')
    Join Academy
@endsection

@section('breadcrumb_title')
    Join Academy
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
                        <h2 class="sec-title line primary">Register</h2>
                        <p>Please enter player information below</p>
                    </div>
                    <div class="account-form bg-mute rounded-4">
                        <form action="#">
                            <div class="form-group mb-4">
                                <label>Player Name*</label>
                                <input type="text" placeholder="Enter here...">
                            </div>
                            <div class="form-group mb-4">
                                <label>School Name*</label>
                                <input type="text" placeholder="Enter here...">
                            </div>
                            <div class="form-group half-form">
                                <label>Date of Birth*</label>
                                <input type="date" placeholder="Enter here...">
                            </div>
                            <div class="form-group half-form">
                                <label>Age*</label>
                                <input type="text" placeholder="Enter here...">
                            </div>
                            <div class="form-group mb-4">
                                <label>Address*</label>
                                <input type="text" placeholder="Enter here...">
                            </div>
                            <div class="form-group half-form">
                                <label>Emergency Contact Number*</label>
                                <input type="text" placeholder="Enter here...">
                            </div>
                            <div class="form-group half-form">
                                <label>Contact Number*</label>
                                <input type="text" placeholder="Enter here...">
                            </div>
                            <button class="btn btn-primary w-100 mt-5">Join</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
@endsection

@section('script')
@endsection
