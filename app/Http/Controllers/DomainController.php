<?php

namespace App\Http\Controllers;

use App\Actions\DomainValueActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class DomainController extends Controller
{
    /**
     * @throws \Exception
     */
    public function showApi(Request $request, $alias): JsonResponse
    {
        try{
            $inputs = $request->all();

            $use_alias = 0;
            $exclude_alias = "";
            if(isset($inputs["use_alias"])) {
                $use_alias = $inputs["use_alias"];
            }
            if(isset($inputs["exclude_alias"])) {
                $exclude_alias = $inputs["exclude_alias"];
            }

            $result = DomainValueActions::domainValuesOptions($alias, $use_alias, $exclude_alias);
            return response()->json([
                'status' => 'success',
                'data' => $result,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the domain'
            ], 500);
        }
    }
}
