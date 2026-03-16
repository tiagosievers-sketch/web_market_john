<?php

namespace App\Actions;

use App\Libraries\GatewayHttpLibrary;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class GeographyActions
{
    /**
     * @throws Exception
     */
    public static function getStateMedicaid(string $stateLetters): mixed
    {
        $now = Carbon::now();
        $responseState = GatewayHttpLibrary::getStatesMedicaid($stateLetters,$now->year,$now->quarter);
        if(isset($responseState->status)){
            if($responseState->status == 'success'){
               if(isset($responseState->data)){
                   return $responseState->data;
                }
            }
        }
        return false;
    }


    /**
     * @throws Exception
     */
    public static function statesOptions(): array
    {
        $responseStates = GatewayHttpLibrary::getStates();
//        dd($responseStates);
        $states = [];
        if(isset($responseStates->status)){
            if($responseStates->status == 'success'){
                if(isset($responseStates->data)){
                    if (isset($responseStates->data->states)) {
                        $statesCollection = collect($responseStates->data->states);
                        $statesCollection = $statesCollection->sortBy('name');
                        foreach ($statesCollection as $state) {
                            if (isset($state->name) && isset($state->abbrev)) {
                                $states[$state->abbrev] = $state->name;
                            }
                        }
                    }
                }
            }
        }
        return $states;
    }

    /**
     * @throws Exception
     */
    public static function countiesOptions($zipcode): array
    {
        $now = Carbon::now();
        $responseCounties = GatewayHttpLibrary::getCountyByZipcode($zipcode,(string)$now->year);
        $counties = [];
        if(isset($responseCounties->status)&&isset($responseCounties->data)){
            if($responseCounties->status==='success'){
                if(isset($responseCounties->data->counties)){
                    $countiesCollection = collect($responseCounties->data->counties);
                    $countiesCollection = $countiesCollection->sortBy('name');
                    foreach ($countiesCollection as $county) {
                        if (isset($county->name)) {
                            $counties[] = $county->name;
                        }
                    }
                }
            }
        }
        return $counties;
    }

    /**
     * @throws Exception
     */
    public static function countyFips($zipcode): array
    {
        $now = Carbon::now();
        $responseCounties = GatewayHttpLibrary::getCountyByZipcode($zipcode,(string)$now->year);
        $counties = [];
        if(isset($responseCounties->status)&&isset($responseCounties->data)){
            if($responseCounties->status==='success'){
                if(isset($responseCounties->data->counties)){
                    $countiesCollection = collect($responseCounties->data->counties);
                    $countiesCollection = $countiesCollection->sortBy('name');
                    foreach ($countiesCollection as $county) {
                        if (isset($county->name)) {
                            $counties[] = $county->fips;
                        }
                    }
                }
            }
        }
        return $counties;
    }



    /**
     * @throws Exception
     */
    public static function countyFipsAndStateLetters($zipcode,$countyName): array
    {
        $now = Carbon::now();
        $responseCounties = GatewayHttpLibrary::getCountyByZipcode($zipcode,(string)$now->year);
        $counties = [];
        if(isset($responseCounties->status)&&isset($responseCounties->data)){
            if($responseCounties->status==='success'){
                if(isset($responseCounties->data->counties)){
                    $countiesCollection = collect($responseCounties->data->counties);
                    $countiesCollection = $countiesCollection->sortBy('name');
                    foreach ($countiesCollection as $county) {
                        if (isset($county->name)) {
                            if($countyName == '') {
                                $counties['fips'] = $county->fips;
                                $counties['stateLetters'] = $county->state;
                                return $counties;
                            }
                            if($county->name == $countyName){
                                $counties['fips'] = $county->fips;
                                $counties['stateLetters'] = $county->state;
                                return $counties;
                            }
                        }
                    }
                }
            }
        }
        return $counties;
    }

    public static function getCountyInfoByZip(string $zipcode, $countyName = null): mixed
    {
        $now = Carbon::now();
        $responseCounties = GatewayHttpLibrary::getCountyByZipcode($zipcode,(string)$now->year);
        if(isset($responseCounties->status)&&isset($responseCounties->data)){
            if($responseCounties->status==='success'){
                if(isset($responseCounties->data)){
                    $countiesCollection = collect($responseCounties->data->counties);
                    Log::info('Counties',$countiesCollection->toArray());
                    if($countiesCollection->count() > 0) {
                        if($countyName != null) {
                            $county = $countiesCollection->first(function ($item) use ($countyName) {
                                return str_contains(strtoupper($item->name), strtoupper($countyName));
                            });
                            if($county == null) {
                                return $countiesCollection->first();
                            }
                            return $county;
                        }
                        return $countiesCollection->first();
                    }
                }
            }
        }
        return false;
    }
}
