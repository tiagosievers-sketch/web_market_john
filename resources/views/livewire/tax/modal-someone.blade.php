<div class=" modal fade" id="modalDemoAddDependents" tabindex="-1" aria-labelledby="modalDemoAddDependentsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-primary ms-auto" data-bs-dismiss="modal">X</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.nome')</label>
                                    <input type="text" class="form-control" name="nameDependents" id="nameDependents"
                                        placeholder="@lang('labels.nome')">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.campoCentral')</label>
                                    <input type="text" class="form-control" name="middleDependents"
                                        id="middleDependents" placeholder="@lang('labels.campoCentral')">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.sobreNome')</label>
                                    <input type="text" class="form-control" name="lastnameDependents"
                                        id="lastnameDependents" placeholder="@lang('labels.sobreNome')">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.suffix')</label>
                                    <select class="form-select" name="suffixesDependents" id="suffixesDependents">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($suffixes as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.dataNascimento')</label>
                                    <input class="form-control" name="dateDependents" id="dateDependents"
                                        placeholder="MM/DD/YYYY" type="text">
                                </div>
                                <div class="invalid-feedbackDependents" style="display: none;">
                                    <!-- Inicialmente escondida -->
                                    <!-- A mensagem de erro será inserida aqui -->
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">@lang('labels.campoSexo') <i
                                            class="fas fa-question custom-tooltip" data-bs-toggle="modal"
                                            data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>
                                    <select class="form-select" name="sexoDependents" id="sexoDependents">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($sexes as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label">@lang('labels.householdRelacionamento')</label>
                                    <select class="form-select" name="relationshipsDependentsSomeone"
                                        id="relationshipsDependentsSomeone">
                                        <option value="" selected>@lang('labels.campoSelecao')</option>
                                        @foreach ($relationships as $key => $value)
                                            <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-7">
                                    <label class="form-label">@lang('labels.householdConfirmacao') <span
                                            class="text-danger">@lang('labels.msgRequerido')</span></label>
                                    <div class="row">

                                        <div class="col-lg-6 mb-3">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <label class="rdiobox wd-16 mg-b-0">
                                                        <input class="mg-0" type="radio" name="liveswithyouSomeone"
                                                            value="1">
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="liveswithyouSomeone" value="1">
                                                <div class="form-control">
                                                    @lang('labels.checkYes')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <label class="rdiobox wd-16 mg-b-0">
                                                        <input class="mg-0" type="radio" name="liveswithyouSomeone"
                                                            value="0">
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="liveswithyouSomeone" value="0">
                                                <div class="form-control">
                                                    @lang('labels.checkNo')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <button type="button" id="addDependentbtn"
                                    class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddDependente')

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>
