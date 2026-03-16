{{-- primeira pergunta  primeira tela  / Does second second live with someone under the age of 19? --}}
<div id="otherFamily" class="tabcontent" style="display: block;">
    <input type="hidden" id="application_id" name="application_id" value="{{ $application_id ?? 0 }}">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row align-items-center">
                    <h1 class="col-form-label">@lang('labels.outroRelacionamento') {{ $applicant_name ?? '' }}</h1>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-sm">
                    <label class="col-form-label">@lang('labels.informacaoAdicionalPrimeiraPergunta') {{ $applicant_name ?? '' }}
                        @lang('labels.informacaoAdicionalPrimeiraPerguntaParte2')</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="additionalInformationCheck"
                                        id="additionalInformationcheckYes" value="1">
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
                                    <input class="mg-0" type="radio" name="additionalInformationCheck"
                                        id="additionalInformationcheckNo" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">@lang('labels.checkNo')</div>
                        </div>
                    </div>
                    {{-- <input type="hidden" id="applying_coverage" name="applying_coverage" value="1"> --}}
                </div>
            </div>
            {{-- fim primeira pergunta --}}

            {{-- segunda pergunta primeira tela --}}
            <div class="card-body" id="additionalInformation2" style="display: none;">
                <div class="row row-sm">
                    <label class="col-form-label">@lang('labels.informacaoAdicionalPrimeiraPessoa') {{ $applicant_name ?? '' }}
                        @lang('labels.informacaoAdicionalPrimeiraPessoaParte2')</label>
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="additionalInformation2Check"
                                        id="additional2checkYes" value="1">
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
                                    <input class="mg-0" type="radio" name="additionalInformation2Check"
                                        id="additional2checkNo" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">@lang('labels.checkNo')</div>
                        </div>
                    </div>
                    {{-- <input type="hidden" id="applying_coverage" name="applying_coverage" value="1"> --}}
                </div>
            </div>



            {{-- lista de dependentes --}}
            <div class="card-body" id="dependentSectionTest" style="display: none">
                <div class="row">
                    <label class="col-form-label">@lang('labels.dependent')</label>
                    <div class="col-lg-12 mb-3">
                        <ul id="dependentListDependentTest" class="list-group">
                            <!-- A lista será preenchida dinamicamente aqui -->
                        </ul>
                    </div>
                </div>
            </div>




            {{-- botão continue - voltar --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <button id="btnBackTwo" class="btn btn-primary btn-lg btn-block"
                            onclick="openTab(event, 'additionalInformation')">@lang('labels.buttonVoltar')</button>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <button id="btnContinue" class="btn btn-secondary btn-lg btn-block"
                            onclick="openTab(event, 'tabNonTax')">@lang('labels.buttonContinue')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- fim segunda pergunta  primeira tela --}}




<script>
    function updateHouseholdListMember() {
        const dependentListContainerTest = $('#dependentListDependentTest'); // Container da lista de dependentes
        const dependentSectionTest = $('#dependentSectionTest'); // Seção de dependentes


        // Filtra e gera o HTML para a lista de dependentes (field_type = 4)
        const dependents = additionalInformation.filter(member => member.field_type == 6);
        const dependentListHtml = dependents
            .map(member => {
                console.log('ID do membro:', member.id); // Verifique se o ID está correto
                return `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${member.firstname} ${member.middlename || ''} ${member.lastname}
                <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdMember(this)">Remover</a>
            </li>
        `;
            }).join('');

        console.log('Membros da household Lista Dependente:', additionalInformation);

        // Atualiza o HTML da lista com o novo conteúdo
        dependentListContainerTest.html(dependentListHtml);

        // Mostra ou esconde as seções conforme necessário
        dependentSectionTest.css('display', dependents.length > 0 ? 'block' : 'none');
    }



    // Remove um membro da lista quando o botão "Remover" é clicado
    function removeHouseholdMember(button) {
        const memberId = parseInt($(button).data('member-id')); // Obtém o ID do membro a ser removido
        console.log('ID do membro a ser removido:', memberId);

        const index = additionalInformation.findIndex(member => member.id === memberId); // Encontra o índice do membro
        console.log('Índice do membro na lista:', index);

        if (index > -1) {
            additionalInformation.splice(index, 1); // Remove o membro da array
            updateHouseholdListMember(); // Atualiza a lista de dependentes
        } else {
            console.error('Membro não encontrado na lista.');
        }

        return false; // Impede a ação padrão do link (navegação)
    }
</script>
