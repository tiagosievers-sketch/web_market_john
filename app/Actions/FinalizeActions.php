<?php

namespace App\Actions;

use App\Http\Requests\StoreFinalizeRequest;
use App\Http\Requests\UpdateHouseHoldMemberFinalizeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Requests\UpdateMemberFinalizeRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Contact;
use App\Models\HouseholdMember;
use App\Models\IncomeDeduction;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinalizeActions
{

    public static function storeFinalize(StoreFinalizeRequest $request)
    {
        $userId = Auth::id();
        $finalizeFields = $request->validated();
        $finalizeFields['user_id'] = $userId;

        $application = Application::find($finalizeFields['application_id']);

        if ($application) {
            // Use os valores validados da requisição, garantindo valores padrão
            $finalizeFields['allow_marketplace_income_data'] = $finalizeFields['allow_marketplace_income_data'] ?? 0;
            $finalizeFields['years_renewal_of_eligibility'] = $finalizeFields['years_renewal_of_eligibility'] ?? 0;
            $finalizeFields['attestation_statement'] = $finalizeFields['attestation_statement'] ?? 0;
            $finalizeFields['marketplace_permission'] = $finalizeFields['marketplace_permission'] ?? 0;
            $finalizeFields['penalty_of_perjury_agreement'] = $finalizeFields['penalty_of_perjury_agreement'] ?? 0;
            $finalizeFields['full_name'] = $finalizeFields['full_name'] ?? '';

            $finalizeFields['created_by'] = $userId;
            $finalizeFields['created_at'] = Carbon::now();
            $finalizeFields['updated_by'] = $userId;
            $finalizeFields['updated_at'] = Carbon::now();

            // Insere os dados na tabela 'judicial_messages'
            $insertedId = DB::table('judicial_messages')->insertGetId($finalizeFields);

            return $insertedId;
        }

        return null;
    }



    public static function updateMemberFinalize(UpdateMemberFinalizeRequest $request)
    {
        // $data = $request->only([
        //     'application_id',
        //     'household_member_id',
        //     'firstname',
        //     'lastname',
        //     'street_address',
        //     'phone',
        //     'email',
        //     'send_mail',
        //     'written_lang',
        //     'spoken_lang',
        //     'street_address',
        //     'city',
        //     'state',
        //     'zipcode',
        //     'county'
        // ]);

        $data = $request->validated();

        // Encontre o membro que você deseja atualizar
        $mainMember = HouseholdMember::find($request->household_member_id);

        if ($mainMember) {
            $mainMember->firstname = $request->input('firstname');
            $mainMember->middlename = $request->input('middlename');
            $mainMember->lastname = $request->input('lastname');
            $mainMember->save();
        } else {
            throw new ModelNotFoundException('Household member not found.');
        }

        $application = Application::find($mainMember->application_id);
        if ($application) {
            $application->send_email = $request->input('send_email');
            $application->save();
        }

        $address = Address::where('household_member_id', $mainMember->id);
        if ($address->exists()) {
            $address = $address->first();
            $address->street_address = $request->input('street_address');
            $address->city = $request->input('city');
            $address->state = $request->input('state');
            $address->zipcode = $request->input('zipcode');
            $address->county = $request->input('county');
            $address->updated_at = Carbon::now();
            $address->save();
        }



        $contacts = Contact::where('application_id', $mainMember->application_id);

        if ($contacts->exists()) {
            $contacts = $contacts->first();
            $contacts->phone = $request->input('phone');
            $contacts->email  = $request->input('email');
            $contacts->written_lang = $request->input('written_lang');
            $contacts->spoken_lang = $request->input('spoken_lang');
            $contacts->save();
        }

        // Atualize os campos do membro
        $mainMember->update($data);

        // Retorne o ID do membro atualizado
        return $mainMember->id;
    }


    public static function updateHouseHoldMemberFinalize(UpdateHouseHoldMemberFinalizeRequest $memberData)
    {
        $validatedMember = $memberData->validated();
    
        $householdMember = HouseholdMember::findOrFail($validatedMember['household_member_id']);
    
        $rawDate = trim($validatedMember['birthdate']);
        $birthdate = null;
    
        if (\Carbon\Carbon::hasFormat($rawDate, 'm/d/Y')) {
            $birthdate = \Carbon\Carbon::createFromFormat('m/d/Y', $rawDate)->format('Y-m-d');
        } else {
            throw new \Exception("Formato de data inválido: {$rawDate}");
        }
    
        // Atualizar os campos do HouseholdMember
        $householdMember->update([
            'firstname' => $validatedMember['firstnameHousehold'] ?? null,
            'middlename' => $validatedMember['middlenameHousehold'] ?? null,
            'lastname' => $validatedMember['lastnameHousehold'] ?? null,
            'birthdate' => $birthdate,
            'sex' => $validatedMember['sex'] ?? null,
            'use_tobacco' => $validatedMember['use_tobacco'] ?? 0,
            'applying_coverage' => $validatedMember['applying_coverage'] ?? 0,
            'has_ssn' => $validatedMember['has_ssn'] ?? 0,
            'ssn' => $validatedMember['ssn'] ?? null,
        ]);
    
        // Atualizar o relacionamento na tabela `relationships`
        $relationship = Relationship::where('member_to_id', $householdMember->id)
            ->where('application_id', $validatedMember['application_id'])
            ->first();
    
        if ($relationship) {
            $relationship->update([
                'relationship' => $validatedMember['relationshipHousehold'] ?? null,
            ]);
        } 
    }
    



    public static function updateIncome(UpdateIncomeRequest $request)
    {
        $income = IncomeDeduction::find($request['income_id']);

        if (!$income) {
            throw new \Exception("Income not found.");
        }

        // Formatar a data para Y-m-d antes de salvar
        $unemploymentDate = $request['unemployment_date']
            ? \Carbon\Carbon::createFromFormat('m/d/Y', $request['unemployment_date'])->format('Y-m-d')
            : null;

        $income->update([
            'income_deduction_type' => $request['income_deduction_type'],
            'amount' => $request['amount'],
            'frequency' => $request['frequency'],
            'employer_name' => $request['employer_name'] ?? null,
            'employer_former_state' => $request['employer_former_state'] ?? null,
            'educational_amount' => $request['educational_amount'] ?? null,
            'non_educational_amount' => $request['non_educational_amount'] ?? null,
            'other_type' => $request['other_type'] ?? null,
            'employer_phone_number' => $request['employer_phone_number'] ?? null,
            'unemployment_date' => $unemploymentDate,
            'type_of_work' => $request['type_of_work'] ?? null,
        ]);

        return $income;
    }
}
