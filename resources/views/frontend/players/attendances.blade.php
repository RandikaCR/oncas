@extends('layouts.frontend')

@section('page_title')
    @if(!empty($player))
        Attendances
    @else
        Player not found
    @endif

@endsection

@section('css')
@endsection

@section('style')
    <style type="text/css">
        .fs-14{
            font-size: 14px !important;
        }
    </style>
@endsection

@section('content')

    @if(!empty($player))
        <div class="row gy-3 gy-md-0 mt-3 justify-content-end px-4">
            <div class="col-sm-3">
                <a class="btn btn-primary w-100" href="{{ route('frontend.players.qrView', $player->id) }}">Player Homepage</a>
            </div>
        </div>
        <section class="contact-card-sec sec-padding">
            <div class="container">
                <div class="row gy-3 gy-md-0">
                    <div class="col-sm-12">
                        <div class="poins-table">
                            <h2 class="sub-title mb-5">Available Events</h2>
                            <table class="table">
                                <tr>
                                    <th class="text-start">Event</th>
                                    <th class="text-center">Time</th>
                                    <th></th>
                                </tr>
                                @foreach($events as $event)
                                    <tr class="align-middle fs-14">
                                        <td class="text-start">
                                            <p class="mb-0 fw-bold">{{ $event->event }}</p>
                                            <p class="mb-0 text-muted">{{ $event->venue }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="mb-0">{{ dateTimeFullFormat($event->start_time) }}</p>
                                            <p class="mb-0 text-muted">{{ dateTimeFullFormat($event->end_time) }}</p>
                                        </td>
                                        <td class="text-end">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm set-attendance" data-event-id="{{ $event->id }}"><i class="feather-icon icon-check m-0"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
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
    @if(!empty($player))
    <script>
        $(document).ready(function(){
            $('.set-attendance').on('click', function ($e){
                $e.preventDefault();
                $name = "{{ $player->first_name . ' ' . $player->last_name }}";
                $playerId = "{{ $player->id }}";
                $eventId = $(this).data('event-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to mark " + $name + " attended to this event!",
                    icon: "warning",
                    showCancelButton: !0,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Attended!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-secondary w-xs mt-2",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then((result) => {
                    if (result.isConfirmed) {

                        setTimeout(function() {
                            $.ajax({
                                url: "{{ route('frontend.players.setAttendance') }}",
                                type: 'POST',
                                data: {
                                    player_id: $playerId,
                                    event_id: $eventId,
                                    _token: csrf_token()
                                },
                                dataType: 'json',
                                beforeSend: function ($jqXHR, $obj) {
                                    Swal.fire({
                                        title: "Processing...",
                                        text: "Please wait",
                                        imageUrl: "{{ asset('assets/common/images/ajax-loader.gif') }}",
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                },
                                success: function ($response, $textStatus, $jqXHR) {
                                    if($response.status == 'success'){
                                        Swal.fire('Done!', $response.message, 'success');
                                    }else{
                                        Swal.fire('Error!', $response.message, 'error');
                                    }

                                    setTimeout(function(){
                                        location.reload();
                                    },3000);
                                },
                                error: function ($jqXHR, $textStatus, $errorThrown) {
                                    Swal.fire('Oops...', 'Something went wrong with the System!', 'error');
                                }
                            });

                        }, 50);
                    }
                });

            });
        });
    </script>
    @endif
@endsection
