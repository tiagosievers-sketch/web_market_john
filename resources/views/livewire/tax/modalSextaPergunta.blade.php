    <!-- Modal da sexta pergunta, will be... -->
    <div class=" modal fade" id="modaldemo9" tabindex="-1" aria-labelledby="modaldemo9Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">



                            <div class="card-body" id="dependentSectionModalSexta">
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
                                                        value="{{ $otherMember->id }}" name="memberCheckbox"
                                                        onclick="ensureSingleSelection(this)">

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





                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label">@lang('labels.householdDeclarante', ['year', date('Y')])</label>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="checkbox wd-16 mg-b-0">
                                                    <input class="mg-0" type="checkbox" name="reclamanteimposto"
                                                        value="1">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">
                                                @lang('labels.householdAlguem')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            <div class="card-body" display="none" id="modalSextaPerguntaFirstName">
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.nome')</label>
                                        <input type="text" class="form-control" name="nameDependentTax"
                                            id="nameDependentTax" placeholder="@lang('labels.nome')">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.campoCentral')</label>
                                        <input type="text" class="form-control" name="middleDependentTax"
                                            id="middleDependentTax" placeholder="@lang('labels.campoCentral')">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.sobreNome')</label>
                                        <input type="text" class="form-control" name="lastnameDependentTax"
                                            id="lastnameDependentTax" placeholder="@lang('labels.sobreNome')">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.suffix')</label>
                                        <select class="form-select" name="suffixesDependentTax"
                                            id="suffixesDependentTax">
                                            <option value="" selected>@lang('labels.campoSelecao')</option>
                                            @foreach ($suffixes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.dataNascimento')</label>
                                        <input class="form-control" name="dateDependentTax" id="dateDependentTax"
                                            placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">@lang('labels.campoSexo') <i
                                                class="fas fa-question custom-tooltip" data-bs-toggle="modal"
                                                data-bs-target="#alertModalSexo" title="@lang('labels.msgClicar')"></i></label>
                                        <select class="form-select" name="sexesDependentTax" id="sexesDependentTax">
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
                                        <select class="form-select" name="relationshipsDependentTax"
                                            id="relationshipsDependentTax">
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
                                                            <input class="mg-0" type="radio"
                                                                name="liveswithyouTax" value="1">
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
                                                            <input class="mg-0" type="radio"
                                                                name="liveswithyouTax" value="0">
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

                            </div>
                            <div class="card-body">
                                <div class="row row-sm">
                                    <label class="col-form-label">@lang('labels.householdInformacao')</label></label>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="rdiobox wd-16 mg-b-0">
                                                    <input class="mg-0" type="radio" name="provideClaiming"
                                                        value="1">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">Yes</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label class="rdiobox wd-16 mg-b-0">
                                                    <input class="mg-0" type="radio" name="provideClaiming"
                                                        value="0">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="form-control">No</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <button type="button" id="addDependentTexbtn"
                                            class="btn btn-primary btn-lg btn-block">@lang('labels.householdAddDependente')

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="card-body" id="dependentTaxMember" style="display: none">
        <div class="row">
            <label class="col-form-label">@lang('labels.relacaoEsposa')</label>
            <div class="col-lg-12 mb-3">
                <ul id="dependentTaxList" class="list-group">
                    <!-- A lista será preenchida dinamicamente aqui -->
                </ul>
            </div>
        </div>
    </div>


    </div>



    <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Obtém o checkbox do 'reclamanteimposto' e a div para o nome
    const checkbox = document.querySelector('input[name="reclamanteimposto"]');
    const modalSextaPerguntaFirstName = document.querySelector('#modalSextaPerguntaFirstName');

    // Esconde a div inicialmente
    modalSextaPerguntaFirstName.style.display = "none";

    // Adiciona um evento de clique ao checkbox 'reclamanteimposto'
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            // Mostra os campos se o checkbox for marcado
            modalSextaPerguntaFirstName.style.display = "block";
        } else {
            // Esconde os campos se o checkbox for desmarcado
            modalSextaPerguntaFirstName.style.display = "none";
        }
        // Desabilita os checkboxes de membros quando 'reclamanteimposto' for marcado
        toggleCheckboxState();
    });

    // Obtém os checkboxes de membros
    const memberCheckboxes = document.querySelectorAll('input[name="memberCheckbox"]');

    // Função para garantir que apenas um checkbox de membro seja selecionado
    function ensureSingleSelection(checkbox) {
        memberCheckboxes.forEach(function(item) {
            if (item !== checkbox) {
                item.checked = false;
            }
        });
        // Desabilita o 'reclamanteimposto' quando algum 'memberCheckbox' for marcado
        handleMemberCheckboxSelection();
    }

    // Função para desmarcar e desabilitar os checkboxes de membros
    function toggleCheckboxState() {
        // Se 'reclamanteimposto' for marcado, desmarcar e desabilitar os 'memberCheckboxes'
        if (checkbox.checked) {
            memberCheckboxes.forEach(function(item) {
                item.checked = false;
                item.disabled = true; // Desabilita os checkboxes
            });
        } else {
            memberCheckboxes.forEach(function(item) {
                item.disabled = false; // Reabilita os checkboxes
            });
        }
    }

    // Função para desmarcar 'reclamanteimposto' se algum 'memberCheckbox' for marcado
    function handleMemberCheckboxSelection() {
        let isAnyMemberCheckboxChecked = false;

        memberCheckboxes.forEach(function(item) {
            if (item.checked) {
                isAnyMemberCheckboxChecked = true;
            }
        });

        if (isAnyMemberCheckboxChecked) {
            checkbox.checked = false;
            checkbox.disabled = true; // Desabilita o 'reclamanteimposto'
        } else {
            checkbox.disabled = false; // Reabilita o 'reclamanteimposto'
        }
    }

    // Adiciona o evento de mudança para cada 'memberCheckbox'
    memberCheckboxes.forEach(function(item) {
        item.addEventListener('change', function() {
            ensureSingleSelection(item);
        });
    });
});

    </script>
