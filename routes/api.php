<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\GeographyController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\TaxHouseholdController;
use App\Http\Controllers\AgentReferralController;
use App\Http\Controllers\InsurancePlansController;
use App\Http\Controllers\FullApplicationController;
use App\Http\Controllers\HouseholdMemberController;
use App\Http\Controllers\IncomeDeductionController;
use App\Http\Controllers\Api\AuthRegisterController;
use App\Http\Controllers\AddressInformationController;
use App\Http\Controllers\Crm2easyIntegrationController;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\AdditionalQuestionController;
use App\Http\Controllers\FinalizeController;
use App\Http\Controllers\MemberInformationController;
use App\Http\Controllers\QuickQuotationController;
use App\Http\Livewire\Index;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\AvailableYearsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/', function () {
    return 'Laravel API ' . app()->version();
});
Route::get('/phpinfo', function () {
    return phpinfo();
});
Route::group(['middleware' => ['forcejson:api']], function () {
    Route::prefix('v1')->name('v1.')->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('/register-email', [AuthController::class, 'register']);
            Route::post('/login-email', [AuthController::class, 'login']);
            Route::post('/firebase-login', [AuthController::class, 'firebaseLogin'])->name('firebase.login');
            

            Route::middleware('auth:sanctum')->group(function () {
                Route::post('/logout', [AuthController::class, 'logout']);
            });
           
        });
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('list', [UserController::class, 'listUsers'])->name('list');
        });
        Route::middleware('auth:sanctum')->group(function () {
            Route::prefix('application')->name('application.')->group(function () {
                Route::post('store/{application_id?}', [ApplicationController::class, 'createOrUpdateApi'])->name('store');
                Route::put('update/{application_id}', [ApplicationController::class, 'updateApplicationApi'])->name('update');
                Route::get('list', [ApplicationController::class, 'list'])->name('list');
                Route::get('show/{application_id}', [ApplicationController::class, 'showApi'])->name('show');
                Route::get('contacts/{application_id}', [ApplicationController::class, 'applicationContacts'])->name('contacts');
                Route::get('addresses/{application_id}', [ApplicationController::class, 'applicationAddresses'])->name('addresses');
                Route::get('households/{application_id}', [ApplicationController::class, 'applicationHouseholds'])->name('households');
                Route::delete('delete/{application_id}', [ApplicationController::class, 'delete'])->name('delete');
                Route::post('update-year/{application_id}', [ApplicationController::class, 'updateYear'])->name('updateYear');
  
            });
            Route::prefix('contact')->name('contact.')->group(function () {
                Route::post('save/{application_id}', [ContactController::class, 'createOrUpdateApi'])->name('save');
                Route::get('show/{contact_id}', [ContactController::class, 'showApi'])->name('show');
            });
            Route::prefix('address')->name('address.')->group(function () {
                Route::post('save/{application_id}', [AddressController::class, 'createOrUpdateApi'])->name('save');
                Route::get('show/{address_id}', [AddressController::class, 'showApi'])->name('show');
            });
            Route::prefix('household')->name('household.')->group(function () {
                Route::prefix('ajax')->name('ajax.')->group(function () {
                    Route::post('store', [HouseholdController::class, 'ajaxCreate'])->name('store');
                    Route::post('store-quotation', [HouseholdController::class, 'ajaxCreateQuotation'])->name('storequotation');
                    Route::put('update/{application_id}', [HouseholdController::class, 'ajaxCreate'])->name('update');
                    Route::put('update-members/{application_id}', [HouseholdController::class, 'updateMembers'])->name('storeMembers');
                    Route::get('delete/{household_member_id}', [HouseholdController::class, 'ajaxDelete'])->name('delete');
                    Route::post('store-quick-quotation', [QuickQuotationController::class, 'storeQuickQuotation'])->name('storequickquotation');
                    Route::post('quick-quotation/{application_id}/add-member', [
                        QuickQuotationController::class,
                        'addMember'
                    ])->name('quick-quotation.add-member');
                    Route::post('deleteHousehold/{application_id}', [HouseholdController::class, 'deleteHouseHoldData'])->name('deleteHouseHoldData');
                });
                Route::apiResource('member', HouseholdMemberController::class)
                    ->parameters([
                        'member' => 'householdMember'
                    ])
                    ->only(['show'])
                ;
            });

            Route::post('create-full-application', [FullApplicationController::class, 'createFullApplication'])->name('fullapplication.create');

            Route::post('create-full-application-test', [FullApplicationController::class, 'testApplicationInsert'])->name('fullapplication.test');

            Route::prefix('relationship')->name('relationship.')->group(function () {
                Route::get('/application/{application_id}', [RelationshipController::class,'returnOtherMembersRelationshipsByApplication'])->name('application');
                Route::post('/store-or-update', [RelationshipController::class,'createOrUpdateRelationships'])->name('storeorupdate');
                Route::get('/list-detail/{domain_value_id}', [RelationshipController::class,'listRelationshipsHaveDetail'])->name('listDetail');
                Route::get('/combo-detail/{domain_value_id}', [RelationshipController::class,'comboForRelationshipDetail'])->name('comboDetail');
                Route::post('deleteRelationshipdata/{application_id}', [RelationshipController::class, 'deleteRelationshipdata'])->name('deleteRelationshipdata');
            });

            Route::prefix('domain')->name('domain.')->group(function () {
                Route::get('show/{alias}', [DomainController::class, 'showApi'])->name('showApi');
            });
            Route::prefix('geography')->name('geography.')->group(function () {
                Route::get('states', [GeographyController::class,'getStates'])->name('states');
                Route::get('counties/{zipcode}', [GeographyController::class,'countiesByZip'])->name('counties');
            });
            Route::prefix('plans')->name('plans.')->group(function () {
                Route::post('search/{application_id}/{page}', [InsurancePlansController::class,'searchPlans'])->name('searchPlans');
                Route::post('most-accessible/{application_id}', [InsurancePlansController::class,'searchMostAccessiblePlan'])->name('mostAccessible');
                Route::post('most-accessibleFiltered/{application_id}', [InsurancePlansController::class,'searchMostAccessiblePlanFiltered'])->name('searchMostAccessiblePlanFiltered');
                Route::get('search/plan-detail/{application_id}/{hios_plan_id}', [InsurancePlansController::class,'searchPlansDetails'])->name('searchPlansDetails');
                Route::post('store',[PlanController::class,'ajaxCreatePlansByApplication'])->name('storePlans');
                Route::get('get-all-plans/{application_id}', [FullApplicationController::class, 'getAllPlansByApplication'])
                    ->name('getAllPlans');
            });
            Route::prefix('tax')->name('tax.')->group(function () {
                Route::get('member/{application_id}', [TaxHouseholdController::class,'recoverNextMember'])->name('nextMember');
                Route::post('fill-first-tax/{application_id}', [TaxHouseholdController::class,'fillFirstHouseholdTaxForm'])->name('fillFirstTax');
                Route::post('deletetaxdata/{application_id}', [TaxHouseholdController::class, 'deleteTaxData'])->name('deleteTaxData');
            });

            Route::prefix('additionalinformation')->name('additionalinformation.')->group(function () {
                Route::post('deleteadditional/{application_id}', [AdditionalInformationController::class, 'deleteAdditionalInformation'])->name('deleteadditional');
                Route::post('fill/{application_id}', [AdditionalInformationController::class,'fillAdditionalInformation'])->name('fill');
            });

            Route::prefix('addinfo')->name('addinfo.')->group(function () { // address information
                Route::post('fill/address/{application_id}', [AddressInformationController::class,'fillAddressInformation'])->name('fillAddress');
            });

            Route::prefix('income')->name('income.')->group(function () {
                Route::post('update-quotation-main-income', [IncomeDeductionController::class,'updateQuotationMainIncome'])->name('quotationMainIncome');
                Route::post('fillIncome/{application_id}', [IncomeDeductionController::class,'fillIncome'])->name('fillIncome');
                Route::get('/list/{application_id}', [IncomeDeductionController::class, 'getIncomeListController'])->name('list');
                Route::get('net-income', [IncomeDeductionController::class, 'getNetIncome'])->name('getNetIncome');
                Route::delete('delete/{application_id}/{income_id}', [IncomeDeductionController::class, 'delete'])->name('delete');
            });

            Route::prefix('additionalQuestion')->name('additionalQuestion.')->group(function () {
                Route::post('store/{application_id}', [AdditionalQuestionController::class,'fillAdditionalQuestion'])->name('store');
            });

            Route::prefix('finallize')->name('finallize.')->group(function () {
                Route::post('store/{application_id}', [FinalizeController::class,'store'])->name('store');
                Route::post('updateMember/{application_id}/{member_id}', [FinalizeController::class,'updateMember'])->name('update');
                Route::post('household-members/update', [FinalizeController::class, 'updateHouseholdMember'])->name('householdFinalize.update');
                Route::post('income/update', [FinalizeController::class, 'updateIncome'])->name('income.update');
            });


            Route::prefix('memberinfo')->name('memberinfo.')->group(function () {
                Route::get('list/{application_id}', [MemberInformationController::class,'recoverMemberInfoList'])->name('list');
                Route::post('store', [MemberInformationController::class, 'storeMemberInformation'])->name('store');
            });

            Route::prefix('agent-referral')->name('agent-referral.')->group(function () {
                Route::get('clients/{agent_id}', [AgentReferralController::class, 'getClientsByAgentId'])
                ->name('clientsByAgentId');
            });
            Route::prefix('crm-2easy')->name('crm-2easy.')->group(function () {
                Route::get('available-stati/{language}', [Crm2easyIntegrationController::class, 'availableStati'])
                    ->name('stati');
                Route::get('client/{client_id}', [Crm2easyIntegrationController::class, 'clientData'])
                    ->name('client');
            });


            // Rota para exibir o PDF em Inglês
            Route::get('gerar-pdf/ingles', function () {
                return view('livewire.pdfIngles');
            })->name('gerar-pdf-ingles');
            Route::get('gerar-pdf/ingles/download', [PdfController::class, 'downloadPdfIngles'])->name('gerar-pdf-ingles-download');

            // Rota para exibir o PDF em Português
            Route::get('gerar-pdf/portugues', function () {
                return view('livewire.pdfPortugues');
            })->name('gerar-pdf-portugues');
            Route::get('gerar-pdf/portugues/download', [PdfController::class, 'downloadPdfPortugues'])->name('gerar-pdf-portugues-download');

            // Rota para exibir o PDF em Espanhol
            Route::get('gerar-pdf/espanhol', function () {
                return view('livewire.pdfEspanhol');
            })->name('gerar-pdf-espanhol');
            Route::get('gerar-pdf/Espanhol/download', [PdfController::class, 'downloadPdfEspanhol'])->name('gerar-pdf-espanhol-download');

            Route::post('/gerar-pdf-plano', [PdfController::class, 'generatePdfFromPlans'])->name('gerar-pdf-plano');

        });
        Route::prefix('register')->name('register.')->group(function () {
            Route::post('/agent', [AuthRegisterController::class, 'registerAgent'])->name('agent.submit');
            Route::post('/client', [AuthRegisterController::class, 'registerClient'])->name('client.submit');
        });

        Route::get('/available-years', [AvailableYearsController::class, 'getAvailableYears'])
            ->name('availableYears');
    });
});


