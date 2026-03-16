<?php

namespace App\Http\Controllers;

use App\Actions\AddressActions;
use App\Http\Requests\StoreAddressRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{

    /**
     * @throws \Exception
     */
    public function createOrUpdateApi(StoreAddressRequest $request, int $application_id): JsonResponse
    {
        try{
            // dd($request);
            $address = AddressActions::storeOrUpdateAddress($request,$application_id);
            return response()->json([
                'status' => 'success',
                'data' => $address,
            ]);
        } catch (ValidationException|\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @throws \Exception
     */
    public function showApi(Request $request, int $address_id): JsonResponse
    {
        try{
            $address = AddressActions::getAddressByid($address_id);
            if($address) {
                return response()->json([
                    'status' => 'success',
                    'data' => $address,
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover the address.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        }
    }
}
