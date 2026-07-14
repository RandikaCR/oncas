@extends('layouts.backend')

@php
    $pageTitle = 'Player Join Requests';
    $singlePageTitle = 'Player Join Request';
    $routePrefix = 'playerJoinRequests';
    $pageUrl = 'join-requests';
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
                    Add New
                </a>
            </div>
        </div>
    @endsection

    @section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('backend.'.$routePrefix .'.index') }}">
                                    <div class="row">
                                        <div class="col-sm-7 mb-3">
                                            <label for="keyword" class="form-label">Search</label>
                                            <input class="form-control" id="keyword" name="keyword" type="text" placeholder="Enter here..." value="{{ $keyword }}">
                                        </div>
                                        <div class="col-sm-5 mb-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">
                                                <span class="mdi mdi-magnify me-2"></span>
                                                Search
                                            </button>
                                            <a href="{{ url('admin/' . $pageUrl) }}" class="btn btn-outline-dark waves-effect waves-light ms-2">
                                                <span class="mdi mdi-restore me-2"></span>
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">All {{ $pageTitle }}</h4>
                        <div class="flex-shrink-0">
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row">
                                <div class="col-xl-612">
                                    <div class="table-responsive mt-4 mt-xl-0">
                                        <table class="table table-hover table-striped align-middle table-nowrap mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">
                                                    <p class="mb-0">Name</p>
                                                    <p class="mb-0 text-muted">School</p>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <p class="mb-0">Date of Birth</p>
                                                    <p class="mb-0 text-muted">Age</p>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <p class="mb-0">Contact</p>
                                                    <p class="mb-0 text-muted">Emergency Contact</p>
                                                </th>
                                                <th class="text-center" scope="col">
                                                    <p class="mb-0">Address</p>
                                                </th>
                                                <th class="text-end" scope="col">
                                                    <p class="mb-0">Actions</p>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($records as $row)
                                                <tr class="@if(empty($row->is_view)) fw-bolder @endif" id="row-{{ $row->id }}">
                                                    <td>
                                                        <p class="mb-0 fw-medium">{{ $row->name }}</p>
                                                        <p class="mb-0 text-muted">{{ $row->school_name }}</p>

                                                    </td>
                                                    <td class="text-center">
                                                        <p class="mb-0">{{ $row->date_of_birth }}</p>
                                                        <p class="mb-0 text-muted">{{ $row->age }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="mb-0">{{ $row->contact }}</p>
                                                        <p class="mb-0 text-muted">{{ $row->emergency_contact }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="mb-0">{{ $row->address }}</p>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center">
                                                            <div>
                                                                <a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-primary btn-sm waves-effect waves-light view" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><span class="mdi mdi-magnify"></span></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                            <div class="mt-5">
                                {{--Paginaiton--}}
                                {!! $records->links('vendor.pagination.backend') !!}
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>

        <div class="modal fade" id="editFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content" id="save-form-area">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $singlePageTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">Name</label>
                                        <p class="request-name fw-medium"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">School Name</label>
                                        <p class="request-school fw-medium"></p>
                                    </div>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">Date of Birth</label>
                                        <p class="request-dob fw-medium"></p>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">Age</label>
                                        <p class="request-age fw-medium"></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">Contact</label>
                                        <p class="request-contact fw-medium"></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">Emergency Contact</label>
                                        <p class="request-emergency-contact fw-medium"></p>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-2">
                                    <div>
                                        <label for="business-input" class="form-label text-muted">Address</label>
                                        <p class="request-address fw-medium"></p>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="form-alert-area">

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-end">
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

        function setJoinRequestCountOnNavBar($count){
            if(getDecimalValue($count) > 0){
                $('.nav-join-request-count').html($count);
            }else{
                $('.nav-join-request-count').hide();
            }
        }

        $(document).ready(function (){
            $('.close-this-form').on('click', function (){
                $('.request-name').html('');
                $('.request-school').html('');
                $('.request-dob').html('');
                $('.request-age').html('');
                $('.request-contact').html('');
                $('.request-emergency-contact').html('');
                $('.request-address').html('');
            });


            $('.table').on('click', '.view', function (){
                $id = $(this).data('id');
                $url = "{{ route('backend.'.$routePrefix.'.get') }}";

                $('#editFormModal').modal('show');

                $.ajax({
                    url: $url,
                    dataType: 'json',
                    data: {
                        id: $id,
                        _token: csrf_token()
                    },
                    method: 'POST',
                    beforeSend: function ($jqXHR, $obj) {
                        $('#form-alert-area').html('');
                        $('#form-alert-area').html(alertProcessing('Please Wait...', 'Getting Info'));
                    },
                    success: function ($res, $textStatus, $jqXHR) {
                        $('.request-name').html($res.data.name);
                        $('.request-school').html($res.data.school_name);
                        $('.request-dob').html($res.data.date_of_birth);
                        $('.request-age').html($res.data.age);
                        $('.request-contact').html($res.data.contact);
                        $('.request-emergency-contact').html($res.data.emergency_contact);
                        $('.request-address').html($res.data.address);
                        $('#form-alert-area').html('');

                        setJoinRequestCountOnNavBar($res.count);

                        $('.table').find('#row-' + $id).removeClass('fw-bolder');
                    },
                    error: function ($jqXHR, $textStatus, $errorThrown) {

                    }
                });
            });
        });
    </script>


@endsection
