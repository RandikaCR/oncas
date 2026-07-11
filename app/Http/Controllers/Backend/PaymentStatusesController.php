<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymentStatuses;
use Illuminate\Http\Request;

class PaymentStatusesController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isOnlyAdmins();

        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = PaymentStatuses::select('payment_statuses.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('payment_statuses.payment_status', 'like', "%$keyword%");
            })
            ->orderBy('payment_status', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.payment-statuses.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = PaymentStatuses::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'payment_status' => $get->payment_status,
            'label' => $get->label,
        ];
        return response()->json($out);

    }

    public function store(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $userAccess = isOnlyAdmins();
        if (empty($userAccess)){
            return response()->json($this->userAccessDeniedMessage(), 422);
        }

        $validator = $request->validate([
            'payment_status' => ['required', 'string', 'unique:payment_statuses,payment_status,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = PaymentStatuses::find($id);
            }
            else{
                $save = New PaymentStatuses();
                $save->status = 1;
            }

            $save->payment_status = $req['payment_status'];
            $save->label = !empty($req['label']) ? $req['label'] : null;
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Payment Status saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Payment Status already exist!';
        }



        $out = [
            'status' => $status,
            'message_title' => $messageTitle,
            'message_text' => $messageText,
        ];
        return response()->json($out);

        /*if ($response->successful()) {
            $rdata = $response->json();
            if (!empty($rdata)) {
                return response()->json($rdata);
            }
        } else if ($response->status() == 400) {
            return response()->json($response->json(), 422);
        } else if ($response->status() == 401) {
            return response()->json($response->json(), 401);
        }*/
    }

    public function status(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $text = '';
        $class = '';

        if (!empty($id)){
            $get = PaymentStatuses::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = PaymentStatuses::find($id);
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
}
