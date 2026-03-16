<?php

namespace App\Actions;

use App\Http\Requests\StoreAddressInformationRequest;
use App\Http\Requests\StoreMemberHouseholdRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\HouseholdMember;
use App\Models\Relationship;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberInformationActions
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

    public static function returnMemberList(int $application_id): array
    {
        /** @var Application $application */
        $application = Application::find($application_id);
        if ($application) {
            $members = $application->householdMembers();
            if ($members->count() > 0) {
                return $members->get()->toArray();
            }
            return array();
        }
        return array();
    }


    public static function storeMemberInformationAction(StoreMemberHouseholdRequest $request)
    {
        $userId = Auth::id();
        $validated = $request->validated();

        // Busca o membro específico pelo `this_household_member_id` do payload
        $mainMember = HouseholdMember::find($validated['this_household_member_id']);

        if ($mainMember) {
            $householdMemberData = $validated['household_members'][0] ?? []; // Confirma que os dados de membro estão presentes

            // Converte datas
            $lastTobaccoUsage = isset($householdMemberData['last_tobacco_usage'])
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $householdMemberData['last_tobacco_usage'])->format('Y-m-d')
                : null;

            $documentExpirationDate = isset($householdMemberData['document_expiration_date'])
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $householdMemberData['document_expiration_date'])->format('Y-m-d')
                : null;

            // Mapeamento explícito dos campos
            $memberData = [
                // Identificação
                'has_ssn' => $householdMemberData['has_ssn'] ?? 0,
                'ssn' => $householdMemberData['ssn'] ?? null,

                // Uso de tabaco
                'use_tobacco' => $householdMemberData['use_tobacco'] ?? 0,
                'last_tobacco_usage' => $lastTobaccoUsage,

                // Cidadania e imigração
                'is_us_citizen' => $householdMemberData['is_us_citizen'] ?? 0,
                'eligible_immigration_status' => $householdMemberData['eligible_immigration_status'] ?? null,

                // Documentos
                'document_type' => $householdMemberData['document_type'] ?? null,
                'document_number' => $householdMemberData['document_number'] ?? null,
                'document_number_type' => $householdMemberData['document_number_type'] ?? null,
                'document_complement_number' => $householdMemberData['document_complement_number'] ?? null,
                'document_expiration_date' => $documentExpirationDate,
                'document_country_issuance' => $householdMemberData['document_country_issuance'] ?? null,
                'document_category_code' => $householdMemberData['document_category_code'] ?? null,
                'has_sevis' => $householdMemberData['has_sevis'] ?? 0,
                'sevis_number' => $householdMemberData['sevis_number'] ?? null,

                // Status e outros identificadores
                'is_federally_recognized_indian_tribe' => $householdMemberData['is_federally_recognized_indian_tribe'] ?? 0,
                'has_hhs_or_refugee_resettlement_cert' => $householdMemberData['has_hhs_or_refugee_resettlement_cert'] ?? 0,
                'has_orr_eligibility_letter' => $householdMemberData['has_orr_eligibility_letter'] ?? 0,
                'is_cuban_haitian_entrant' => $householdMemberData['is_cuban_haitian_entrant'] ?? 0,
                'is_lawfully_present_american_samoa' => $householdMemberData['is_lawfully_present_american_samoa'] ?? 0,
                'is_battered_spouse_child_parent_vawa' => $householdMemberData['is_battered_spouse_child_parent_vawa'] ?? 0,
                'has_another_document_or_alien_number' => $householdMemberData['has_another_document_or_alien_number'] ?? 0,
                'none_of_these_document' => $householdMemberData['none_of_these_document'] ?? 0,
                'is_incarcerated_pending' => $householdMemberData['is_incarcerated_pending'] ?? 0,
                'live_in_eua' => $householdMemberData['live_in_eua'] ?? 0,
                'ineligible_full_coverage' => $householdMemberData['ineligible_full_coverage'] ?? 0,

                // Informações pessoais e preferências
                'is_incarcerated' => $householdMemberData['is_incarcerated'] ?? 0,
                'is_hip_lat_spanish' => $householdMemberData['is_hip_lat_spanish'] ?? null,
                'hip_lat_spanish_specific' => $householdMemberData['hip_lat_spanish_specific'] ?? null,
                'race' => $householdMemberData['race'] ?? null,
                'declined_race' => $householdMemberData['declined_race'] ?? 0,
                'birth_sex' => $householdMemberData['birth_sex'] ?? null,
                'gender_identity' => $householdMemberData['gender_identity'] ?? null,
                'sexual_orientation' => $householdMemberData['sexual_orientation'] ?? null,

                // Nome do documento
                'same_document_name' => $householdMemberData['same_document_name'] ?? 0,
                'document_first_name' => $householdMemberData['document_first_name'] ?? null,
                'document_middle_name' => $householdMemberData['document_middle_name'] ?? null,
                'document_last_name' => $householdMemberData['document_last_name'] ?? null,
                'document_suffix' => $householdMemberData['document_suffix'] ?? null,

                // Gravidez
                'is_pregnant' => $householdMemberData['is_pregnant'] ?? 0,
                'babies_expected' => $householdMemberData['babies_expected'] ?? null,

                // Campos específicos com nomes diferentes
                'is_ai_aln' => $householdMemberData['isAiAln'] ?? 0, // Mapear para o nome do banco
            ];

            $mainMember->update($memberData);

            // Retorna o próximo membro que ainda tenha `answer_member_information` como 0
            $nextMember = HouseholdMember::where('application_id', $validated['application_id'])
                ->where('answer_member_information', 0)
                ->value('id'); // Obtém apenas o ID

            return [
                'id' => $nextMember ?? null,
                'message' => $nextMember ? 'Próximo membro encontrado' : 'Nenhum próximo membro encontrado'
            ];
        }

        // Resposta alternativa se o mainMember não for encontrado
        return [
            'id' => null,
            'message' => 'Membro não encontrado.'
        ];
    }
}
