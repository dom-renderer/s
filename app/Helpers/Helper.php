<?php

namespace App\Helpers;

use \Illuminate\Support\Facades\DB;

class Helper {
    
    public static $defaulDialCode = 'bb';

    public static function title ($title = '') {
        if (!empty($title)) {
            return $title;
        } else if ($name = DB::table('settings')->first()?->name) {
            return $name;
        } else {
            return env('APP_NAME', '');
        }
    }

    public static function logo () {
        if ($name = DB::table('settings')->first()?->logo) {
            return url("settings-media/{$name}");
        } else {
            return url('assets/images/logo.png');
        }
    }

    public static function favicon () {
        if ($name = DB::table('settings')->first()?->favicon) {
            return url("settings-media/{$name}");
        } else {
            return url('assets/images/favicon.ico');
        }
    }

    public static function bgcolor ($bg = null) {
        if (!empty($bg)) {
            return $bg;
        } else if ($color = DB::table('settings')->first()?->theme_color) {
            return $color;
        } else {
            return '#3a082f';
        }
    }

    public static function getIso2ByDialCode($dialCode = null) {
        if (empty(trim($dialCode))) {
            $dialCode = '91';
        }

        $dialCode = trim(str_replace('+', '', $dialCode));
        return strtolower(\App\Models\Country::select('iso2')->where('phonecode', "+{$dialCode}")->orWhere('phonecode', $dialCode)->first()->iso2 ?? 'in');
    }
}