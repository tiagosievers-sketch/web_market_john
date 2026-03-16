@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">
    <!-- Adicione estilos adicionais se necessário -->
@endsection

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.applicantAddress')</h4>
        </div>
    </div>
    <!-- END BREADCRUMB -->

    <!-- Spinner de Carregamento -->
    <div id="loading-spinner"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Formulário de Endereço -->
    <form id="addressForm" method="POST" action="{{ route('addinfo.fillAddress', $application_id) }}">
        @csrf
        <!-- Campo hidden para garantir que o application_id seja enviado -->
        <input type="hidden" name="application_id" value="{{ $application_id }}">

        <!-- Endereço Principal -->
        <div class="card">
            <div class="card-body">
                <div class="row row-sm">
                    <label class="col-form-label">
                        @lang('labels.followingAddress')
                    </label>
                    <p>
                        {{ $address['street_address'] ?? 'Endereço não disponível' }}<br>
                        {{ $address['city'] ?? 'Cidade não disponível' }}, {{ $address['state'] ?? 'Estado não disponível' }}
                        {{ $address['zipcode'] ?? 'CEP não disponível' }}
                    </p>
                </div>

                <!-- Opções de Residência -->
                <div class="row row-sm mt-3">
                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="everyone_lives_main_member"
                                        id="everyone_lives_main_member_yes" value="1" required>
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">Sim</div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <label class="rdiobox wd-16 mg-b-0">
                                    <input class="mg-0" type="radio" name="everyone_lives_main_member"
                                        id="everyone_lives_main_member_no" value="0" required>
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-control">Não</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Se "Não" for selecionado, mostrar a lista de membros -->
        <div class="card mt-4" id="who_does_not_live_with_you_section" style="display:none;">
            <div class="card-body">
                <label class="col-form-label">@lang('labels.whoDoesLive')</label>
                <div class="row row-sm">
                    <div class="col-sm-12">
                        @foreach ($householdMembers as $index => $member)
                            @if ($index > 0)
                                <!-- Ignora o primeiro membro -->
                                <div class="form-check mb-3 d-flex align-items-center"
                                    style="border: 1px solid #ddd; padding: 10px; border-radius: 7px; margin-right: 10px; padding-left: 30px;">
                                    <input class="form-check-input" type="checkbox" name="does_not_live_with[]"
                                        id="member_{{ $member->id }}" value="{{ $member->id }}"
                                        style="margin-right: 10px;">
                                    <label class="form-check-label" for="member_{{ $member->id }}">
                                        {{ $member->firstname }} {{ $member->lastname }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Template para Seção de Endereço de Membros -->
        <template id="address-template">
            <div class="card mt-3 address-section">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('labels.campoEndereco')</label>
                                <input type="text" name="street_address[]" class="form-control address-field" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('labels.enderecoApt')</label>
                                <input type="text" name="apte_ste[]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('labels.enderecoCidade')</label>
                                <input type="text" name="city[]" class="form-control address-field" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('labels.enderecoEstado')</label>
                                <select class="form-select address-field" name="state[]" required>
                                    <option value="" selected>@lang('labels.campoSelecao')</option>
                                    @foreach ($states as $key => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('labels.enderecoCEP')</label>
                                <input type="text" name="zipcode[]" class="form-control zipcode-field address-field" placeholder="Digite o CEP">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('labels.campoCounty')</label>
                                <select name="county[]" class="form-control county-field" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Botão de Continuação -->
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-secondary btn-lg"
                        style="width: 150px;">@lang('labels.buttonContinue')</button>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const whoDoesNotLiveSection = $('#who_does_not_live_with_you_section');
            const addressTemplate = $('#address-template').html();

            // Inicialmente, esconder a seção de membros
            whoDoesNotLiveSection.hide();

            // Mostrar ou esconder a lista de membros com base na seleção dos radio buttons
            $('input[name="everyone_lives_main_member"]').on('change', function() {
                if ($(this).val() == "0") {
                    whoDoesNotLiveSection.show();
                    addRequiredFields();
                } else {
                    whoDoesNotLiveSection.hide();
                    $('.address-section').remove(); // Remove todas as seções de endereço
                    $('input[type="checkbox"]').prop('checked', false); // Limpa os checkboxes
                    removeRequiredFields();
                }
            });

            // Adicionar ou remover seção de endereço ao marcar/desmarcar os checkboxes
            $('body').on('change', 'input[type="checkbox"][name="does_not_live_with[]"]', function() {
                if ($(this).is(':checked')) {
                    // Verifica se já existe uma seção de endereço abaixo do checkbox
                    if (!$(this).closest('.form-check').next('.address-section').length) {
                        // Clona a template e insere abaixo do checkbox
                        let newAddress = $(addressTemplate).clone();
                        $(this).closest('.form-check').after(newAddress);
                        addRequiredFields();
                    }
                } else {
                    // Remove a seção de endereço correspondente
                    $(this).closest('.form-check').next('.address-section').remove();
                    removeRequiredFields();
                }
            });

            // Função de Debounce para limitar chamadas AJAX
            function debounce(func, delay) {
                let debounceTimer;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(context, args), delay);
                };
            }

            // Função AJAX para carregar counties com base no CEP
            function loadCounties(zipcodeInput) {
                const csrf_token = '{{ csrf_token() }}';
                const zipcode = $(zipcodeInput).val().trim();
                const countySelect = $(zipcodeInput).closest('.address-section').find('.county-field');

                if (zipcode !== '') {
                    countySelect.prop('disabled', true).empty().append(new Option('Carregando...', ''));
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf_token
                        },
                        url: "{{ route('geography.counties', '') }}/" + zipcode,
                        type: "GET",
                        success: function(response) {
                            countySelect.empty(); // Limpa as opções existentes
                            if (response.status === 'success' && response.data.length > 0) {
                                countySelect.append(new Option('Select', ''));
                                response.data.forEach(function(county) {
                                    countySelect.append(new Option(county, county));
                                });
                                // Seleciona automaticamente o primeiro condado
                                countySelect.val(response.data[0]);
                            } else {
                                countySelect.append(new Option('Nenhum condado encontrado', ''));
                            }
                            countySelect.prop('disabled', false);
                        },
                        error: function() {
                            countySelect.empty().append(new Option('Erro ao carregar condados', ''));
                            countySelect.prop('disabled', false);
                        }
                    });
                } else {
                    countySelect.empty().append(new Option('Select', ''));
                    countySelect.prop('disabled', false);
                }
            }

            // Attach input event com debounce aos campos zipcode
            $('body').on('input', '.zipcode-field', debounce(function() {
                loadCounties(this);
            }, 500));

            // Adiciona ou remove o atributo "required" nos campos de endereço
            function addRequiredFields() {
                $('.address-field').prop('required', true);
                $('.county-field').prop('required', true);
            }

            function removeRequiredFields() {
                $('.address-field').prop('required', false);
                $('.county-field').prop('required', false);
            }

            // Enviar o formulário via Ajax
            $('#addressForm').submit(function(e) {
                e.preventDefault(); // Impede o envio padrão

                const selectedOption = $('input[name="everyone_lives_main_member"]:checked').val();
                const formData = {
                    application_id: '{{ $application_id }}',
                    everyone_lives_main_member: selectedOption,
                    other_addresses: []
                };

                if (selectedOption === "0") {
                    // Adiciona membros e endereço quando "Não" é selecionado
                    $('input[type="checkbox"]:checked').each(function() {
                        let addressSection = $(this).closest('.form-check').next('.address-section');
                        formData.other_addresses.push({
                            household_member_id: $(this).val(),
                            street_address: addressSection.find('input[name="street_address[]"]').val(),
                            apte_ste: addressSection.find('input[name="apte_ste[]"]').val(),
                            city: addressSection.find('input[name="city[]"]').val(),
                            state: addressSection.find('select[name="state[]"]').val(),
                            zipcode: addressSection.find('input[name="zipcode[]"]').val(),
                            county: addressSection.find('select[name="county[]"]').val()
                        });
                    });
                }

                const csrf_token = '{{ csrf_token() }}';

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    url: "{{ route('addinfo.fillAddress', $application_id) }}",
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    beforeSend: function() {
                        $('#loading-spinner').show(); // Mostrar o spinner antes de enviar
                    },
                    success: function(response) {
                        $('#loading-spinner').hide(); // Esconder o spinner

                        Swal.fire({
                            title: 'Success!',
                            text: '@lang('labels.AddressesSuccess').',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href =
                                "{{ route('livewire.members', ['application_id' => $application_id]) }}";
                        });
                    },
                    error: function(jqXHR) {
                        $('#loading-spinner').hide();

                        Swal.fire({
                            title: 'Error!',
                            text: '@lang('labels.AddressesError').',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(jqXHR.responseText);
                    }
                });
            });
        });
    </script>
@endsection
