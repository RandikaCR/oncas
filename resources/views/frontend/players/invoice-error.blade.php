@extends('layouts.frontend')

@section('page_title')
    Invoice Not Found
@endsection

@section('breadcrumb_title')
    Invoice Not Found
@endsection

@section('css')
@endsection

@section('style')
@endsection

@section('content')
    <section class="contact-card-sec sec-padding position-relative d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="error-txt text-center">
                        <h3 class="text-uppercase h1 text-danger">Invalid Invoice!</h3>
                        <p>Invalid Invoice or has been canceled. Please contact admin.</p>
                        <a class='btn btn-primary mt-5' href='{{ url('/') }}'>Back to Home</a>
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
