<?php

namespace App\Http\Controllers;

use App\Actions\GeographyActions;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\Translation\t;

class GeographyController extends Controller
{
    /**
     * @throws \Exception
     */
    public function countiesByZip($zipcode):JsonResponse
    {
        try{
            $counties = GeographyActions::countiesOptions($zipcode);
            return response()->json([
                'status' => 'success',
                'data' => $counties,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the counties by the zipcode.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function getStates(): JsonResponse
    {
        try{
            $states = GeographyActions::statesOptions();
            return response()->json([
                'status' => 'success',
                'data' => $states,
            ]);
        } catch ( \Exception $e) {
            Log::error('Exception: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the states.'
            ], 500);
        }
    }    
}
