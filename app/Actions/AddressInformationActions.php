<?php

namespace App\Actions;

use App\Http\Requests\StoreAddressInformationRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Finalize;
use App\Models\HouseholdMember;
use App\Models\IncomeDeduction;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressInformationActions
{

    const FIELD_TYPES = [
        //Applicant
        'applicant' => 0,
        //Household
        'Spouse' => 1,
        'OtherApplicant' => 2,
        'SpouseTax' => 3,
        'DependentTax' => 4,
        'OtherTax' => 5,
        //AdditionalInformation
        'OtherNonMember' => 6,
        'Child' => 7
    ];

    public static function storeAddressInformation(StoreAddressInformationRequest $request): bool
    {
        $validated = $request->validated();
        $userId = Auth::id();
        $application = Application::find($validated['application_id']);
    
        if ($application) {
            $mainMember = $application->mainMember()->first();
            $errors = 0;
    
            // IDs dos membros enviados na requisição
            $sentMemberIds = collect($validated['other_addresses'])->pluck('household_member_id')->toArray();
    
            // Obter os membros que possuem endereços no banco atualmente
            $currentAddressMembers = Address::whereIn('household_member_id', $application->householdMembers->pluck('id'))->get();
    
            // Verificar membros que precisam ter seus endereços removidos (excluindo o `mainMember`)
            $membersToRemoveAddresses = $currentAddressMembers->filter(function ($address) use ($sentMemberIds, $mainMember) {
                return $address->household_member_id != $mainMember->id && !in_array($address->household_member_id, $sentMemberIds);
            });
    
            foreach ($membersToRemoveAddresses as $address) {
                // Remover o endereço
                $address->delete();
    
                // Atualizar o membro correspondente
                $member = HouseholdMember::find($address->household_member_id);
                if ($member) {
                    $member->update(['lives_with' => null]);
                }
            }
    
            // Processar membros enviados na requisição
            if (isset($validated['other_addresses'])) {
                foreach ($validated['other_addresses'] as $memberAddress) {
                    $member = HouseholdMember::find($memberAddress['household_member_id']);
                    if ($member) {
                        // Tenta encontrar um endereço existente
                        $existingAddress = Address::where('household_member_id', $member->id)->first();
    
                        $addressData = [
                            'household_member_id' => $member->id,
                            'street_address' => $memberAddress['street_address'],
                            'apte_ste' => $memberAddress['apte_ste'] ?? null,
                            'city' => $memberAddress['city'],
                            'state' => $memberAddress['state'],
                            'zipcode' => $memberAddress['zipcode'],
                            'county' => $memberAddress['county'],
                            'mailing' => false,
                            'created_by' => $userId,
                        ];
    
                        if ($existingAddress) {
                            // Atualiza o endereço existente
                            $updated = $existingAddress->update($addressData);
                            if (!$updated) {
                                $errors++;
                            }
                        } else {
                            // Cria um novo endereço
                            $newAddress = Address::create($addressData);
                            if (!$newAddress) {
                                $errors++;
                            }
                        }
    
                        // Atualiza o campo `lives_with`
                        $member->update(['lives_with' => null, 'created_by' => $userId]);
                    } else {
                        $errors++;
                    }
                }
            }
    
            // Atualizar os applicants que vivem com o mainMember
            if (isset($mainMember->id)) {
                $applicants = $application->householdApplicants()->where('lives_with', '=', $mainMember->id)->get();
                foreach ($applicants as $applicant) {
                    $response = $applicant->update([
                        'lives_with' => $mainMember->id,
                        'created_by' => $userId,
                    ]);
                    if (!$response) {
                        $errors++;
                    }
                }
            }
    
            return $errors === 0;
        }
    
        return false;
    }
    
    
}
