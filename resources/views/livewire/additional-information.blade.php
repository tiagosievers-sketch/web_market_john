@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">
@endsection

@php
    //    $aplication_id = 1;
    //dd($sexes);
@endphp

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.informacaoAdicional')</h4>
        </div>
    </div>

    <!-- END BREADCRUMB -->

    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab">
                    <button id="tabOtherFamily" class="tablinks active"
                        onclick="openTab(event, 'otherFamily')">@lang('labels.informacaoAdicionalOutraFamilia')</button>
                    <button id="tabNonTax" class="tablinks" onclick="openTab(event, 'nonTax')">@lang('labels.nonTaxInfoAdicional')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- primeira pergunta  primeira tela  / Does second second live with someone under the age of 19? --}}
    @include('livewire.additional-information.primeiraEsegunda-pergunta')
    {{-- fim segunda pergunta  primeira tela --}}

    {{-- primeira pergunta Non Tax --}}
    @include('livewire.additional-information.primeira-non-tax')
    {{-- fim segunda pergunta --}}




    <!-- Modal primeira tela-->
    @include('livewire.additional-information.add-member')
    <!-- End Modal -->


    <!-- Modal segunda tela-->
    @include('livewire.additional-information.modal-non-tax')
    <!-- End Modal -->

    {{-- End Non-Filer HouseHold Information --}}

@endsection


@section('scripts')
    <!-- INTERNAL DATEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- INTERNAL JQUERY.MASKEDINPUT JS -->
    <script src="{{ asset('build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL SPECTRUM-COLORPICKER JS -->
    <script src="{{ asset('build/assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

    <!--  INTERNAL SELECT2 JS -->
    <script src="{{ asset('build/assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- INTERNAL ION-RANGESLIDER JS -->
    {{-- <script src="{{ asset('build/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script> --}}

    <!-- INTERNAL JQUERY-AMAZEUI DATETIMEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

    <!-- INTERNAL JQUERY-SIMPLE DATETIMEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

    <!-- INTERNAL PICKER JS -->
    {{-- <script src="{{ asset('build/assets/plugins/pickerjs/picker.min.js') }}"></script> --}}

    <!-- INTERNAL COLORPICKER JS -->
    <script src="{{ asset('build/assets/plugins/colorpicker/pickr.es5.min.js') }}"></script>
    @vite('resources/assets/js/colorpicker.js')


    <!-- BOOTSTRAP-DATEPICKER JS -->
    <script src="{{ asset('build/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <!-- INTERNAL FORM-ELEMENTS JS -->
    @vite('resources/assets/js/form-elements.js')

    <!--    Modal Pergunta 2  JS -->
    <script src="{{ asset('js/additionalInformation/modalAdditionalAlerta.js') }}"></script>

    <!--    checkBoxAdditional -->
    <script src="{{ asset('js/additionalInformation/checkBoxAdditional.js') }}"></script>

    <!--    checkBoxAdditionalSegundaTela -->
    <script src="{{ asset('js/additionalInformation/checkBoxNonTax.js') }}"></script>

    <!--    Aba Navegacao adicional -->
    <script src="{{ asset('js/additionalInformation/abaNavegacaoAdditional.js') }}"></script>

    <!--    Aba Navegacao adicional -->
    <script src="{{ asset('js/additionalInformation/modalAddChildren.js') }}"></script>

    <!-- Adicionando o SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- Vite Compilation -->
    @vite('resources/assets/js/colorpicker.js')
    @vite('resources/assets/js/modal.js')


    <script>
        // Array para armazenar informações adicionais
        const additionalInformation = [];

        // Função para adicionar outro membro
        function addOtherMember(tax) {
            const additionalInformationCheck = parseInt($('input[name="additionalInformationCheck"]:checked').val(), 1) ||
                0;
            const additionalInformation2Check = parseInt($('input[name="additionalInformation2Check"]:checked').val(), 1) ||
                0;

            const relationship = $('#relationshipsDependents').val() || null;


            console.log("additionalInformationCheck", Boolean(additionalInformationCheck));
            console.log("additionalInformation2Check", additionalInformation2Check);
            const member = {
                'id': Date.now(), // Gera um ID único
                'live_someone_under_nineteen': Boolean(additionalInformationCheck),
                'taking_care_under_nineteen': Boolean(additionalInformation2Check),

                'firstname': $('#nameFamilyMember').val(),
                'middlename': $('#middleFamilyMember').val(),
                'lastname': $('#lastnameFamilyMember').val(),
                'suffix': $('#suffixesFamilyMember').val(),
                'birthdate': $('#dateFamilyMember').val(),
                'sex': $('#sexesFamilyMember').val(),
                'relationship': relationship,
                'tax_form': null,
                'lives_with_you': null,
                'tax_claimant': null,
                'eligible_cost_saving': null,
                'field_type': 6,
            };

            addOtherRelashionshipMember(member);
            updateHouseholdListMember(); // Atualiza a lista de membros
        }
        // Função para adicionar dependentes (crianças)
        function addChildren(tax) {
            const nonTaxCheckYes = parseInt($('input[name="nonTaxCheckYes"]:checked').val(), 1) || 0;
            const nonTax2checkYes = parseInt($('input[name="nonTax2checkYes"]:checked').val(), 1) || 0;
            const member = {
                'id': Date.now(),
                'live_any_other_family': nonTaxCheckYes,
                'live_son_daughter': nonTax2checkYes,
                'firstname': $('#nameChildrenTax').val(),
                'middlename': $('#middleChildrenTax').val(),
                'lastname': $('#lastnameChildrenTax').val(),
                'suffix': $('#suffixesChildrenTax').val(),
                'birthdate': $('#dateChildrenTax').val(),
                'sex': $('#sexesChildrenTax').val(),
                'relationship': $('#relationshipsChilds').val(),
                'tax_form': null,
                'lives_with_you': null,
                'tax_claimant': null,
                'eligible_cost_saving': null,
            };

            addOtherRelashionshipMember(member);
            updateHouseholdListChildren();
        }

        // Função para adicionar membro ao array
        function addOtherRelashionshipMember(member) {
            additionalInformation.push(member);
        }

        // Formatação do JSON a ser enviado
        const member_id = @json($member_id);

        function formatHouseholdForSubmission() {
            const applicationId = $('#application_id').val();
            const thisHouseholdMemberId = member_id;
            const liveSomeoneUnderNineteen = Boolean($('input[name="additionalInformationCheck"]:checked').val());
            const takingCareUnderNineteen = Boolean($('input[name="additionalInformation2Check"]:checked').val());
            const liveAnyOtherFamily = Boolean($('input[name="live_any_other_family"]:checked').val());
            const liveSonDaughter = Boolean($('input[name="live_son_daughter"]:checked').val());

            // Mapeia os membros da família
            const formattedHouseholdMembers = additionalInformation.map(member => {
                return {
                    'firstname': member.firstname,
                    'middlename': member.middlename || null,
                    'lastname': member.lastname,
                    'suffix': member.suffix || null,
                    'birthdate': member.birthdate,
                    'sex': member.sex,
                    'relationship': member.relationship,
                    'tax_form': member.tax_form,
                    'lives_with_you': member.lives_with_you,
                    'tax_claimant': member.tax_claimant,
                    'eligible_cost_saving': member.eligible_cost_saving,
                    'field_type': member.field_type || 6
                };
            });

            // Filtra crianças sob cuidado (baseado no relacionamento, por exemplo, 24 ou 25)
            const childTakingCare = formattedHouseholdMembers.filter(member => member.relationship != 17);

            // Filtra outros filhos ou dependentes (baseado no relacionamento, por exemplo, 17)
            const otherSonDaughter = formattedHouseholdMembers.filter(member => member.relationship == 17);

            return JSON.stringify({
                'application_id': applicationId,
                'this_household_member_id': thisHouseholdMemberId,
                'live_someone_under_nineteen': liveSomeoneUnderNineteen,
                'taking_care_under_nineteen': takingCareUnderNineteen,
                'live_any_other_family': liveAnyOtherFamily,
                'live_son_daughter': liveSonDaughter,
                'child_taking_care': childTakingCare.length ? childTakingCare : [], // Envia as crianças sob cuidado
                'other_son_daughter': otherSonDaughter.length ? otherSonDaughter : [],
            });
        }




        // Definição de mensagens
        const successMessage = @json(__('labels.dadosGravados'));
        const errorMessage = @json(__('labels.errodadosGravados'));

        // Função principal para enviar o formulário
        function sendFormHousehold(buttonElement) {
            console.log("Função sendFormHousehold foi chamada.");

            const household = formatHouseholdForSubmission();
            const csrf_token = '{{ csrf_token() }}';

            console.log("Dados do formulário preparados para envio:", household);

            // Exibir o loader

            // Enviar os dados via AJAX
            // Mostra o loader do SweetAlert antes de iniciar a requisição
            Swal.fire({
                title: '@lang('labels.aguarde')...',
                text: '@lang('labels.processando')',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading(); // Mostra o loading
                }
            });

            // Inicia a requisição AJAX
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                },
                url: "{{ route('additionalinformation.fill', $application_id) }}", // Certifique-se que a rota está correta
                type: "POST",
                data: household,
                contentType: "application/json",
                success: function(response) {
                    Swal.close(); // Fecha o loader do SweetAlert
                    console.log("Resposta do servidor:", response);
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '@lang('labels.sucesso')!',
                            text: successMessage,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            willClose: () => {
                                window.location.href =
                                    "{{ route('livewire.address-applicant', $application_id) }}";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Erro!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.close(); // Fecha o loader do SweetAlert
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Houve um erro na requisição.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    console.error("Erro na requisição:", jqXHR.status);
                    console.error("Texto do Status:", textStatus);
                    console.error("Erro Lançado:", errorThrown);
                    console.error("Resposta do servidor:", jqXHR.responseText);
                }
            });

        }


        // Adicionando eventos após o documento ser carregado
        $(document).ready(function() {
            // Botão de adicionar outro membro
            $('#addOtherMemberBtn').on('click', function(e) {
                e.preventDefault();
                addOtherMember(0);
                $('#modalAdditionInformation').modal('hide');
            });

            // Máscara de input para data
            $('#dateFamilyMember').mask('99/99/9999');
            $('#dateChildrenTax').mask('99/99/9999');

            // Botão de adicionar criança
            $('#addChildrendBtn').on('click', function(e) {
                e.preventDefault();
                addChildren(0);
                $('#modalChildrenTax').modal('hide');
            });

            // Abas de navegação
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

            // Define a aba inicial como ativa
            document.getElementById("tabOtherFamily").click();

            // Botões de navegação
            document.getElementById("btnContinue").addEventListener("click", function() {
                document.getElementById("tabNonTax").click();
            });
            document.getElementById("btnBack").addEventListener("click", function() {
                document.getElementById("tabOtherFamily").click();
            });
        });
    </script>
@endsection
