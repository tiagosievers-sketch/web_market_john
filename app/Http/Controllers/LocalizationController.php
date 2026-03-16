<?php

namespace App\Http\Controllers;

use App\Actions\UserActions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Ramsey\Collection\Collection;


class LocalizationController extends Controller
{

    CONST LOCALIZATION_LIST = ['en', 'pt', 'es'];
    public function changeLocalization(string $locale)
    {
        if (! in_array($locale, self::LOCALIZATION_LIST)) {
            abort(400);
        }
        session(['my_locale' => $locale]);
        return back();
    }

    public function listLocalization(){
        try{
            return response()->json([
                'status' => 'success',
                'data' => self::LOCALIZATION_LIST,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to retrieve the localization list'.$e->getMessage()
            ], 500);
        }
    }
}
