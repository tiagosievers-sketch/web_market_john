<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\Application;
use App\Models\Contact;
use App\Models\HouseholdMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuickQuotationActions
{
    public static function storeQuotationData(Request $request)
    {
        // Valida e coleta os dados
        $data = $request->validated();
        $userId = Auth::id();


        $agent_id = null;
        $client_id = null;
        if (UserProfileActions::verifyProfile($userId, ['agent'])) {
            $agent_id = $userId;
        }
        if (UserProfileActions::verifyProfile($userId, ['client'])) {
            $client_id = $userId;
        }
        $application = Application::create([
            'created_by' => $userId,
            'send_email' => $data['mainUser']['send_email'] ?? false,
            'send_text' => $data['mainUser']['send_text'] ?? false,
            'external_id' => $data['mainUser']['external_id'] ?? null,
            'additional_external_id' => $data['mainUser']['additional_external_id'] ?? null,
            'external_agent' => $data['mainUser']['external_agent'] ?? null,
            'notices_mail_or_email' => $data['mainUser']['notices_mail_or_email'] ?? null,
            'fast_application' => 1,
            'agent_id' => $agent_id,
            'client_id' => $client_id,
            'year' => isset($data['mainUser']['year']) ? (int) $data['mainUser']['year'] : null,

            //dados quotation
            'dados_da_application' => [[
                'type' => 'application_created',
                'created_by' => $userId,
                'created_at' => now()->toISOString(),
            ]],
            'ultima_quotation' => [
                'status' => 'initialized',
                'created_at' => now()->toISOString(),
            ],

        ]);
        // (guarde as datas originais p/ webhook)
        $rawMainBirth   = $data['mainUser']['birthdate'] ?? null;
        $rawSpouseBirth = !empty($data['spouse']['birthdate']) ? $data['spouse']['birthdate'] : null;


        // Cria o membro principal da aplicação
        $mainUser = $data['mainUser'];
        $mainUser['birthdate'] = Carbon::createFromFormat('m/d/Y', $mainUser['birthdate'])->format('Y-m-d');
        unset($mainUser['year']);
        $mainMember = HouseholdMember::create(array_merge($mainUser, [
            'application_id' => $application->id,
            'field_type' => 0,
            'created_by' => $userId,
            'is_pregnant' => $mainUser['pregnant'] ?? false,
            'taking_care_under_nineteen' => $mainUser['parent_of_child_under_19'] ?? false,
        ]));

        // Verifica e cria o spouse se os dados existirem
        if (!empty($data['spouse'])) {
            $spouse = $data['spouse'];
            $spouse['birthdate'] = Carbon::createFromFormat('m/d/Y', $spouse['birthdate'])->format('Y-m-d');
            HouseholdMember::create(array_merge($spouse, [
                'application_id' => $application->id,
                'field_type' => 1,
                'created_by' => $userId,
                'is_pregnant' => $spouse['pregnant'] ?? false,
                'taking_care_under_nineteen' => $spouse['parent_of_child_under_19'] ?? false,
            ]));
        }

        // Cria dependentes, se existirem
        if (!empty($data['dependents'])) {
            foreach ($data['dependents'] as $dependent) {
                $dependent['birthdate'] = Carbon::createFromFormat('m/d/Y', $dependent['birthdate'])->format('Y-m-d');
                HouseholdMember::create(array_merge($dependent, [
                    'application_id' => $application->id,
                    'field_type' => 6,
                    'created_by' => $userId,
                    'is_pregnant' => $dependent['pregnant'] ?? false,
                    'taking_care_under_nineteen' => $dependent['parent_of_child_under_19'] ?? false,
                ]));
            }
        }

        // Verifica se o endereço está presente e cria o Address
        Address::create([
            'household_member_id' => $mainMember->id,
            'zipcode' => $data['mainUser']['zipcode'],
            'county' => $data['mainUser']['county'],
            'mailing' => 0,
            'created_by' => $userId,
        ]);


        // Verifica se os campos de contato estão presentes e cria o Contact
        Contact::create([
            'application_id' => $application->id,
            'written_lang' => $data['mainUser']['written_lang'] ?? 4,
            'spoken_lang' => $data['mainUser']['spoken_lang'] ?? 4,
            'created_by' => $userId
        ]);

        // ====== MONTA O PAYLOADDO WEBHOOK ======
        $payloadDados = [];

        // main_member
        $payloadDados[] = [
            'role'                   => 'main_member',
            'firstname'              => $data['mainUser']['firstname'] ?? null,
            'lastname'               => $data['mainUser']['lastname'] ?? null,
            'birthdate'              => $rawMainBirth,
            'sex'                    => $data['mainUser']['sex'] ?? null,
            'use_tobacco'            => (int)($data['mainUser']['tobacco'] ?? 0),
            'notices_mail_or_email'  => (bool)($data['mainUser']['notices_mail_or_email'] ?? false),
            'income_predicted_amount' => $data['mainUser']['income_predicted_amount'] ?? null,
            'spoken_lang'            => $data['mainUser']['spoken_lang'] ?? 4,
            'written_lang'           => $data['mainUser']['written_lang'] ?? 4,
            'county'                 => $data['mainUser']['county'] ?? null,
            'zipcode'                => $data['mainUser']['zipcode'] ?? null,
        ];

        // spouse
        if (!empty($data['spouse'])) {
            $sp = $data['spouse'];
            $payloadDados[] = [
                'role'         => 'spouse',
                'id'           => $sp['id'] ?? ('spouse-' . now()->timestamp),
                'birthdate'    => $rawSpouseBirth,
                'relationship' => $sp['relationship'] ?? null,
                'sex'          => $sp['sex'] ?? null,
                'use_tobacco'  => (int)($sp['tobacco'] ?? 0),
            ];
        }

        // dependents
        if (!empty($data['dependents'])) {
            foreach ($data['dependents'] as $i => $dep) {
                $payloadDados[] = [
                    'role'         => 'dependent',
                    'id'           => $dep['id'] ?? ('dep-' . ($dep['external_id'] ?? ($i + 1)) . '-' . now()->timestamp),
                    'firstname'    => $dep['firstname'] ?? null,
                    'lastname'     => $dep['lastname'] ?? null,
                    'birthdate'    => $dep['birthdate'] ?? null,
                    'relationship' => $dep['relationship'] ?? null,
                    'sex'          => $dep['sex'] ?? null,
                    'use_tobacco'  => (int)($dep['tobacco'] ?? 0),
                ];
            }
        }

        $payload = [
            'dados_da_application' => $payloadDados,
            'ultima_quotation'     => [],
        ];

        // envia webhook com payload custom
        self::sendQuotationWebhook($application, $payload);

        // Retorna o número da aplicação para uso posterior
        return $application->id;
    }


    public static function addMember(Request $request, $applicationId)
    {
        $data = $request->validate([
            'field_type' => 'required|integer', // 1 para spouse e 6 para dependent
            'birthdate' => 'required|date_format:m/d/Y',
            'tobacco' => 'required|boolean',
            'sex' => 'integer|required|exists:domain_values,id'
        ]);


        $userId = Auth::id();
        $data['birthdate'] = Carbon::createFromFormat('m/d/Y', $data['birthdate'])->format('Y-m-d');

        // Verificar se já existe um spouse (field_type == 1) caso esteja adicionando um spouse
        if ($data['field_type'] == 1 && HouseholdMember::where('application_id', $applicationId)->where('field_type', 1)->exists()) {
            return ['status' => 'error', 'message' => 'Já existe um spouse cadastrado.'];
        }

        // Criar o membro
        $householdMember = HouseholdMember::create(array_merge($data, [
            'application_id' => $applicationId,
            'created_by' => $userId
        ]));

        $application = $householdMember->application();
        $application->update(['override_household_number' => null]);

        return ['status' => 'success', 'message' => 'Success!'];
    }

    // Função para remover um membro (dependent ou spouse)
    public static function removeMember($applicationId, $memberId)
    {
        // Encontra o membro e remove seus relacionamentos antes de deletar o membro
        $member = HouseholdMember::where('application_id', $applicationId)->findOrFail($memberId);

        $application = $member->application();

        // Apaga todos os relacionamentos associados ao membro antes de deletá-lo
        $member->relationships()->delete();

        // Agora, deleta o próprio member
        $member->delete();
        $application->update(['override_household_number' => null]);

        return ['status' => 'success', 'message' => 'Success!'];
    }

    /**
     * Envia os dados da "quotation" para a URL configurada no .env
     */
    protected static function sendQuotationWebhook(Application $application, array $payload = null): void
    {
        $url = (string) config('railway2easy.url', '');

        if (empty($url)) {
            Log::info('Quotation webhook não enviado: URL ausente.', [
                'application_id' => $application->id,
            ]);
            return;
        }

        if ($payload === null) {
            $payload = [
                'dados_application' => [],
                'ultima_quotation'  => [],
            ];
        }

        try {
            $response = Http::timeout(10)
                ->retry(2, 500)
                ->acceptJson()
                ->asJson()
                ->post($url, $payload);

            if ($response->failed()) {
                Log::error('Falha ao enviar quotation webhook', [
                    'application_id' => $application->id,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Exceção no envio do quotation webhook', [
                'application_id' => $application->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
