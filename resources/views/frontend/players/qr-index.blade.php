@extends('layouts.frontend')

@section('page_title')
    @if(!empty($player))
        {{ $player->first_name . ' ' . $player->last_name }}
    @else
        Player not found
    @endif

@endsection

@section('css')
@endsection

@section('style')
    <style type="text/css">
        .sec-padding-custom{
            padding: 40px 0 60px;
        }
    </style>
@endsection

@section('content')

    @if(!empty($player))
        <section class="contact-card-sec sec-padding-custom">
            <div class="container">
                <div class="row gy-3 gy-md-0">
                    <div class="col-sm-12 text-center">
                        <h5>{{ $player->first_name . ' ' . $player->last_name }}</h5>
                    </div>
                    <div class="col-sm-3">
                        <a class="btn btn-primary w-100" href="{{ route('frontend.players.attendances', $player->id) }}">Attendances</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="contact-card-sec sec-padding">
            <div class="container">
                <div class="row gy-3 gy-md-0">
                    <div class="col-sm-12">
                        <div class="alert alert-danger text-center fw-bold">Player not found</div>
                    </div>
                </div>
            </div>
        </section>
    @endif


@endsection

@section('js')
@endsection

@section('script')
@endsection
