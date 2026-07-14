@extends('mails.' . $layout)

@section('content')

    <style type="text/css">
        .order-table th,
        .order-table td{
            border: 1px solid #ccc;
        }
    </style>

    <div style="padding: 20px;box-sizing: border-box; text-align: center;mso-padding-alt: 20px;">

        <h4 style="font-family: 'Roboto', sans-serif;margin-bottom: 10px;font-weight: 600;">New Player Join Request</h4>
        <p style="font-family: 'Roboto', sans-serif;margin-bottom: 10px;font-weight: 400;">New player join request has been received through the website. please refer it and respond</p>
        <p style="font-family: 'Roboto', sans-serif;margin-top: 40px;margin-bottom: 10px;font-weight: 400;">To view request, please click the button below or go to the dashboard.</p>
    </div>

    <div style="padding: 20px;box-sizing: border-box; text-align: center;mso-padding-alt: 20px;">

        <a href="{{ $data['url'] }}" style="background-color: #23aae2;border: 1px solid #23aae2;color: #ffffff;padding: 15px 40px;mso-padding-alt: 15px 40px 15px 40px;font-family: 'Roboto', sans-serif;font-weight: 600;text-decoration: none;">View Requests</a>

    </div>

    <div style="padding: 20px;box-sizing: border-box; text-align: center;mso-padding-alt: 20px;">

    </div>



@endsection
