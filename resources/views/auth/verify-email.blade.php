@extends('layouts.frontend')

@section('page_title')
    Verify Your Account
@endsection

@section('breadcrumb_title')
    Verify Your Account
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
                    <div class="text-center">
                        <h2 class="sec-title line primary">Verify Your Account</h2>
                        <p>Please click the link that we have sent to your inbox.</p>
                    </div>
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success text-center">A new verification link has been sent to the email address you provided during registration.</div>
                    @endif
                    <div class="account-form rounded-4">
                        <div class="d-sm-flex justify-content-center mb-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-gr wow fadeInUp">Resend Verification Link</button>
                            </form>
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
@endsection
