<?php

namespace App\Http\Controllers;

use App\Actions\FullApplicationActions;
use App\Actions\PdfActions;
use App\Http\Controllers\InsurancePlansController;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{
    public function sendApplicationPdf($application_id)
    {
        // Chama a função da InsurancePlansController para buscar os dados dos planos
        $response = app(InsurancePlansController::class)->searchMostAccessiblePlanFiltered($application_id);
        $plans = $response->getData(true)['data']; // Extrai os dados da resposta JSON como array

        // Gera o PDF usando a action de PdfActions
        return PdfActions::generatePdf($application_id, $plans);
    }


    /**
     * @throws \Exception
     */
    public function generatePdfFromPlans(Request $request)
    {
        $planIds = array_column($request->input('plans', []), 'id');
        // Converte o código do idioma para o formato completo
        $language = match ($request->input('language', 'en')) {
            'pt' => 'portuguese',
            'es' => 'spanish',
            'en' => 'english',
            default => 'english'
        };

        $applicationId = (int) $request->input('application_id');
        $application = Application::find($applicationId);

        // Força o locale para o idioma da requisição
        App::setLocale($language);

        // Armazena o idioma completo na sessão
        session(['pdf_language' => $language]);

        // Obtém os dados estruturados dos planos
        $plansInColumns = FullApplicationActions::getPlansInColumnsScreenQuotation($applicationId, $planIds);

        // Adiciona o idioma ao array de planos
        $plansInColumns['language'] = $language;

        // Chama a função generatePdf com os dados organizados
        return PdfActions::generatePdfTeste($applicationId, $plansInColumns);
    }
}
