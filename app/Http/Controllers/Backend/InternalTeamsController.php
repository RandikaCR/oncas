<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InternalTeams;
use Illuminate\Http\Request;

class InternalTeamsController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isOnlyAdmins();

        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = InternalTeams::select('internal_teams.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('internal_teams.internal_team', 'like', "%$keyword%");
            })
            ->orderBy('internal_team', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.internal-teams.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = InternalTeams::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'internal_team' => $get->internal_team,
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
            'internal_team' => ['required', 'string', 'unique:internal_teams,internal_team,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = InternalTeams::find($id);
            }
            else{
                $save = New InternalTeams();
                $save->status = 1;
            }

            $save->internal_team = $req['internal_team'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Internal Team saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Internal Team already exist!';
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
            $get = InternalTeams::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = InternalTeams::find($id);
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
