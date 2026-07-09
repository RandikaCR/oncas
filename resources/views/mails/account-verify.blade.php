@extends('mails.' . $layout)

@section('content')

    <style type="text/css">
        .order-table th,
        .order-table td{
            border: 1px solid #ccc;
        }
    </style>

    <div style="padding: 20px;box-sizing: border-box; text-align: center;mso-padding-alt: 20px;">

        <h4 style="font-family: 'Roboto', sans-serif;margin-bottom: 10px;font-weight: 600;">Thank you for registering with ONCAS Cricket Academy</h4>
        <p style="font-family: 'Roboto', sans-serif;margin-bottom: 10px;font-weight: 400;">Please click the button below to verify your email address.</p>
    </div>

    <div style="padding: 20px;box-sizing: border-box; text-align: center;mso-padding-alt: 20px;">

        <a href="{{ $data['url'] }}" style="background-color: #23aae2;border: 1px solid #23aae2;color: #ffffff;padding: 15px 40px;mso-padding-alt: 15px 40px 15px 40px;font-family: 'Roboto', sans-serif;font-weight: 600;text-decoration: none;">Verify Email Address</a>

    </div>

    <div style="padding: 20px;box-sizing: border-box; text-align: center;mso-padding-alt: 20px;">

        <p style="font-size: 14px;color: #98a6ad;border-bottom: 1px solid #e9ebec;padding-bottom: 18px;">If you did not create an account, no further action is required.</p>

    </div>



@endsection
