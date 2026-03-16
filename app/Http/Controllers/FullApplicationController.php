<?php

namespace App\Http\Controllers;

use App\Actions\InsurancePlansActions;
use App\Jobs\IntegrationWithCrmJob;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actions\FullApplicationActions;
use App\Http\Requests\FilterPlansRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreFullApplicationRequest;

class FullApplicationController extends Controller
{
    /**
     * Cria Application, Household e Quotation em um só endpoint.
     */


    public function createFullApplication(StoreFullApplicationRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            // Etapa 1: Cria a Application
            $application = FullApplicationActions::createApplication($request->application);

            // Copie os dados da household para uma variável temporária
            $householdData = $request->household;

            // Verifique se os membros da household estão presentes no request
            if (isset($householdData['household_members'])) {
                $householdData['application_id'] = $application['id'];
                // Etapa 2: Cria os membros do Household
                $household = FullApplicationActions::createHousehold($householdData, $application['id']);
            } else {
                throw new \Exception("Household members are missing in the request.");
            }

            // Copie os dados da quotation para uma variável temporária
            $quotationData = $request->quotation;
            $quotationData['application_id'] = $application['id'];
            $quotationData['client_id'] = $application['additional_external_id'];

            // Etapa 3: Cria a cotação (Quotation)
            $quotation = FullApplicationActions::createQuotation($quotationData, $application['id']);

            //  // Etapa 4: Busca todos os planos acessíveis (sem paginação)
            //  $plans = FullApplicationActions::getAllAccessiblePlans($application['id'], $filterPlansRequest);  // Usando o FilterPlansRequest corretamente

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'application_id' => $application['id']
                    //  'plans' => $plans,  // Planos despagados
                ],
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'validationError',
                'message' => $e->getMessage()
            ], 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to complete the request: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function testApplicationInsert(StoreFullApplicationRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            // Etapa 1: Cria a Application
            $application = FullApplicationActions::createApplication($request->application);
            // Copie os dados da household para uma variável temporária
            $householdData = $request->household;

            // Verifique se os membros da household estão presentes no request
            if (isset($householdData['household_members'])) {
                $householdData['application_id'] = $application['id'];
                // Etapa 2: Cria os membros do Household
                $household = FullApplicationActions::createHousehold($householdData, $application['id']);
            } else {
                throw new \Exception("Household members are missing in the request.");
            }

            // Copie os dados da quotation para uma variável temporária
            $quotationData = $request->quotation;
            $quotationData['application_id'] = $application['id'];
            $quotationData['client_id'] = $application['additional_external_id'];

            // Etapa 3: Cria a cotação (Quotation)
            $quotation = FullApplicationActions::createQuotation($quotationData, $application['id']);


            IntegrationWithCrmJob::dispatch($quotationData);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'application_id' => $application['id']
                ],
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'validationError',
                'message' => $e->getMessage()
            ], 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to complete the request: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function generateQuotationByApplicationId(int $application_id): JsonResponse
    {
        try {
            //Procura a application
            $application = Application::find($application_id);

            if($application){
                //Recupera os dados da quotation
                $application->load(['mainMember']);
                $quotationData = [
                    'income_predicted_amount' => $application->mainMember?->income_predicted_amount??0,
                    'application_id' => $application->id,
                    'client_id' => $application->additional_external_id
                ];

                IntegrationWithCrmJob::dispatch($quotationData);

                return response()->json([
                    'status' => 'success',
                    'data' => 'Quotation dispatched!',
                ]);
            }

            return response()->json([
                'status' => 'failure',
                'message' => 'Could not find application with this ID'
            ], 204);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'validationError',
                'message' => $e->getMessage()
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to complete the request: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getAllPlansByApplication(int $application_id): JsonResponse
    {
        try {
//            $plans = InsurancePlansActions::searchMostAccessiblePlanFiltered($application_id);
            $plans = FullApplicationActions::getAllAccessiblePlans($application_id);

            return response()->json([
                'status' => 'success',
                'data' => $plans,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'validationError',
                'message' => $e->getMessage()
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to complete the request: ' . $e->getMessage(),
            ], 500);
        }
    }
}
