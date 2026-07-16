@extends('layouts.backend')

@php
    $pageTitle = 'Event';
    $singlePageTitle = 'Event';
    $routePrefix = 'events';
    $pageUrl = 'events';
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
            <div class="col-sm-12 mb-3">
                <div class="d-sm-flex justify-content-end">
                    @if(empty($event->is_completed))
                        <a href="javascript:void(0);" class="btn btn-success me-3 mb-2 mark-as-completed">
                            <span class="mdi mdi-check me-2"></span>
                            Completed
                        </a>
                    @endif

                    <a class="btn btn-info me-3 mb-2 add-attendance-btn" data-bs-toggle="modal" data-bs-target="#editFormModal">
                    <span class="d-flex align-items-center">
                        <span class="flex-grow-1">
                            Add Attendance
                        </span>
                    </span>
                    </a>

                    <a href="{{ route('backend.events.edit', $event->id) }}" class="btn btn-primary mb-2 me-3">
                        <span class="mdi mdi-pencil me-2"></span>
                        Edit
                    </a>
                    <a href="{{ route('backend.events.index') }}" class="btn btn-primary me-3 mb-2">
                        <span class="mdi mdi-plus-box me-2"></span>
                        All Events
                    </a>
                </div>

            </div>
        </div>
    @endsection

    @section('content')

        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="card">
                    <div class="card-header align-items-center justify-content-between d-flex">
                        <div>
                            <h4 class="card-title mb-0 flex-grow-1">Event Details</h4>
                        </div>
                        <div>
                            @if(!empty($event->is_completed))
                                <span class="badge bg-success">Completed</span>
                            @endif

                        </div>

                    </div><!-- end card header -->

                    <div class="card-body p-4">
                        <h5 class="card-title text-dark mb-1">{{ $event->event }}</h5>
                        <p class="text-muted mb-2 fs-12">{{ $event->venue }}</p>

                        <div class="row mt-3 py-2 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-1">Start Time</label>
                                <p class="fw-medium mb-0">{{ dateTimeFullFormat($event->start_time) }}</p>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-1">End Time</label>
                                <p class="fw-medium mb-0">{{ dateTimeFullFormat($event->end_time) }}</p>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-1">Description</label>
                                <p class="fw-medium mb-0">{{ $event->description }}</p>
                            </div>
                        </div>


                    </div>
                </div><!-- end card -->
            </div>
            <div class="col-lg-9 col-12">
                <div class="tab-content text-muted mb-5">
                    <div class="tab-pane active" id="tab-attendances" role="tabpanel">
                        <div class="card" id="attendances-table-area">
                            <div class="card-body">
                                <div class="card-header align-items-center justify-content-between d-md-flex">
                                    <div class="">
                                        <h4 class="card-title flex-grow-1 mb-2">Attendances</h4>
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
                                                <th class="" scope="col">
                                                    <div>
                                                        <p class="mb-0">Player</p>
                                                        <p class="mb-0 text-muted">Registration Number</p>
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


        <div class="modal fade" id="editFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content" id="save-form-area">
                    <div class="modal-header">
                        <h5 class="modal-title"><span class="me-1" id="save-form-title">Add Attendance</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-9 mb-3">
                                    <div>
                                        <label for="name-input" class="form-label">Search</label>
                                        <input type="text" class="form-control" id="name-input" placeholder="Enter here....">
                                    </div>
                                </div>
                                <div class="col-3 mb-3 d-flex justify-content-end align-items-end">
                                    <button type="button" class="btn btn-info w-100 search-players"><i class="mdi mdi-magnify"></i></button>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-nowrap align-middle mb-0">
                                            <thead>
                                            <tr>
                                                <th class="" scope="col">
                                                    <div>
                                                        <p class="mb-0">Player</p>
                                                        <p class="mb-0 text-muted">Registration Number</p>
                                                    </div>
                                                </th>
                                                <th class="text-end" scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-body" id="players-listing-area">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12" id="form-alert-area">

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <input type="hidden" id="edit-id" value="0">
                        <a href="javascript:void(0);" class="btn btn-outline-dark waves-effect waves-light close-this-form me-2" data-bs-dismiss="modal"><i class="mdi mdi-restore me-1"></i>Close</a>
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

        var $eventId = "{{ $event->id }}";
        var $currentTab = 'subscriptions';

        var $attendancesTableArea = $('#attendances-table-area');


        function getAttendances($pageNo = 1){
            $keyword = $($attendancesTableArea).find('.keyword').val().trim();

            $.ajax({
                url: "{{ route('backend.events.getAttendancesViaAjax') }}",
                type: 'POST',
                data: {
                    event_id: $eventId,
                    keyword: $keyword,
                    page: $pageNo,
                    _token: csrf_token()
                },
                dataType: 'json',
                beforeSend: function ($jqXHR, $obj) {

                    $($attendancesTableArea).find('.search-btn').prop('disabled', true);
                    $($attendancesTableArea).find('.search-btn-loading').removeClass('d-none');
                    $($attendancesTableArea).find('.search-btn-text').text('Loading....');
                    $($attendancesTableArea).find('.pagination-area').html('');
                    $($attendancesTableArea).find('.table-body').html('');
                    $($attendancesTableArea).find('.table-body').html(ajaxLoader(6));
                    $($attendancesTableArea).find('.records-showing-first-count').text(0);
                    $($attendancesTableArea).find('.records-showing-last-count').text(0);
                    $($attendancesTableArea).find('.records-total-count').text(0);

                },
                success: function ($res, $textStatus, $jqXHR) {
                    $($attendancesTableArea).find('.table-body').html('');

                    $($attendancesTableArea).find('.search-btn').prop('disabled', false);
                    $($attendancesTableArea).find('.search-btn-loading').addClass('d-none');
                    $($attendancesTableArea).find('.search-btn-text').text('Search');
                    $($attendancesTableArea).find('.pagination-area').html($res.pagination);
                    $($attendancesTableArea).find('.table-body').html($res.body);
                    $($attendancesTableArea).find('.records-showing-first-count').text($res.showing_first_item);
                    $($attendancesTableArea).find('.records-showing-last-count').text($res.showing_last_item);
                    $($attendancesTableArea).find('.records-total-count').text($res.total_count);

                },
                error: function ($jqXHR, $textStatus, $errorThrown) {
                }
            });
        }

        function player($item){

            $tr = $('<tr></tr>').attr('id', 'player-row-' + $item.id);

            $('<td></td>').append($('<div></div>')
                .append($('<p></p>').addClass('mb-0 fw-medium').text($item.first_name + ' ' +$item.last_name))
                .append($('<p></p>').addClass('mb-0 text-muted').text($item.reg_no))
            ).appendTo($tr);

            $('<td></td>').addClass('text-end').append($('<div></div>').addClass('d-flex justify-content-end align-items-center')
                .append($('<div></div>')
                    .append($('<a></a>').addClass('btn btn-primary btn-sm waves-effect waves-light add-attendance').attr('href', 'javascript:void(0);').attr('data-id', $item.id).text('Add'))
                )
            ).appendTo($tr);

            return $tr;

        }

        $(document).ready(function (){

            getAttendances();


            /*START - ATTENDANCES RELATED SCRIPTS*/
            $($attendancesTableArea).on('click', '.pagination a', function($e) {
                $e.preventDefault();
                var $url = $(this).attr('href');
                var $startIndex = $url.indexOf('page');
                if ($startIndex !== -1) {
                    $startOfValueIndex = $startIndex + 5;
                    $pageNo = $url.substring($startOfValueIndex).trim();
                    getAttendances($pageNo);
                }
            });
            $($attendancesTableArea).on('keydown', '.keyword', function($e) {
                if ($e.which === 13) {
                    $e.preventDefault();
                    getAttendances(1);
                }
            });
            $($attendancesTableArea).on('click', '.search-btn', function($e) {
                getAttendances(1);
            });
            $($attendancesTableArea).on('click', '.search-clear-btn', function($e) {
                $($attendancesTableArea).find('.keyword').val('');
                getAttendances(1);
            });
            /*END - ATTENDANCES RELATED SCRIPTS*/


            $('.close-this-form').on('click', function (){
                $('#name-input').val('');
                $('#players-listing-area').html('');
            });


            $('.search-players').on('click', function ($e){
                $e.preventDefault();
                $this = $(this);
                $($this).prop('disabled', true);
                $('#players-listing-area').html('');

                $keyword = $('#name-input').val().trim();

                if($keyword != ''){
                    $.ajax({
                        url: "{{ route('backend.'.$routePrefix.'.getPlayers') }}",
                        dataType: 'json',
                        data: {
                            keyword: $keyword,
                            _token: csrf_token()
                        },
                        method: 'POST',
                        beforeSend: function ($jqXHR, $obj) {
                            $($this).html('Loading...');
                            $('#players-listing-area').html(ajaxLoader(6));
                        },
                        success: function ($res, $textStatus, $jqXHR) {
                            $($this).html('Search');
                            $($this).prop('disabled', false);
                            $('#players-listing-area').html('');

                            if(Object.keys($res).length > 0){
                                $.each($res, function ($index, $item){
                                    $r = player($item);
                                    $('#players-listing-area').append($r);
                                });
                            }
                        },
                        error: function ($res, $textStatus, $errorThrown) {
                        }
                    });
                }else{
                    Swal.fire('Error!', 'Search field can not be empty!', 'error');
                    $($this).prop('disabled', false);
                }
            });


            $('#players-listing-area').on('click', '.add-attendance', function ($e){
                $e.preventDefault();
                $playerId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to add this player as attended!",
                    icon: "warning",
                    showCancelButton: !0,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Add!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-info w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-danger w-xs mt-2",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then((result) => {
                    if (result.isConfirmed) {

                        setTimeout(function() {
                            $.ajax({
                                url: "{{ route('backend.events.setAttendance') }}",
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
                                        getAttendances(1);
                                        Swal.fire('Done!', $response.message, 'success');
                                    }else{
                                        Swal.fire('Error!', $response.message, 'error');
                                    }
                                },
                                error: function ($jqXHR, $textStatus, $errorThrown) {
                                    Swal.fire('Oops...', 'Something went wrong with the System!', 'error');
                                }
                            });

                        }, 50);
                    }
                });

            });


            $('.mark-as-completed').on('click', function ($e){
                $e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to mark this event as completed!",
                    icon: "warning",
                    showCancelButton: !0,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Completed!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-info w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-danger w-xs mt-2",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then((result) => {
                    if (result.isConfirmed) {

                        setTimeout(function() {
                            $.ajax({
                                url: "{{ route('backend.events.setAsCompleted') }}",
                                type: 'POST',
                                data: {
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
                                    Swal.fire('Done!', 'Event is completed!', 'success');
                                    setTimeout(function (){
                                       location.reload();
                                    }, 2000);
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
@endsection
