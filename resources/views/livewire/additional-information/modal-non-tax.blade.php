  <!-- Modal segunda tela-->
  <div class=" modal fade" id="modalChildrenTax" tabindex="-1" aria-labelledby="modalChildrenTax" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-body">
                  <div class="container">
                      <div class="card">
                          <div class="card-body d-flex justify-content-between align-items-center">
                              <button type="button" class="btn btn-primary ms-auto"
                                  data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                          </div>
                          <div class="card-body">
                              <div class="row mb-3">
                                  <div class="col-lg-4">
                                      <label class="form-label">@lang('labels.nome')</label>
                                      <input type="text" class="form-control" name="nameChildrenTax"
                                          id="nameChildrenTax" placeholder="@lang('labels.nome')">
                                  </div>
                                  <div class="col-lg-4">
                                      <label class="form-label">@lang('labels.campoCentral')</label>
                                      <input type="text" class="form-control" name="middleChildrenTax"
                                          id="middleChildrenTax" placeholder="@lang('labels.campoCentral')">
                                  </div>
                                  <div class="col-lg-4">
                                      <label class="form-label">@lang('labels.sobreNome')</label>
                                      <input type="text" class="form-control" name="lastnameChildrenTax"
                                          id="lastnameChildrenTax" placeholder="@lang('labels.sobreNome')">
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <div class="col-lg-4">
                                      <label class="form-label">@lang('labels.suffix')</label>
                                      <select class="form-select" name="suffixesChildrenTax" id="suffixesChildrenTax">
                                          <option value="" selected>@lang('labels.campoSelecao')</option>
                                          @foreach ($suffixes as $key => $value)
                                              <option value="{{ $key }}">{{ $value }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-4">
                                      <label class="form-label">@lang('labels.dataNascimento')</label>
                                      <input class="form-control" name="dateChildrenTax" id="dateChildrenTax"
                                          placeholder="MM/DD/YYYY" type="text">
                                  </div>
                                  <div class="col-lg-4">
                                      <label class="form-label">@lang('labels.campoSexo') <i
                                              class="fas fa-question custom-tooltip" data-bs-toggle="modal"
                                              data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>

                                      <select class="form-select" name="sexesChildrenTax" id="sexesChildrenTax">
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
                                      <select class="form-select" name="relationshipsChilds" id="relationshipsChilds">
                                          <option value="" selected>@lang('labels.campoSelecao')</option>
                                          @foreach ($relationshipChild as $child)
                                              <option value="{{ $child['id'] }}">{{ $child['name'] }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>


                          </div>

                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-lg-12 mb-3">
                                  <button type="button" id="addChildrendBtn"
                                      class="btn btn-primary btn-lg btn-block">@lang('labels.addChildrenNonTax')

                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>

              </div>
          </div>

      </div>
  </div>
  <!-- End Modal -->
