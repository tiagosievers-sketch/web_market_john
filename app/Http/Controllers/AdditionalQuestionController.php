<?php

namespace App\Http\Controllers;

use App\Actions\AdditionalQuestionActions;
use App\Http\Requests\StoreAdditionalQuestionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdditionalQuestionController extends Controller
{
    
    public function fillAdditionalQuestion(StoreAdditionalQuestionRequest $request): JsonResponse
    {
        try{
            $response = AdditionalQuestionActions::updateAdditionalQuestions($request);
            if($response){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Additional information registered with success.',
                ]);
            }
            return response()->json([
                'status' => 'failure',
                'message' => 'Could not find the main Household Member'
            ], 204);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
//           dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to send additional information data.'.$e->getMessage()
            ], 500);
        }
    }
}
