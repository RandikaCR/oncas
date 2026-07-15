@extends('layouts.backend')

@php
    $pageTitle = 'Create an Event';
    $singlePageTitle = 'Create a Event';
    $routePrefix = 'events';
    $pageUrl = 'events';
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
                <a href="{{ route('backend.events.index') }}" class="btn btn-primary me-3">
                    <span class="mdi mdi-plus-box me-2"></span>
                    All Events
                </a>
            </div>
        </div>
    @endsection

    @section('content')
        <form method="POST" action="{{ route('backend.events.store') }}">
            @csrf
            <input type="hidden" name="id" value="{{ isset($event) ? $event->id : 0 }}">
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
                            <h4 class="card-title mb-0 flex-grow-1">Event Details</h4>
                            <div class="flex-shrink-0">
                                <button type="submit" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-content-save me-1"></i>SAVE</button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div>
                                            <label for="venue_id" class="form-label">Venue</label>
                                            <select class="js-example-basic-single form-control"  name="venue_id" id="venue_id">
                                                <option value="">Select Venue</option>
                                                @foreach($venues as $venue)
                                                    <option value="{{ $venue->id }}" {{ !empty($event) && $event->venue_id == $venue->id ? 'selected' : '' }}>{{ $venue->venue }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <div>
                                            <label for="event" class="form-label">Event*</label>
                                            <input type="text" class="form-control" id="event" name="event" value="{{ !empty($event) ? $event->event : '' }}" placeholder="Enter here....">
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <div>
                                            <label class="form-label" for="start_time">Start Time</label>
                                            <input type="text" class="form-control" data-provider="flatpickr" id="start_time" name="start_time" data-date-format="d-M-Y" data-enable-time value="{{ !empty($event) && date('Y', strtotime($event->start_time)) > 1970 ? date('d-M-Y H:i:s', strtotime($event->start_time)) : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div>
                                            <label class="form-label" for="end_time">End Time</label>
                                            <input type="text" class="form-control" data-provider="flatpickr" id="end_time" name="end_time" data-date-format="d-M-Y" data-enable-time value="{{ !empty($event) && date('Y', strtotime($event->end_time)) > 1970 ? date('d-M-Y H:i:s', strtotime($event->end_time)) : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div>
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="4">{{ !empty($event) ? $event->description : '' }}</textarea>
                                        </div>
                                    </div>

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

        $(document).ready(function (){

        });
    </script>


@endsection
