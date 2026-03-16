                      {{-- Pergunta 5 - Are you claiming any dependents on your taxes for 2024? --}}

                      <div class="row row-sm" id="impostoConjuge" style="display: none; margin-left: 10px">
                          <label class="col-form-label">@lang('labels.householdDeclaracaoImpostoConjuge', ['year' => date('Y')])</label>
                          <div class="col-lg-12 mb-3">
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="input-group me-2">
                                      <div class="input-group-text">
                                          <label class="rdiobox wd-16 mg-b-0">
                                              <input class="mg-0" type="radio" name="checkHouseholdConjuge"
                                                  id="showHouseholdConjugeYes" value="1">
                                              <span></span>
                                          </label>
                                      </div>
                                      <div class="form-control">
                                          @lang('labels.checkYes')
                                      </div>
                                  </div>

                                  <div class="input-group">
                                      <div class="input-group-text">
                                          <label class="rdiobox wd-16 mg-b-0">
                                              <input class="mg-0" type="radio" name="checkHouseholdConjuge"
                                                  id="showHouseholdConjugeNo" value="0">
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



                      <div class="card-body" id="dependentSection4Pergunta" style="display:none">
                          <!-- Verifica se temos um member e listar os otherMembers -->
                          @if ($current_member && $current_member->otherMembers)
                              @foreach ($current_member->otherMembers as $otherMember)
                                  <div class="row mb-3">
                                      <label class="col-form-label col-lg-12">@lang('labels.dependent')</label>
                                      <div class="col-lg-12 mb-3">
                                          <div class="position-relative border p-3 rounded">
                                              <!-- Checkbox para os membros relacionados -->
                                              <input type="checkbox"
                                                  class="form-check-input position-absolute start-0 top-50 translate-middle-y ms-2"
                                                  id="memberCheckbox_{{ $otherMember->id }}"
                                                  value="{{ $otherMember->id }}">

                                              <div class="d-flex justify-content-between align-items-center ms-5">
                                                  <!-- Nome do outro membro relacionado -->
                                                  <label class="form-check-label mb-0"
                                                      for="memberCheckbox_{{ $otherMember->id }}">
                                                      {{ $otherMember->firstname }} {{ $otherMember->lastname }}
                                                  </label>
                                                  <!-- Data de nascimento (adicione se precisar) -->
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          @else
                              <!-- Se não houver member ou otherMembers, mostrar mensagem ou outro conteúdo -->
                              <p>@lang('labels.noRelatedMembers')</p>
                          @endif
                      </div>
                      {{-- usa a modal-someone --}}

                        <div class="row row-sm" id="addDependente" style="display: none; margin-left: 10px">
                          <div class="row">
                              <label class="col-form-label ">@lang('labels.householdDependente')</label>
                              <div class="col-lg-6 mb-3">
                                  <a class="modal-effect btn btn-outline-secondary btn-lg btn-block"
                                      data-bs-effect="effect-scale" data-bs-toggle="modal"
                                      href="#modalDemoAddDependents">@lang('labels.householdAddDependente')</a>
                              </div>
                          </div>
                      </div>


                      <div class="card-body" id="dependentSection2" style="display: none; margin-left: 10px">
                          <div class="row">
                              <label class="col-form-label">@lang('labels.dependent')</label>
                              <div class="col-lg-12 mb-3">
                                  <ul id="dependentListDependent2" class="list-group">
                                      <!-- A lista será preenchida dinamicamente aqui -->
                                  </ul>
                              </div>
                          </div>
                      </div>


                      <script>
                          document.addEventListener("DOMContentLoaded", function() {
                              const btnAddAnotherPerson = document.getElementById('btnAddAnotherPerson');

                              btnAddAnotherPerson.addEventListener('click', function(event) {
                                  event.preventDefault();

                                  // Obtém todos os checkboxes marcados
                                  const selectedMembers = Array.from(document.querySelectorAll(
                                          'input[type="checkbox"]:checked'))
                                      .map(checkbox => checkbox.value);


                                  console.log("Membros selecionados quinta pergunta:", selectedMembers);

                                  // Aqui você pode processar os IDs dos membros selecionados como precisar
                              });
                          });



                          function updateHouseholdListDependent2() {
                              const dependentListContainer2 = $('#dependentListDependent2'); // Container da lista de dependentes
                              const dependentSection2 = $('#dependentSection2'); // Seção de dependentes
                              console.log('Membros da household Lista Dependente:', householdMembers);


                              // Filtra e gera o HTML para a lista de dependentes (field_type = 5)
                              const dependents = householdMembers.filter(member => member.field_type == 5);
                              const dependentListHtml = dependents
                                  .map(member => `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${member.firstname} ${member.middlename || ''} ${member.lastname}
                <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdMemberDependentClaiming(this)">Remover</a>
            </li>
        `).join('');

                              // Atualiza o HTML da lista com o novo conteúdo
                              dependentListContainer2.html(dependentListHtml);

                              // Mostra ou esconde as seções conforme necessário
                              dependentSection2.css('display', dependents.length > 0 ? 'block' : 'none');
                          }



                          // Remove um membro da lista quando o botão "Remover" é clicado
                          function F(button) {
                              const memberId = $(button).data('member-id'); // Obtém o ID do membro a ser removido
                              const index = householdMembers.findIndex(member => member.id === memberId); // Encontra o índice do membro

                              if (index > -1) {
                                  householdMembers.splice(index, 1); // Remove o membro da array
                                  updateHouseholdListDependent2(); // Atualiza a lista de cônjuges e dependentes
                              }
                              return false; // Impede a ação padrão do link (navegação)
                          }

                          // Remove um membro da lista quando o botão "Remover" é clicado
                          function removeHouseholdMemberDependentClaiming(button) {
                              const memberId = $(button).data('member-id'); // Obtém o ID do membro a ser removido
                              const index = householdMembers.findIndex(member => member.id === memberId); // Encontra o índice do membro

                              if (index > -1) {
                                  householdMembers.splice(index, 1); // Remove o membro da array
                                  updateHouseholdListDependent2(); // Atualiza a lista de cônjuges e dependentes
                              }
                              return false; // Impede a ação padrão do link (navegação)
                          }
                      </script>
