<div class="card-body" id="spouseSection" style="display:none">
    @if (isset($spouse) && $spouseOk == true)
        <div class="row">
            <label class="col-form-label">@lang('labels.relacaoEsposa')</label>
            <div class="col-lg-12 mb-3">
                <div class="input-group">
                    <div class="form-control">
                        <span>@lang('labels.nome'):</span> {{ $spouse['firstname'] }} {{ $spouse['lastname'] }}
                    </div>
                    <div class="form-control">
                        <span>@lang('labels.dataNascimento'):</span>
                        {{ \Carbon\Carbon::parse($spouse['birthdate'])->format('m/d/Y') }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <label class="col-form-label">@lang('labels.householdDemaisSolicitante')</label>
            <div class="col-lg-6 mb-3">
                <a href="#" class="btn btn-outline-secondary btn-lg btn-block"
                    id="btnAddSpouse">@lang('labels.householdAddConjuge')</a>
            </div>
        </div>
    @endif
</div>

<div class="card-body" id="spouseSectionTest" style="display: none">
    <div class="row">
        <label class="col-form-label">@lang('labels.relacaoEsposa')</label>
        <div class="col-lg-12 mb-3">
            <ul id="spouseListTest" class="list-group">
                <!-- A lista será preenchida dinamicamente aqui -->
            </ul>
        </div>
    </div>
</div>



    <script>
    function updateHouseholdListSpouse() {
        const spouseListTest = $('#spouseListTest'); // Container da lista de dependentes
        const spouseSectionTest = $('#spouseSectionTest'); // Seção de dependentes
        console.log('Membros da household Lista ESPOSA:', householdMembers);


        // Filtra e gera o HTML para a lista de dependentes (field_type = 4)
        const member = householdMembers.filter(member => member.field_type == 3);
        const spouseListHtml = member
            .map(member => `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${member.firstname} ${member.middlename || ''} ${member.lastname}
                <a href="#" class="btn btn-outline-secondary btn-sm" data-member-id="${member.id}" onclick="removeHouseholdSpouse(this)">Remover</a>
            </li>
        `).join('');
        // Atualiza o HTML da lista com o novo conteúdo
        spouseListTest.html(spouseListHtml);

        // Mostra ou esconde as seções conforme necessário
        spouseSectionTest.css('display', member.length > 0 ? 'block' : 'none');
    }



    // Remove um membro da lista quando o botão "Remover" é clicado
    function removeHouseholdSpouse(button) {
        const memberId = $(button).data('member-id'); // Obtém o ID do membro a ser removido
        const index = householdMembers.findIndex(member => member.id === memberId); // Encontra o índice do membro

        if (index > -1) {
            householdMembers.splice(index, 1); // Remove o membro da array
            updateHouseholdListSpouse(); // Atualiza a lista de cônjuges e dependentes
        }
        return false; // Impede a ação padrão do link (navegação)
    }
    </script>