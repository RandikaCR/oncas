@extends('layouts.backend')

@section('page_title')
    News Categories
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
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">All News Categories</h4>
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
                                            <th class="text-center" scope="col">
                                                <p class="mb-0">ID</p>
                                            </th>
                                            <th scope="col" style="width: 50%;">
                                                <p class="mb-0">News Category</p>
                                            </th>
                                            <th class="text-center" scope="col">
                                                <p class="mb-0">Display Order</p>
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
                                        @foreach($categories as $category)
                                            <tr id="row-{{ $category->id }}">
                                                <td class="fw-medium text-center">
                                                    <p class="mb-0">{{ $category->id }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0">{{ $category->news_category }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="mb-0">{{ $category->display_order }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="mb-0"><span class="badge {{ $category->categoryStatus()->class }}">{{ $category->categoryStatus()->text }}</span></p>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <div class="form-check form-switch form-switch-success form-switch-md">
                                                            <input class="form-check-input status" data-id="{{ $category->id }}" type="checkbox" role="switch"  {{ ($category->status == 1) ? 'checked': '' }} >
                                                        </div>
                                                        <div>
                                                            <a href="javascript:void(0);" data-id="{{ $category->id }}" class="btn btn-primary btn-sm waves-effect waves-light edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="mdi mdi-pencil"></span></a>
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
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><span class="me-1">Create New</span><span>News Category</span></h4>
                    <div class="flex-shrink-0">
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div>
                                <label for="category-input" class="form-label">News Category Name*</label>
                                <input type="text" class="form-control" id="category-input" placeholder="Enter here....">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div>
                                <label for="order-input" class="form-label">Display Order</label>
                                <input type="text" class="form-control" id="order-input" placeholder="Enter here...." value="0">
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="slug-input" placeholder="Enter here...." value="">
                        <div class="col-sm-12" id="form-alert-area">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <input type="hidden" id="edit-id" value="0">
                            <a href="{{ url('/admin/news-categories') }}" class="btn btn-outline-dark waves-effect waves-light me-2"><i class="mdi mdi-restore me-1"></i>Reset</a>
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

                $url = "{{ route('backend.newsCategories.store') }}";

                $id = $('#edit-id').val();
                $slug = $('#slug-input').val();
                $category = $('#category-input').val();
                $displayOrder = $('#order-input').val();

                if($category != ''){
                    $.ajax({
                        url: $url,
                        dataType: 'json',
                        data: {
                            "id": $id,
                            "slug": $slug,
                            "news_category": $category,
                            "display_order": $displayOrder,
                            "_token": csrf_token()
                        },
                        method: 'POST',
                        beforeSend: function ($jqXHR, $obj) {
                            $('#form-alert-area').html('');
                            $('#form-alert-area').html(alertProcessing());
                        },
                        success: function ($res, $textStatus, $jqXHR) {
                            $('#edit-id').val(0);
                            $('#category-input').val('');
                            $('#order-input').val(0);
                            $('#slug-input').val('');
                            $('#form-alert-area').html('');
                            $alert = alertSuccess($res.message_text, $res.message_title);
                            $('#form-alert-area').html($alert);
                            $($this).prop('disabled', false);

                            setTimeout(function (){
                                location.reload();
                            }, 1000);
                        },
                        error: function ($jqXHR, $textStatus, $errorThrown) {

                        }
                    });
                }else{
                    $('#form-alert-area').html('');
                    $alert = alertDanger('Category can not be empty!', 'Error');
                    $('#form-alert-area').html($alert);
                    $($this).prop('disabled', false);
                }

            });

            $('#category-input').on('blur', function ($e){

                $this = $(this);
                $title = $($this).val();

                $id = $('#temp_id').val();

                $url = "{{ route('backend.newsCategories.slugGenerator') }}";

                $isSending = false;
                setTimeout(function (){
                    if(!$isSending){
                        $.ajax({
                            url: $url,
                            dataType: 'json',
                            data: {
                                id: $id,
                                title: $title,
                                _token: csrf_token()
                            },
                            method: 'POST',
                            beforeSend: function ($jqXHR, $obj) {
                                $isSending = true;
                                $('#slug-warning').addClass('d-none');
                            },
                            success: function ($res, $textStatus, $jqXHR) {
                                $isSending = false;
                                $('#slug-input').val($res.slug);
                                if($res.is_exist == 1){
                                    $('#slug-warning').removeClass('d-none');
                                }

                            },
                            error: function ($jqXHR, $textStatus, $errorThrown) {

                            }
                        });
                    }
                }, 400);

            });

            $('.table').on('click', '.edit', function (){
                $id = $(this).data('id');
                $url = "{{ route('backend.newsCategories.get') }}";
                $.ajax({
                    url: $url,
                    dataType: 'json',
                    data: {
                        "id": $id,
                        "_token": csrf_token()
                    },
                    method: 'POST',
                    beforeSend: function ($jqXHR, $obj) {
                        $('#form-alert-area').html('');
                        $('#form-alert-area').html(alertProcessing('Please Wait...', 'Getting Info'));

                        $('.save-this-form').prop('disabled', true);

                        $('#edit-id').val(0);
                        $('#category-input').val('');
                        $('#order-input').val(0);
                        $('#slug-input').val('');
                    },
                    success: function ($res, $textStatus, $jqXHR) {
                        $('#edit-id').val($res.id);
                        $('#category-input').val($res.news_category);
                        $('#order-input').val($res.display_order);
                        $('#slug-input').val($res.slug);
                        $('#form-alert-area').html('');
                        $('.save-this-form').prop('disabled', false);

                    },
                    error: function ($jqXHR, $textStatus, $errorThrown) {

                    }
                });
            });

            $('.table').on('change', '.status', function (){
                $id = $(this).data('id');
                $url = "{{ route('backend.newsCategories.status') }}";
                $rowId = '#row-' + $id;
                $.ajax({
                    url: $url,
                    dataType: 'json',
                    data: {
                        "id": $id,
                        "_token": csrf_token()
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
