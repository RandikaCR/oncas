<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BattingStyles;
use Illuminate\Http\Request;

class BattingStylesController extends Controller
{
    public function index(Request $request)
    {
        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = BattingStyles::select('batting_styles.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('batting_styles.batting_style', 'like', "%$keyword%");
            })
            ->orderBy('batting_style', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.batting-styles.index',[
            'records' => $records,
            'keyword' => $keyword,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = BattingStyles::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'batting_style' => $get->batting_style,
        ];
        return response()->json($out);

    }

    public function store(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $validator = $request->validate([
            'batting_style' => ['required', 'string', 'unique:batting_styles,batting_style,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = BattingStyles::find($id);
            }
            else{
                $save = New BattingStyles();
                $save->status = 1;
            }

            $save->batting_style = $req['batting_style'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Batting Style saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Batting Style already exist!';
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
            $get = BattingStyles::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = BattingStyles::find($id);
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
