<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BowlingStyles;
use Illuminate\Http\Request;

class BowlingStylesController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isOnlyAdmins();

        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = BowlingStyles::select('bowling_styles.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('bowling_styles.bowling_style', 'like', "%$keyword%");
            })
            ->orderBy('bowling_style', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.bowling-styles.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = BowlingStyles::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'bowling_style' => $get->bowling_style,
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
            'bowling_style' => ['required', 'string', 'unique:bowling_styles,bowling_style,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = BowlingStyles::find($id);
            }
            else{
                $save = New BowlingStyles();
                $save->status = 1;
            }

            $save->bowling_style = $req['bowling_style'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Bowling Style saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Bowling Style already exist!';
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
            $get = BowlingStyles::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = BowlingStyles::find($id);
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
