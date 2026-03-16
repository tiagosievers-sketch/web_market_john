<?php

namespace App\Actions;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use Exception;
use Illuminate\Support\Facades\Auth;

class AddressActions
{
    /**
     * @throws Exception
     */
    public static function storeOrUpdateAddress(StoreAddressRequest $request, $application_id): array
    {
        $userId = Auth::id();
        $addressReq = $request->validated();
        $address = Address::where('application_id',$application_id)->where('mailing',$addressReq['mailing'])->first();
        $addressData = [
            'application_id' => $application_id,
            'street_address' => $addressReq['street_address'],
            'apte_ste' => $addressReq['apte_ste']??null,
            'city' => $addressReq['city'],
            'state' => $addressReq['state'],
            'zipcode' => $addressReq['zipcode'],
            'county' => $addressReq['county'],
            'mailing' => $addressReq['mailing'],
            'created_by' => $userId
        ];
        if($address){
            $address->update($addressData);
            $address->load(['createdByUser']);
        } else {
            $address = Address::create($addressData);
        }
        return $address->toArray();
    }

    public static function getAddressByid($id): array
    {
        $address = Address::find($id);
        if($address){
            return $address->toArray();
        }
        return array();
    }

    public static function deleteAddress(int $id): bool|null
    {
        $address = Address::find($id);
        if($address){
            return $address->delete();
        }
        return false;
    }

    public static function getAddressByAplicationId($id): array
    {
        $addresses = Address::where('application_id', $id)->get();
        
        if($addresses){
            return $addresses->toArray();
        }
        return array();
    }

}
