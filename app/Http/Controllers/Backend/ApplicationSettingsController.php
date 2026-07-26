<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSettings;
use Illuminate\Http\Request;

class ApplicationSettingsController extends Controller
{
    public function index(Request $request){

        $userAccess = isOnlyAdmins();

        $app = ApplicationSettings::find('019f7001-020a-7045-b240-4a76006b9057');
        return view('backend.application-settings.index', [
            'app' => $app,
            'user_access' => $userAccess,
        ]);
    }

    public function updateFees(Request $request){

        $fmTitle = 'info';
        $fmMsg = 'Nothing to update';

        $userAccess = isOnlyAdmins();
        if (empty($userAccess)){
            return response()->json($this->userAccessDeniedMessage(), 422);
        }

        $request->validate([
            'registration_fee' => ['required'],
            'monthly_fee' => ['required'],
        ]);

        $app = ApplicationSettings::find('019f7001-020a-7045-b240-4a76006b9057');
        $app->registration_fee = $request->registration_fee;
        $app->monthly_fee = $request->monthly_fee;
        $app->save();

        $fmTitle = 'success';
        $fmMsg = 'Fees updated successfully';

        // Create and update on Stripe

        session()->flash($fmTitle, $fmMsg);
        return redirect( route('backend.applicationSettings.index') );
    }
}
