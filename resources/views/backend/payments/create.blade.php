@extends('layouts.backend')

@php
    $pageTitle = 'Create a Payment';
    $singlePageTitle = 'Create a Payment';
    $routePrefix = 'payments';
    $pageUrl = 'payments';
@endphp

@section('page_title')
    {{ $pageTitle }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/backend/packages/cdn.jsdelivr.net/npm/select2%404.1.0-rc.0/dist/css/select2.min.css') }}">
@endsection

@section('css')

@endsection

@if(!empty($user_access))

    @section('header_buttons')
        <div class="row">
            <div class="col-sm-12 d-flex justify-content-end mb-3">
                @if(!empty($payment))
                    <a href="{{ route('backend.payments.view', $payment->id) }}" class="btn btn-primary me-3">
                        <span class="mdi mdi-magnify me-2"></span>
                        View
                    </a>
                @endif
                <a href="{{ route('backend.payments.index') }}" class="btn btn-primary me-3">
                    <span class="mdi mdi-plus-box me-2"></span>
                    All Payments
                </a>
            </div>
        </div>
    @endsection

    @section('content')
        <form method="POST" action="{{ route('backend.payments.store') }}">
            @csrf
            <input type="hidden" name="id" value="{{ isset($payment) ? $payment->id : 0 }}">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label shadow fade show mb-xl-2" role="alert">
                                <i class="ri-error-warning-line label-icon"></i><strong>Required field: </strong>
                                {{$error}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Payment Details</h4>
                            <div class="flex-shrink-0">
                                <button type="submit" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-content-save me-1"></i>SAVE</button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div>
                                            @php
                                            $selectedPlayerId = !empty($player_id) ? $player_id : null;
                                            if (!empty($payment)){
                                                $selectedPlayerId = $payment->player_id;
                                            }
                                            @endphp
                                            <label for="player_id" class="form-label">Player</label>
                                            <select class="js-example-basic-single form-control"  name="player_id" id="player_id">
                                                <option value="">Select Player</option>
                                                @foreach($players as $player)
                                                    <option value="{{ $player->id }}" {{ !empty($selectedPlayerId) && $selectedPlayerId == $player->id ? 'selected' : '' }}>{{ generatePlayerID($player->registration_number) . ' - ' . $player->first_name .' '.$player->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div>
                                            <label for="payment_status_id" class="form-label">Payment Status</label>
                                            <select class="js-example-basic-single form-control"  name="payment_status_id" id="payment_status_id">
                                                <option value="">Select Payment Status</option>
                                                @foreach($payment_statuses as $ps)
                                                    <option value="{{ $ps->id }}" {{ !empty($payment) && $payment->payment_status_id == $ps->id ? 'selected' : '' }}>{{ $ps->payment_status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                                        <div class="flex-shrink-0">
                                            <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light add-row"><i class="mdi mdi-plus me-1"></i>ADD NEW LINE</a>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">

                                <div id="payment-details">

                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->
                </div>
            </div>
        </form>

    @endsection

@else
    @section('content')
        @include('partials.backend.no-access')
    @endsection
@endif


@section('scripts')
    <script src="{{ asset('assets/backend/packages/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/backend/packages/cdn.jsdelivr.net/npm/select2%404.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/select2.init.js') }}"></script>
@endsection

@section('custom_scripts')
    <script>

        $paymentId = "{{ !empty($payment) ? $payment->id : 0 }}";
        $paymentTypes = [];
        $events = [];
        $ptMonthlyFeeId = "{{ $pt_monthly_fee_id }}";
        $ptMatchFeeId = "{{ $pt_match_fee_id }}";
        $ptRegistrationFeeId = "{{ $pt_registration_fee_id }}";
        $defaultRegistrationFee = "{{ $as->registration_fee }}";
        $defaultMonthlyFee = "{{ $as->monthly_fee }}";

        function paymentRow($item){

            $isVisibleMonthArea = 'd-none';
            $isVisibleEventsArea = 'd-none';
            $month = '';
            $amount = 0;
            $selectedPaymentType = null;
            $selectedEventId = null;

            if(typeUnd($item)){
                $selectedPaymentType = $item.payment_type_id;
                $amount = $item.amount;

                if($selectedPaymentType == $ptMonthlyFeeId){
                    $isVisibleMonthArea = '';

                    $month = moment($item.month).format('MMM-YYYY');

                }else if($selectedPaymentType == $ptMatchFeeId){
                    $isVisibleEventsArea = '';
                    $selectedEventId = $item.event_id;
                }
            }

            $selectPaymentTypes = $('<select></select>').addClass('js-example-basic-single form-control select-payment-type').attr('name', 'payment_type_id[]')
            $('<option></option>').attr('value', '').text('Select Payment Type').appendTo($selectPaymentTypes);

            $.each($paymentTypes, function ($ptIndex, $ptItem){
                $ptSelected = ($ptItem.id == $selectedPaymentType) ? true : false;
                $('<option></option>').attr('value', $ptItem.id).prop('selected', $ptSelected).text($ptItem.payment_type).appendTo($selectPaymentTypes);
            });


            $selectEvents = $('<select></select>').addClass('js-example-basic-single form-control').attr('name', 'event_id[]')
            $('<option></option>').attr('value', '').text('Select Event').appendTo($selectEvents);

            $.each($events, function ($eIndex, $eItem){
                $eSelected = ($eItem.id == $selectedEventId) ? true : false;
                $('<option></option>').attr('value', $eItem.id).prop('selected', $eSelected).text($eItem.event + ' - ' +$eItem.venue).appendTo($selectEvents);
            });

            $el = $('<div></div>').addClass('row mb-3 border-bottom');

            $detailRow = $('<div></div>').addClass('row');

            $('<div></div>').addClass('col-md-2 mb-3')
            .append($('<div></div>')
                .append($('<label></label>').addClass('form-label').text('Payment Type'))
                .append($selectPaymentTypes)
            ).appendTo($detailRow);

            $('<div></div>').addClass('col-md-4 mb-3 detail-event-area ' + $isVisibleEventsArea)
            .append($('<div></div>')
                .append($('<label></label>').addClass('form-label').text('Event'))
                .append($selectEvents)
            ).appendTo($detailRow);

            $('<div></div>').addClass('col-md-2 mb-3 detail-month-area ' + $isVisibleMonthArea)
            .append($('<div></div>')
                .append($('<label></label>').addClass('form-label').text('Month'))
                .append($('<input>').addClass('form-control date-select').attr('name', 'month[]').attr('data-provider', 'flatpickr').attr('data-date-format', 'M-Y').val($month))
            ).appendTo($detailRow);

            $('<div></div>').addClass('col-md-2 mb-3')
            .append($('<div></div>')
                .append($('<label></label>').addClass('form-label').text('Amount*'))
                .append($('<div></div>').addClass('input-group')
                    .append($('<span></span>').addClass('input-group-text').text('Rs.'))
                    .append($('<input>').addClass('form-control text-end amount').attr('name', 'amount[]').val($amount).attr('aria-label', 'Amount'))
                    .append($('<span></span>').addClass('input-group-text').text('.00'))
                )
            ).appendTo($detailRow);

            $('<div></div>').addClass('col-sm-11').append($detailRow).appendTo($el);

            $('<div></div>').addClass('col-sm-1 mb-3 d-flex justify-content-end align-items-center')
            .append($('<div></div>')
                    .append($('<a></a>').addClass('btn btn-danger btn-sm waves-effect waves-light remove-detail').attr('href', 'javascript:void(0);').attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete')
                        .append($('<span></span>').addClass('mdi mdi-delete'))
                    )
            ).appendTo($el);

            return $el;

        }


        $(document).ready(function (){

            $.ajax({
                url: "{{ route('backend.payments.getPaymentDetailsRowInfo') }}",
                type: 'POST',
                data: {
                    payment_id: $paymentId,
                    _token: csrf_token()
                },
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {
                },
                success: function ($response, $textStatus, $jqXHR) {
                    $paymentTypes = $response.payment_types;
                    $events = $response.events;

                    if(typeUnd($response.details) && Object.keys($response.details).length > 0){
                        $.each($response.details, function ($index, $item){
                            $row = paymentRow($item);
                            $('#payment-details').append($row);
                        });

                        $(".js-example-basic-single").select2();
                        flatpickr($('.date-select'), {
                            dateFormat: "M-Y",
                        });
                    }
                },
                error: function ($jqXHR, $textStatus, $errorThrown) {

                }
            });


            $('#payment-details').on('change', '.select-payment-type', function ($e){
                $ptId = $(this).val();

                $(this).parent().parent().siblings('.detail-month-area').addClass('d-none');
                $(this).parent().parent().siblings('.detail-event-area').addClass('d-none');
                $(this).parent().parent().parent().find('.amount').val(0);


                // monthly fee
                if($ptId == $ptMonthlyFeeId){
                    $(this).parent().parent().siblings('.detail-month-area').removeClass('d-none');
                    $(this).parent().parent().parent().find('.date-select').val(moment().format('MMM-YYYY'));
                    $(this).parent().parent().parent().find('.amount').val($defaultMonthlyFee);
                }
                // match fee
                else if($ptId == $ptMatchFeeId){
                    $(this).parent().parent().siblings('.detail-event-area').removeClass('d-none');
                }
                // Registration fee
                else if($ptId == $ptRegistrationFeeId){
                    $(this).parent().parent().parent().find('.amount').val($defaultRegistrationFee);
                }

            });

            $('.add-row').on('click', function ($e){
                $e.preventDefault();

                $row = paymentRow();
                $('#payment-details').append($row);

                $(".js-example-basic-single").select2();

                flatpickr($('.date-select'), {
                    dateFormat: "M-Y",
                });
            });

            $('#payment-details').on('click', '.remove-detail', function ($e){
                $e.preventDefault();
                $this = $(this);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this detail!",
                    icon: "warning",
                    showCancelButton: !0,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-secondary w-xs mt-2",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire('Done!', 'Detail has been deleted!', 'success');
                        $($this).parent().parent().parent().fadeOut('slow');
                        setTimeout(function (){
                            $($this).parent().parent().parent().remove();
                        }, 1000);
                    }
                });


            });
        });
    </script>


@endsection
