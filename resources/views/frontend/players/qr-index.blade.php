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
                    <div class="col-sm-12 text-center mb-2 mb-sm-5">
                        <div class="team-member2 text-center">
                            <div class="team-img mb-4">
                                <img class="img-fluid" src="{{ asset('assets/common/images/players/' . $player->image) }}" alt="{{ $player->first_name . ' ' . $player->last_name }}" style="max-width: 250px; width: 100%;">
                            </div>
                            <h5 class="mb-1">{{ $player->first_name . ' ' . $player->last_name }}</h5>
                            <h6 class="text-muted">{{ generatePlayerID($player->registration_number) }}</h6>
                            <p class="badge {{ $player->status_label }}">{{ $player->player_status }}</p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <a class="btn btn-primary w-100 mb-3" href="{{ route('frontend.players.attendances', $player->id) }}">Attendances</a>
                    </div>
                    <div class="col-sm-3">
                        <a class="btn btn-primary w-100 mb-3" href="{{ route('backend.payments.create', ['player_id' => $player->id]) }}">Payments</a>
                    </div>

                    <div class="col-sm-3">
                        <a class="btn btn-primary w-100 mb-3" href="{{ route('backend.players.view', $player->id) }}">View Player</a>
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
