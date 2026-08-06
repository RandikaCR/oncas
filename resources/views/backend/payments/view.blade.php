@extends('layouts.backend')

@php
    $pageTitle = 'Payment';
    $singlePageTitle = 'Payment';
    $routePrefix = 'payments';
    $pageUrl = 'payments';
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
                <div class="d-flex justify-content-end">



                    <a href="{{ route('backend.payments.index') }}" class="btn btn-primary me-3 mb-2">
                        <span class="mdi mdi-plus-box me-2"></span>
                        All Payments
                    </a>

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary waves-effect waves-light shadow-none dropdown-toggle mb-2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-menu-2-line"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                            <li>
                                <a class="dropdown-item" href="{{ route('backend.payments.edit', $payment->id) }}">
                                    <span class="mdi mdi-pencil me-2"></span>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item add-signature-btn" href="javascript:void(0);">
                                    <span class="mdi mdi-signature-freehand me-2"></span>
                                    Add Signature
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item generate-invoice-without-signature-btn" href="javascript:void(0);">
                                    <span class="mdi mdi-file-percent me-2"></span>
                                    Generate Invoice Without Signature
                                </a>
                            </li>
                        </ul>
                    </div>
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
                            <h4 class="card-title mb-0 flex-grow-1">Payment</h4>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body p-4">
                        <div class="row py-3 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-2">Player</label>
                                <p class="fw-medium mb-0">{{ $payment->first_name . ' '. $payment->last_name }}</p>
                                <p class="fw-medium text-muted mb-0">{{ generatePlayerID($payment->registration_number) }}</p>
                            </div>
                        </div>
                        <div class="row py-3 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-2">Status</label>
                                <p class="fw-medium mb-0"><span class="badge {{ $payment->payment_status_label }}">{{ $payment->payment_status }}</span></p>
                            </div>
                        </div>
                        <div class="row py-3 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-2">Amount</label>
                                @php
                                    $amount = 0;
                                @endphp
                                @if(!empty($payment->payment_details))
                                    @foreach($payment->payment_details as $d)
                                        @php
                                            $amount += $d->amount;
                                        @endphp
                                    @endforeach
                                @endif
                                <p class="fw-medium mb-0">{{ priceWithCurrency($amount) }}</p>
                            </div>
                        </div>
                        @if(!empty($voucher))
                            <div class="row py-3 border-bottom align-items-center">
                                <div class="col-sm-12 text-start">
                                    <div class="d-flex justify-content-between">
                                        <div><label class="text-muted fs-12 mb-2">Payment Voucher</label></div>
                                        <div>

                                            <a href="javascript:void(0);" class="btn btn-success btn-sm waves-effect waves-light me-1 whatsapp-invoice"><i class="mdi mdi-whatsapp"></i></a>

                                            <a href="{{ url('payment/invoice/' . $voucher->id) }}" class="btn btn-info btn-sm waves-effect waves-light me-1" target="_blank"><i class="mdi mdi-magnify"></i></a>

                                            <a href="{{ url('assets/common/pdf/' . $voucher->filename) }}" class="btn btn-primary btn-sm waves-effect waves-light" target="_blank"><i class="mdi mdi-download"></i></a>
                                        </div>
                                    </div>
                                    <p class="fw-medium mb-0">{{ generateVoucherNumber($voucher->voucher_number) }}</p>
                                    <p class="fw-medium text-muted mb-0">{{ !empty($voucher->created_at) ? dateTimeFullFormat($voucher->created_at) : '' }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="row py-3 border-bottom align-items-center">
                            <div class="col-sm-12 text-start">
                                <label class="text-muted fs-12 mb-2">Payment Created by</label>
                                <p class="fw-medium mb-0">{{ $payment->created_user }}</p>
                                <p class="fw-medium text-muted mb-0">{{ dateTimeFullFormat($payment->created_at) }}</p>
                            </div>
                        </div>

                    </div>
                </div><!-- end card -->
            </div>
            <div class="col-lg-9 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header align-items-center justify-content-between d-md-flex">
                            <div class="">
                                <h4 class="card-title flex-grow-1 mb-2">Payment Details</h4>
                            </div>
                        </div>
                        <div class="live-preview table-area">
                            <div class="table-responsive">
                                <table class="table table-striped table-nowrap align-middle mb-0">
                                    <thead>
                                    <tr>
                                        <th class="" scope="col">
                                            <div>
                                                <p class="mb-0">Payment Type</p>
                                            </div>
                                        </th>
                                        <th class="" scope="col">
                                            <div>
                                                <p class="mb-0">Description</p>
                                            </div>
                                        </th>
                                        <th class="text-end" scope="col">
                                            <div>
                                                <p class="mb-0">Amount</p>
                                            </div>
                                        </th>
                                        <th class="text-end" scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-body">
                                    @if(!empty($payment->payment_details))
                                        @foreach($payment->payment_details as $d)
                                            <tr>
                                                <td>{{ $d->payment_type }}</td>
                                                <td>
                                                    @if($d->payment_type_id == $pt_monthly_fee_id)
                                                        {{ date('F - Y', strtotime($d->month)) }}
                                                    @elseif($d->payment_type_id == $pt_match_fee_id)
                                                        {{ $d->event . ' - ' . $d->event_venue }}
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <p class="mb-0 fw-medium">{{ priceWithCurrency($d->amount) }}</p>
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div>
            </div>
        </div>


        <div class="modal fade" id="editFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content" id="save-form-area">
                    <div class="modal-header">
                        <h5 class="modal-title"><span class="me-1" id="save-form-title">Place Signature</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="signature-wrapper" style="width: 100%;">
                                        <canvas id="signature-pad" width="400" height="200" style="border: 1px solid #ccc;"></canvas>
                                    </div>
                                </div>
                                <div class="col-sm-12" id="form-alert-area">

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-danger waves-effect waves-light" id="clear-signature-btn"><i class="mdi mdi-close me-1"></i>CLEAR</button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light" id="save-signature-btn"><i class="mdi mdi-content-save me-1"></i>SAVE & GENERATE INVOICE</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
@endsection

@section('custom_scripts')
    <script>

        function sendPdfToWhatsApp() {
            const $phoneNumber = "{{ generateWhatsAppNumber($payment->emergency_contact_1) }}";
            const $pdfUrl = "{{ url('payment/invoice/' . $voucher->id) }}";
            const $voucherNo = "#{{ generateVoucherNumber($voucher->voucher_number) }}";
            const $message = encodeURIComponent('Thank you for your payment. here is your invoice '+$voucherNo+'. Click this link to view your invoice. ' + $pdfUrl);
            window.open('https://wa.me/'+$phoneNumber+'?text=' + $message, '_blank');
        }

        var $paymentId = "{{ $payment->id }}";

        function initSignaturePad(){
            // Get references to elements
            const canvas = document.getElementById('signature-pad');
            const clearButton = document.getElementById('clear-signature-btn');
            const saveButton = document.getElementById('save-signature-btn');

            // Initialize Signature Pad
            const signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 3,
                penColor: 'rgb(0, 0, 0)' // Black ink
            });

            // Clear button logic
            clearButton.addEventListener('click', () => {
                signaturePad.clear();
            });

            // Save button logic (exporting data)
            saveButton.addEventListener('click', () => {
                if (signaturePad.isEmpty()) {
                    Swal.fire('Error!', 'Place your signature first!', 'error');
                } else {
                    // Export signature as a Base64 PNG image string
                    const dataURL = signaturePad.toDataURL();


                    Swal.fire({
                        title: "Are you sure?",
                        text: "You want to add this signature!",
                        icon: "warning",
                        showCancelButton: !0,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Yes, Add it!",
                        cancelButtonText: "No, cancel!",
                        confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                        cancelButtonClass: "btn btn-danger w-xs mt-2",
                        buttonsStyling: !1,
                        showCloseButton: !0,
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "{{ route('backend.payments.storeSignature') }}",
                                type: 'POST',
                                data: {
                                    image: dataURL,
                                    payment_id: $paymentId,
                                    _token: csrf_token()
                                },
                                dataType: 'json',
                                beforeSend: function ($jqXHR, $obj) {
                                    $('#form-alert-area').html('');
                                    $('#form-alert-area').html(alertProcessing('Generating Invoice....'));
                                },
                                success: function ($response, $textStatus, $jqXHR) {
                                    $('#form-alert-area').html('');
                                    $('#form-alert-area').html(alertSuccess('New Invoice has been generated with the new signature.'));
                                    setTimeout(function (){
                                        location.reload();
                                    }, 2000);
                                },
                                error: function ($jqXHR, $textStatus, $errorThrown) {

                                }
                            });

                        }
                    });


                }
            });
        }

        $(document).ready(function (){

            $('.whatsapp-invoice').on('click', function ($e){
                $e.preventDefault();
                sendPdfToWhatsApp();
            });

            $('.add-signature-btn').on('click', function (){
                $('#editFormModal').modal('show');
                setTimeout(function (){
                    $sigPadAreaWidth = $('.signature-wrapper').width();
                    $('#signature-pad').attr('width', $sigPadAreaWidth + 'px').attr('height', $sigPadAreaWidth / 2 + 'px');
                    initSignaturePad();
                }, 400);
            });


            $('.generate-invoice-without-signature-btn').on('click', function (){
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to generate this invoice without the signature!",
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

                        $.ajax({
                            url: "{{ route('backend.payments.generateInvoiceWithoutSignature') }}",
                            type: 'POST',
                            data: {
                                payment_id: $paymentId,
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
                                Swal.fire('Done!', 'New Invoice has been generated without the signature.', 'success');
                                setTimeout(function (){
                                    location.reload();
                                }, 2000);
                            },
                            error: function ($jqXHR, $textStatus, $errorThrown) {

                            }
                        });

                    }
                });
            });




        });
    </script>
@endsection
