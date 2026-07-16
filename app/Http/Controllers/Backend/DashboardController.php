<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        return view('backend.index');
    }

    public function setThemeMode(Request $request){

        $mode = 'light';
        if ($request->mode == 'light'){
            $mode = 'dark';
        }
        session()->put('theme_mode', $mode);
    }

}
