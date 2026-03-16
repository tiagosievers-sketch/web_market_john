@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">

    <style>
        .form-check-input {
            margin-left: -25px;
            /* Move o checkbox mais para fora da borda */
        }

        .form-check-label {
            margin-left: 10px;
            /* Ajusta o espaçamento entre o checkbox e o nome */
        }

        .position-absolute {
            top: 50%;
            /* Centraliza o checkbox verticalmente */
            transform: translateY(-50%);
            /* Ajuste preciso para centralização */
        }
    </style>
@endsection

@section('content')
    @include('livewire.tax.breadcrumb-header')



    <!-- Modal modalAddSpouse -->
    @include('livewire.tax.modalAddSpouse')



    <!-- Modal modalAddAnotherPerson -->
    @include('livewire.tax.modaldemoAddAnotherPerson')



    <!-- Modal modaldemoAlerta -->
    @include('livewire.tax.modaldemoAlerta')



    {{-- inicio tax --}}
    <div id="taxHousehold" class="tabcontent">
        <!-- END BREADCRUMB -->
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <h1 class="col-form-label ">@lang('labels.householdInformacoesFiscais')</h1>
                        <span id="currentMemberName" class="col-form-label">@lang('labels.member'):
                            <strong>{{ $current_member['firstname'] ?? 'N/A' }}
                                {{ $current_member['lastname'] ?? '' }}</strong></span>

                    </div>
                </div>


                {{-- pergunta 1 - Are you married --}}
                @include('livewire.tax.primeiraPergunta')


                {{-- listar esposa se existir ou botão de adicionar nova --}}
                @include('livewire.tax.spouseSection')


                {{-- pergunta 2 --}}
                @include('livewire.tax.segundaPergunta')


                {{-- 3 pergunta Are you filing taxes jointly with your spouse for 2024? --}}
                @include('livewire.tax.terceiraPergunta')



                @if ($current_member['tax_claimant'] == null)
                    {{-- esta --}}
                    {{-- pergunta 4  Are you and your spouse claiming any dependents on your taxes for 2024?? --}}
                    @include('livewire.tax.quartaPergunta')



                    {{-- dependentSection --}}
                    @include('livewire.tax.dependentSection')




                    {{-- Esta --}}
                    {{-- Pergunta 5 - Are you claiming any dependents on your taxes for 2024? --}}
                    @include('livewire.tax.quintaPergunta')





                    {{-- esta --}}
                    {{-- Pergunta 6 - 'householdDeclaracaoImposYou' => 'Will you be claimed as a tax dependent by someone else for 2024?', --}}
                    @include('livewire.tax.sextaPergunta')

                    {{-- fim --}}
                @endif



                {{-- <!-- Seção para a lista de dependentes -->
                <div class="card-body" id="dependentSection" style="display: none">
                    <div class="row">
                        <label class="col-form-label">@lang('labels.dependent')</label>
                        <div class="col-lg-12 mb-3">
                            <ul id="dependentList" class="list-group">
                                <!-- A lista será preenchida dinamicamente aqui -->
                            </ul>
                        </div>
                    </div>
                </div> --}}

            </div>







            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <button id="btnBack" class="btn btn-primary btn-lg btn-block"
                            onclick="openTab(event, 'household')">@lang('labels.buttonVoltar')</button>
                    </div>

                    <div class="col-lg-6 mb-3">
                        <a href="#" class="btn btn-secondary btn-lg btn-block" onclick="sendFormHousehold(this)">
                            @lang('labels.buttonContinue')</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @include('livewire.tax.modal-someone')



    </div>
    <!-- End Modal -->


    <!-- Modal da sexta pergunta, will be... -->
    @include('livewire.tax.modalSextaPergunta')

    {{-- fim tax --}}





    <!-- Modal de alerta Married-->

    @include('livewire.tax.alertModal')


    <!--End modal alerta -->


    <!-- Modal de alerta sobre o sexo -->
    @include('livewire.tax.modalSexo')



    <!-- Spinner de carregamento -->
    {{-- <div class="loader" id="loader">
        <div class="spinner"></div>
    </div> --}}


    <!-- Spinner de carregamento -->
    <div id="loading-spinner"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; align-items: center; justify-content: center;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Mostar msg Modal JS -->
    <script src="{{ asset('/js/msgModal.js') }}"></script>
    <script src="{{ asset('/js/tax/tax.js') }}"></script>


    <!-- INTERNAL DATEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- INTERNAL JQUERY.MASKEDINPUT JS -->
    <script src="{{ asset('/build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL SPECTRUM-COLORPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ asset('/build/assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- INTERNAL ION-RANGESLIDER JS -->
    <script src="{{ asset('/build/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <!-- INTERNAL JQUERY-AMAZEUI DATETIMEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

    <!-- INTERNAL JQUERY-SIMPLE DATETIMEPICKER JS -->
    <script src="{{ asset('/build/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

    <!-- INTERNAL FORM-ELEMENTS JS -->
    {{-- <script src="{{ asset('/resources/assets/js/form-elements.js') }}"></script> --}}

    <!-- Adicionando o SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const taxClaimant = {{ $current_member['tax_claimant'] ?? 'null' }};

            // Se tax_claimant diferente null, ocultar as perguntas
            if (taxClaimant != null) {
                document.getElementById('quartaPergunta').style.display = 'none';
                document.getElementById('dependentSection').style.display = 'none';
                document.getElementById('quintaPergunta').style.display = 'none';
                document.getElementById('sextaPergunta').style.display = 'none';
            } else {
                // Se for diferente  null, mostrar as perguntas
                document.getElementById('quartaPergunta').style.display = 'block';
                document.getElementById('dependentSection').style.display = 'block';
                document.getElementById('quintaPergunta').style.display = 'block';
                document.getElementById('sextaPergunta').style.display = 'block';
            }
        });

        //{{-- checkbox --}}

        $(document).ready(function() {
            // Adiciona um evento de clique aos campos de rádio
            $('input[type="radio"][name="checkYes"]').click(function() {
                if ($(this).is(':checked')) {
                    // Desmarca o outro campo de rádio
                    $('input[type="radio"][name="checkNo"]').prop('checked', false);
                    // Atualiza o valor do campo oculto
                    $('input[name="checkYes"]').val('1');
                    $('input[name="checkNo"]').val('0');
                }
            });

            $('input[type="radio"][name="checkNo"]').click(function() {
                if ($(this).is(':checked')) {
                    // Desmarca o outro campo de rádio
                    $('input[type="radio"][name="checkYes"]').prop('checked', false);
                    // Atualiza o valor do campo oculto
                    $('input[name="checkYes"]').val('0');
                    $('input[name="checkNo"]').val('1');
                }
            });

            // Defina os valores iniciais dos campos ocultos com base na seleção atual dos botões de rádio
            if ($('input[type="radio"][name="checkYes"]').is(':checked')) {
                $('input[name="checkYes"]').val('1');
                $('input[name="checkNo"]').val('0');
            } else if ($('input[type="radio"][name="checkNo"]').is(':checked')) {
                $('input[name="checkYes"]').val('0');
                $('input[name="checkNo"]').val('1');
            } else {
                // Se nenhum botão estiver selecionado, defina ambos os campos ocultos como 0
                $('input[name="checkYes"]').val('0');
                $('input[name="checkNo"]').val('0');
            }
        });
        //end checkbox


        document.addEventListener("DOMContentLoaded", function() {
            const btnAddSpouse = document.getElementById('btnAddSpouse');
            const modalAddSpouse = new bootstrap.Modal(document.getElementById('modalAddSpouse'));

            btnAddSpouse.addEventListener('click', function(event) {
                event.preventDefault();
                modalAddSpouse.show();
            });
        })




        const householdMembers = [];
        let nextId = 1; // Contador para IDs únicos



        console.log('householdMembers:', householdMembers);



        function addhouseholdSpouse(tax) {

            const liveswith = $('input[name="liveswithyouSpouse"]:checked').val() === '1'; // Garantir que é booleano

            const spouse = {
                id: nextId++, // Atribui um ID único
                'firstname': $('#nameSpouse').val(),
                'middlename': $('#middleSpouse').val(),
                'lastname': $('#lastnameSpouse').val(),
                'suffix': $('#suffixSpouse').val(),
                'birthdate': $('#birthdateSpouse').val(),
                'sex': $('#sexSpouse').val(),
                'relationship': <?php echo $spouse_id ?? 10; ?>,
                'tax_form': tax,
                'lives_with_you': liveswith, // Armazena como booleano
                'married': 1,
                'tax_claimant': null,
                'eligible_cost_saving': null,
                'field_type': 3,
                'income_predicted_amount': 0,
            };

            console.log('Objeto spouse criado:', spouse); // Verifique se "lives_with_you" está correto (true ou false)


            addhouseholdMembers(spouse);
            updateHouseholdListSpouse(); // Atualiza a lista após adicionar o cônjuge
        }




        //usado no modaldemoaddAnotherPerson.blade.php - //Add another person
        function addhouseholdPerson(tax) {

            const liveswith = $('#liveswithyouPerson:checked').val() || '1';

            const person = {
                id: nextId++, // Atribui um ID único
                'firstname': $('#namePerson').val(),
                'middlename': $('#middlePerson').val(),
                'lastname': $('#lastnamePerson').val(),
                'suffix': $('#suffixPerson').val(),
                'birthdate': $('#birthdatePerson').val(),
                'sex': $('#sexPerson').val(),
                'relationship': $('#relationshipPerson').val(),
                'lives_with_you': liveswith,
                'tax_form': tax,
                'tax_claimant': null,
                'eligible_cost_saving': null,
                'field_type': 5, // Inicia em 2
                'income_predicted_amount': 0,
            };

            addhouseholdMembers(person);
            updateHouseholdListDependent(); // Atualiza a lista após adicionar outra pessoa
        }


        function addhouseholdDependentTax(tax) {
            const liveswith = $('input[name="liveswithyouTax"]:checked').val() === '1'; // Garantir que é booleano
            const taxClaimantValue = $('input[name="provideClaiming"]').is(':checked');

            // Verifica se os campos essenciais estão preenchidos
            const firstname = $('#nameDependentTax').val().trim();
            const lastname = $('#lastnameDependentTax').val().trim();
            const birthdate = $('#dateDependentTax').val().trim();
            const sex = $('#sexesDependentTax').val();
            const relationship = $('#relationshipsDependentTax').val();

            // Verifica se os campos de nome, sobrenome, data de nascimento, sexo e relacionamento estão preenchidos
            if (!firstname || !lastname || !birthdate || !sex || !relationship) {
                console.log('Dependente não adicionado: Campos obrigatórios estão faltando.');
                return; // Interrompe a função sem adicionar o dependente
            }

            const dependentTax = {
                id: nextId++, // Atribui um ID único
                'firstname': firstname,
                'middlename': $('#middleDependentTax').val(),
                'lastname': lastname,
                'suffix': $('#suffixesDependentTax').val(),
                'birthdate': birthdate,
                'sex': sex,
                'relationship': relationship,
                'tax_form': tax,
                'lives_with_you': liveswith,
                'tax_claimant': taxClaimantValue,
                'field_type': 4,
            };

            addhouseholdMembers(dependentTax);
            updateHouseholdListDependentTax2(); // Atualiza a lista após adicionar outra pessoa
        }




        //add da quinta pergunta Are you claiming any dependents on your taxes for 2024?
        //usa a modal-someone
        function addhouseholdDependent(tax) {

            const liveswith = $('input[name="liveswithyouSomeone"]:checked').val() === '1'; // Garantir que é booleano

            const person = {
                id: nextId++, // Atribui um ID único
                'firstname': $('#nameDependents').val(),
                'middlename': $('#middleDependents').val(),
                'lastname': $('#lastnameDependents').val(),
                'suffix': $('#suffixesDependents').val(),
                'birthdate': $('#dateDependents').val(),
                'sex': $('#sexoDependents').val(),
                'relationship': $('#relationshipsDependentsSomeone').val(),
                'lives_with_you': liveswith,
                'field_type': 5,
            };

            addhouseholdMembers(person);
            updateHouseholdListDependent2(); // Atualiza a lista após adicionar outra pessoa
        }


        // Função para adicionar membros ao array householdMembers
        function addhouseholdMembers(member) {
            member.lives_with_you = Boolean(member.lives_with_you); // Converte explicitamente para booleano
            householdMembers.push(member); // Adiciona o membro ao array
            console.log('addhouseholdMembers',
                householdMembers); // Verifica no console se o membro foi adicionado corretamente
        }




        function formatHousehold() {
            const applicationId = '{{ $application_id ?? 0 }}';
            const mainMemberId = @json($current_member['id'] ?? 0); // ID do membro principal
            const married = $('input[name="householdOptionMarried"]:checked').val(); // Valor de 'married'

            // Garantir que householdMembers é corretamente carregado
            const householdMembersCheck = @json($householdMembers);
            console.log("Membros da household (householdMembers):", householdMembersCheck);

            // Coletar IDs dos dependentes selecionados (checkboxes)
            const selectedDependentIds = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                .map(checkbox => {
                    console.log(`Checkbox marcado: ${checkbox.value}`);
                    return checkbox.value;
                });

            console.log("Checkboxes marcados (selectedDependentIds):", selectedDependentIds);

            // Filtrar membros existentes e adicioná-los ao array de dependentes
            let dependentMembers = householdMembersCheck.filter(memberCheck => {
                console.log("Membro Dependentes (memberCheck):", memberCheck);
                return selectedDependentIds.includes(String(memberCheck.id)) && memberCheck.field_type >= 1;
            }).map(memberCheck => ({
                id: memberCheck.id,
                lives_with_you: Boolean(memberCheck.lives_with) // Convertendo corretamente para booleano
            }));

            console.log("Membros Dependentes (dependentMembers):", dependentMembers);

            // Lógica para o cônjuge (spouse)
            let spouse = [];
            const spouseCheck = @json($spouse ?? null); // Verifica se o cônjuge já existe no banco de dados

            if (married == "1") {
                // Se married for "1" (casado) e o cônjuge já existir no banco de dados
                if (spouseCheck) {
                    spouse.push({
                        id: spouseCheck.id,
                        lives_with_you: Boolean(spouseCheck.lives_with) // Mantém a lógica atual
                    });
                } else {
                    // Se não há cônjuge no banco de dados, mas married é "1", cria um novo
                    spouse.push({
                        id: null, // Sem ID, pois será um novo cônjuge
                        lives_with_you: $('input[name="liveswithyouSpouse"]:checked').val() === '1'
                    });
                }
            }

            // Filtrar membros novos (sem ID)
            let newHouseholdMembers = householdMembers.filter(member => {
                return !member.id || member.field_type >=
                    2; // Incluindo todos os membros sem ID ou dependentes novos
            }).map(member => ({
                firstname: member.firstname,
                middlename: member.middlename ?? null,
                lastname: member.lastname,
                suffix: member.suffix ?? null,
                birthdate: member.birthdate,
                sex: member.sex,
                relationship: member.relationship ?? null, // Relacionamento
                field_type: member.field_type,
                lives_with_you: Boolean(member.lives_with_you),
                is_dependent: member.is_dependent ?? 1, // Campo obrigatório
                tax_filler: member.tax_filler ?? 0,
                tax_claimant: member.tax_claimant ??
                    mainMemberId // Definir mainMember como tax_claimant se não especificado
            }));

            console.log("Novos membros da household (newHouseholdMembers):", newHouseholdMembers);

            // Verifique se newHouseholdMembers contém dados válidos e não está vazio
            newHouseholdMembers = newHouseholdMembers.length > 0 ? newHouseholdMembers : null;

            // Formatar os dados para envio
            const householdData = {
                application_id: applicationId,
                this_household_member_id: mainMemberId, // ID do membro principal
                fed_tax_income_return: $('input[name="incomeTax"]:checked').val(),
                married: married, // Envia o valor de married corretamente
                spouse: spouse.length > 0 ? spouse : null, // Envia o cônjuge como array se existir
                dependents: dependentMembers.length > 0 ? dependentMembers :
                null, // Dependentes selecionados via checkbox
                jointly_taxed_spouse: $('input[name="taxedspouse"]:checked').val() ?? 0, // Campo obrigatório
                tax_filler: $('input[name="incomeTax"]:checked').val() ?? 0, // Campo obrigatório
                tax_claimant: mainMemberId, // Campo obrigatório
                provide_tax_filler_information: $('input[name="provideClaiming"]:checked').val() ??
                    0, // Campo obrigatório
                new_household_members: newHouseholdMembers // Se houver novos membros
            };

            console.log('Household Data:', householdData);
            return JSON.stringify(householdData);
        }

        const successMessage = @json(__('labels.dadosGravados'));
        const errorMessage = @json(__('labels.errodadosGravados'));

        function sendFormHousehold(buttonElement) {
            const household = formatHousehold(); // Formata os dados que serão enviados
            const csrf_token = '{{ csrf_token() }}';

            // Mostrar o spinner antes de fazer a requisição
            document.getElementById('loading-spinner').style.display = 'flex'; // Mostra o spinner

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('tax.fillFirstTax', $application_id) }}", // A rota de preenchimento
                type: "POST",
                data: household,
                contentType: "application/json",
                success: function(response) {
                    // Esconder o spinner após a requisição ser concluída
                    document.getElementById('loading-spinner').style.display = 'none';

                    if (response && response.data && response.data.id) {
                        // Constrói a URL com o ID do próximo membro e redireciona
                        const nextMemberId = response.data.id;

                        // Constrói a URL com o application_id e o próximo member_id
                        const url = "{{ route('livewire.tax', $application_id) }}?member_id=" + nextMemberId;

                        // Redireciona para a URL com o próximo membro
                        window.location.href = url;

                    } else {
                        // Se não houver próximo membro, redirecionar para a próxima rota correta
                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: '@lang('labels.allMembers')!',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            willClose: () => {
                                // Corrigindo a rota para redirecionar corretamente
                                window.location.href =
                                    "{{ route('livewire.additional-information', ['application_id' => $application_id]) }}";
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Esconder o spinner também em caso de erro
                    document.getElementById('loading-spinner').style.display = 'none';

                    Swal.fire({
                        title: 'Erro!',
                        text: 'Houve um erro na requisição.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    console.error("Erro:", jqXHR.responseText);
                }
            });
        }



        $(document).ready(function() {

            // Input Masks
            $('#birthdateSpouse').mask('99/99/9999');
            $('#birthdatePerson').mask('99/99/9999');
            $('#dateDependents').mask('99/99/9999');
            $('#dateDependentTax').mask('99/99/9999');
            $('#dateSpouseHouseholdTax').mask('99/99/9999');
        });


        function openTab(evt, tabName) {
            let i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }

        $(function() {
            // Validação do campo de data de nascimento
            $('#birthdateSpouse').on('blur', function() {
                const birthdateValue = $(this).val();
                const parts = birthdateValue.split('/');
                const errorMessage = $('.invalid-feedbackSpouse'); // Seleciona a div de feedback

                // Limpa mensagens de erro anteriores
                errorMessage.text('');
                errorMessage.hide(); // Esconde a mensagem de erro
                $(this).removeClass('is-invalid');

                if (parts.length === 3) {
                    const month = parseInt(parts[0], 10);
                    const day = parseInt(parts[1], 10);

                    if (month > 12) {
                        errorMessage.text('@lang('labels.monthBig').');
                        errorMessage.show(); // Mostra a mensagem de erro
                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                    } else if (day > 31) {
                        errorMessage.text('@lang('labels.dayBig').');
                        errorMessage.show(); // Mostra a mensagem de erro
                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                    }
                }
            });
            $('#birthdatePerson').on('blur', function() {
                const birthdateValue = $(this).val();
                const parts = birthdateValue.split('/');
                const errorMessage = $('.invalid-feedbackPerson'); // Seleciona a div de feedback

                // Limpa mensagens de erro anteriores
                errorMessage.text('');
                errorMessage.hide(); // Esconde a mensagem de erro
                $(this).removeClass('is-invalid');

                if (parts.length === 3) {
                    const month = parseInt(parts[0], 10);
                    const day = parseInt(parts[1], 10);

                    if (month > 12) {
                        errorMessage.text('@lang('labels.monthBig').');
                        errorMessage.show(); // Mostra a mensagem de erro
                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                    } else if (day > 31) {
                        errorMessage.text('@lang('labels.dayBig').');
                        errorMessage.show(); // Mostra a mensagem de erro
                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                    }
                }
            });
            $('#dateDependents').on('blur', function() {
                const birthdateValue = $(this).val();
                const parts = birthdateValue.split('/');
                const errorMessage = $('.invalid-feedbackDependents'); // Seleciona a div de feedback

                // Limpa mensagens de erro anteriores
                errorMessage.text('');
                errorMessage.hide(); // Esconde a mensagem de erro
                $(this).removeClass('is-invalid');

                if (parts.length === 3) {
                    const month = parseInt(parts[0], 10);
                    const day = parseInt(parts[1], 10);

                    if (month > 12) {
                        errorMessage.text('@lang('labels.monthBig').');
                        errorMessage.show(); // Mostra a mensagem de erro
                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                    } else if (day > 31) {
                        errorMessage.text('@lang('labels.dayBig').');
                        errorMessage.show(); // Mostra a mensagem de erro
                        $(this).addClass('is-invalid'); // Adiciona classe de erro
                    }
                }
            });
        });
    </script>
@endsection
