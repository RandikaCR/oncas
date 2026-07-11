@extends('layouts.frontend')

@section('page_title')
    Join Academy
@endsection

@section('breadcrumb_title')
    Join Academy
@endsection

@section('css')
@endsection

@section('style')
@endsection

@section('content')

    @include('partials.frontend.breadcrumb')

    <section class="account-sec sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="text-center mb-5">
                        <h2 class="sec-title line primary">Register</h2>
                        <p>Please enter player information below</p>
                    </div>
                    <div class="account-form bg-mute rounded-4">
                        <form action="#">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label>Player Name*</label>
                                        <input type="text" id="name" placeholder="Enter here...">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label>School Name*</label>
                                        <input type="text" id="school_name" placeholder="Enter here...">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Date of Birth*</label>
                                        <input type="date" id="date_of_birth" placeholder="Enter here..." style="max-width: 100%;">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Age*</label>
                                        <input type="text" id="age" placeholder="Enter here...">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label>Address*</label>
                                        <input type="text" id="address" placeholder="Enter here...">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Contact Number*</label>
                                        <input type="text" id="contact" placeholder="Enter here...">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Emergency Contact Number*</label>
                                        <input type="text" id="emergency_contact" placeholder="Enter here...">
                                    </div>
                                </div>
                            </div>


                            <button class="btn btn-primary w-100 mt-5 join-academy">Join</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('.join-academy').on('click', function ($e){
                $e.preventDefault();
                $name = $('#name').val().trim();
                $schoolName = $('#school_name').val().trim();
                $dateOfBirth = $('#date_of_birth').val().trim();
                $age = $('#age').val().trim();
                $address = $('#address').val().trim();
                $contact = $('#contact').val().trim();
                $emergencyContact = $('#emergency_contact').val().trim();

                $isValidated = 0;
                if($name == ''){
                    Swal.fire('Oops...', 'Player Name is required!', 'error');
                    $isValidated++;
                }else if($schoolName == ''){
                    Swal.fire('Oops...', 'School Name is required!', 'error');
                    $isValidated++;
                }else if($dateOfBirth == ''){
                    Swal.fire('Oops...', 'Date of Birth required!', 'error');
                    $isValidated++;
                }else if($age == ''){
                    Swal.fire('Oops...', 'Age is required!', 'error');
                    $isValidated++;
                }else if($address == ''){
                    Swal.fire('Oops...', 'Address required!', 'error');
                    $isValidated++;
                }else if($contact == ''){
                    Swal.fire('Oops...', 'Contact number is required!', 'error');
                    $isValidated++;
                }else if($emergencyContact == ''){
                    Swal.fire('Oops...', 'Emergency Contact number is required!', 'error');
                    $isValidated++;
                }

                if($isValidated == 0){
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You want to join with our Academy!",
                        icon: "warning",
                        showCancelButton: !0,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Yes, Join!",
                        cancelButtonText: "No, cancel!",
                        confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                        cancelButtonClass: "btn btn-secondary w-xs mt-2",
                        buttonsStyling: !1,
                        showCloseButton: !0,
                    }).then((result) => {
                        if (result.isConfirmed) {

                            setTimeout(function() {
                                $.ajax({
                                    url: "{{ route('frontend.setJoinAcademy') }}",
                                    type: 'POST',
                                    data: {
                                        name: $name,
                                        school_name: $schoolName,
                                        date_of_birth: $dateOfBirth,
                                        age: $age,
                                        address: $address,
                                        contact: $contact,
                                        emergency_contact: $emergencyContact,
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
                                        Swal.fire('Thank you!', 'You will be contacted by our official soon.', 'success');

                                        $('#name').val('');
                                        $('#school_name').val('');
                                        $('#date_of_birth').val('');
                                        $('#age').val('');
                                        $('#address').val('');
                                        $('#contact').val('');
                                        $('#emergency_contact').val('');

                                        setTimeout(function(){
                                            location.reload();
                                        },4000);
                                    },
                                    error: function ($jqXHR, $textStatus, $errorThrown) {
                                        Swal.fire('Oops...', 'Something went wrong with the System!', 'error');
                                    }
                                });

                            }, 50);
                        }
                    });
                }




            });
        });
    </script>

@endsection
