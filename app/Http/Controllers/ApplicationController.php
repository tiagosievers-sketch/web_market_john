<?php

namespace App\Http\Controllers;

use App\Actions\ApplicationActions;
use App\Actions\HouseholdActions;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Contact;
use App\Models\HouseholdMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    /**
     * @throws \Exception
     */
    public function createOrUpdate(StoreApplicationRequest $request, int $application_id = null): RedirectResponse
    {
        try {
            $application = ApplicationActions::storeOrUpdateApplication($request, $application_id);

            // Obtenha a URL de origem
            $previousUrl = url()->previous();

            // Verifique de qual rota veio e redirecione apropriadamente
            if (strpos($previousUrl, 'primary-contact') !== false && strpos($previousUrl, 'primary-contact-quotation') === false) {
                // Se veio da rota 'primary-contact.route'
                return redirect()->route('livewire.household', $application['id']);
            } else {
                // Redirecionamento fluxo reduzido
                return redirect()->route('livewire.household-quotation', $application['id']);
            }
        } catch (\Exception $e) {
            // Manipulação de erro
            dd($e->getMessage());
            //return redirect()->route('index')->withErrors($e->getMessage());
        }
    }


    /**
     * @throws \Exception
     */
    public function update(StoreApplicationRequest $request, int $application_id): RedirectResponse
    {
        try {
            $application = ApplicationActions::updateApplication($request, $application_id);
            // dd($application);
            return redirect()->route('livewire.household-edit', $application['id']);
        } catch (\Exception $e) {
            //           dd($e->getMessage());
            return redirect()->route('livewire.primary-contact-edit', $application_id)->withErrors($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function list(Request $request): JsonResponse
    {
        try {
            // 1) Autenticação (evita acessar propriedade em $user = null)
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'status'  => 'unauthorized',
                    'message' => 'Auth required.',
                ], 401);
            }

            $applications = ApplicationActions::listApplications($request);

            if (empty($applications)) {
                if (!empty($user->is_admin) && $user->is_admin) {
                    $applications = Application::query()
                        ->select(['id', 'user_id', 'created_at', 'updated_at'])
                        ->get();
                } else {
                    $applications = Application::query()
                        ->where('user_id', $user->id)
                        ->select(['id', 'user_id', 'created_at', 'updated_at'])
                        ->get();
                }
            }
            $payload = collect($applications)->map(function ($row) {

                $arr = is_array($row) ? $row : $row->toArray();
                return [
                    'id'         => $arr['application_id'] ?? $arr['id'] ?? null,
                    'firstname'  => $arr['firstname']  ?? null,
                    'middlename' => $arr['middlename'] ?? null,
                    'lastname'   => $arr['lastname']   ?? null,
                    'ssn'        => $arr['ssn']        ?? null,
                ];
            })->values();

            return response()->json(
                [
                    'status' => 'success',
                    'data'   => $payload,
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
            );
        } catch (\Throwable $e) {
            Log::error('Error on /api/v1/application/list', [
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'It was not possible to recover applications list.',
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function delete(Request $request, int $application_id): JsonResponse
    {
        try {
            $success = ApplicationActions::deleteApplication($application_id);

            if ($success) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Application Deleted',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Could not delete the application.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to delete the application.',
            ], 500);
        }
    }


    /**
     * @throws \Exception
     */
    public function createOrUpdateApi(StoreApplicationRequest $request, int $application_id = null): JsonResponse
    {

        try {
            // dd($request);
            $application = ApplicationActions::storeOrUpdateApplication($request, $application_id);
            return response()->json([
                'status' => 'success',
                'data' => $application,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'validationError',
                'message' => $e->getMessage()
            ], 202);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function showApi(Request $request, int $application_id): JsonResponse
    {
        try {
            $application = ApplicationActions::getApplicationByid($application_id);
            if ($application) {
                return response()->json([
                    'status' => 'success',
                    'data' => $application,
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * @throws \Exception
     */
    public function updateApplicationApi(UpdateApplicationRequest $request, int $application_id): JsonResponse
    {
        try {
            $application = ApplicationActions::updateApplicationApi($request, $application_id);
            if ($application) {
                return response()->json([
                    'status' => 'success',
                    'data' => $application,
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application1.'
            ], 500);
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function applicationContacts(Request $request, int $application_id): JsonResponse
    {
        try {
            $contacts = ApplicationActions::getContactsByAppId($application_id);
            return response()->json([
                'status' => 'success',
                'data' => $contacts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function applicationAddresses(Request $request, int $application_id): JsonResponse
    {
        try {
            $addresses = ApplicationActions::getAddressesByAppId($application_id);
            return response()->json([
                'status' => 'success',
                'data' => $addresses,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function applicationHouseholds(Request $request, int $application_id): JsonResponse
    {
        try {
            $households = ApplicationActions::getHouseholdsByAppId($application_id);
            return response()->json([
                'status' => 'success',
                'data' => $households,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function applicationPlans(Request $request, int $application_id): JsonResponse
    {
        try {
            $households = ApplicationActions::getHouseholdsByAppId($application_id);
            return response()->json([
                'status' => 'success',
                'data' => $households,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'It was not possible to recover application.'
            ], 500);
        }
    }


    public function deleteApplicationAndRelations($applicationId)
    {
        // Encontra a aplicação pelo ID
        $application = Application::findOrFail($applicationId);

        // Inicia a transação para garantir que todos os dados sejam deletados ou que a operação seja revertida em caso de erro
        DB::beginTransaction();

        try {
            // Deleta Household Members (dependents e spouse)
            HouseholdMember::where('application_id', $applicationId)->delete();

            // Deleta Address relacionado aos membros do Household
            Address::whereIn('household_member_id', function ($query) use ($applicationId) {
                $query->select('id')
                    ->from('household_members')
                    ->where('application_id', $applicationId);
            })->delete();

            // Deleta os contatos relacionados à aplicação
            Contact::where('application_id', $applicationId)->delete();

            // Deleta a própria aplicação
            $application->delete();

            // Confirma a transação
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Aplicação e todos os dados relacionados foram deletados com sucesso.'
            ]);
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao deletar a aplicação: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateHouseholdNumber(Request $request, $applicationId): JsonResponse
    {
        try {
            $householdData = $request->validate([
                'override_household_number' => 'required|integer|min:1',
            ]);

            $updatedHousehold = ApplicationActions::updateNumberMembers(
                $applicationId,
                $householdData['override_household_number']
            );

            return response()->json([
                'status' => 'success',
                'data' => $updatedHousehold,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update household number. ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Atualiza o ano da aplicação usando ApplicationActions
     */
    public function updateYear(Request $request, $application_id)
    {
        Log::info('DEBUG updateYear - Iniciando', [
            'application_id' => $application_id,
            'year_request' => $request->year,
            'full_url' => $request->fullUrl()
        ]);

        try {
            $request->validate([
                'year' => 'required|integer|min:2020|max:' . (date('Y') + 2)
            ]);

            Log::info('DEBUG updateYear - Chamando ApplicationActions');

            $application = ApplicationActions::updateApplicationYear(
                $application_id,
                ['year' => $request->year]
            );

            Log::info('DEBUG updateYear - Sucesso');

            return response()->json([
                'status' => 'success',
                'message' => 'Ano atualizado com sucesso'
            ]);
        } catch (\Exception $e) {
            Log::error('DEBUG updateYear - Erro', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }
}

