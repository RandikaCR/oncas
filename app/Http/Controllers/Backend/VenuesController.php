<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Venues;
use Illuminate\Http\Request;

class VenuesController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isOnlyAdmins();

        $keyword = !empty($request->keyword) ? $request->keyword : null;
        $records = Venues::select('venues.*')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('venues.venue', 'like', "%$keyword%")
                    ->orWhere('venues.address', 'like', "%$keyword%");
            })
            ->orderBy('venue', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.venues.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function get(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;


        if (!empty($id)){
            $get = Venues::find($id);
            $status = 'success';

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'id' => $id,
            'venue' => $get->venue,
            'address' => $get->address,
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
            'venue' => ['required', 'string', 'unique:venues,venue,' . $id],
        ]);

        $validator = 1;

        if ($validator){

            if (!empty($id)){
                $save = Venues::find($id);
            }
            else{
                $save = New Venues();
                $save->status = 1;
            }

            $save->venue = $req['venue'];
            $save->address = $req['address'];
            $save->save();
            $status = 'success';
            $messageTitle = 'Success';
            $messageText = 'Venue saved';
        }else{

            $status = 'error';
            $messageTitle = 'Error!';
            $messageText = 'Venue already exist!';
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
            $get = Venues::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = Venues::find($id);
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
