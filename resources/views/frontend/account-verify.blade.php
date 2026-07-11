@extends('layouts.frontend')

@section('page_title')
    Email Verification
@endsection

@section('breadcrumb_title')
    Email Verification
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
                    @if(!empty($errors))
                        @foreach($errors as $error)
                            <div class="alert alert-danger text-center">{{ $error }}</div>
                        @endforeach
                    @else

                        <div class="text-center mb-5">
                            <h2 class="sec-title line primary">Account Activated</h2>
                            <p>Please login to your account</p>
                        </div>
                        @if(!empty(Auth::user()->id))
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('backend.dashboard') }}" class="btn btn-primary w-25">Dashboard</a>
                            </div>
                        @else
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('login') }}" class="btn btn-primary w-25">Login</a>
                            </div>
                        @endif

                    @endif

                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
@endsection

@section('script')
@endsection
