@if(!empty($payments))
    @foreach($payments as $row)
        <tr id="payments-row-{{ $row->id }}">
            <td>
                <div>
                    <p class="mb-0">{{ !empty($row->voucher_number) ? generateVoucherNumber($row->voucher_number) : '' }}</p>
                    @if(!empty($row->payment_details))
                        @foreach($row->payment_details as $pd)
                            <p class="mb-0 text-secondary fs-10">
                                {{ $pd->payment_type }}
                                <span class="text-muted">
                                    @if($pd->payment_type_id == $pt_monthly_fee_id)
                                        <span class="mx-1">-</span>
                                        {{ date('F - Y', strtotime($pd->month)) }}
                                    @elseif($pd->payment_type_id == $pt_match_fee_id)
                                        <span class="mx-1">-</span>
                                        {{ $pd->event . ' - ' . $pd->event_venue }}
                                    @endif
                                </span>
                            </p>
                        @endforeach
                    @endif
                </div>
            </td>
            <td class="text-end">
                <div>
                    <p class="mb-0 fw-medium">{{ priceWithCurrency($row->amount) }}</p>
                </div>
            </td>
            <td class="text-center">
                <div>
                    <p class="mb-0">{{ $row->created_user }}</p>
                    <p class="mb-0 text-muted fs-12">{{ dateTimeFullFormat($row->created_at) }}</p>
                </div>
            </td>
            <td class="text-center">
                <div>
                    <p class="mb-0"><span class="badge {{ $row->payment_status_label }}">{{ $row->payment_status }}</span></p>
                </div>
            </td>
            <td class="text-end">
                <div class="d-flex justify-content-end align-items-center">
                    {{--<div class="form-check form-switch form-switch-success form-switch-md">
                        <input class="form-check-input status" data-id="{{ $subscription->id }}" type="checkbox" role="switch"  {{ ($subscription->status == 1) ? 'checked': '' }} >
                    </div>--}}
                    <div>
                        @if(!empty($row->filename))
                            <a href="{{ url('assets/common/pdf/' . $row->filename) }}" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="View Invoice" target="_blank"><span class="mdi mdi-file-pdf-box"></span></a>
                        @endif

                        <a href="{{ route('backend.payments.view', $row->id) }}" class="btn btn-primary btn-sm waves-effect waves-light view-payment" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><span class="mdi mdi-magnify"></span></a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr id="">
        <td colspan="6">
            <div class="py-5">
                <h4 class="mb-0 fw-medium text-center">No Records found.</h4>
            </div>
        </td>
    </tr>
@endif

