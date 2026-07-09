<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AccountVerify;
use App\Models\PlayerJoinRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function appLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $out = ['status' => 'success'];
        return response()->json($out);
    }

    public function test(Request $request){
        $userId = '019f44f9-40e9-72a0-9b05-94a2f6f2cf0b';
        $mailData = [
            'layout' => 'layout_1',
            'email_subject' => 'Thank you for registering with ONCAS Cricket Academy. Please verify your account.',
            'url' => $this->accountVerifyUrlGenerator($userId),
        ];

        /*$htmlBody = (new AccountVerify($mailData))->render();
        echo $htmlBody;
        exit();*/

        $out = Mail::to('fb.cralwis@gmail.com')->send(new AccountVerify($mailData));

        dd($out);
    }

}
