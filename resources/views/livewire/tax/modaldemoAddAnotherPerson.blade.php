    <div class="modal fade" id="modaldemoAddAnotherPerson" tabindex="-1" aria-labelledby="modaldemoAddAnotherPersonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">

                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">@lang('labels.householdAddPessoa')</h1>
                            <button type="button" class="btn btn-primary ms-auto"
                                data-bs-dismiss="modal">@lang('labels.buttonCancelar')</button>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.nome'):</div>
                                        <input type="text" class="form-control" name="namePerson" id="namePerson"
                                            placeholder="@lang('labels.nome')">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-text">@lang('labels.campoCentral'):</div>
                                        <input type="text" class="form-control" name="middlePerson" id="middlePerson"
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
                                        <input type="text" class="form-control" name="lastnamePerson"
                                            id="lastnamePerson" placeholder="@lang('labels.sobreNome')">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group ">
                                        <span class="input-group-text">@lang('labels.suffix'):</span>
                                        <select class="form-select" name="suffixPerson" id="suffixPerson">
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
                                        <input class="form-control" name="birthdatePerson" id="birthdatePerson"
                                            placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                     <div class="invalid-feedbackPerson" style="display: none;">
                                        <!-- Inicialmente escondida -->
                                        <!-- A mensagem de erro será inserida aqui -->
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('labels.campoSexo') <i class="fas fa-question"
                                                data-bs-toggle="modal" data-bs-target="#alertModalSexo"
                                                title="@lang('labels.msgClicar')"></i></span>
                                        <select class="form-select" id="sexPerson" name="sexPerson" required>
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($sexes as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-12 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('labels.householdRelacionamento'):</span>
                                        <select class="form-select" name="relationshipPerson" id="relationshipPerson">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($relationships as $key => $value)
                                                <option value="{{ $key }}">@lang('labels.' . $value)</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="row mb-3 ml-3" style="margin-left: 10px;">
                          <div class="col-lg-7">
                              <label class="form-label">@lang('labels.householdConfirmacao') <span class="text-danger">@lang('labels.msgRequerido')</span></label>
                              <div class="row">
                                  <div class="col-lg-6 mb-3">
                                      <div class="input-group">
                                          <div class="input-group-text">
                                              <label class="rdiobox wd-16 mg-b-0">
                                                  <input class="mg-0" type="radio" name="liveswithyouPerson"
                                                      value="1">
                                                  <span></span>
                                              </label>
                                          </div>
                                          <div class="form-control">
                                              @lang('labels.checkYes')
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-lg-6 mb-3">
                                      <div class="input-group">
                                          <div class="input-group-text">
                                              <label class="rdiobox wd-16 mg-b-0">
                                                  <input class="mg-0" type="radio" name="liveswithyouPerson"
                                                      value="0">
                                                  <span></span>
                                              </label>
                                          </div>
                                          <div class="form-control">
                                              @lang('labels.checkNo')
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <a href="#" id="savePersonBtn"
                                        class="btn btn-primary btn-lg btn-block">@lang('labels.buttonSalvarPessoa')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Seção para a lista de dependentes -->
                <div class="card-body" id="dependentSectionAnother" style="display: none">
                    <div class="row">
                        <label class="col-form-label">@lang('labels.dependent')</label>
                        <div class="col-lg-12 mb-3">
                            <ul id="dependentListAnother" class="list-group">
                                <!-- A lista será preenchida dinamicamente aqui -->
                            </ul>
                        </div>
                    </div>
                </div>


    <script>
      document.addEventListener("DOMContentLoaded", function() {
            const btnAddAnotherPerson = document.getElementById('btnAddAnotherPerson');
            const modaldemoAddAnotherPerson = new bootstrap.Modal(document.getElementById(
                'modaldemoAddAnotherPerson'));

            btnAddAnotherPerson.addEventListener('click', function(event) {
                event.preventDefault();
                modaldemoAddAnotherPerson.show();
            });
        });



        
    function updateHouseholdListAnother() {
        const dependentListContainerAnother = $('#dependentListAnother'); // Container da lista de dependentes
        const dependentSectionAnother = $('#dependentSectionAnother'); // Seção de dependentes
        console.log('Membros da household Lista Dependente:', householdMembers);


        // Filtra e gera o HTML para a lista de dependentes (field_type = 4)
        const dependents = householdMembers.filter(member => member.field_type == 6);
        const dependentListHtml = dependents
            .map(member => `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${member.firstname} ${member.middlename || ''} ${member.lastname}
                <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdMemberAnother(this)">Remover</a>
            </li>
        `).join('');

        // Atualiza o HTML da lista com o novo conteúdo
        dependentListContainerAnother.html(dependentListHtml);

        // Mostra ou esconde as seções conforme necessário
        dependentSectionAnother.css('display', dependents.length > 0 ? 'block' : 'none');
    }



 // Remove um membro da lista quando o botão "Remover" é clicado
function removeHouseholdMemberAnother(button) {
    const memberId = $(button).data('member-id'); // Obtém o ID do membro a ser removido
    const index = householdMembers.findIndex(member => member.id == memberId); // Usar == para garantir a comparação

    if (index > -1) {
        householdMembers.splice(index, 1); // Remove o membro da array
        updateHouseholdListAnother(); // Atualiza a lista de dependentes
    } else {
        console.error("Membro não encontrado:", memberId);
    }
    return false; // Impede a ação padrão do link (navegação)
}

</script>