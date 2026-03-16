<?php

namespace App\Http\Controllers;

use App\Actions\ContactActions;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{


    /**
     * @throws \Exception
     */
    public function createOrUpdateApi(StoreContactRequest $request, int $application_id): JsonResponse
    {
        try{
            // dd($request);
            $contact = ContactActions::storeOrUpdateContact($request,$application_id);
            return response()->json([
                'status' => 'success',
                'data' => $contact,
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
    public function showApi(Request $request, int $contact_id): JsonResponse
    {
        try{
            $contact = ContactActions::getContactByid($contact_id);
            if($contact) {
                return response()->json([
                    'status' => 'success',
                    'data' => $contact,
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
