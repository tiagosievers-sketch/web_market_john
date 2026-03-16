<?php

namespace App\Http\Controllers;

use App\Actions\PlanActions;
use App\Http\Requests\StorePlansRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlanController extends Controller
{

    /**
     * @throws \Exception
     */
    public function ajaxCreatePlansByApplication(StorePlansRequest $request): JsonResponse
    {
        try{
            $application = PlanActions::createPlansByApplication($request);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to sent plans data.'.$e->getMessage()
            ], 500);
        }
    }
}
