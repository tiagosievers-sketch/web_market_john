<?php

namespace App\Jobs;

use App\Actions\PdfActions;
use App\Libraries\Railway2easyApiLibrary;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Actions\InsurancePlansActions;
use Illuminate\Queue\SerializesModels;
use App\Actions\FullApplicationActions;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Requests\FilterPlansRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class IntegrationWithCrmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $quotationData;
    private mixed $quotationDetailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($quotationData)
    {
        $this->quotationData = $quotationData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Application Received!',['Application ID' => $this->quotationData['application_id']??'Not Found']);
        try {
            $quotations = FullApplicationActions::getPlansInColumns($this->quotationData['application_id'], false);
            if(empty($quotations['hmo_plan'])&&empty($quotations['oopc_plan'])&&empty($quotations['epo_plan'])){
                Log::info('Proceed to do quotation with deductible not zero!');
                $quotations = FullApplicationActions::getPlansInColumns($this->quotationData['application_id'],false);
            }
            Log::info('Quotations processed!',$quotations);
            if(empty($quotations['hmo_plan'])&&empty($quotations['oopc_plan'])&&empty($quotations['epo_plan'])){
                Log::info('No plan found!');
                throw new \Exception('No plan found for this data!');
            }
            $application = Application::find($this->quotationData['application_id']);
            if (!$application) {
                throw new \Exception('Application not found');
            }
            $webhookOverwrite = $application->webhook??null;
//            $quotationsDetail = FullApplicationActions::getPlanDetail($application, $quotations);

//            Log::info('Quotations details processed!',$quotationsDetail);

            $response = PdfActions::generatePdf($this->quotationData['application_id'],$quotations);
            if($response){
                Log::info('Quotation sent successfully!');
            } else {
                Log::error('Error sending quotation!');
                Railway2easyApiLibrary::sendError( $application->id,$application->additional_external_id,'Error sending quotation!',$webhookOverwrite);
            }
        } catch (\Exception $e){
            $applicationId = $this->quotationData['application_id']??0;
            $application = Application::find($applicationId);
            $webhookOverwrite = $application->webhook??null;
            $clientId = $this->quotationData['client_id']??0;
            Log::error("Error processing quotation from application with ID $applicationId: ".$e->getMessage());
            Railway2easyApiLibrary::sendError( $applicationId, $clientId,$e->getMessage(),$webhookOverwrite);
        }
    }
}
