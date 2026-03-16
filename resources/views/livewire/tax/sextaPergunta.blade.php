    {{-- Pergunta 6 - 'householdDeclaracaoImposYou' => 'Will you be claimed as a tax dependent by someone else for 2024?', --}}
    <div class="row row-sm" id="imposYou" style="display: none; margin-left: 10px">
        <label class="col-form-label">@lang('labels.householdDeclaracaoImposYou', ['year' => date('Y')])</label>
        <div class="col-lg-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="input-group me-2">
                    <div class="input-group-text">
                        <label class="rdiobox wd-16 mg-b-0">
                            <input class="mg-0" type="radio" name="dependent" id="showHouseholdImposYouYes"
                                value="1">
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
                            <input class="mg-0" type="radio" name="dependent" id="showHouseholdImposYouNo"
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
        <div class="card-body" id="dependentSection3" style="display: none">
            <div class="row">
                <label class="col-form-label">@lang('labels.dependent')</label>
                <div class="col-lg-12 mb-3">
                    <ul id="dependentListContainer3" class="list-group">
                        <!-- A lista será preenchida dinamicamente aqui -->
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <script>
        function updateHouseholdListDependentTax2() {
            const dependentListContainer3 = $('#dependentListContainer3');
            const dependentSection3 = $('#dependentSection3');

            console.log('Membros da household Lista Dependente tax2:', householdMembers);

            // Filtra dependentes com field_type 4 e nomes não vazios
            const dependents = householdMembers.filter(member =>
                member.field_type === 4 && member.firstname.trim() !== '' && member.lastname.trim() !== ''
            );

            if (dependents.length === 0) {
                console.log('Nenhum dependente válido encontrado.');
            } else {
                console.log('Dependentes válidos:', dependents);
            }

            // Mapeia dependentes para gerar o HTML
            const dependentListHtml = dependents.map(member => `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ${member.firstname} ${member.middlename || ''} ${member.lastname}
            <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdMemberDependentTax(this)">Remover</a>
        </li>
    `).join('');

            // Atualiza o conteúdo do container
            if (dependentListContainer3.length > 0) {
                dependentListContainer3.html(dependentListHtml);
            }

            // Mostra ou esconde a seção dependendo se há dependentes
            if (dependentSection3.length > 0) {
                dependentSection3.css('display', dependents.length > 0 ? 'block' : 'none');
            }
        }



        // Remove um membro da lista quando o botão "Remover" é clicado
        function removeHouseholdMemberDependentTax(button) {
            const memberId = $(button).data('member-id'); // Obtém o ID do membro a ser removido
            const index = householdMembers.findIndex(member => member.id === memberId); // Encontra o índice do membro

            if (index > -1) {
                householdMembers.splice(index, 1); // Remove o membro da array
                updateHouseholdListDependentTax2(); // Atualiza a lista de cônjuges e dependentes
            }
            return false; // Impede a ação padrão do link (navegação)
        }
    </script>
