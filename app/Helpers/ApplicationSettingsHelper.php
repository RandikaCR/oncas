<?php

namespace App\Helpers;

use App\Models\ApplicationSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApplicationSettingsHelper extends Helper
{
    public function getApplicationSetting($req = []){
        $out = ApplicationSettings::find('019f7001-020a-7045-b240-4a76006b9057');
        return $out;
    }
}

