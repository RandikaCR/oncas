<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ApplicationSettingsHelper;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\PaymentDetails;
use App\Models\Payments;
use App\Models\PaymentStatuses;
use App\Models\PaymentTypes;
use App\Models\PaymentVoucherNumbers;
use App\Models\PaymentVouchers;
use App\Models\Players;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{
    private $defaultPaymentTypeRegistrationFeeId = '019f7010-926b-7139-99c7-6de6b5f9c7fd';
    private $defaultPaymentTypeMonthlyFeeId = '019f7010-095a-73bc-b9a2-a658162b2794';
    private $defaultPaymentTypeMatchFeeId = '019f7010-cf32-7090-ac15-fb9ac5fd1887';

    public function index(Request $request){

        $userAccess = isAllUserRolesAllowed();

        $keyword = !empty($request->keyword) ? $request->keyword : null;

        $records = Payments::select(
            'payments.*',
            'players.first_name',
            'players.last_name',
            'players.registration_number',
            'payment_statuses.payment_status',
            'payment_statuses.label AS payment_status_label',
            'users.name AS created_user',
        )
            ->join('players', 'payments.player_id', 'players.id')
            ->join('payment_statuses', 'payments.payment_status_id', 'payment_statuses.id')
            ->join('users', 'payments.created_by', 'users.id')
            ->with([
                'payment_details' => function ($query) {
                    return $query->select(
                        'payment_details.*',
                        'payment_types.payment_type',
                    )
                        ->join('payment_types', 'payment_details.payment_type_id', 'payment_types.id');
                },
            ])
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('players.first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('players.first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('players.first_name', 'like', '%' . $keyword . '%');
            })
            ->orderBy('payments.created_at', 'DESC')
            ->paginate(20)
            ->withQueryString();

        $payments = [];
        foreach ($records as $record) {
            $amount = 0;
            if (!empty($record->payment_details)) {
                foreach ($record->payment_details as $paymentDetail) {
                    $amount += $paymentDetail->amount;
                }
            }

            $record['amount'] = $amount;
            $payments[] = $record;
        }

        return view('backend.payments.index',[
            'payments' => $payments,
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);

    }

    public function view(Request $request, $paymentId){
        $userAccess = isAllUserRolesAllowed();

        $payment = Payments::select(
            'payments.*',
            'players.first_name',
            'players.last_name',
            'players.registration_number',
            'payment_statuses.payment_status',
            'payment_statuses.label AS payment_status_label',
            'users.name AS created_user',
        )
            ->join('players', 'payments.player_id', 'players.id')
            ->join('payment_statuses', 'payments.payment_status_id', 'payment_statuses.id')
            ->join('users', 'payments.created_by', 'users.id')
            ->with([
                'payment_details' => function ($query) {
                    return $query->select(
                        'payment_details.*',
                        'payment_types.payment_type',
                        'events.event',
                        'events.start_time AS event_start_time',
                        'events.end_time AS event_end_time',
                        'venues.venue AS event_venue',
                    )
                        ->join('payment_types', 'payment_details.payment_type_id', 'payment_types.id')
                        ->leftJoin('events', 'payment_details.event_id', 'events.id')
                        ->leftJoin('venues', 'events.venue_id', 'venues.id');
                },
            ])
            ->where('payments.id', $paymentId)
            ->first();

        $voucher = PaymentVouchers::where('payment_id', $paymentId)->where('is_active', 1)->first();

        return view('backend.payments.view',[
            'user_access' => $userAccess,
            'payment' => $payment,
            'voucher' => $voucher,
            'pt_registration_fee_id' => $this->defaultPaymentTypeRegistrationFeeId,
            'pt_monthly_fee_id' => $this->defaultPaymentTypeMonthlyFeeId,
            'pt_match_fee_id' => $this->defaultPaymentTypeMatchFeeId,
        ]);
    }

    public function create(Request $request){
        $userAccess = isAllUserRolesAllowed();

        $s = new ApplicationSettingsHelper();
        $as = $s->getApplicationSetting();

        $playerId = !empty($request->player_id) ? $request->player_id : null;

        $players = Players::orderBy('first_name', 'ASC')->get();
        $payment_statuses = PaymentStatuses::where('status', 1)->get();

        return view('backend.payments.create',[
            'user_access' => $userAccess,
            'players' => $players,
            'player_id' => $playerId,
            'payment_statuses' => $payment_statuses,
            'pt_registration_fee_id' => $this->defaultPaymentTypeRegistrationFeeId,
            'pt_monthly_fee_id' => $this->defaultPaymentTypeMonthlyFeeId,
            'pt_match_fee_id' => $this->defaultPaymentTypeMatchFeeId,
            'as' => $as,
        ]);
    }

    public function edit(Request $request, $paymentId){
        $userAccess = isAllUserRolesAllowed();

        $s = new ApplicationSettingsHelper();
        $as = $s->getApplicationSetting();

        $payment = Payments::find($paymentId);
        $players = Players::orderBy('first_name', 'ASC')->get();
        $payment_statuses = PaymentStatuses::where('status', 1)->get();


        return view('backend.payments.create',[
            'user_access' => $userAccess,
            'payment' => $payment,
            'players' => $players,
            'payment_statuses' => $payment_statuses,
            'pt_registration_fee_id' => $this->defaultPaymentTypeRegistrationFeeId,
            'pt_monthly_fee_id' => $this->defaultPaymentTypeMonthlyFeeId,
            'pt_match_fee_id' => $this->defaultPaymentTypeMatchFeeId,
            'as' => $as,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'player_id' => ['required'],
            'payment_status_id' => ['required'],
        ]);

        $isNewPayment = 0;

        if(!empty($request->id)){
            $save = Payments::find($request->id);
        }
        else{
            $isNewPayment = 1;
            $save = new Payments();
            $save->created_by = $this->userId;
        }

        $save->player_id = $request->player_id;
        $save->payment_status_id = $request->payment_status_id;
        $save->save();
        $paymentId = $save->id;


        // Clear all exist payment details
        $getPaymentDetails = PaymentDetails::where('payment_id', $paymentId)->get();
        foreach ($getPaymentDetails as $paymentDetail) {
            $pd = PaymentDetails::find($paymentDetail->id);
            $pd->delete();
        }


        if (!empty($request->payment_type_id)) {
            $index = 0;
            foreach ($request->payment_type_id as $ptId) {
                // Monthly Fee
                $ptMonth = !empty($request->month[$index]) ? date('Y-m-01 :00:00:00', strtotime($request->month[$index])) : null;

                $pd = new PaymentDetails();
                $pd->payment_id = $paymentId;
                $pd->payment_type_id = $ptId;
                $pd->amount = !empty($request->amount[$index]) ? $request->amount[$index] : 0;
                $pd->status = 1;
                $pd->created_by = $this->userId;

                if ($ptId == $this->defaultPaymentTypeMonthlyFeeId){
                    $pd->month = $ptMonth;
                    $pd->event_id = null;
                }elseif ($ptId == $this->defaultPaymentTypeMatchFeeId){
                    $pd->event_id = !empty($request->event_id[$index]) ? $request->event_id[$index] : 0;
                    $pd->month = null;
                }

                $pd->save();
            }
        }


        if (!empty($isNewPayment)){

            // Generate Voucher

        }


        session()->flash('success', 'Payment Details has been saved successfully!');
        return redirect(route('backend.payments.view', $paymentId));
    }

    public function status(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $text = '';
        $class = '';

        if (!empty($id)){
            $get = Events::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = Events::find($id);
            $getStatus = commonStatus($get->status);
            $text = $getStatus['text'];
            $class = $getStatus['class'];

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'text' => $text,
            'class' => $class,
        ];
        return response()->json($out);

    }

    public function getPaymentDetailsRowInfo(Request $request){

        $paymentId = !empty($request->payment_id) ? $request->payment_id : 0;

        $paymentTypes = PaymentTypes::where('status', 1)->get();
        $events = Events::select(
            'events.*',
            'venues.venue'
        )
            ->join('venues', 'events.venue_id', 'venues.id')
            // ->where('events.is_completed', 0)
            ->where('events.is_canceled', 0)
            ->where('events.status', 1)
            ->get();

        $details = [];
        if (!empty($paymentId)){
            $details = PaymentDetails::select(
                'payment_details.*',
                'payment_types.payment_type',
                'events.event',
                'events.start_time AS event_start_time',
                'events.end_time AS event_end_time',
                'venues.venue AS event_venue',
            )
                ->join('payment_types', 'payment_details.payment_type_id', 'payment_types.id')
                ->leftJoin('events', 'payment_details.event_id', 'events.id')
                ->leftJoin('venues', 'events.venue_id', 'venues.id')
                ->where('payment_details.payment_id', $paymentId)
                ->get();

        }


        $out = [
            'payment_types' => $paymentTypes,
            'events' => $events,
            'details' => $details,
        ];

        return response()->json($out);
    }

    public function storeSignature(Request $request){
        $request->validate([
            'image' => 'required|string'
        ]);

        $imageData = $request->input('image');

        // 2. Strip out the 'data:image/png;base64,' metadata wrapper if present
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            // Get everything after the comma
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
        }

        // 3. Clean up potential spaces converted from '+' signs during AJAX transfer
        $imageData = str_replace(' ', '+', $imageData);

        // 4. Decode the binary data string
        $decodedImage = base64_decode($imageData);

        if ($decodedImage === false) {
            return response()->json(['message' => 'Invalid base64 string provided'], 400);
        }

        // 5. Generate a secure, unique filename for the file
        $fileName = Str::uuid() . '.png';

        $uploadPath = public_path('assets/common/images/signatures/' . $fileName);
        file_put_contents($uploadPath, $decodedImage);


        $request->payment_id = $request->payment_id;
        $request->signature = $fileName;
        $this->generateInvoice($request);


        return response()->json([
            'success' => true,
        ]);
    }

    public function generateInvoice(Request $request){

        $paymentId = !empty($request->payment_id) ? $request->payment_id : 0;
        $signature = !empty($request->signature) ? $request->signature : null;

        if (!empty($paymentId)){

            $getVouchers = PaymentVouchers::where('payment_id', $paymentId)->get();
            foreach ($getVouchers as $v){
                $tv = PaymentVouchers::find($v->id);
                $tv->is_active = 0;
                $tv->save();
            }

            $pv = new PaymentVouchers();
            $pv->payment_id = $paymentId;
            $pv->signature = $signature;
            $pv->is_active = 1;
            $pv->created_by = $this->userId;
            $pv->save();

            $paymentVoucherId = $pv->id;

            // Generate Voucher Number
            $pvn = new PaymentVoucherNumbers();
            $pvn->payment_voucher_id = $paymentVoucherId;
            $pvn->save();

            $fileName = $paymentVoucherId .'-'. generateVoucherNumber($pvn->id) . '.pdf';

            $pv = PaymentVouchers::find($paymentVoucherId);
            $pv->voucher_number = $pvn->id;
            $pv->filename = $fileName;
            $pv->save();

            $payment = Payments::select(
                'payments.*',
                'players.first_name',
                'players.last_name',
                'players.registration_number',
                'payment_statuses.payment_status',
                'payment_statuses.label AS payment_status_label',
                'users.name AS created_user',
            )
                ->join('players', 'payments.player_id', 'players.id')
                ->join('payment_statuses', 'payments.payment_status_id', 'payment_statuses.id')
                ->join('users', 'payments.created_by', 'users.id')
                ->with([
                    'payment_details' => function ($query) {
                        return $query->select(
                            'payment_details.*',
                            'payment_types.payment_type',
                            'events.event',
                            'events.start_time AS event_start_time',
                            'events.end_time AS event_end_time',
                            'venues.venue AS event_venue',
                        )
                            ->join('payment_types', 'payment_details.payment_type_id', 'payment_types.id')
                            ->leftJoin('events', 'payment_details.event_id', 'events.id')
                            ->leftJoin('venues', 'events.venue_id', 'venues.id');
                    },
                ])
                ->where('payments.id', $paymentId)
                ->first();


            $voucher = PaymentVouchers::find($paymentVoucherId);

            $pdf = PDF::loadView('pdf.invoice', [
                'payment' => $payment,
                'voucher' => $voucher,
                'pt_registration_fee_id' => $this->defaultPaymentTypeRegistrationFeeId,
                'pt_monthly_fee_id' => $this->defaultPaymentTypeMonthlyFeeId,
                'pt_match_fee_id' => $this->defaultPaymentTypeMatchFeeId,
            ])
                ->setPaper('A4', 'portrait')->setOption([
                    'tempDir' => public_path(),
                    'chroot' => public_path(),
                ]);


            $fileName = public_path('assets/common/pdf/' . $fileName);
            return $pdf->save($fileName);
        }

        return true;
    }

    public function viewInvoice(Request $request, $paymentId){

        $payment = Payments::select(
            'payments.*',
            'players.first_name',
            'players.last_name',
            'players.registration_number',
            'payment_statuses.payment_status',
            'payment_statuses.label AS payment_status_label',
            'users.name AS created_user',
        )
            ->join('players', 'payments.player_id', 'players.id')
            ->join('payment_statuses', 'payments.payment_status_id', 'payment_statuses.id')
            ->join('users', 'payments.created_by', 'users.id')
            ->with([
                'payment_details' => function ($query) {
                    return $query->select(
                        'payment_details.*',
                        'payment_types.payment_type',
                        'events.event',
                        'events.start_time AS event_start_time',
                        'events.end_time AS event_end_time',
                        'venues.venue AS event_venue',
                    )
                        ->join('payment_types', 'payment_details.payment_type_id', 'payment_types.id')
                        ->leftJoin('events', 'payment_details.event_id', 'events.id')
                        ->leftJoin('venues', 'events.venue_id', 'venues.id');
                },
            ])
            ->where('payments.id', $paymentId)
            ->first();

        return view('pdf.invoice', ['payment' => $payment]);
    }

}
