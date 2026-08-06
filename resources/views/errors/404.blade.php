@extends('layouts.frontend')

@section('page_title')
    Page Not Found
@endsection

@section('breadcrumb_title')
    Page Not Found
@endsection

@section('css')
@endsection

@section('style')
@endsection

@section('content')
    <section class="error-sec position-relative d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="error-txt text-center">
                        <h1 class="error-title">404</h1>
                        <div class="py-3 pt-lg-5"></div>
                        <h3 class="text-uppercase h1">Oops... Page Not Found!</h3>
                        <p>Please return to the site's homepage, It looks like nothing was found at this location.</p>
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
