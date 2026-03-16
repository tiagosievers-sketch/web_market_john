<?php

namespace App\Actions;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Facades\Auth;

class ContactActions
{
    /**
     * @throws Exception
     */
    public static function storeOrUpdateContact(StoreContactRequest $request, $application_id): array
    {
        $userId = Auth::id();
        $contactReq = $request->validated();
        $contact = Contact::where('application_id',$application_id)->first();
        $contactData = [
            'application_id' => $application_id,
            'email' => $contactReq['email'],
            'phone' => $contactReq['phone'],
            'extension' => $contactReq['extension'],
            'type' => $contactReq['type'],
            'second_phone' => $contactReq['second_phone'],
            'second_extension' => $contactReq['second_extension'],
            'second_type' => $contactReq['second_type'],
            'written_lang' => $contactReq['written_lang'],
            'spoken_lang' => $contactReq['spoken_lang'],
            'created_by' => $userId
        ];
        if($contact){
            $contact->update($contactData);
            $contact->load(['phoneType','secondPhoneType','writtenLang','spokenLang','createdByUser']);
        } else {
            $contact = Contact::create($contactData);
        }
        return $contact->toArray();
    }

    public static function getContactByid($id): array
    {
        $contact = Contact::find($id);
        if($contact){
            return $contact->toArray();
        }
        return array();
    }

    public static function deleteContact(int $id): bool|null
    {
        $contact = Contact::find($id);
        if($contact){
            return $contact->delete();
        }
        return false;
    }

    public static function getContactByAplicationId($application_id): array
    {
       $contacts = Contact::where('application_id',$application_id)->get();
       if($contacts){
           return $contacts->toArray();
       }
        return array();
    }

}
