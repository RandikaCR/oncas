<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymentTypes;
use Illuminate\Http\Request;

class PaymentTypesController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isOnlyAdmins();

        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = PaymentTypes::select('payment_types.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('payment_types.payment_type', 'like', "%$keyword%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate(20)
            ->withQueryString();

        $disabledIds = [
            '019f7010-095a-73bc-b9a2-a658162b2794',
            '019f7010-926b-7139-99c7-6de6b5f9c7fd',
            '019f7010-cf32-7090-ac15-fb9ac5fd1887',
        ];

        return view('backend.payment-types.index',[
            'records' => $records,
            'keyword' => $keyword,
            'disabled_ids' => $disabledIds,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = PaymentTypes::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'payment_type' => $get->payment_type,
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
            'payment_type' => ['required', 'string', 'unique:payment_types,payment_type,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = PaymentTypes::find($id);
            }
            else{
                $save = New PaymentTypes();
                $save->status = 1;
            }

            $save->payment_type = $req['payment_type'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Payment Type saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Payment Type already exist!';
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
            $get = PaymentTypes::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = PaymentTypes::find($id);
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
