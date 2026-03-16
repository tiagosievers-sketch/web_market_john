@extends('layouts.app')

@section('content')

<!-- BREADCRUMB -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <h4 class="page-title">@lang('labels.declaracaoPrivacidade')</h4> <br>
        <h6 class="page-title">@lang('labels.declaracaoPrivacidadetwo')</h6> <br>

        <div class="mb-xl-0">
            <div class="btn-group dropdown">
                <a href="#" class="custom-link">
                    @lang('labels.privancySaibaMais') <i class="fas fa-share"></i>
                </a>
            </div>
        </div>


    </div>
    <div class="d-flex my-xl-auto right-content align-items-center">
        <div class="mb-xl-0">
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary">@lang('labels.redirecionamento')</button>
            </div>
        </div>
    </div>
</div>
<!-- END BREADCRUMB -->

<!-- ROW -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">@lang('labels.privacidadeUso')</h4>
            </div>
            <div class="card-body">
                <div class="wd-xl-100p ht-350">
                    <div class="ql-scrolling-demo p-4 border" id="scrolling-container" style="max-height: 350px; overflow-y: auto;">
                        <div id="quillInline">
                            @lang("labels.privacidadeInformacao")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->

<!-- ROW -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="page-title">
                    @lang("labels.alertaInformation")
                </div>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <div class="input-group-text">
                        <label class="ckbox wd-16 mg-b-0">
                            <input class="mg-0" type="checkbox" name="checkInformation">
                            <span></span>
                        </label>
                    </div>
                    <input type="hidden" name="checkInformation" value="0">
                    <div class="form-control">
                        @lang("labels.checkInformation")
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <div class="input-group-text">
                        <label class="ckbox wd-16 mg-b-0">
                            <input class="mg-0" type="checkbox" name="checkInformationtwo">
                            <span></span>
                        </label>
                    </div>
                    <!-- Input hidden para enviar o valor 0 quando o checkbox não estiver marcado -->
                    <input type="hidden" name="checkInformationtwo" value="0">
                    <div class="form-control">
                        @lang("labels.checkInformationtwo")
                    </div>
                </div>

                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="page-title">@lang("labels.consentimento")</h4>
                            <a href="#" class="custom-link">
                                @lang('labels.startFormConsentimento') <i class="fas fa-share"></i>
                            </a>
                        </div> <br>
                        <p class="mb-2">@lang("labels.consentimentotwo") </p>
                    </div>

                </div>

                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <p class="mb-2"><strong>@lang("labels.provaconcentimento")</strong></p>
                    </div>
                </div>


                <div class="input-group">
                    <div class="input-group-text">
                        <label class="ckbox wd-16 mg-b-0">
                            <input class="mg-0" type="checkbox" name="checkInform">
                            <span></span>
                        </label>
                    </div>
                    <input type="hidden" name="checkInform" value="0">
                    <div class="form-control">
                        @lang("labels.checkInform")
                    </div>

                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-text">
                        <label class="ckbox wd-16 mg-b-0">
                            <input class="mg-0" type="checkbox" name="checkUpload">
                            <span></span>
                        </label>
                    </div>
                    <input type="hidden" name="checkUpload" value="0">
                    <div class="form-control">
                        @lang('labels.checkUpload')
                    </div>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-text">
                        <label class="ckbox wd-16 mg-b-0">
                            <input class="mg-0" type="checkbox" name="checkProof">
                            <span></span>
                        </label>
                    </div>
                    <input type="hidden" name="checkProof" value="0">
                    <div class="form-control">
                        @lang('labels.checkProof')
                    </div>
                </div>
                <br>


                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <a href="{{Route('livewire.form-start')}}" class="btn btn-primary btn-lg btn-block">@lang('labels.buttonVoltar')</a>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <a href="{{Route("livewire.primary-contact")}}" class="btn btn-secondary btn-lg btn-block">@lang('labels.buttonContinue')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END ROW -->

<!-- MODAL -->
<div class="modal" id="modalQuill">
    <!-- Conteúdo do modal omitido para brevidade -->
</div>
<!-- END MODAL -->

@endsection