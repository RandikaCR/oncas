@extends('layouts.backend')

@section('page_title')
    Event

    @if(isset($event))
        #{{ $event->id }}
    @endif
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/backend/libs/croppie/croppie.min.css') }}">

@endsection

@section('css')

    <style type="text/css">

        .img-overlay-area{
            position: absolute;
            background: rgba(0,0,0,0.2);
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            -webkit-transition: all .5s ease-in-out;
            -o-transition: all .5s ease-in-out;
            -moz-transition: all .5s ease-in-out;
            transition: all .5s ease-in-out;
        }

        .img-action:hover .img-overlay-area{
            opacity: 1;
            -webkit-transition: all .5s ease-in-out;
            -o-transition: all .5s ease-in-out;
            -moz-transition: all .5s ease-in-out;
            transition: all .5s ease-in-out;
            cursor: pointer;
        }

        .img-border{
            border: 1px solid #eee;
        }

    </style>

@endsection

@section('header_buttons')
    <div class="row">
        <div class="col-sm-12 d-flex justify-content-end mb-3">
            <a href="{{ url('admin/events') }}" class="btn btn-primary">
                <span class="mdi mdi-format-list-bulleted-square me-2"></span>
                All Events
            </a>
        </div>
    </div>
@endsection

@section('content')

    <form method="POST" action="{{ route('backend.events.store') }}">
        @csrf
        <input type="hidden" name="id" value="{{ isset($event) ? $event->id : '' }}">
        <input type="hidden" id="temp_id" name="temp_id" value="{{ $temp_id }}">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Event Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <label>Slug</label>
                                <input class="form-control" type="text" id="slug" name="slug" placeholder="Enter here...." value="{{ isset($event) ? $event->slug : '' }}" readonly>
                                <label class="text-danger fw-bold mt-1 d-none" id="slug-warning">Slug already exists!</label>
                            </div>

                            <div class="col-sm-12 mb-4">
                                <label>Title (ENGLISH) *</label>
                                <input class="form-control" type="text" id="main-title" name="en_title" placeholder="Enter here...." value="{{ isset($event) ? $event->en_title : '' }}">
                            </div>

                            <div class="col-sm-12 mb-4">
                                <label>Content (ENGLISH)</label>
                                <textarea id="content-en" name="en_content">
                                    {{ isset($event) ? $event->en_content : '' }}
                                </textarea>
                            </div>

                            <hr class="my-4">

                            <div class="col-sm-12 mb-4">
                                <label>Title (SINHALA)</label>
                                <input class="form-control" type="text" id="title-si" name="si_title" placeholder="Enter here...." value="{{ isset($event) ? $event->si_title : '' }}">
                            </div>

                            <div class="col-sm-12 mb-4">
                                <label>Content (SINHALA)</label>
                                <textarea id="content-si" name="si_content">
                                    {{ isset($event) ? $event->si_content : '' }}
                                </textarea>
                            </div>

                            <hr class="my-4">

                            <div class="col-sm-12 mb-4">
                                <label>Title (TAMIL)</label>
                                <input class="form-control" type="text" id="title-ta" name="ta_title" placeholder="Enter here...." value="{{ isset($event) ? $event->ta_title : '' }}">
                            </div>

                            <div class="col-sm-12 mb-4">
                                <label>Content (TAMIL)</label>
                                <textarea id="content-ta" name="ta_content">
                                    {{ isset($event) ? $event->ta_content : '' }}
                                </textarea>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end align-items-center">
                            <div>
                                <button type="submit" class="btn btn-secondary waves-effect waves-light save-this-form"><i class="mdi mdi-content-save me-1"></i>SAVE</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-sm-12">
                                <label>Category</label>
                                <select class="form-control" name="event_category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (!empty($event) && $event->event_category_id == $category->id) ? 'selected' : '' }}>{{ $category->event_category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <label>Images</label>
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
                                    <div class="col-sm-12 d-flex mt-5">
                                        <div class="row" id="uploaded_image">
                                            @if(!empty($images))
                                                @foreach($images as $img )
                                                    <div class="col-md-6 mb-3" id="row-{{ $img->id }}">
                                                        <div class="d-flex align-items-center justify-content-center img-action img-border">
                                                            <img class="img-fluid img-bordered" src="{{ url('assets/common/images/uploads/events/'.$img->image) }}">
                                                            @if( $img->is_primary == 1 )
                                                                <span class="badge bg-success" style="position: absolute;top: 10px;right: 10px;"><i class="mdi mdi-key"></i></span>
                                                            @else
                                                                <div class="img-overlay-area d-flex justify-content-center align-items-center">
                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs me-2 delete-image" data-id="{{ $img->id }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete"></i></a>
                                                                    <a href="javascript:void(0);" class="btn btn-success btn-xs primary-image" data-id="{{ $img->id }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Make this Primary Image?"><i class="mdi mdi-key"></i></a>
                                                                </div>
                                                            @endif


                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <input type="hidden" id="route_get_slug" value="{{ route('backend.events.slugGenerator') }}">

@endsection


@section('scripts')

    <!--jquery cdn-->
    <script src="{{ asset('assets/backend/packages/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!-- ckeditor -->
    <script src="{{ asset('assets/backend/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- croppie -->
    <script src="{{ asset('assets/backend/libs/croppie/croppie.min.js') }}"></script>


@endsection

@section('custom_scripts')
    <script>

        function appendImage($img){

            $image = "{{ url('assets/common/images/uploads/events') }}/" + $img.filename;

            $item = $('<div></div>').addClass('col-md-6 mb-3').attr('id', $img.id);

            if($img.is_primary == 1){
                $('<div></div>').addClass('d-flex align-items-center justify-content-center img-action')
                    .append($('<img>').addClass('img-fluid img-bordered').attr('src', $image))
                    .append($('<span></span>').addClass('badge bg-success').css({'position' : 'absolute', 'top' : '10px', 'right' : '10px'})
                        .append($('<i></i>').addClass('mdi mdi-key'))
                    ).appendTo($item);
            }
            else{
                $('<div></div>').addClass('d-flex align-items-center justify-content-center img-action img-border')
                    .append($('<img>').addClass('img-fluid img-bordered').attr('src', $image))
                    .append($('<div></div>').addClass('img-overlay-area d-flex justify-content-center align-items-center')
                        .append(
                            $('<a></a>').addClass('btn btn-danger btn-xs me-2 delete-image')
                                .attr('href', 'javascript:void(0);')
                                .attr('data-id', $img.id)
                                .attr('data-toggle', 'tooltip')
                                .attr('data-placement', 'top')
                                .attr('title', 'Delete')
                                .attr('data-original-title', 'Delete')
                                .append($('<i></i>').addClass('mdi mdi-delete'))
                        )
                        .append(
                            $('<a></a>').addClass('btn btn-success btn-xs primary-image')
                                .attr('href', 'javascript:void(0);')
                                .attr('data-id', $img.id)
                                .attr('data-toggle', 'tooltip')
                                .attr('data-placement', 'top')
                                .attr('title', 'Make this Primary Image?')
                                .attr('data-original-title', 'Make this Primary Image?')
                                .append($('<i></i>').addClass('mdi mdi-key'))
                        )
                    ).appendTo($item);
            }

            return $item;
        }

        ClassicEditor.create(document.querySelector("#content-en"), {
            toolbar: {
                //removeItems: [ 'insertImage', 'blockQuote', 'link' ],
                items: [
                    'heading', '|', 'bold', 'italic', 'listItem', 'link', '|', 'undo', 'redo'
                ]
            },
        }).then(function (e) {
            e.ui.view.editable.element.style.height = "200px";
        })
            .catch(function (e) {
                console.error(e);
            });

        ClassicEditor.create(document.querySelector("#content-si"), {
            toolbar: {
                //removeItems: [ 'insertImage', 'blockQuote', 'link' ],
                items: [
                    'heading', '|', 'bold', 'italic', 'listItem', 'link', '|', 'undo', 'redo'
                ]
            },
        }).then(function (e) {
            e.ui.view.editable.element.style.height = "200px";
        })
            .catch(function (e) {
                console.error(e);
            });

        ClassicEditor.create(document.querySelector("#content-ta"), {
            toolbar: {
                //removeItems: [ 'insertImage', 'blockQuote', 'link' ],
                items: [
                    'heading', '|', 'bold', 'italic', 'listItem', 'link', '|', 'undo', 'redo'
                ]
            },
        }).then(function (e) {
            e.ui.view.editable.element.style.height = "200px";
        })
            .catch(function (e) {
                console.error(e);
            });


        $image_thumb = $('#thumb_image_demo').croppie({
            enableExif: true,
            viewport: {
                width:280,
                height:147,
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
                    width: 1200,
                    height: 630
                }
            }).then(function(response){

                $id = $('#temp_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('backend.events.imageUpload') }}",
                    type: "POST",
                    data: {
                        image:response,
                        id: $id,
                    },
                    beforeSend: function ($jqXHR, $obj) {
                        $('#image-status').html('Uploading....');
                    },
                    success: function ($data) {
                        $('#image-status').html($data.status);
                        $img = appendImage($data);
                        $('#uploaded_image').append($img);
                    }
                });

            })
        });


        $(document).ready(function (){
            $('#main-title').on('blur', function ($e){

                $this = $(this);
                $title = $($this).val();

                $id = $('#temp_id').val();

                $url = $('#route_get_slug').val();

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
                                $('#slug').val($res.slug);
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


            $('#uploaded_image').on('click', '.delete-image', function ($e){
                $e.preventDefault();
                $this = $(this);
                $id = $($this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this Image!",
                    icon: "warning",
                    showCancelButton: !0,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Do it!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-danger w-xs mt-2",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then((result) => {
                    if (result.isConfirmed) {

                        setTimeout(function() {
                            $.ajax({
                                url: "{{ route('backend.events.deleteImage') }}",
                                type: 'POST',
                                data: {
                                    id: $id,
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
                                    Swal.fire('Done!', 'Image has been deleted!', 'success');

                                    $($this).parent().parent().parent().fadeOut('slow');
                                    setTimeout(function (){
                                        $($this).parent().parent().parent().remove();
                                    },1000);
                                },
                                error: function ($jqXHR, $textStatus, $errorThrown) {
                                    Swal.fire('Oops...', 'Something went wrong with the System!', 'error');
                                }
                            });

                        }, 50);
                    }
                });

            });

            $('#uploaded_image').on('click', '.primary-image', function ($e){
                $e.preventDefault();
                $this = $(this);
                $id = $($this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to set this as a Primary Image!",
                    icon: "warning",
                    showCancelButton: !0,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Do it!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-danger w-xs mt-2",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then((result) => {
                    if (result.isConfirmed) {

                        setTimeout(function() {
                            $.ajax({
                                url: "{{ route('backend.events.setPrimaryImage') }}",
                                type: 'POST',
                                data: {
                                    id: $id,
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
                                    Swal.fire('Done!', 'Primary Image has been updated!', 'success');

                                    $('#uploaded_image').html('');

                                    setTimeout(function (){
                                        $.each($response.images, function ($index, $item){
                                            $img = appendImage($item);
                                            $('#uploaded_image').append($img);
                                        });
                                    }, 100);




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
