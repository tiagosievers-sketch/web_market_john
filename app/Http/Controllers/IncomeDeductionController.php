<?php

namespace App\Http\Controllers;

use App\Actions\IncomeDeductionActions;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateQuotationMainIncomeRequest;
use App\Models\Application;
use App\Models\HouseholdMember;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IncomeDeductionController extends Controller
{

    /**
     * @throws Exception
     */
    public function updateQuotationMainIncome(UpdateQuotationMainIncomeRequest $request): JsonResponse
    { {
            try {
                $success = IncomeDeductionActions::updateQuotationMainIncome($request);
                return response()->json([
                    'status' => 'success',
                    'data' => $success,
                ]);
            } catch (ValidationException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'It was not possible to sent plans data.' . $e->getMessage()
                ], 500);
            }
        }
    }


    public function fillIncome(StoreIncomeRequest $request): JsonResponse
    {
        try {
            $success = IncomeDeductionActions::fillIncome($request);
            return response()->json([
                'status' => 'success',
                'data' => $success,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to sent plans data.' . $e->getMessage()
            ], 500);
        }
    }

    public function getIncomeListController($application_id)
    {
        try {
            $data = IncomeDeductionActions::getIncomeList($application_id);
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to send plans data.' . $e->getMessage()
            ], 500);
        }
    }

    // IncomeController.php
    // IncomeDeductionController.php
    public function getNetIncome(Request $request)
    {
        $memberId = $request->input('member_id');
        $member = HouseholdMember::find($memberId);

        if (!$member) {
            return response()->json(['error' => 'Household member not found'], 404);
        }

        return response()->json(['netIncome' => $member->net_income]);
    }

    public function delete(int $application_id, int $income_id): JsonResponse
    {
        try {
            $deleted = IncomeDeductionActions::deleteIncomeData($application_id, $income_id);

            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('Income not found'),
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => __('Successfully deleted income'),
            ]);
        } catch (\Exception $e) {
            \Log::error("Erro ao excluir income ID {$income_id} da aplicação {$application_id}: {$e->getMessage()}");

            return response()->json([
                'status' => 'error',
                'message' => __('Could not successfully delete income'),
            ], 500);
        }
    }
}
