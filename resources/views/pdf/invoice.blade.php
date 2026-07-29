<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
        }
        /* Table layout system mandatory for Dompdf structure */
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        table td {
            padding: 8px;
            vertical-align: top;
        }
        .header-table td {
            padding-bottom: 40px;
        }
        .text-right {
            text-align: right;
        }
        .heading td {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: bold;
        }
        .item td {
            border-bottom: 1px solid #eee;
        }
        .total td {
            border-top: 2px solid #dee2e6;
            font-weight: bold;
        }

        footer{
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 40px;
            background: #ffffff;
            text-align: center;
            color: #888888;
            font-size: 12px;
            line-height: 18px;
            border-top: 1px solid #666666;
        }

        .status-label {
            background: #45cb85;
        }
        @if(str_contains($payment->payment_status_label, 'danger'))
        .status-label {
            background: #f06548;
        }
        @elseif(str_contains($payment->payment_status_label, 'warning'))
        .status-label {
            background: #ffbe0b;
        }
        @elseif(str_contains($payment->payment_status_label, 'info'))
        .status-label {
            background: #299cdb;
        }
        @endif

    </style>
</head>
<body>
<div class="invoice-box">
    <!-- Header Info Layout -->
    <table class="header-table">
        <tr>
            <td>
                <img src="{{ public_path('assets/common/images/logo-email.png') }}" style="width: 80px;">
                <p>ONCAS Cricket Academy</p>
            </td>
            <td class="text-right">
                <h1>INVOICE</h1>
                <p><strong>Invoice #:</strong> {{ generateVoucherNumber($voucher->voucher_number) }}<br>
                    <strong>Date:</strong> {{ dateTimeFullFormat($voucher->created_at) }}<br>
                    <strong>Payment Status:</strong> <span class="status-label" style="color: #ffffff; padding: 2px 20px;">{{ $payment->payment_status }}</span></p>
            </td>
        </tr>
    </table>

    <!-- Client Info Layout -->
    <table style="margin-bottom: 40px;">
        <tr>
            <td>
                {{ $payment->first_name .' '. $payment->last_name }}<br>
                {{ generatePlayerID($payment->registration_number) }}
            </td>
        </tr>
    </table>

    <table style="margin-bottom: 250px;">
        <tr class="heading">
            <td colspan="2">Description</td>
            <td class="text-right" style="width: 120px;">Total</td>
        </tr>

        @php
            $amount = 0;
        @endphp
        @if(!empty($payment->payment_details))
            @foreach($payment->payment_details as $d)
                @php
                    $amount += $d->amount;
                @endphp

                <tr class="item">
                    <td>{{ $d->payment_type }}</td>
                    <td>
                        @if($d->payment_type_id == $pt_monthly_fee_id)
                            {{ date('F - Y', strtotime($d->month)) }}
                        @elseif($d->payment_type_id == $pt_match_fee_id)
                            {{ $d->event . ' - ' . $d->event_venue }}
                        @endif
                    </td>
                    <td class="text-right">{{ priceWithCurrency($d->amount) }}</td>
                </tr>
            @endforeach
        @endif

        <tr class="total">
            <td class="text-right" colspan="2">Total:</td>
            <td class="text-right">{{ priceWithCurrency($amount) }}</td>
        </tr>
    </table>

    <table style="margin-bottom: 40px;">
        @if(!empty($voucher->signature))
            <tr>
                <td style="padding: 0; vertical-align: bottom;">
                    <img src="{{ public_path('assets/common/images/signatures/' . $voucher->signature) }}" style="width: 200px;">
                </td>
            </tr>
        @endif

        <tr>
            <td style="padding: 0; vertical-align: bottom; line-height: 10px;">.................................................</td>
        </tr>
        <tr>
            <td style="">
                Signature
            </td>
        </tr>
    </table>

    <footer>
        This is a System generated invoice
        <br>
        Reference ID : {{ $voucher->id }}
    </footer>
</div>
</body>
</html>
