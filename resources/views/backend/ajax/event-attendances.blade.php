@if(!empty($attendances))
    @foreach($attendances as $row)
        <tr id="attendance-row-{{ $row->id }}">
            <td>
                <div>
                    <p class="mb-0 fw-medium">{{ $row->first_name . ' '. $row->last_name }}</p>
                    <p class="mb-0 text-muted">{{ generatePlayerID($row->registration_number) }}</p>
                </div>
            </td>
            <td class="text-end">
                <div class="d-flex justify-content-end align-items-center">
                    {{--<div class="form-check form-switch form-switch-success form-switch-md">
                        <input class="form-check-input status" data-id="{{ $subscription->id }}" type="checkbox" role="switch"  {{ ($subscription->status == 1) ? 'checked': '' }} >
                    </div>--}}
                    <div>
                        {{--<a href="javascript:void(0);" class="btn btn-primary btn-sm waves-effect waves-light approve-this-subscription" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve this subscription" data-id="{{ $o->id }}"><span class="mdi mdi-file-send"></span></a>--}}
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

