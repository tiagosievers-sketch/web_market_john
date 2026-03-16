<?php

namespace App\Http\Controllers;

use App\Actions\AddressInformationActions;
use App\Http\Requests\StoreAddressInformationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressInformationController extends Controller
{
    public function fillAddressInformation(StoreAddressInformationRequest $request): JsonResponse
    {
        try {
            $response = AddressInformationActions::storeAddressInformation($request);
            if ($response) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully organized members addresses',
                ]);
            }
            return response()->json([
                'status' => 'failure',
                'message' => 'Could not successfully organize members addresses',
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
                'message' => 'Could not successfully organize members addresses.' . $e->getMessage()
            ], 500);
        }
    }
}
