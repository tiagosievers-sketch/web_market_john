@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="css/abaNavegacao.css">
@endsection

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.contatoPrincipal')</h4>
        </div>
    </div>


    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab">
                    <button id="tabYourInformation" class="tablinks active"
                        onclick="openTab(event, 'yourInformation')">@lang('labels.informacaoPessoal')</button>
                    <button id="tabHomeAddress" class="tablinks"
                        onclick="openTab(event, 'homeAddres')">@lang('labels.campoEndereco')</button>
                    <button id="tabcontactDetails" class="tablinks"
                        onclick="openTab(event, 'contactDetails')">@lang('labels.detalheContato')</button>
                </div>
            </div>
        </div>
    </div>
    <form id="form_application" method="POST" action="{{ route('application.store') }}">
        @csrf
        <div id="yourInformation" class="tabcontent" style="display: block;">
            <!-- END BREADCRUMB -->
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label class="col-form-label ">@lang('labels.informacaoPessoal')</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.nome'):
                                    </div>
                                    <input type="text" class="form-control" name="firstname" id="firstname"
                                        placeholder="@lang('labels.nome')" required>
                                </div>
                                <span class="text-danger" id="dateMaskError" style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.campoCentral'):
                                    </div>
                                    <input type="text" class="form-control" name="middlename" id="middlename"
                                        placeholder="@lang('labels.campoCentral')">
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.sobreNome'):
                                    </div>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="@lang('labels.sobreNome')" required>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-4 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.suffix'):</span>
                                    <select class="form-select" name="suffix" id="suffix">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($suffixes as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.dataNascimento'):
                                    </div>
                                    <input class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"
                                        id="birthdate" placeholder="MM/DD/YYYY" type="text"
                                        value="{{ old('birthdate') }}" required>
                                </div>
                                @error('birthdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="col-lg-4 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question"
                                            data-bs-toggle="modal" data-bs-target="#alertModalSexo"
                                            title="@lang('labels.msgClicar')"></i></span>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($sexes as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.campoNumero'):
                                    </div>
                                    <input class="form-control" name="ssn" id="ssn"
                                        placeholder=" @lang('labels.campoNumero')" type="text" inputmode="numeric" required>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0" type="checkbox" name="ckbox-campoSSN">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="has_ssn" id="has_ssn" value="1">
                                    <div class="form-control">
                                        @lang('labels.campoSSN')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <a href="{{ Route('livewire.privacy-information') }}"
                                    class="btn btn-primary btn-lg btn-block">@lang('labels.buttonVoltar')</a>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                                    onclick="openTab(event, 'homeAddres')">@lang('labels.buttonContinue')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ROW -->
        </div>
        <div id="homeAddres" class="tabcontent" style="display: none;">
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label class="col-form-label">@lang('labels.campoEndereco')</label>
                        </div>
                        <div class="form-group row align-items-center ">
                            <h1 class="col-form-label">@lang('labels.enderecotitle')</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0" type="checkbox" name="ckbox-checkEndereco">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input type="hidden" id="has_perm_address" name="has_perm_address" value="0">
                                    <div class="form-control">
                                        @lang('labels.checkEnderecoPermantente')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.enderecoRua'):
                                    </div>
                                    <input type="text" class="form-control" id="street_address" name="street_address"
                                        placeholder="@lang('labels.enderecoRua')" required>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.enderecoApt'):
                                    </div>
                                    <input type="text" class="form-control" id="apte_ste" name="apte_ste"
                                        placeholder="@lang('labels.enderecoApt')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.enderecoCidade'):
                                    </div>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="@lang('labels.enderecoCidade')" required>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.enderecoEstado'):</span>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($states as $key => $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>


                            <div class="col-lg-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.enderecoCEP'):
                                    </div>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                                        placeholder="@lang('labels.enderecoCEP')" onchange="loadCounties(this,'county')" required>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.campoCounty'):</span>
                                    <select id="county" name="county" class="form-select">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row row-sm">
                            <label class="col-form-label">@lang('labels.checkEnderecoCorrespondencia')</label>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checkaddress" value="1"
                                                id="checkYesAddress">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">@lang('labels.checkYes')</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checkaddress" value="0"
                                                id="checkNoAddress">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="form-control">@lang('labels.checkNo')</div>
                                </div>
                            </div>

                            <input type="hidden" id="mailing" name="mailing" value="0">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <button id="btnBack" class="btn btn-primary btn-lg btn-block"
                                    onclick="openTab(event, 'homeAddres')">@lang('labels.buttonVoltar')</button>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <button id="btnContinueTwo" class="btn btn-secondary btn-lg btn-block"
                                    onclick="openTab(event, 'contactDetails')">@lang('labels.buttonContinue')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ROW -->
            <!-- Modal -->
            <!-- Modal -->
            <div class="modal fade" id="modalAddAddrres" tabindex="-1" aria-labelledby="modalAddAddrresLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                style="font-size:34px">X</button>
                        </div>
                        <div class="modal-body">
                            <h2>@lang('labels.campoEnderecoCorrespondencia')</h2> <br>
                            <h1 class="col-form-label">@lang('labels.campoReceberCorrespondencia')</h1><br>
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-6">
                                                <label class="form-label">@lang('labels.campoEnderecoCorrespondencia')</label>
                                                <input type="text" class="form-control" id="mail_street_address"
                                                    name="mail_street_address" placeholder="@lang('labels.campoEnderecoCorrespondencia')">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label">@lang('labels.enderecoApt')</label>
                                                <input type="text" class="form-control" id="mail_apte_ste"
                                                    name="mail_apte_ste" placeholder="@lang('labels.enderecoApt')">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label class="form-label">@lang('labels.enderecoCidade')</label>
                                                <input type="text" class="form-control" id="mail_city"
                                                    name="mail_city" placeholder="@lang('labels.enderecoCidade')">
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label class="form-label">@lang('labels.enderecoEstado')</label>
                                                <select id="mail_state" name="mail_state" class="form-select">
                                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                                    @foreach ($states as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-lg-3">
                                                <label class="form-label">@lang('labels.enderecoCEP')</label>
                                                <input type="text" class="form-control" id="mail_zipcode"
                                                    name="mail_zipcode" placeholder="@lang('labels.enderecoCEP')"
                                                    onchange="loadCounties(this,'mail_county')">
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label class="form-label">@lang('labels.campoCounty')</label>
                                                <select class="form-select" id="mail_county" name="mail_county">
                                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <button type="button" class="btn btn-primary btn-lg btn-block"
                                        id="addAddressButton">
                                        @lang('labels.buttonAddAddress')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <!-- End Modal -->
        <div id="contactDetails" class="tabcontent" style="display: none;">
            <!-- END BREADCRUMB -->
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label class="col-form-label ">@lang('labels.detalheContato')</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.enderecoEmail'):
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="@lang('labels.enderecoEmail')" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.numeroTelefone'):
                                    </div>
                                    <input class="form-control" id="phone" name="phone"
                                        placeholder="(000) 000-0000" type="text" required>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.campoExtensao'):
                                    </div>
                                    <input class="form-control" id="extension" name="extension" type="text">
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.campoTipo'):</span>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($types as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3 mt-4">
                            <div class="input-group">
                                <a href="#" class="btn btn-outline-secondary btn-lg"
                                    id="showPhoneFields">@lang('labels.numeroTelefonetwo')</a>
                            </div>
                        </div>
                        <div class="row row-sm" id="phoneFields" style="display: none;">
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.numeroTelefone'):
                                    </div>
                                    <input class="form-control" id="second_phone" name="second_phone"
                                        placeholder="(000) 000-0000" type="text">
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        @lang('labels.campoExtensao'):
                                    </div>
                                    <input id="second_extension" name="second_extension" class="form-control"
                                        type="text">
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.campoTipo'):</span>
                                    <select id="second_type" name="second_type" class="form-select">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($types as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3 mt-4">
                            <div class="input-group ">
                                <a href="#" class="btn btn-outline-secondary btn-lg" id="hidePhoneFields"
                                    style="display: none;">@lang('labels.numeroTelefoneRemove')</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.campoLinguagem') <i
                                            class="fa fa-question"></i></span>
                                    <select id="written_lang" name="written_lang" class="form-select" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($languages as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group ">
                                    <span class="input-group-text">@lang('labels.campoIdiomaFalado') <i
                                            class="fa fa-question"></i></span>
                                    <select id="spoken_lang" name="spoken_lang" class="form-select" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($languages as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger" id="dateMaskError"
                                    style="display: none;">@lang('labels.msgRequerido')</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <label class="col-form-label">@lang('labels.checknoticiaTitle')</label>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checknoticia"
                                                id="checknoticiaPapel">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input id="notices_mail" name="notices_mail" type="hidden" value="0">
                                    <div class="form-control">
                                        @lang('labels.checknoticiaPapel')
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="checknoticia"
                                                id="checknoticiaEmail">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input id="notices_mail_or_email" name="notices_mail_or_email" type="hidden"
                                        value="1">
                                    <div class="form-control">
                                        @lang('labels.checknoticiaEmail')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="enviarEmailTexto" style="display:none;">
                        <label class="col-form-label">@lang('labels.checknoticiaChoose')</label>
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0" type="checkbox" name="send_email">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input id="send_email" name="send_email" type="hidden" value="1">
                                    <div class="form-control">
                                        @lang('labels.checknoticiaReceberEmail')
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0">
                                            <input class="mg-0" type="checkbox" name="send_text">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input id="send_text" name="send_text" type="hidden" value="1">
                                    <div class="form-control">
                                        @lang('labels.checknoticiaReceberTexto')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <button id="btnBackTwo" class="btn btn-primary btn-lg btn-block"
                                    onclick="openTab(event, 'yourInformation')">@lang('labels.buttonVoltar')</button>
                            </div>
                            <div class="col-lg-6 mb-3">
                                {{-- <a href="{{ Route("livewire.household-quotation") }}" class="btn btn-secondary btn-lg btn-block">@lang('labels.buttonContinue')</a> --}}
                                <button type="submit"
                                    class="btn btn-secondary btn-lg btn-block">@lang('labels.buttonContinue')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ROW -->
        </div>
    </form>
    <!-- Modal de alerta sobre o sexo -->
    <div class="modal fade" id="alertModalSexo" tabindex="-1" aria-labelledby="alertModalSexoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalSexoLabel">@lang('labels.msgSobreoSexotitulo')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('labels.msgSobreoSexo')</p>
                    <p>@lang('labels.msgSobreoSexoGestante')</p>
                    <p>@lang('labels.msgInformacoesSite')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End modal alerta sobre o sexo -->
@endsection
@section('scripts')
    <!-- Mostar msg Modal JS -->
    <!-- <script src="{{ asset('js/msgModal.js') }}"></script> -->

    <!-- Marca e desmarca checkBox -->
    <script src="{{ asset('js/checkBox.js') }}"></script>
    <!-- Mudar Paginacao -->
    <script src="{{ asset('js/paginacaoPrimaryContact.js') }}"></script>

    <!--    ESCONDER CAMPO JS -->
    <script src="{{ asset('js/primaryContact/mostrarCampoPhone.js') }}"></script>

    <!--    Aba de Navegacao JS -->
    {{-- <script src="{{ asset('js/abaNavegacaoContact.js') }}"></script> --}}

    {{-- <!-- INTERNAL DATEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script> --}}

    <!-- INTERNAL JQUERY.MASKEDINPUT JS -->
    <script src="{{ asset('build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL SPECTRUM-COLORPICKER JS -->
    {{-- <script src="{{ asset('build/assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script> --}}

    <!--  INTERNAL SELECT2 JS -->
    <script src="{{ asset('build/assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- INTERNAL ION-RANGESLIDER JS -->
    <script src="{{ asset('build/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <!-- INTERNAL JQUERY-AMAZEUI DATETIMEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

    <!-- INTERNAL JQUERY-SIMPLE DATETIMEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

    <!-- INTERNAL PICKER JS -->
    <script src="{{ asset('build/assets/plugins/pickerjs/picker.min.js') }}"></script>

    <!-- INTERNAL COLORPICKER JS -->
    <script src="{{ asset('build/assets/plugins/colorpicker/pickr.es5.min.js') }}"></script>
    @vite('resources/assets/js/colorpicker.js')


    <!-- BOOTSTRAP-DATEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <!-- INTERNAL FORM-ELEMENTS JS -->
    @vite('resources/assets/js/form-elements.js')

    @vite('resources/assets/js/modal.js')


    <script>
        $(document).ready(function() {
            console.log('Document ready: Inicializando...');

            // Inicializa o Select2 para o campo 'state' fora da modal
            $('#state').select2({
                placeholder: "@lang('labels.campoSelecao')",
                allowClear: true,
                width: '80%'
            });
            console.log('Select2 inicializado para o campo state.');

            // Função para verificar se o Select2 já foi inicializado
            function isSelect2Initialized(selector) {
                const initialized = !!$(selector).data('select2');
                console.log('isSelect2Initialized para', selector, ':', initialized);
                return initialized;
            }

            // Ao abrir a modal, inicialize o Select2 no 'mail_state'
            $('#modalAddAddrres').on('shown.bs.modal', function() {
                console.log('Modal aberta.');

                // Verifica se o Select2 já está aplicado ao 'mail_state' e destrói antes de re-aplicar
                if (isSelect2Initialized('#mail_state')) {
                    console.log('Destruindo Select2 existente no mail_state...');
                    $('#mail_state').select2('destroy');
                }

                // Reaplica o Select2 para o mail_state
                console.log('Aplicando Select2 para mail_state...');
                $('#mail_state').select2({
                    placeholder: "@lang('labels.campoSelecao')",
                    allowClear: true,
                    tags: true, // Permite adicionar valores digitados
                    width: '70%' // Garante que o Select2 ocupe o espaço correto
                });
                console.log('Select2 aplicado com sucesso ao mail_state.');

                // Remover o atributo aria-readonly que pode estar interferindo
                $('#mail_state').removeAttr('aria-readonly');
                console.log('aria-readonly removido de mail_state.');

                // Atualiza o layout da modal após abrir
                $('#modalAddAddrres').trigger('resize');
                console.log('Modal layout forçado a ser atualizado.');
            });

            // Log de fechamento da modal
            $('#modalAddAddrres').on('hide.bs.modal', function() {
                console.log('Modal fechada.');
            });
        });



        function loadCounties(element, targetElem) {
            const csrf_token = '{{ csrf_token() }}';
            const selectElem = $('#' + targetElem);

            // Desabilita o select enquanto carrega os dados
            selectElem.prop('disabled', true);

            // Verifica se o CEP foi inserido e não está vazio
            if ('value' in element && element.value.trim() !== '') {
                let zipcode = element.value.trim(); // Remove espaços em branco

                // Limpa todas as opções do select, incluindo a opção "Select"
                selectElem.find('option[value=""]').remove(); // Remove explicitamente a opção vazia, se existir
                selectElem.empty(); // Limpa completamente o select

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    url: "{{ route('geography.counties', '') }}/" + zipcode,
                    type: "GET",
                    success: function(response) {
                        if ('status' in response && 'data' in response) {
                            if (response.status === 'success' && response.data.length > 0) {
                                // Itera sobre os counties recebidos e adiciona no select
                                response.data.forEach((county) => {
                                    let optionElement = document.createElement('option');
                                    optionElement.value = county;
                                    optionElement.innerHTML = county;
                                    document.getElementById(targetElem).appendChild(optionElement);
                                });

                                // Seleciona automaticamente o primeiro item
                                selectElem.val(response.data[0]); // Seleciona o primeiro county
                            } else {
                                console.log('Nenhum condado encontrado');
                            }
                        } else {
                            console.log('Resposta inesperada:', response);
                        }

                        // Reabilita o select após o carregamento
                        selectElem.prop('disabled', false);
                    },
                    error: function(error) {
                        console.error('Erro na requisição:', error);
                        selectElem.prop('disabled', false);
                    }
                });
            } else {
                // Se o campo de CEP estiver vazio, redefina o select com a opção padrão
                selectElem.empty(); // Limpa completamente o select
                let defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.innerHTML = '@lang('labels.campoSelecao')'; // Mensagem padrão
                document.getElementById(targetElem).appendChild(defaultOption);
                selectElem.prop('disabled', false);
            }
        }


        $(
            function() {
                // Input Masks
                $('#birthdate').mask('99/99/9999');
                $('#phone').mask('(999) 999-9999');
                $('#second_phone').mask('(999) 999-9999');
            }
        );




        // Função para garantir que não haja múltiplos listeners
        function removeAllEventListeners() {
            document.getElementById("btnContinue").replaceWith(document.getElementById("btnContinue").cloneNode(true));
            document.getElementById("btnContinueTwo").replaceWith(document.getElementById("btnContinueTwo").cloneNode(
                true));
            document.getElementById("btnBack").replaceWith(document.getElementById("btnBack").cloneNode(true));
            document.getElementById("btnBackTwo").replaceWith(document.getElementById("btnBackTwo").cloneNode(true));
        }

        // Remover todos os event listeners antes de adicionar novos
        removeAllEventListeners();

        // Botão para mudar para a aba Home Address
        document.getElementById("btnContinue").addEventListener("click", function(e) {
            e.stopPropagation(); // Previne qualquer propagação de eventos desnecessária
            openTab(e, 'homeAddres');
        });

        // Botão para mudar para a aba Contact Details
        document.getElementById("btnContinueTwo").addEventListener("click", function(e) {
            e.stopPropagation(); // Previne qualquer propagação de eventos desnecessária
            openTab(e, 'contactDetails');
        });

        // Botão para voltar para Your Information
        document.getElementById("btnBack").addEventListener("click", function(e) {
            e.stopPropagation(); // Previne qualquer propagação de eventos desnecessária
            openTab(e, 'yourInformation');
        });

        // Botão para voltar para Home Address
        document.getElementById("btnBackTwo").addEventListener("click", function(e) {
            e.stopPropagation(); // Previne qualquer propagação de eventos desnecessária
            openTab(e, 'homeAddres');
        });

        // Função para abrir a aba e realizar validações se necessário
        function openTab(evt, tabName) {
            evt.preventDefault(); // Impede o comportamento padrão do botão

            let isValid = true;

            // Valida a aba anterior antes de trocar para a próxima aba
            if (tabName === 'homeAddres') {
                isValid = validateYourInformation();
            } else if (tabName === 'contactDetails') {
                isValid = validateHomeAddress();
            }

            if (!isValid) {
                // Se houver campos inválidos, apenas os destaques são mostrados, sem alert
                return;
            }

            // Oculta todas as abas
            let tabcontent = document.getElementsByClassName("tabcontent");
            for (let i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remove a classe 'active' de todos os botões
            let tablinks = document.getElementsByClassName("tablinks");
            for (let i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Exibe a aba selecionada e adiciona a classe 'active' ao botão correspondente
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Função para garantir que o valor de has_ssn seja atualizado quando o checkbox mudar
        document.querySelector('input[name="ckbox-campoSSN"]').addEventListener('change', function() {
            let hasSSNHidden = document.getElementById('has_ssn');
            let ssnField = document.getElementById('ssn');
            if (this.checked) {
                hasSSNHidden.value = "0"; // SSN não será obrigatório quando o checkbox estiver marcado
                ssnField.removeAttribute(
                    'required'); // Remove a obrigatoriedade do SSN se o checkbox estiver marcado

            } else {
                hasSSNHidden.value = "1"; // SSN será obrigatório quando o checkbox estiver desmarcado
                ssnField.setAttribute('required',
                    'required'); // Torna o SSN obrigatório se o checkbox não estiver marcado
            }
        });



        // Valida os campos da aba Your Information
        function validateYourInformation() {
            let isValid = true;
            let requiredFields = ['firstname', 'lastname', 'birthdate', 'sex'];

            // Verifica se o checkbox está marcado antes de adicionar o SSN como obrigatório
            let ssnCheckbox = document.querySelector('input[name="ckbox-campoSSN"]');

            // Se o checkbox NÃO estiver marcado, o SSN é obrigatório
            if (!ssnCheckbox.checked) {
                requiredFields.push('ssn'); // SSN será obrigatório se o checkbox não estiver marcado
            }

            requiredFields.forEach(function(fieldId) {
                let field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                    clearError(field);
                }
            });

            return isValid;
        }



        // Valida os campos da aba Home Address
        function validateHomeAddress() {
            let isValid = true;
            let requiredFields = ['street_address', 'city', 'state', 'zipcode'];

            requiredFields.forEach(function(fieldId) {
                let field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    field.classList.add('is-invalid');
                    //            showError(field, '@lang('labels.fieldRequired')');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                    clearError(field);
                }
            });
            return isValid;
        }

        // Valida os campos da aba Contact Details
        function validateContactDetails() {
            let isValid = true;
            let requiredFields = ['phone', 'type', 'written_lang', 'spoken_lang', 'email'];

            requiredFields.forEach(function(fieldId) {
                let field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    field.classList.add('is-invalid');
                    //            showError(field, '@lang('labels.fieldRequired')');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                    clearError(field);
                }
            });
            return isValid;
        }

        // Função para exibir mensagem de erro
        function showError(field, message) {
            let errorSpan = field.nextElementSibling;
            if (!errorSpan || !errorSpan.classList.contains('error-message')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('error-message');
                errorSpan.style.color = 'red';
                field.parentNode.appendChild(errorSpan);
            }
            errorSpan.textContent = message;
        }

        // Função para limpar mensagem de erro
        function clearError(field) {
            let errorSpan = field.nextElementSibling;
            if (errorSpan && errorSpan.classList.contains('error-message')) {
                errorSpan.remove();
            }
        }





        document.addEventListener("DOMContentLoaded", function() {
            const checkYesAddress = document.getElementById('checkYesAddress');
            const checkNoAddress = document.getElementById('checkNoAddress');
            const modalAddAddrres = new bootstrap.Modal(document.getElementById('modalAddAddrres'));
            const addAddressButton = document.getElementById('addAddressButton');
            const modalElement = document.getElementById('modalAddAddrres');

            const street = document.getElementById('mail_street_address');
            const city = document.getElementById('mail_city');
            const state = document.getElementById('mail_state');
            const zipcode = document.getElementById('mail_zipcode');

            let addressAdded = false; // Variável para controlar se o endereço foi adicionado

            // Mostrar a modal quando selecionar "Não" para endereço permanente
            checkNoAddress.addEventListener('change', function() {
                if (this.checked) {
                    modalAddAddrres.show();
                }
            });

            // Fechar a modal se marcar "Sim"
            checkYesAddress.addEventListener('change', function() {
                modalAddAddrres.hide();
            });

            // Função de validação para os campos da modal
            function validateModalFields() {
                let isValid = true;

                if (!street.value.trim()) {
                    street.classList.add('is-invalid');
                    isValid = false;
                } else {
                    street.classList.remove('is-invalid');
                }

                if (!city.value.trim()) {
                    city.classList.add('is-invalid');
                    isValid = false;
                } else {
                    city.classList.remove('is-invalid');
                }

                if (!state.value.trim()) {
                    state.classList.add('is-invalid');
                    isValid = false;
                } else {
                    state.classList.remove('is-invalid');
                }

                if (!zipcode.value.trim()) {
                    zipcode.classList.add('is-invalid');
                    isValid = false;
                } else {
                    zipcode.classList.remove('is-invalid');
                }

                return isValid;
            }

            // Fechar modal e enviar dados ao clicar no botão "Adicionar"
            addAddressButton.addEventListener('click', function() {
                if (validateModalFields()) {
                    modalAddAddrres.hide(); // Fecha a modal
                    addressAdded = true; // Marca que o endereço foi adicionado
                    console.log('Endereço adicionado com sucesso!');
                } else {
                    console.log('Erro: Campos obrigatórios não preenchidos.');
                }
            });

            // Ao fechar a modal, verificar se o endereço foi adicionado
            modalElement.addEventListener('hide.bs.modal', function() {
                if (!addressAdded) {
                    checkYesAddress.checked = true; // Marca "Sim" se o endereço não foi adicionado
                    console.log('Modal fechada sem adicionar o endereço. Campo marcado como "Sim".');
                } else {
                    console.log('Modal fechada com endereço adicionado.');
                }
            });
        });
    </script>
@endsection
