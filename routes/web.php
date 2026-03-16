<?php

use App\Http\Livewire\Tax;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\AdditionalQuestionController;
use App\Http\Controllers\AddressInformationController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\IncomeDeductionController;
use App\Http\Controllers\InsurancePlansController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TaxHouseholdController;
use App\Http\Livewire\Index;
use App\Http\Livewire\Income;
use App\Http\Livewire\Signin;
use App\Http\Livewire\Members;
use App\Http\Livewire\Finalize;
use App\Http\Livewire\FormStart;
use App\Http\Livewire\Household;
use App\Http\Livewire\Quotation;
use App\Http\Livewire\UserProfile;
use App\Http\Livewire\Relationship;
use App\Http\Livewire\PrimaryContact;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\FormHomeAddress;
use App\Http\Livewire\QuotationDetail;
use App\Http\Controllers\IDMController;
use App\Http\Livewire\ViewDataQuotation;
use App\Http\Livewire\AdditionalQuestion;
use App\Http\Livewire\FormContactdetails;
use App\Http\Livewire\HouseholdQuotation;
use App\Http\Livewire\PrimaryContactEdit;
use App\Http\Livewire\PrivacyInformation;
use App\Http\Livewire\AdditionalInformation;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\GeographyController;
use App\Http\Controllers\HouseholdController;
use App\Http\Livewire\PrimaryContactQuotation;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\AgentReferralController;
use App\Http\Controllers\FinalizeController;
use App\Http\Controllers\MemberInformationController;
use App\Http\Controllers\QuickQuotationController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\AdditionalQuestionEdit;
use App\Http\Livewire\AddressesApplicant;
use App\Http\Livewire\AddressesApplicantEdit;
use App\Http\Livewire\IncomeEdit;
use App\Http\Livewire\MembersEdit;
use App\Http\Livewire\QuickQuotation;

Route::get('', function () {
    return redirect('/index');
});
Route::get('login', Signin::class)->name('login');
Route::prefix('localization')->name('localization.')->group(function () {
    Route::get('change/{locale}', [LocalizationController::class, 'changeLocalization'])->name('change');
    Route::get('list', [LocalizationController::class, 'listLocalization'])->name('list');
});

Route::prefix('auth')->name('auth.')->group(function () {

    // Rotas do Facebook
    Route::prefix('facebook')->name('facebook.')->group(function () {
        Route::get('/', [Index::class, 'redirectToMeta'])->name('login');
        Route::get('callback', [Index::class, 'handleMetaCallback'])->name('callback');
    });

    Route::get('/login', [AuthLoginController::class, 'index'])->name('login.form');



    // Rota para login padrão
    Route::post('/login', [AuthLoginController::class, 'login'])->name('login');

    // Rotas do Google
    Route::prefix('google')->name('google.')->group(function () {
        Route::get('login', [Index::class, 'redirectToGoogle'])->name('login'); // Redireciona para o login do Google
        Route::get('callback', [Index::class, 'handleGoogleCallback'])->name('callback'); // Callback do Google
    });

    // Rotas do Meta (Facebook)
    Route::prefix('meta')->name('meta.')->group(function () {
        Route::get('callback', [Index::class, 'handleMetaCallback'])->name('callback');
    });
});

Route::middleware([
    'auth'
])->group(function () {
    Route::get('index', Index::class)->name('index');
    Route::get('logout', [AuthLoginController::class, 'logout'])->name('logout');
    Route::get('form-start', FormStart::class)->name('livewire.form-start');
    Route::get('primary-contact-edit/{application_id}', PrimaryContactEdit::class)->name('livewire.primary-contact-edit');
    Route::get('additional-information/{application_id}', AdditionalInformation::class)->name('livewire.additional-information');

    Route::get('/agent-referrals', [AgentReferralController::class, 'getAgentClients'])->name('agent.referrals');
    Route::get('additional-question/{application_id}', AdditionalQuestion::class)->name('livewire.additional-question');
    Route::get('additional-question-edit/{application_id}', AdditionalQuestionEdit::class)->name('livewire.additional-question-edit');
    Route::get('income/{application_id}', Income::class)->name('livewire.income');
    Route::get('income-edit/{application_id}', IncomeEdit::class)->name('livewire.income-edit');
    Route::get('privacy-information', PrivacyInformation::class)->name('livewire.privacy-information');
    Route::get('primary-contact', PrimaryContact::class)->name('livewire.primary-contact');
    Route::get('primary-contact-quotation', PrimaryContactQuotation::class)->name('livewire.primary-contact-quotation');
    Route::get('form-home-address', FormHomeAddress::class);
    Route::get('form-contactdetails', FormContactdetails::class);
    Route::get('household/{application_id}', Household::class)->name('livewire.household');
    Route::get('tax/{application_id}', Tax::class)->name('livewire.tax');
    Route::get('household-quotation/{application_id}', HouseholdQuotation::class)->name('livewire.household-quotation');
    Route::get('quotation/{application_id}', Quotation::class)->name('livewire.quotation');
    Route::get('view-data-quotation/{application_id}', ViewDataQuotation::class)->name('livewire.view-data-quotation');
    Route::get('quotation-detail/{application_id}/{plan_id}/{premium}', QuotationDetail::class)->name('livewire.quotation-detail');
    Route::get('members/{application_id}', Members::class)->name('livewire.members');
    Route::get('members-edit/{application_id}', MembersEdit::class)->name('livewire.members-edit');
    Route::get('finalizeMember/{application_id}', Finalize::class)->name('livewire.finalize');
    Route::get('relationship/{application_id}', Relationship::class)->name('livewire.relationship');
    Route::get('/user/profile', UserProfile::class)->name('user.profile');
    Route::get('address-applicant/{application_id}', AddressesApplicant::class)->name('livewire.address-applicant');
    Route::get('address-applicant-edit/{application_id}', AddressesApplicantEdit::class)->name('livewire.address-applicant-edit');
    Route::get('/quick-quotation', QuickQuotation::class)->name('quickQuotation');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile/image', [UserController::class, 'deleteImage'])->name('profile.image.delete');


    // Route::get('household-edit/{application_id}', HouseholdEdit::class)->name('livewire.household-edit');

    Route::get('/agent/{agent_id}/clients', [AgentReferralController::class, 'getClientsByAgentId'])->name('agent.clients');

    Route::prefix('geography')->name('geography.')->group(function () {
        Route::get('counties/{zipcode}', [GeographyController::class, 'countiesByZip'])->name('counties');
    });
    Route::prefix('application')->name('application.')->group(function () {
        Route::post('store/{application_id?}', [ApplicationController::class, 'createOrUpdate'])->name('store');
        Route::get('list', [ApplicationController::class, 'list'])->name('list');
        Route::delete('delete/{application_id}', [ApplicationController::class, 'delete'])->name('delete');
        Route::put('update/{application_id}', [ApplicationController::class, 'update'])->name('update');
        Route::post('update-household-number/{application_id}', [ApplicationController::class, 'updateHouseholdNumber'])->name('updateHouseholdNumber');
        Route::post('update-year/{application_id}', [ApplicationController::class, 'updateYear'])->name('updateYear');

    });

    Route::prefix('household')->name('household.')->group(function () {
        Route::prefix('ajax')->name('ajax.')->group(function () {
            Route::post('store', [HouseholdController::class, 'ajaxCreate'])->name('store');
            Route::post('store-quotation', [HouseholdController::class, 'ajaxCreateQuotation'])->name('storequotation');
            Route::put('update/{application_id}', [HouseholdController::class,'ajaxCreate'])->name('update');
            Route::get('delete/{household_member_id}', [HouseholdController::class, 'ajaxDelete'])->name('delete');
            Route::post('store-quick-quotation', [QuickQuotationController::class, 'storeQuickQuotation'])->name('storequickquotation');
            Route::post('quick-quotation/{application_id}/add-member', [QuickQuotationController::class, 'addMember'])->name('quick-quotation.add-member');
            Route::delete('quick-quotation/{application_id}/remove-member/{member}', [QuickQuotationController::class, 'removeMember'])->name('quick-quotation.remove-member');
            Route::post('deletehousholdata/{application_id}', [HouseholdController::class, 'deleteHouseHoldData'])->name('deletehousholdata');
        });
    });

    Route::prefix('relationship')->name('relationship.')->group(function () {
        Route::get('/application/{application_id}', [RelationshipController::class,'returnOtherMembersRelationshipsByApplication'])->name('application');
        Route::post('/store-or-update', [RelationshipController::class,'createOrUpdateRelationships'])->name('storeorupdate');
        Route::get('/list-detail/{domain_value_id}', [RelationshipController::class,'listRelationshipsHaveDetail'])->name('listDetail');
        Route::get('/combo-detail/{domain_value_id}', [RelationshipController::class,'comboForRelationshipDetail'])->name('comboDetail');
        Route::post('deleteRelationship/{application_id}', [RelationshipController::class, 'deleteRelationship'])->name('deleteRelationship');
    });

    Route::prefix('idm')->name('idm.')->group(function () {
        Route::get('connect', [IDMController::class, 'connect'])->name('idm_connect');
        Route::get('refresh', [IDMController::class, 'refreshToken'])->name('idm_refresh');
    });
    Route::prefix('plans')->name('plans.')->group(function () {
        Route::post('search/{application_id}/{page}', [InsurancePlansController::class, 'searchPlans'])->name('searchPlans');
        Route::post('most-accessible/{application_id}/', [InsurancePlansController::class, 'searchMostAccessiblePlan'])->name('mostAccessible');
        Route::get('search/plan-detail/{application_id}/{hios_plan_id}', [InsurancePlansController::class, 'searchPlansDetails'])->name('searchPlansDetails');
        Route::post('store', [PlanController::class, 'ajaxCreatePlansByApplication'])->name('storePlans');
    });
    Route::prefix('tax')->name('tax.')->group(function () {
        Route::get('member/{application_id}', [TaxHouseholdController::class,'recoverNextMember'])->name('nextMember');
        Route::post('fill-first-tax/{application_id}', [TaxHouseholdController::class,'fillFirstHouseholdTaxForm'])->name('fillFirstTax');
        Route::post('deletetaxdata/{application_id}', [TaxHouseholdController::class, 'deletetaxdata'])->name('deletetaxdata');
    });
    Route::prefix('memberinfo')->name('memberinfo.')->group(function () {
        Route::get('list/{application_id}', [MemberInformationController::class,'recoverMemberInfoList'])->name('list');
        Route::post('store', [MemberInformationController::class, 'storeMemberInformation'])->name('store');
    });

    Route::prefix('additionalinformation')->name('additionalinformation.')->group(function () {
        Route::post('deleteadditional/{application_id}', [AdditionalInformationController::class, 'deleteAdditionalInformation'])->name('deleteAdditionalInformation');
        Route::post('fill/{application_id}', [AdditionalInformationController::class,'fillAdditionalInformation'])->name('fill');
    });

    Route::prefix('addinfo')->name('addinfo.')->group(function () { //address information
        Route::post('fill/address/{application_id}', [AddressInformationController::class,'fillAddressInformation'])->name('fillAddress');
    });
    Route::prefix('income')->name('income.')->group(function () {
        Route::post('update-quotation-main-income', [IncomeDeductionController::class, 'updateQuotationMainIncome'])->name('quotationMainIncome');
        Route::post('fillIncome/{application_id}', [IncomeDeductionController::class,'fillIncome'])->name('fillIncome');
        Route::get('/list/{application_id}', [IncomeDeductionController::class, 'getIncomeListController'])->name('list');
        Route::get('/income/net-income', [IncomeDeductionController::class, 'getNetIncome'])->name('getNetIncome');
        Route::delete('delete/{application_id}/{income_id}', [IncomeDeductionController::class, 'delete'])->name('delete');
    });
    Route::prefix('additionalQuestion')->name('additionalQuestion.')->group(function () {
        Route::post('store/{application_id}', [AdditionalQuestionController::class,'fillAdditionalQuestion'])->name('store');
    });

    Route::prefix('finalize')->name('finalize.')->group(function () {
        Route::post('store/{application_id}', [FinalizeController::class,'store'])->name('store');
        Route::post('updateMember/{application_id}/{member_id}', [FinalizeController::class,'updateMember'])->name('update');
        Route::post('household-members/update', [FinalizeController::class, 'updateHouseholdMember'])->name('householdFinalize.update');
        Route::post('income/update', [FinalizeController::class, 'updateIncome'])->name('income.update');

    });

});
Route::prefix('idm')->name('idm.')->group(function () {
    Route::get('callback', [IDMController::class, 'callback'])->name('idm.callback');
    Route::get('logout', [IDMController::class, 'logout'])->name('idm.logout');
});


Route::get('/register/agent', [AuthRegisterController::class, 'showAgentRegistrationForm'])->name('agent.register');
Route::post('/register/agent', [AuthRegisterController::class, 'registerAgent'])->name('agent.register.submit');

Route::get('/register/client', [AuthRegisterController::class, 'showClientRegistrationForm'])->name('client.register');
Route::post('/register/client', [AuthRegisterController::class, 'registerClient'])->name('client.register.submit');


// Rota para exibir o PDF em Inglês
Route::get('gerar-pdf/ingles', function () { return view('livewire.pdfIngles');})->name('gerar-pdf-ingles');
Route::get('gerar-pdf/ingles/download', [PdfController::class, 'downloadPdfIngles'])->name('gerar-pdf-ingles-download');

// Rota para exibir o PDF em Português
Route::get('gerar-pdf/portugues', function () {return view('livewire.pdfPortugues');})->name('gerar-pdf-portugues');
Route::get('gerar-pdf/portugues/download', [PdfController::class, 'downloadPdfPortugues'])->name('gerar-pdf-portugues-download');

// Rota para exibir o PDF em Espanhol
Route::get('gerar-pdf/espanhol', function () { return view('livewire.pdfEspanhol');})->name('gerar-pdf-espanhol');
Route::get('gerar-pdf/Espanhol/download', [PdfController::class, 'downloadPdfEspanhol'])->name('gerar-pdf-espanhol-download');

Route::post('/gerar-pdf-plano', [PdfController::class, 'generatePdfFromPlans'])->name('gerar-pdf-plano');
