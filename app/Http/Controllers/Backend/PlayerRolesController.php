<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PlayerRoles;
use Illuminate\Http\Request;

class PlayerRolesController extends Controller
{
    public function index(Request $request)
    {
        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = PlayerRoles::select('player_roles.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('player_roles.player_role', 'like', "%$keyword%");
            })
            ->orderBy('player_role', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.player-roles.index',[
            'records' => $records,
            'keyword' => $keyword,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = PlayerRoles::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'player_role' => $get->player_role,
        ];
        return response()->json($out);

    }

    public function store(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $validator = $request->validate([
            'player_role' => ['required', 'string', 'unique:player_roles,player_role,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = PlayerRoles::find($id);
            }
            else{
                $save = New PlayerRoles();
                $save->status = 1;
            }

            $save->player_role = $req['player_role'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Player Role saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Player Role already exist!';
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
            $get = PlayerRoles::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = PlayerRoles::find($id);
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
