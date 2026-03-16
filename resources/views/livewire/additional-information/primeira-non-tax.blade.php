 {{-- primeira pergunta Non Tax --}}
 <div id="nonTax" class="tabcontent" style="display: none;">
     <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
         <div class="card">
             <div class="card-body">
                 <div class="form-group row align-items-center">
                     <h1 class="col-form-label">{{ __('labels.situacaoNonFiler', ['name' => $applicant_name ?? '']) }}
                     </h1>

                 </div>
             </div>
             <div class="card-body">
                 <div class="row row-sm">
                     <label class="col-form-label">
                         {{ __('labels.informacaoAdicionalNonTax', ['name' => $applicant_name ?? '', 'address' => $applicant_addresses[0]['street_address'] ?? '']) }}</label>
                     <div class="col-lg-6 mb-3">
                         <div class="input-group">
                             <div class="input-group-text">
                                 <label class="rdiobox wd-16 mg-b-0">
                                     <input class="mg-0" type="radio" name="nonTaxCheck" id="nonTaxCheckYes"
                                         value="1">
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
                                     <input class="mg-0" type="radio" name="nonTaxCheck" id="nonTaxCheckNo"
                                         value="0">
                                     <span></span>
                                 </label>
                             </div>
                             <div class="form-control">@lang('labels.checkNo')</div>
                         </div>
                     </div>
                 </div>
             </div>

             {{-- segunda pergunta Non Tax  --}}
             <div class="card-body" id="additionalTax" style="display: none;">
                 <div class="row row-sm">
                     <label class="col-form-label">@lang('labels.nonFilerFilhoFilha', ['name' => $applicant_name ?? '', 'address' => $applicant_addresses[0]['street_address'] ?? ''])</label>
                     <div class="col-lg-6 mb-3">
                         <div class="input-group">
                             <div class="input-group-text">
                                 <label class="rdiobox wd-16 mg-b-0">
                                     <input class="mg-0" type="radio" name="nonTax2Check" id="nonTax2checkYes"
                                         value="1">
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
                                     <input class="mg-0" type="radio" name="nonTax2Check" id="nonTax2checkNo"
                                         value="0">
                                     <span></span>
                                 </label>
                             </div>
                             <div class="form-control">@lang('labels.checkNo')</div>
                         </div>
                     </div>
                 </div>
                 {{-- botao adicionar Children --}}
                 <div class="card-body" style="display: none;" id="btnAddChildren">
                     <div class="row">
                         <label class="col-form-label">@lang('labels.nonTaxAddChildren')</label>
                         <div class="col-lg-10 mx-auto mb-3">
                             <a href="#" class="btn btn-outline-secondary btn-lg btn-block"
                                 id="btnAddChildrenSubmit">@lang('labels.nonTaxAddChildrenBtn')</a>
                         </div>
                     </div>
                 </div>
                 {{-- fim botao adicionar Children --}}
             </div>


             {{-- lista de dependentes --}}
             <div class="card-body" id="dependentSectionChildren" style="display: none">
                 <div class="row">
                     <label class="col-form-label">@lang('labels.dependent')</label>
                     <div class="col-lg-12 mb-3">
                         <ul id="dependentListDependentChildren" class="list-group">
                             <!-- A lista será preenchida dinamicamente aqui -->
                         </ul>
                     </div>
                 </div>
             </div>


             {{-- Botões Voltar e Continuar --}}
             <div class="card-body">
                 <div class="row">
                     <div class="col-lg-6 mb-3">
                         <button id="btnBackTwo" class="btn btn-primary btn-lg btn-block"
                             onclick="openTab(event, 'additionalInformation')">@lang('labels.buttonVoltar')</button>
                     </div>
                     <div class="col-lg-6 mb-3">
                         <button class="btn btn-secondary btn-lg btn-block" onclick="sendFormHousehold(this)">
                             @lang('labels.buttonContinue')</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 {{-- fim segunda pergunta --}}




 <script>
     function updateHouseholdListChildren() {
         const dependentListContainerChildren = $(
         '#dependentListDependentChildren'); // Container da lista de dependentes
         const dependentSectionChildren = $('#dependentSectionChildren'); // Seção de dependentes

additionalInformation.forEach(member => {
    console.log('Valor de relationship:', member.relationship, 'Tipo:', typeof member.relationship);
});
         // Filtra e gera o HTML para a lista de dependentes (field_type = 4)
const dependents = additionalInformation.filter(member => member.relationship == 17); // Comparação numérica
         const dependentListHtml = dependents
             .map(member => {
                 console.log('ID do membro:', member.id); // Verifique se o ID está correto
                 return `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${member.firstname} ${member.middlename || ''} ${member.lastname}
                <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdChildren(this)">@lang('labels.buttonRemover')</a>
            </li>
        `;
             }).join('');

         console.log('Membros da household Lista Dependente:', additionalInformation);

         // Atualiza o HTML da lista com o novo conteúdo
         dependentListContainerChildren.html(dependentListHtml);

         // Mostra ou esconde as seções conforme necessário
         dependentSectionChildren.css('display', dependents.length > 0 ? 'block' : 'none');
     }

     //<a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdChildren(this)">Remover</a>


     // Remove um membro da lista quando o botão "Remover" é clicado
     function removeHouseholdChildren(button) {
         const memberId = parseInt($(button).data('member-id')); // Obtém o ID do membro a ser removido
         console.log('ID do membro a ser removido:', memberId);

         const index = additionalInformation.findIndex(member => member.id === memberId); // Encontra o índice do membro
         console.log('Índice do membro na lista:', index);

         if (index > -1) {
             additionalInformation.splice(index, 1); // Remove o membro da array
             updateHouseholdListChildren(); // Atualiza a lista de dependentes
         } else {
             console.error('Membro não encontrado na lista.');
         }

         return false; // Impede a ação padrão do link (navegação)
     }
 </script>
