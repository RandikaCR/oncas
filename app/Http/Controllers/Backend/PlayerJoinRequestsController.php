<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PlayerJoinRequests;
use Illuminate\Http\Request;

class PlayerJoinRequestsController extends Controller
{
    public function index(Request $request){
        $userAccess = isAllUserRolesAllowed();

        $keyword = !empty($request->keyword) ? $request->keyword : null;

        $records = PlayerJoinRequests::select('player_join_requests.*',)
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->here('name', 'like', '%' . $keyword . '%')
                    ->orWhere('school_name', 'like', '%' . $keyword . '%')
                    ->orWhere('date_of_birth', 'like', '%' . $keyword . '%')
                    ->orWhere('age', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('contact', 'like', '%' . $keyword . '%')
                    ->orWhere('emergency_contact', 'like', '%' . $keyword . '%');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.player-join-requests.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $get = [];

        if (!empty($id)){
            $get = PlayerJoinRequests::find($id);
            $status = 'success';

            $get->is_view = 1;
            $get->viewed_by = $this->userId;
            $get->viewed_at = $this->dbInsertTime();
            $get->save();

            $get['date_of_birth'] = date('d-F-Y', strtotime($get->date_of_birth));

        }else{
            $status = 'error';
        }

        $count = PlayerJoinRequests::where('is_view', 0)->count();

        $out = [
            'status' => $status,
            'data' => $get,
            'count' => batchNumberFormat($count, 2),
        ];
        return response()->json($out);

    }
}
