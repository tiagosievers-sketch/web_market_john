<?php

namespace App\Actions;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateQuotationMainIncomeRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Contact;
use App\Models\HouseholdMember;
use App\Models\IncomeDeduction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class IncomeDeductionActions
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
        'OtherNonMember' => 6
    ];
    /**
     * @throws Exception
     */
    public static function updateQuotationMainIncome(UpdateQuotationMainIncomeRequest $request): bool
    {
        $userId = Auth::id();
        $validated = $request->validated();
        $mainApplicant = HouseholdMember::where('application_id', $validated['application_id'])
            ->where('field_type', 0)
            ->first();
        if ($mainApplicant) {
            return $mainApplicant->update([
                'income_predicted_amount' => $validated['income_predicted_amount'],
                'created_by' => $userId
            ]);
        }
        return false;
    }



    public static function fillIncome(StoreIncomeRequest $request): array 
    {
        $userId = Auth::id();
        $validated = $request->validated();
        $responses = [];
    
        foreach ($validated['income_data'] as $incomeEntry) {
    
            // Verifica se é um entry da modal `yearlyIncomeModal` (sem campos específicos de income/deduction)
            $isYearlyIncomeEntry = isset($incomeEntry['income_confirmed'], $incomeEntry['income_predictable'], $incomeEntry['income_predicted_amount'])
                && !isset($incomeEntry['type'], $incomeEntry['income_deduction_type'], $incomeEntry['amount']);
    
            // Obtém o membro principal da household
            $mainApplicant = HouseholdMember::find($validated['household_member_id']);
    
            if ($isYearlyIncomeEntry && $mainApplicant) {
                // Atualiza apenas a tabela `household` com os dados da `yearlyIncomeModal`
                $mainApplicant->update([
                    'income_confirmed' => $incomeEntry['income_confirmed'],
                    'income_predictable' => $incomeEntry['income_predictable'],
                    'income_predicted_amount' => $incomeEntry['income_predicted_amount']
                ]);
    
                // Adiciona a resposta da atualização, se necessário
                $responses[] = [
                    'income_confirmed' => $incomeEntry['income_confirmed'],
                    'income_predictable' => $incomeEntry['income_predictable'],
                    'income_predicted_amount' => $incomeEntry['income_predicted_amount']
                ];
    
            } elseif ($mainApplicant) {
                // Caso contrário, cria um novo registro na tabela de `incomesAndDeductions`
    
                if (!empty($incomeEntry['unemployment_date'])) {
                    $unemployment_date = Carbon::createFromFormat('m/d/Y', $incomeEntry['unemployment_date']);
                    $unemployment_date = $unemployment_date->format('Y-m-d');
                }
    
                // Cria os dados do income/deduction
                $incomeData = [
                    'has_deduction_current_year' => $incomeEntry['has_deduction_current_year'] ?? false,
                    'income_confirmed' => $incomeEntry['income_confirmed'] ?? false,
                    'income_predictable' => $incomeEntry['income_predictable'] ?? false,
                    'income_predicted_amount' => $incomeEntry['income_predicted_amount'] ?? 0,
                    'type' => $incomeEntry['type'] ?? 0,
                    'income_deduction_type' => $incomeEntry['income_deduction_type'] ?? null,
                    'amount' => $incomeEntry['amount'] ?? 0,
                    'educational_amount' => $incomeEntry['educational_amount'] ?? 0,
                    'non_educational_amount' => $incomeEntry['non_educational_amount'] ?? 0,
                    'frequency' => $incomeEntry['frequency'] ?? null,
                    'other_type' => $incomeEntry['other_type'] ?? null,
                    'employer_name' => $incomeEntry['employer_name'] ?? null,
                    'employer_former_state' => $incomeEntry['employer_former_state'] ?? null,
                    'employer_phone_number' => $incomeEntry['employer_phone_number'] ?? null,
                    'unemployment_date' => $unemployment_date ?? null,
                    'household_member_id' => $validated['household_member_id'],
                    'has_income' => $incomeEntry['has_income'] ?? false,
                    'created_by' => $userId
                ];
    
                $income = $mainApplicant->incomesAndDeductions()->create($incomeData);
                $responses[] = $income->toArray();
            }
        }
    
        return ['income_data' => $responses];
    }
    

    public static function getIncomeList($application_id)
    {
        $incomesAndDeductions = Application::findOrFail($application_id)
            ->householdMembers()
            ->with('incomesAndDeductions') 
            ->get()
            ->flatMap->incomesAndDeductions; 
    
        return $incomesAndDeductions; 
    }

    public static function deleteIncomeData(int $application_id, int $income_id): bool
    {
        try {
            // Localiza o income pelo ID e valida se pertence à aplicação
            $income = IncomeDeduction::where('id', $income_id)
                ->first();
            
            if (!$income) {
                return false; // Income não encontrado
            }
    
            // Exclui o income
            $income->delete();
    
            return true;
        } catch (\Exception $e) {
            \Log::error("Erro ao excluir income ID {$income_id} da aplicação {$application_id}: {$e->getMessage()}");
            return false;
        }
    }
    

    
}
