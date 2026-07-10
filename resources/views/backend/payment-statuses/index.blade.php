@extends('layouts.backend')

@php
    $pageTitle = 'Payment Statuses';
    $singlePageTitle = 'Payment Status';
    $routePrefix = 'paymentStatuses';
    $pageUrl = 'payment-statuses';
@endphp

@section('page_title')
    {{ $pageTitle }}
@endsection

@section('styles')

@endsection

@section('css')

@endsection

@section('header_buttons')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">
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
                                            {{--<th class="text-center" scope="col">
                                                <p class="mb-0">ID</p>
                                            </th>--}}
                                            <th scope="col">
                                                <p class="mb-0">{{ $singlePageTitle }}</p>
                                            </th>
                                            <th class="text-center" scope="col">
                                                <p class="mb-0">Status</p>
                                            </th>
                                            <th class="text-end" scope="col">
                                                <p class="mb-0">Actions</p>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $row)
                                            <tr id="row-{{ $row->id }}">
                                                {{--<td class="fw-medium text-center">
                                                    <p class="mb-0">{{ $row->id }}</p>
                                                </td>--}}
                                                <td>
                                                    <p class="mb-0">{{ $row->payment_status }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="mb-0"><span class="badge {{ commonStatus($row->status)['class'] }}">{{ commonStatus($row->status)['text'] }}</span></p>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <div class="form-check form-switch form-switch-success form-switch-md">
                                                            <input class="form-check-input status" data-id="{{ $row->id }}" type="checkbox" role="switch"  {{ ($row->status == 1) ? 'checked': '' }} >
                                                        </div>
                                                        <div>
                                                            <a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-primary btn-sm waves-effect waves-light edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="mdi mdi-pencil"></span></a>
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


        <div class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><span class="me-1">Create New</span><span>{{ $singlePageTitle }}</span></h4>
                    <div class="flex-shrink-0">
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div>
                                <label for="name-input" class="form-label">{{ $singlePageTitle }}*</label>
                                <input type="text" class="form-control" id="name-input" placeholder="Enter here....">
                            </div>
                        </div>
                        <div class="col-sm-12" id="form-alert-area">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <input type="hidden" id="edit-id" value="0">
                            <a href="{{ url('/admin/' . $pageUrl) }}" class="btn btn-outline-dark waves-effect waves-light me-2"><i class="mdi mdi-restore me-1"></i>Reset</a>
                            <button type="button" class="btn btn-secondary waves-effect waves-light save-this-form"><i class="mdi mdi-content-save me-1"></i>SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('assets/backend/packages/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection

@section('custom_scripts')
    <script>
        $(document).ready(function (){
            $('.save-this-form').on('click', function (){
                $this = $(this);
                $($this).prop('disabled', true);

                $id = $('#edit-id').val();
                $name = $('#name-input').val();

                if($name != ''){
                    $.ajax({
                        url: "{{ route('backend.'.$routePrefix.'.store') }}",
                        dataType: 'json',
                        data: {
                            id: $id,
                            payment_status: $name,
                            _token: csrf_token()
                        },
                        method: 'POST',
                        beforeSend: function ($jqXHR, $obj) {
                            $('#form-alert-area').html('');
                            $('#form-alert-area').html(alertProcessing());
                        },
                        success: function ($res, $textStatus, $jqXHR) {
                            $('#edit-id').val(0);
                            $('#name-input').val('');
                            $('#form-alert-area').html('');
                            $alert = alertSuccess($res.message_text, $res.message_title);
                            $('#form-alert-area').html($alert);
                            $($this).prop('disabled', false);

                            setTimeout(function (){
                                location.reload();
                            }, 1000);
                        },
                        error: function ($res, $textStatus, $errorThrown) {
                            $('#form-alert-area').html('');
                            if(Object.keys($res.responseJSON).length > 0 && Object.keys($res.responseJSON.errors).length > 0){
                                alertDangerMultiple($res.responseJSON.errors, '#form-alert-area');
                            }
                            $($this).prop('disabled', false);
                        }
                    });
                }else{
                    $('#form-alert-area').html('');
                    $alert = alertDanger('Payment Status can not be empty!', 'Error');
                    $('#form-alert-area').html($alert);
                    $($this).prop('disabled', false);
                }

            });


            $('.table').on('click', '.edit', function (){
                $id = $(this).data('id');
                $url = "{{ route('backend.'.$routePrefix.'.get') }}";
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

                        $('.save-this-form').prop('disabled', true);

                        $('#edit-id').val(0);
                        $('#name-input').val('');
                    },
                    success: function ($res, $textStatus, $jqXHR) {
                        $('#edit-id').val($res.id);
                        $('#name-input').val($res.payment_status);
                        $('#form-alert-area').html('');
                        $('.save-this-form').prop('disabled', false);

                    },
                    error: function ($jqXHR, $textStatus, $errorThrown) {

                    }
                });
            });

            $('.table').on('change', '.status', function (){
                $id = $(this).data('id');
                $url = "{{ route('backend.'.$routePrefix.'.status') }}";
                $rowId = '#row-' + $id;
                $.ajax({
                    url: $url,
                    dataType: 'json',
                    data: {
                        id: $id,
                        _token: csrf_token()
                    },
                    method: 'POST',
                    beforeSend: function ($jqXHR, $obj) {

                    },
                    success: function ($res, $textStatus, $jqXHR) {
                        $($rowId).find('.badge').removeClass('bg-success bg-warning').addClass($res.class);
                        $($rowId).find('.badge').html($res.text);
                    },
                    error: function ($jqXHR, $textStatus, $errorThrown) {

                    }
                });
            });
        });
    </script>


@endsection
