<!-- Modal Add Spouse -->
<div class="modal fade" id="modalAddSpouse" tabindex="-1" aria-labelledby="modalAddSpouseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">@lang('labels.householdAddConjuge')</h1>
                        <button type="button" class="btn btn-primary ms-auto"
                            data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                    </div>

                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.nome'):</div>
                                    <input type="text" class="form-control" name="nameSpouse" id="nameSpouse"
                                        placeholder="@lang('labels.nome')">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.campoCentral')</div>
                                    <input type="text" class="form-control" name="middleSpouse" id="middleSpouse"
                                        placeholder="@lang('labels.campoCentral')">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.sobreNome'):</div>
                                    <input type="text" class="form-control" name="lastnameSpouse" id="lastnameSpouse"
                                        placeholder="@lang('labels.sobreNome')">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.suffix'):</span>
                                    <select class="form-select" name="suffixSpouse" id="suffixSpouse">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($suffixes as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">@lang('labels.dataNascimento'):</div>
                                    <input class="form-control" name="birthdateSpouse" id="birthdateSpouse"
                                        placeholder="MM/DD/YYYY" type="text">
                                </div>
                                  <div class="invalid-feedbackSpouse" style="display: none;">
                                        <!-- Inicialmente escondida -->
                                        <!-- A mensagem de erro será inserida aqui -->
                                    </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question"
                                            data-bs-toggle="modal" data-bs-target="#alertModalSexo"
                                            title="@lang('labels.msgClicar')"></i></span>
                                    <select class="form-select" id="sexSpouse" name="sexSpouse" required>
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($sexes as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 ml-3" style="margin-left: 10px;">
                        <div class="col-lg-7">
                            <label class="form-label">@lang('labels.householdConfirmacao')</label>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <label class="rdiobox wd-16 mg-b-0">
                                                <input class="mg-0" type="radio" name="liveswithyouSpouse" value="1">
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
                                                <input class="mg-0" type="radio" name="liveswithyouSpouse" value="0">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-control">@lang('labels.checkNo')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <button id="saveSpouseBtn" class="btn btn-primary btn-lg btn-block" disabled>@lang('labels.householdAddConjuge')</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
