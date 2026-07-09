@extends('layouts.backend')

@section('page_title')
    Sport Categories
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/backend/libs/croppie/croppie.min.css') }}">
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
                    <h4 class="card-title mb-0 flex-grow-1">All Sport Categories</h4>
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
                                                <p class="mb-0">Sport Category</p>
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
                                                    <p class="mb-0">{{ $category->sport_category }}</p>
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
                    <h4 class="card-title mb-0 flex-grow-1"><span class="me-1">Create New</span><span>Sport Category</span></h4>
                    <div class="flex-shrink-0">
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div>
                                <label for="category-input" class="form-label">Slug *</label>
                                <input type="text" class="form-control" id="slug-input" placeholder="Enter here...." readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2">
                            <div>
                                <label for="category-input" class="form-label">Sport Category Name *</label>
                                <input type="text" class="form-control" id="category-input" placeholder="Enter here....">
                            </div>
                        </div>
                        <div class="col-sm-4 mb-4">
                            <div>
                                <label for="order-input" class="form-label">Display Order</label>
                                <input type="text" class="form-control" id="order-input" placeholder="Enter here...." value="0">
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="file">
                                            <input type="file" accept="image/*" class="file-styled-primary" id="thumb_image" >
                                        </label>
                                    </div>
                                    <div class="row" style="">
                                        <div class="col-12" id="uploaded_thumb">
                                            <div id="thumb_image_demo" style=""></div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="text-success" id="image-status"></p>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span class="btn btn-info btn-sm thumb_crop">Apply</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-4" id="uploaded_image" style="display: none;">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex align-items-center justify-content-center img-action img-border">
                                        <img id="img" class="img-fluid img-bordered" src="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="image-input" value="">
                        </div>



                        <div class="col-sm-12" id="form-alert-area">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <input type="hidden" id="edit-id" value="0">
                            <a href="{{ url('/admin/sport-categories') }}" class="btn btn-outline-dark waves-effect waves-light me-2"><i class="mdi mdi-restore me-1"></i>Reset</a>
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
    <!-- croppie -->
    <script src="{{ asset('assets/backend/libs/croppie/croppie.min.js') }}"></script>
@endsection

@section('custom_scripts')
    <script>

        function appendImage($img){

            $image = "{{ url('assets/common/images/uploads') }}/" + $img.filename;

            $item = $('<div></div>').addClass('col-md-12 mb-3').attr('id', $img.id);

            if($img.is_primary == 1){
            }
            else{
                $('<div></div>').addClass('d-flex align-items-center justify-content-center img-action img-border')
                    .append($('<img>').addClass('img-fluid img-bordered').attr('src', $image)).appendTo($item);
            }

            return $item;
        }

        $(document).ready(function (){


            $('.save-this-form').on('click', function (){
                $this = $(this);
                $($this).prop('disabled', true);

                $url = "{{ route('backend.sportCategories.store') }}";

                $id = $('#edit-id').val();
                $slug = $('#slug-input').val();
                $category = $('#category-input').val();
                $displayOrder = $('#order-input').val();
                $image = $('#image-input').val();

                if($category != '' && $image != ''){
                    $.ajax({
                        url: $url,
                        dataType: 'json',
                        data: {
                            "id": $id,
                            "slug": $slug,
                            "sport_category": $category,
                            "image": $image,
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
                            $('#image-input').val('');
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
                    $alert = alertDanger('Category & Image can not be empty!', 'Error');
                    $('#form-alert-area').html($alert);
                    $($this).prop('disabled', false);
                }

            });

            $('#category-input').on('blur', function ($e){

                $this = $(this);
                $title = $($this).val();

                $id = $('#temp_id').val();

                $url = "{{ route('backend.sportCategories.slugGenerator') }}";

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
                $url = "{{ route('backend.sportCategories.get') }}";
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
                        $('#image-input').val('');
                        $('#uploaded_image').hide();


                    },
                    success: function ($res, $textStatus, $jqXHR) {
                        $('#edit-id').val($res.id);
                        $('#category-input').val($res.sport_category);
                        $('#order-input').val($res.display_order);
                        $('#slug-input').val($res.slug);
                        $('#image-input').val($res.image);
                        $('#form-alert-area').html('');
                        $('.save-this-form').prop('disabled', false);

                        $('#uploaded_image').show();
                        $('#img').attr('src', "{{ url('assets/common/images/uploads') }}/" + $res.image);

                    },
                    error: function ($jqXHR, $textStatus, $errorThrown) {

                    }
                });
            });

            $('.table').on('change', '.status', function (){
                $id = $(this).data('id');
                $url = "{{ route('backend.sportCategories.status') }}";
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


            $image_thumb = $('#thumb_image_demo').croppie({
                enableExif: true,
                viewport: {
                    width:196,
                    height:280,
                    type:'square' //circle
                },
                boundary:{
                    width:300,
                    height:300
                }
            });

            $('#thumb_image').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_thumb.croppie('bind', {
                        url: event.target.result
                    });
                };
                reader.readAsDataURL(this.files[0]);
                $('#uploaded_thumb').show();
            });

            $('.thumb_crop').click(function(event){

                $image_thumb.croppie('result', {
                    type: 'canvas',
                    /*size: 'original'*/
                    size: {
                        width: 500,
                        height: 714
                    }
                }).then(function(response){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('backend.sportCategories.imageUpload') }}",
                        type: "POST",
                        data: {
                            image:response,
                        },
                        beforeSend: function ($jqXHR, $obj) {
                            $('#image-status').html('Uploading....');
                        },
                        success: function ($data) {
                            $('#uploaded_image').show();
                            $('#image-status').html($data.status);
                            $img = appendImage($data);
                            $('#image-input').val($data.filename);
                            $('#uploaded_image').html($img);
                        }
                    });

                })
            });
        });
    </script>


@endsection
