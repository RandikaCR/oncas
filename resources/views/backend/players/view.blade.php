@extends('layouts.backend')

@php
    $pageTitle = 'Players';
    $singlePageTitle = 'Player';
    $routePrefix = 'players';
    $pageUrl = 'players';
@endphp

@section('page_title')
    {{ $pageTitle }}
@endsection

@section('styles')

@endsection

@section('css')

@endsection

@if(!empty($user_access))

    @section('header_buttons')
        <div class="row">
            <div class="col-sm-12 d-flex justify-content-end mb-3">
                <a href="{{ route('backend.players.create') }}" class="btn btn-primary me-3">
                    <span class="mdi mdi-plus-box me-2"></span>
                    All Players
                </a>
            </div>
        </div>
    @endsection

    @section('content')

        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="card">
                    <div class="card-header align-items-center justify-content-between d-flex">
                        <div>
                            <h4 class="card-title mb-0 flex-grow-1">General Details</h4>
                        </div>
                        <div>
                            <span class="badge {{ $player->status_label }}">{{ $player->player_status }}</span>
                        </div>

                    </div><!-- end card header -->

                    <div class="card-body p-4 text-center">
                        <div class="mb-3 px-5">
                            <img src="{{ asset('assets/common/images/players/' . $player->image) }}" alt="{{ $player->first_name .' '.$player->last_name }}" class="img-fluid">
                        </div>
                        <h5 class="card-title mb-1">{{ $player->first_name .' '.$player->last_name }}</h5>
                        <p class="text-info fw-medium mb-3 fs-14">{{ generatePlayerID($player->registration_number) }}</p>
                        @if(!empty($player->is_foc))
                            <p class="text-muted mb-2"><span class="badge badge-gradient-danger fs-12">FOC Player</span></p>
                        @endif

                        @if(!empty($player->last_activity_at))
                            <p class="text-muted mb-2 fs-11">
                                Last activity <span class="text-dark">{{ dateTimeFullFormat($player->last_activity_at) }}</span>
                                @if(!empty($player->last_activity_venue_id))
                                    at <span class="text-dark">{{ $player->last_activity_venue }}</span>
                                @endif
                            </p>
                        @endif

                        <div class="row mt-3 py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Role</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <span class="fw-medium mb-0">{{ $player->player_role }}</span>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Style</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <p class="fw-medium mb-1">{{ $player->batting_style }}</p>
                                <p class="fw-medium mb-0">{{ $player->bowling_style }}</p>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Level</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <span class="fw-medium mb-0">{{ $player->player_level }}</span>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Date of Birth</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <span class="fw-medium mb-0">{{ dateFormat($player->date_of_birth) }}</span>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">School</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <span class="fw-medium mb-0">{{ $player->school }}</span>
                            </div>
                        </div>

                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Sizes</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <p class="fw-medium mb-1"><span class="text-muted">T-Shirt - </span>{{ $player->tshirt_size }}</p>
                                <p class="fw-medium mb-0"><span class="text-muted">Bottom - </span>{{ $player->bottom_size }}</p>
                            </div>
                        </div>


                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Contact</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <p class="text-muted mb-1"><a href="tel:{{ $player->contact_1 }}">{{ $player->contact_1 }}</a></p>
                                <p class="text-muted mb-0"><a href="tel:{{ $player->contact_2 }}">{{ $player->contact_2 }}</a></p>
                            </div>
                        </div>

                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-5 text-start">
                                <span class="text-muted">Emergency</span>
                            </div>
                            <div class="col-sm-7 text-start">
                                <p class="text-muted mb-1">{{ $player->emergency_contact_1_name }}</p>
                                <p class="text-muted mb-0"><a href="tel:{{ $player->emergency_contact_1 }}">{{ $player->emergency_contact_1 }}</a></p>
                            </div>
                        </div>

                        @if(!empty($player->emergency_contact_2_name))
                            <div class="row py-2 border-bottom align-items-center">
                                <div class="col-sm-5 text-start">
                                    <span class="text-muted">Emergency 2</span>
                                </div>
                                <div class="col-sm-7 text-start">
                                    <p class="text-muted mb-1">{{ $player->emergency_contact_2_name }}</p>
                                    <p class="text-muted mb-0"><a href="tel:{{ $player->emergency_contact_2 }}">{{ $player->emergency_contact_2 }}</a></p>
                                </div>
                            </div>
                        @endif


                    </div>
                    <div class="card-footer">
                        <a class="btn btn-secondary d-grid btn-sm" href="{{ url('assets/common/images/qr/' . $player->qr_code) }}" download>DOWNLOAD QR</a>
                    </div>
                </div><!-- end card -->
            </div>
            <div class="col-lg-9 col-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <ul class="nav nav-pills animation-nav nav-justified" role="tablist" id="tab-list">
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-light active" data-bs-toggle="tab" data-tab="attendances" href="#tab-attendances" role="tab">Attendances</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-light" data-bs-toggle="tab" data-tab="payments" href="#tab-payments" role="tab">Payments</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content text-muted mb-5">
                    <div class="tab-pane active" id="tab-attendances" role="tabpanel">
                        <div class="card" id="orders-table-area">
                            <div class="card-body">
                                <div class="card-header align-items-center justify-content-between d-md-flex">
                                    <div class="">
                                        <h4 class="card-title flex-grow-1 mb-2">Subscriptions</h4>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="mb-2 me-2">
                                            <input class="form-control form-control-sm keyword" type="text" placeholder="Enter keyword here..." autocomplete="off">
                                        </div>
                                        <div class="mb-2">
                                            <button class="btn btn-sm btn-primary btn-load search-btn">
                                <span class="d-flex align-items-center">
                                    <span class="spinner-border flex-shrink-0 me-2 search-btn-loading d-none" role="status"></span>
                                    <span class="flex-grow-1 search-btn-text">
                                        Search
                                    </span>
                                </span>
                                            </button>
                                            <button class="btn btn-sm btn-outline-dark waves-effect waves-light shadow-none search-clear-btn">
                                <span class="d-flex align-items-center">
                                    <span class="flex-grow-1">
                                        Clear
                                    </span>
                                </span>
                                            </button>


                                        </div>

                                    </div>
                                </div>
                                <div class="live-preview table-area">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-nowrap align-middle mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Pricing Plan</p>
                                                        <p class="mb-0 text-muted">Duration</p>
                                                    </div>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Cost</p>
                                                    </div>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Next Cycle</p>
                                                        <p class="mb-0 text-muted">Subscribed at</p>
                                                    </div>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Invoice Number</p>
                                                        <p class="mb-0 text-muted">Invoice created at</p>
                                                    </div>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Order Status</p>
                                                        <p class="mb-0 text-muted">Subscription Approval</p>
                                                    </div>
                                                </th>
                                                <th class="text-end" scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-body">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2 d-flex justify-content-end">
                                        <span class="text-muted"> Showing<span class="mx-1 records-showing-first-count">0</span>to<span class="mx-1 records-showing-last-count">0</span>of<span class="mx-1 records-total-count">0</span>records</span>
                                    </div>
                                    <div class="mt-3 pagination-area">

                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-payments" role="tabpanel">
                        <div class="card" id="reviews-table-area">
                            <div class="card-body">
                                <div class="card-header align-items-center justify-content-between d-md-flex">
                                    <div class="">
                                        <h4 class="card-title flex-grow-1 mb-2">Reviews</h4>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="mb-2 me-2">
                                            <input class="form-control form-control-sm keyword" type="text" placeholder="Enter keyword here..." autocomplete="off">
                                        </div>
                                        <div class="mb-2">
                                            <button class="btn btn-sm btn-primary btn-load search-btn">
                                            <span class="d-flex align-items-center">
                                                <span class="spinner-border flex-shrink-0 me-2 search-btn-loading d-none" role="status"></span>
                                                <span class="flex-grow-1 search-btn-text">
                                                    Search
                                                </span>
                                            </span>
                                            </button>
                                            <button class="btn btn-sm btn-outline-dark waves-effect waves-light shadow-none search-clear-btn">
                                            <span class="d-flex align-items-center">
                                                <span class="flex-grow-1">
                                                    Clear
                                                </span>
                                            </span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="live-preview table-area">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-nowrap align-middle mb-0">
                                            <thead>
                                            <tr>
                                                <th colspan="2" scope="col">
                                                    <div>
                                                        <p class="mb-0">Reviewed Person</p>
                                                        <p class="mb-0 text-muted">Email</p>
                                                    </div>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Rate</p>
                                                    </div>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <div>
                                                        <p class="mb-0">Status</p>
                                                    </div>
                                                </th>
                                                <th class="text-end" scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-body">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2 d-flex justify-content-end">
                                        <span class="text-muted"> Showing<span class="mx-1 records-showing-first-count">0</span>to<span class="mx-1 records-showing-last-count">0</span>of<span class="mx-1 records-total-count">0</span>records</span>
                                    </div>
                                    <div class="mt-3 pagination-area">

                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div id="review-loading-img">
                            <img src="{{ asset('assets/common/images/ajax-loader.gif') }}" alt="loading">

                            <div class="hstack gap-2 justify-content-center mt-5">
                                <a href="javascript:void(0);" class="btn btn-dark fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                            </div>
                        </div>

                        <div id="review-content-area">
                            <h4 class="mb-2" id="review-name"></h4>
                            <h5 class="mb-4" id="review-email"></h5>
                            <p class="text-muted mb-5" id="review-message"></p>
                            <input type="hidden" id="review-id" value="">
                            <div class="hstack gap-2 justify-content-center">
                                <a href="javascript:void(0);" class="btn btn-dark fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                <a href="javascript:void(0);" class="btn btn-success" id="review-approve">Approve</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection

@else
    @section('content')
        @include('partials.backend.no-access')
    @endsection
@endif


@section('scripts')
    <script src="{{ asset('assets/backend/packages/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection

@section('custom_scripts')
    <script>

        var $playerId = "{{ $player->id }}";
        var $currentTab = 'subscriptions';

        var $ordersTableArea = $('#orders-table-area');
        var $reviewsTableArea = $('#reviews-table-area');
        var $messagesTableArea = $('#messages-table-area');
        var $changesTableArea = $('#changes-table-area');


        /*function getAttendances($pageNo = 1){
            $keyword = $($ordersTableArea).find('.keyword').val().trim();

            $.ajax({
                url: "{{--{{ route('backend.orders.getOrdersViaAjax') }}--}}",
                type: 'POST',
                data: {
                    user_id: $playerId,
                    keyword: $keyword,
                    page: $pageNo,
                    _token: csrf_token()
                },
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {

                    $($ordersTableArea).find('.search-btn').prop('disabled', true);
                    $($ordersTableArea).find('.search-btn-loading').removeClass('d-none');
                    $($ordersTableArea).find('.search-btn-text').text('Loading....');
                    $($ordersTableArea).find('.pagination-area').html('');
                    $($ordersTableArea).find('.table-body').html('');
                    $($ordersTableArea).find('.table-body').html(ajaxLoader(6));
                    $($ordersTableArea).find('.records-showing-first-count').text(0);
                    $($ordersTableArea).find('.records-showing-last-count').text(0);
                    $($ordersTableArea).find('.records-total-count').text(0);

                },
                success: function ($res, $textStatus, $jqXHR) {
                    $($ordersTableArea).find('.table-body').html('');

                    $($ordersTableArea).find('.search-btn').prop('disabled', false);
                    $($ordersTableArea).find('.search-btn-loading').addClass('d-none');
                    $($ordersTableArea).find('.search-btn-text').text('Search');
                    $($ordersTableArea).find('.pagination-area').html($res.pagination);
                    $($ordersTableArea).find('.table-body').html($res.body);
                    $($ordersTableArea).find('.records-showing-first-count').text($res.showing_first_item);
                    $($ordersTableArea).find('.records-showing-last-count').text($res.showing_last_item);
                    $($ordersTableArea).find('.records-total-count').text($res.total_count);

                },
                error: function ($jqXHR, $textStatus, $errorThrown) {
                }
            });
        }

        function getPayments($pageNo = 1){
            $keyword = $($reviewsTableArea).find('.keyword').val().trim();

            $.ajax({
                url: "{{--{{ route('backend.userReviews.getReviewsViaAjax') }}--}}",
                type: 'POST',
                data: {
                    user_id: $playerId,
                    keyword: $keyword,
                    page: $pageNo,
                    _token: csrf_token()
                },
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {

                    $($reviewsTableArea).find('.search-btn').prop('disabled', true);
                    $($reviewsTableArea).find('.search-btn-loading').removeClass('d-none');
                    $($reviewsTableArea).find('.search-btn-text').text('Loading....');
                    $($reviewsTableArea).find('.pagination-area').html('');
                    $($reviewsTableArea).find('.table-body').html('');
                    $($reviewsTableArea).find('.table-body').html(ajaxLoader(5));
                    $($reviewsTableArea).find('.records-showing-first-count').text(0);
                    $($reviewsTableArea).find('.records-showing-last-count').text(0);
                    $($reviewsTableArea).find('.records-total-count').text(0);

                },
                success: function ($res, $textStatus, $jqXHR) {
                    $($reviewsTableArea).find('.table-body').html('');

                    $($reviewsTableArea).find('.search-btn').prop('disabled', false);
                    $($reviewsTableArea).find('.search-btn-loading').addClass('d-none');
                    $($reviewsTableArea).find('.search-btn-text').text('Search');
                    $($reviewsTableArea).find('.pagination-area').html($res.pagination);
                    $($reviewsTableArea).find('.table-body').html($res.body);
                    $($reviewsTableArea).find('.records-showing-first-count').text($res.showing_first_item);
                    $($reviewsTableArea).find('.records-showing-last-count').text($res.showing_last_item);
                    $($reviewsTableArea).find('.records-total-count').text($res.total_count);

                },
                error: function ($jqXHR, $textStatus, $errorThrown) {
                }
            });
        }*/

        $(document).ready(function (){



            $('#tab-list').on('click', '.nav-link', function ($e){
                $e.preventDefault();

                $thisTab = $(this).data('tab');
                if($thisTab != $currentTab){
                    if($thisTab == 'attendances'){
                        //getAttendances(1);
                        log('attendance')
                    }else if($thisTab == 'payments'){
                        //getPayments(1);
                        log('payments')
                    }
                }
                $currentTab = $thisTab;
            });


            /*START - ORDERS RELATED SCRIPTS*/
            $($ordersTableArea).on('click', '.pagination a', function($e) {
                $e.preventDefault();
                var $url = $(this).attr('href');
                var $startIndex = $url.indexOf('page');
                if ($startIndex !== -1) {
                    $startOfValueIndex = $startIndex + 5;
                    $pageNo = $url.substring($startOfValueIndex).trim();
                    getOrders($pageNo);
                }
            });
            $($ordersTableArea).on('keydown', '.keyword', function($e) {
                if ($e.which === 13) {
                    $e.preventDefault();
                    getOrders(1);
                }
            });
            $($ordersTableArea).on('click', '.search-btn', function($e) {
                getOrders(1);
            });
            $($ordersTableArea).on('click', '.search-clear-btn', function($e) {
                $($ordersTableArea).find('.keyword').val('');
                getOrders(1);
            });
            /*END - ORDERS RELATED SCRIPTS*/

            /*START - REVIEWS RELATED SCRIPTS*/
            $($reviewsTableArea).on('click', '.pagination a', function($e) {
                $e.preventDefault();
                var $url = $(this).attr('href');
                var $startIndex = $url.indexOf('page');
                if ($startIndex !== -1) {
                    $startOfValueIndex = $startIndex + 5;
                    $pageNo = $url.substring($startOfValueIndex).trim();
                    getReviews($pageNo);
                }
            });
            $($reviewsTableArea).on('keydown', '.keyword', function($e) {
                if ($e.which === 13) {
                    $e.preventDefault();
                    getReviews(1);
                }
            });
            $($reviewsTableArea).on('click', '.search-btn', function($e) {
                getReviews(1);
            });
            $($reviewsTableArea).on('click', '.search-clear-btn', function($e) {
                $($reviewsTableArea).find('.keyword').val('');
                getReviews(1);
            });

            $('.table').on('click', '.view-review', function (){
                $id = $(this).data('id');
                $rowId = '#review-row-' + $id;

                $('#review-loading-img').show();

                $('#review-content-area').hide();
                $('#review-name').html('');
                $('#review-email').html('');
                $('#review-message').html('');
                $('#review-id').val(0);

                $('#staticBackdrop').modal('show');


                $.ajax({
                    url: "{{--{{ route('backend.userReviews.view') }}--}}",
                    dataType: 'json',
                    data: {
                        "id": $id,
                        "_token": csrf_token()
                    },
                    method: 'POST',
                    beforeSend: function ($jqXHR, $obj) {

                    },
                    success: function ($res, $textStatus, $jqXHR) {
                        $('#review-loading-img').hide();

                        $('#review-content-area').show();
                        $('#review-name').html($res.review.name);
                        $('#review-email').html($res.review.email);
                        $('#review-message').html($res.review.message);
                        $('#review-id').val($res.review.id);
                    },
                    error: function ($jqXHR, $textStatus, $errorThrown) {

                    }
                });
            });
            /*END - REVIEWS RELATED SCRIPTS*/


        });
    </script>
@endsection
