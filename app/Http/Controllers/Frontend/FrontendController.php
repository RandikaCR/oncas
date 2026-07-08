<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
}
