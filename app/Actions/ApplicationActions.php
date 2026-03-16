<?php

namespace App\Actions;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
//use App\Http\Requests\UpdateHouseholdMembers;
use App\Models\Address;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Household;
use App\Models\HouseholdMember;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ApplicationActions
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
    public static function storeOrUpdateApplication(StoreApplicationRequest $request, $application_id = null): array
    {
        $userId = Auth::id();
        $agent_id = null;
        $client_id = null;
        $application_id = $application_id ? $application_id : null;
        if (UserProfileActions::verifyProfile($userId, ['agent'])) {
            $agent_id = $userId;
        }
        if (UserProfileActions::verifyProfile($userId, ['client'])) {
            $client_id = $userId;
        }

        $appReq = $request->validated();
        $birthdate = Carbon::createFromFormat('m/d/Y', $appReq['birthdate'])->format('Y-m-d');

        // Dados básicos da aplicação
        $appData = [
            'notices_mail_or_email' => $appReq['notices_mail_or_email'] ?? null,
            'send_email' => $appReq['send_email'] ?? null,
            'send_text' => $appReq['send_text'] ?? null,
            'agent_id' => $agent_id,
            'client_id' => $client_id,
            'created_by' => $userId
        ];

        // Se $application_id existe, atualiza; caso contrário, cria nova aplicação
        if ($application_id) {
            $application = Application::findOrFail($application_id);
            $application->update($appData);
        } else {
            $application = Application::create($appData);
        }

        // Dados do membro principal
        $mainMemberData = [
            'application_id' => $application->id,
            'firstname' => $appReq['firstname'] ?? null,
            'middlename' => $appReq['middlename'] ?? null,
            'lastname' => $appReq['lastname'] ?? null,
            'suffix' => $appReq['suffix'] ?? null,
            'birthdate' => $birthdate,
            'sex' => $appReq['sex'] ?? null,
            'has_ssn' => $appReq['has_ssn'] ?? null,
            'ssn' => $appReq['ssn'] ?? null,
            'has_perm_address' => $appReq['has_perm_address'] ?? null,
            'field_type' => self::FIELD_TYPES['applicant'],
            'created_by' => $userId
        ];

        HouseholdMember::updateOrCreate(
            ['application_id' => $application->id, 'field_type' => self::FIELD_TYPES['applicant']],
            $mainMemberData
        );

        // Endereço permanente
        if (isset($appReq['has_perm_address'])) {
            $addData = [
                'household_member_id' => $application->householdMembers()->first()->id,
                'street_address' => $appReq['street_address'] ?? null,
                'apte_ste' => $appReq['apte_ste'] ?? null,
                'city' => $appReq['city'] ?? null,
                'state' => $appReq['state'] ?? null,
                'zipcode' => $appReq['zipcode'] ?? null,
                'county' => $appReq['county'] ?? null,
                'mailing' => false,
                'created_by' => $userId
            ];
            Address::updateOrCreate(['household_member_id' => $application->householdMembers()->first()->id, 'mailing' => false], $addData);
        }

        // Endereço de correspondência
        if (isset($appReq['mailing'])) {
            $mailData = $appReq['mailing'] == 0
                ? [
                    'household_member_id' => $application->householdMembers()->first()->id,
                    'street_address' => $appReq['street_address'] ?? null,
                    'apte_ste' => $appReq['apte_ste'] ?? null,
                    'city' => $appReq['city'] ?? null,
                    'state' => $appReq['state'] ?? null,
                    'zipcode' => $appReq['zipcode'] ?? null,
                    'county' => $appReq['county'] ?? null,
                    'mailing' => true,
                    'created_by' => $userId
                ]
                : [
                    'household_member_id' => $application->householdMembers()->first()->id,
                    'street_address' => $appReq['mail_street_address'] ?? null,
                    'apte_ste' => $appReq['mail_apte_ste'] ?? null,
                    'city' => $appReq['mail_city'] ?? null,
                    'state' => $appReq['mail_state'] ?? null,
                    'zipcode' => $appReq['mail_zipcode'] ?? null,
                    'county' => $appReq['mail_county'] ?? null,
                    'mailing' => true,
                    'created_by' => $userId
                ];

            Address::updateOrCreate(['household_member_id' => $application->householdMembers()->first()->id, 'mailing' => true], $mailData);
        }

        // Dados de contato
        $contactData = [
            'application_id' => $application->id,
            'email' => $appReq['email'] ?? null,
            'phone' => $appReq['phone'] ?? null,
            'extension' => $appReq['extension'] ?? null,
            'type' => $appReq['type'] ?? null,
            'second_phone' => $appReq['second_phone'] ?? null,
            'second_extension' => $appReq['second_extension'] ?? null,
            'second_type' => $appReq['second_type'] ?? null,
            'written_lang' => $appReq['written_lang'] ?? null,
            'spoken_lang' => $appReq['spoken_lang'] ?? null,
            'created_by' => $userId
        ];

        Contact::updateOrCreate(['application_id' => $application->id], $contactData);

        return $application->load(['contact'])->toArray();
    }


    public static function listApplications(): array
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $builder = HouseholdMember::with('application')
            ->where('field_type', 0)
            ->orderBy('id', 'desc');

        if (isset($user->is_admin) && !$user->is_admin) {
            if (UserProfileActions::verifyProfile($userId, ['agent'])) {
                $builder->whereHas('application', function ($query) use ($userId) {
                    $query->where('agent_id', '=', $userId)
                        ->orWhere('client_id', '=', $userId);
                });
            } elseif (UserProfileActions::verifyProfile($userId, ['client'])) {
                $builder->whereHas('application', function ($query) use ($userId) {
                    $query->where('client_id', '=', $userId);
                });
            }
        }

        return $builder->get()->toArray();
    }
    public static function listApplicationsPaginate()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // Se o usuário for admin, traz todas as aplicações com os relacionamentos
        if (isset($user->is_admin) && $user->is_admin) {
            // Aqui garantimos que o resultado será paginado
            return HouseholdMember::with('application')
                ->where('field_type', 0)
                ->orderBy('id', 'desc')
                ->paginate(10); // Retornando objeto paginado
        }

        // Caso o usuário não seja admin, retorna consulta filtrada
        $builder = HouseholdMember::with('application')
            ->where('field_type', 0)
            ->orderBy('id', 'desc');

        if (UserProfileActions::verifyProfile($userId, ['agent'])) {
            $builder->whereHas('application', function ($query) use ($userId) {
                $query->where('agent_id', '=', $userId)
                    ->orWhere('client_id', '=', $userId);
            });
        } elseif (UserProfileActions::verifyProfile($userId, ['client'])) {
            $builder->whereHas('application', function ($query) use ($userId) {
                $query->where('client_id', '=', $userId);
            });
        }

        return $builder->paginate(10); // Garantindo paginação
    }


    public static function getApplicationByid($id): mixed
    {
        $builder = Application::orderBy('id', 'asc');
        $userId = Auth::id();
        $user =  User::find($userId);
        if (isset($user->is_admin)) {
            if (!$user->is_admin) {
                if (UserProfileActions::verifyProfile($userId, ['agent'])) {
                    $builder->where('agent_id', '=', $userId)->orWhere('client_id', '=', $userId);
                }
                if (UserProfileActions::verifyProfile($userId, ['client']) && (!UserProfileActions::verifyProfile($userId, ['agent']))) {
                    $builder->where('client_id', '=', $userId);
                }
            }
        }
        $application = $builder->where('id', $id)->first();
        if ($application == null) {
            return false;
        }
        return $application->load([
            'contact',
            'mainMember',
            'householdMembers',
            'householdApplicants',
            'householdTaxMembers',
            'householdAdditionalMembers',
            'householdChiefs'
        ]);
    }

    public static function getApplicantNameByid($id, bool $suffix = true, bool $middlename = false): string
    {
        $householdMember = HouseholdMember::where('application_id', $id)->where('field_type', self::FIELD_TYPES['applicant'])->first();
        //        dd($householdMember->toArray());
        // return $householdMember->firstname. ((($middlename)?' '.$householdMember->middlename:'')).' '.$householdMember->lastname.((($suffix&&isset($householdMember->suffix)))?' '.$householdMember->suffix->name:'');
        return $householdMember->firstname .
            (($middlename) ? ' ' . $householdMember->middlename : '') .
            ' ' . $householdMember->lastname .
            (($suffix && isset($householdMember->suffix['name'])) ? ' ' . $householdMember->suffix['name'] : '');
    }

    /**
     * @throws Exception
     */
    public static function updateApplication(StoreApplicationRequest $request, int $applicationId): array
    {
        $userId = Auth::id();
        $agent_id = null;
        $client_id = null;
        if (UserProfileActions::verifyProfile($userId, ['agent'])) {
            $agent_id = $userId;
        }
        if (UserProfileActions::verifyProfile($userId, ['client'])) {
            $client_id = $userId;
        }
        $appReq = $request->validated();
        $application = Application::find($applicationId);
        if ($application) {
            $birthdate = Carbon::createFromFormat('m/d/Y', $appReq['birthdate']);
            $birthdate = $birthdate->format('Y-m-d');
            $appData = [
                'firstname' => $appReq['firstname'],
                'middlename' => $appReq['middlename'] ?? null,
                'lastname' => $appReq['lastname'],
                'suffix' => $appReq['suffix'] ?? null,
                'birthdate' => $birthdate,
                'sex' => $appReq['sex'],
                'has_ssn' => $appReq['has_ssn'],
                'ssn' => $appReq['ssn'] ?? null,
                'has_perm_address' => $appReq['has_perm_address'],
                'notices_mail_or_email' => $appReq['notices_mail_or_email'],
                'send_email' => $appReq['send_email'] ?? null,
                'send_text' => $appReq['send_text'] ?? null,
                'agent_id' => $agent_id,
                'client_id' => $client_id,
                'created_by' => $userId,
            ];
            if ($application->update($appData)) {
                // Atualiza o endereço principal
                $address = Address::where('application_id', $application->id)->where('mailing', false)->first();
                if ($address) {
                    $addData = [
                        'application_id' => $application->id,
                        'street_address' => $appReq['street_address'],
                        'apte_ste' => $appReq['apte_ste'] ?? null,
                        'city' => $appReq['city'],
                        'state' => $appReq['state'],
                        'zipcode' => $appReq['zipcode'],
                        'county' => $appReq['county'],
                        'mailing' => false,
                        'created_by' => $userId,
                    ];
                    $address->update($addData);
                }

                // Verifica e atualiza o endereço de correspondência
                if (isset($appReq['mailing'])) {
                    $mailAddress = Address::where('application_id', $application->id)->where('mailing', true)->first();

                    if ($mailAddress) {
                        if ($appReq['mailing'] == 0) {
                            // Copia os dados do endereço principal
                            $mailData = [
                                'application_id' => $application->id,
                                'street_address' => $appReq['street_address'],
                                'apte_ste' => $appReq['apte_ste'] ?? null,
                                'city' => $appReq['city'],
                                'state' => $appReq['state'],
                                'zipcode' => $appReq['zipcode'],
                                'county' => $appReq['county'],
                                'mailing' => true,
                                'created_by' => $userId,
                            ];
                        } else {
                            // Usa os dados fornecidos para o endereço de correspondência
                            $mailData = [
                                'application_id' => $application->id,
                                'street_address' => $appReq['mail_street_address'] ?? $appReq['street_address'],
                                'apte_ste' => $appReq['mail_apte_ste'] ?? $appReq['apte_ste'],
                                'city' => $appReq['mail_city'] ?? $appReq['city'],
                                'state' => $appReq['mail_state'] ?? $appReq['state'],
                                'zipcode' => $appReq['mail_zipcode'] ?? $appReq['zipcode'],
                                'county' => $appReq['mail_county'] ?? $appReq['county'],
                                'mailing' => true,
                                'created_by' => $userId,
                            ];
                        }
                        $mailAddress->update($mailData);
                    }
                }

                $contact = Contact::where('application_id', $application->id)->first();
                if ($contact) {
                    $contactData = [
                        'application_id' => $application->id,
                        'email' => $appReq['email'] ?? null,
                        'phone' => $appReq['phone'],
                        'extension' => $appReq['extension'] ?? null,
                        'type' => $appReq['type'],
                        'second_phone' => $appReq['second_phone'] ?? null,
                        'second_extension' => $appReq['second_extension'] ?? null,
                        'second_type' => $appReq['second_type'] ?? null,
                        'written_lang' => $appReq['written_lang'],
                        'spoken_lang' => $appReq['spoken_lang'],
                        'created_by' => $userId
                    ];
                    $contact->update($contactData);
                }
            }
            return $application->load(['address', 'mailAddress', 'contact', 'suffixModel', 'sexModel', 'household'])->toArray();
        }
        return array();
    }
    /**
     * @throws Exception
     */
    public static function updateApplicationApi(UpdateApplicationRequest $request, int $applicationId): array
    {
        $userId = Auth::id();
        $agent_id = null;
        $client_id = null;
        if (UserProfileActions::verifyProfile($userId, ['agent'])) {
            $agent_id = $userId;
        }
        if (UserProfileActions::verifyProfile($userId, ['client'])) {
            $client_id = $userId;
        }
        $appReq = $request->validated();
        $application = Application::find($applicationId);
        if ($application) {
            $birthdate = Carbon::createFromFormat('m/d/Y', $appReq['birthdate']);
            $birthdate = $birthdate->format('Y-m-d');
            $appData = [
                'firstname' => $appReq['firstname'],
                'middlename' => $appReq['middlename'] ?? null,
                'lastname' => $appReq['lastname'],
                'suffix' => $appReq['suffix'] ?? null,
                'birthdate' => $birthdate,
                'sex' => $appReq['sex'],
                'has_ssn' => $appReq['has_ssn'],
                'ssn' => $appReq['ssn'] ?? null,
                'has_perm_address' => $appReq['has_perm_address'],
                'notices_mail_or_email' => $appReq['notices_mail_or_email'],
                'send_email' => $appReq['send_email'] ?? null,
                'send_text' => $appReq['send_text'] ?? null,
                'agent_id' => $agent_id,
                'client_id' => $client_id,
                'created_by' => $userId,
                'year' => $appReq['year'] ?? null
            ];
            $application->update($appData);
            return $application->toArray();
        }
        return array();
    }

    public static function deleteApplication(int $applicationId): bool
    {
        $application = Application::find($applicationId);

        if (!$application) {
            return false;
        }

        DB::beginTransaction();
        try {
            // Deletar Household Members e seus dados relacionados
            if ($application->householdMembers()->count() > 0) {
                foreach ($application->householdMembers as $member) {
                    // Atualiza referencias para evitar erros de chave estrangeira
                    HouseholdMember::where('jointly_taxed_spouse', $member->id)->update(['jointly_taxed_spouse' => 0]);
                    HouseholdMember::where('lives_with', $member->id)->update(['lives_with' => null]);
                    HouseholdMember::where('tax_claimant', $member->id)->update(['tax_claimant' => null]);

                    // Deleta Endereços do membro se existirem
                    if ($member->address) {
                        $member->address->delete();
                    }
                    if ($member->mailAddress) {
                        $member->mailAddress->delete();
                    }

                    // Deleta Incomes and Deductions se existirem
                    if ($member->incomesAndDeductions()->count() > 0) {
                        $member->incomesAndDeductions()->delete();
                    }

                    // Deleta Relacionamentos se existirem
                    if ($member->relatedTo()->count() > 0) {
                        $member->relatedTo()->delete();
                    }
                    if ($member->relatedFrom()->count() > 0) {
                        $member->relatedFrom()->delete();
                    }

                    // Deleta o próprio membro
                    $member->delete();
                }
            }

            // Deleta Contact se existir
            if ($application->contact) {
                $application->contact->delete();
            }

            // Deleta Planos se existirem
            if ($application->plans()->count() > 0) {
                $application->plans()->delete();
            }

            // Deleta Agent Referrals se existirem
            if ($application->agentReferrals()->count() > 0) {
                $application->agentReferrals()->delete();
            }

            // Finalmente, deleta a própria Application
            $application->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erro ao excluir aplicação com ID {$applicationId}: " . $e->getMessage());
            return false;
        }
    }





    public static function getContactsByAppId($application_id): array
    {
        $contacts = Contact::where('application_id', $application_id)->get();
        if ($contacts) {
            return $contacts->toArray();
        }
        return array();
    }

    public static function getAddressesByMemberId($member_id): array
    {
        $addresses = Address::where('household_member_id', $member_id)->get();
        if ($addresses) {
            return $addresses->toArray();
        }
        return array();
    }

    public static function getHouseholdsByAppId($application_id): array
    {
        $households = Household::where('application_id', $application_id)->get();
        if ($households) {
            return $households->toArray();
        }
        return array();
    }


    public static function updateNumberMembers(int $applicationId, int $householdNumber)
    {
        $application = Application::findOrFail($applicationId);

        if ($householdNumber < 1) {
            throw ValidationException::withMessages([
                'override_household_number' => 'The household number must be greater than zero.'
            ]);
        }

        $application->override_household_number = $householdNumber;
        $application->save();

        return $application->fresh(['householdMembers']); // Retorna a aplicação atualizada com os membros
    }

    /**
     * Atualiza o ano da aplicação
     */
    public static function updateApplicationYear(int $applicationId, array $data)
    {
        $userId = Auth::id();

        if (!isset($data['year'])) {
            throw new \InvalidArgumentException('Year field is required');
        }

        $year = (int) $data['year'];
        $currentYear = date('Y');

        // Validação do ano
        if ($year < 2020 || $year > $currentYear + 2) {
            throw ValidationException::withMessages([
                'year' => "The year must be between 2020 and " . ($currentYear + 2) . "."
            ]);
        }

        $application = Application::findOrFail($applicationId);

        // Atualiza apenas o campo year
        $application->update([
            'year' => $year,
            'updated_at' => now()
        ]);

        Log::info('Application year updated', [
            'application_id' => $applicationId,
            'previous_year' => $application->getOriginal('year'),
            'new_year' => $year,
            'updated_by' => $userId,
            'timestamp' => now()
        ]);

        return $application->fresh();
    }
}
