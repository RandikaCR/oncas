<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PlayerJoinRequests;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request){
        return view('frontend.index');
    }

    public function contactUs(Request $request){
        return view('frontend.contact');
    }

    public function joinAcademy(Request $request){
        return view('frontend.join-academy');
    }

    public function setJoinAcademy(Request $request){

        $join = new PlayerJoinRequests();
        $join->name = $request->name;
        $join->school_name = $request->school_name;
        $join->date_of_birth = $this->dbInsertTime($request->date_of_birth);
        $join->age = $request->age;
        $join->address = $request->address;
        $join->contact = $request->contact;
        $join->emergency_contact = $request->emergency_contact;
        $join->is_view = 0;
        $join->save();

        $out = ['status' => 'success'];
        return response()->json($out);
    }

}
