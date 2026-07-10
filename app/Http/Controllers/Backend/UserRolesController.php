<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    public function index()
    {
        $records = UserRoles::orderBy('id', 'ASC')->skip(1)->take(PHP_INT_MAX)->get();
        return view('backend.user-roles.index',[
            'records' => $records
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = UserRoles::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'user_role' => $get->user_role,
            'display_name' => $get->display_name,
        ];
        return response()->json($out);

    }

    public function store(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $validator = $request->validate([
            'user_role' => ['required', 'string', 'unique:user_roles,user_role,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = UserRoles::find($id);
            }
            else{
                $save = New UserRoles();
                $save->status = 1;
            }

            $save->user_role = $req['user_role'];
            $save->display_name = $req['display_name'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'User Role saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'User Role already exist!';
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
            $get = UserRoles::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = UserRoles::find($id);
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
