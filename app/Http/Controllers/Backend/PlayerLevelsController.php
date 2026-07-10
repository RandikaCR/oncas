<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PlayerLevels;
use Illuminate\Http\Request;

class PlayerLevelsController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isOnlyAdmins();

        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = PlayerLevels::select('player_levels.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('player_levels.player_level', 'like', "%$keyword%");
            })
            ->orderBy('player_level', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.player-levels.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = PlayerLevels::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'player_level' => $get->player_level,
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
            'player_level' => ['required', 'string', 'unique:player_levels,player_level,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = PlayerLevels::find($id);
            }
            else{
                $save = New PlayerLevels();
                $save->status = 1;
            }

            $save->player_level = $req['player_level'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Player Level saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Player Level already exist!';
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
            $get = PlayerLevels::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = PlayerLevels::find($id);
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
