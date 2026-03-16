{{-- resources/views/livewire/addresses-applicant-edit.blade.php --}}
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/abaNavegacao.css">
    <link rel="stylesheet" href="/css/load.css">
    <style>
        /* Estilos adicionais para melhor apresentação */
        .member-address {
            margin-left: 35px; /* Alinhamento com o label do checkbox */
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 7px;
            background-color: #f9f9f9;
            display: none; /* Inicialmente oculto */
        }

        .member-address.active {
            display: block; /* Exibe quando a classe 'active' é adicionada */
        }
    </style>
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
                                        id="everyone_lives_main_member_yes" value="1" required
                                        {{ $address && $address['everyone_lives_main_member'] == 1 ? 'checked' : '' }}>
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
                                        id="everyone_lives_main_member_no" value="0" required
                                        {{ $address && $address['everyone_lives_main_member'] == 0 ? 'checked' : '' }}>
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
                                {{-- Verifica se o membro não vive com o principal --}}
                                @php
                                    $memberAddress = $member->address ?? null;
                                    $isChecked = $memberAddress ? 'checked' : '';
                                @endphp
                                <div class="form-check mb-3 d-flex align-items-center"
                                    style="border: 1px solid #ddd; padding: 10px; border-radius: 7px; margin-right: 10px; padding-left: 30px;">
                                    <input class="form-check-input" type="checkbox" name="does_not_live_with[]"
                                        id="member_{{ $member->id }}" value="{{ $member->id }}"
                                        style="margin-right: 10px;"
                                        {{ $isChecked }}
                                        @if ($memberAddress)
                                            data-street_address="{{ $memberAddress->street_address ?? '' }}"
                                            data-apte_ste="{{ $memberAddress->apte_ste ?? '' }}"
                                            data-city="{{ $memberAddress->city ?? '' }}"
                                            data-state="{{ $memberAddress->state ?? '' }}"
                                            data-zipcode="{{ $memberAddress->zipcode ?? '' }}"
                                            data-county="{{ $memberAddress->county ?? '' }}"
                                        @endif
                                    >
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

        // Função para normalizar strings (remover acentos, espaços e converter para minúsculas)
        function normalizeString(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim().toLowerCase();
        }

        // Função para carregar counties via AJAX
        function loadCounties(zipcodeInput, countySelect, prefillCounty = null) {
            const csrf_token = '{{ csrf_token() }}';
            const zipcode = $(zipcodeInput).val().trim();

            if (zipcode !== '') {
                countySelect.prop('disabled', true).empty().append(new Option('Carregando...', ''));
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    url: "{{ route('geography.counties', '') }}/" + zipcode,
                    type: "GET",
                    success: function(response) {
                        console.log('Resposta AJAX:', response); // Log para depuração
                        countySelect.empty(); // Limpa as opções existentes
                        if (response.status === 'success' && response.data.length > 0) {
                            countySelect.append(new Option('Selecione', ''));
                            response.data.forEach(function(county) {
                                countySelect.append(new Option(county, county));
                            });

                            // Se houver um valor já selecionado (no edit), mantêm a seleção
                            if (prefillCounty) {
                                const prefillNormalized = normalizeString(prefillCounty);
                                let found = false;

                                countySelect.find('option').each(function() {
                                    const optionValueNormalized = normalizeString($(this).val());
                                    if (optionValueNormalized === prefillNormalized) {
                                        $(this).prop('selected', true);
                                        found = true;
                                        return false; // parar o loop
                                    }
                                });

                                if (!found) {
                                    // Se o condado predefinido não estiver na lista, adicioná-lo e selecioná-lo
                                    countySelect.append(new Option(prefillCounty, prefillCounty));
                                    countySelect.val(prefillCounty);
                                    console.warn(`Condado predefinido "${prefillCounty}" não encontrado na lista. Adicionado manualmente.`);
                                }
                            }
                        } else {
                            countySelect.append(new Option('Nenhum condado encontrado', ''));
                        }
                        countySelect.prop('disabled', false);
                    },
                    error: function(jqXHR) {
                        countySelect.empty().append(new Option('Erro ao carregar condados', ''));
                        countySelect.prop('disabled', false);
                        console.error('Erro ao carregar condados:', jqXHR.responseText); // Log para depuração
                    }
                });
            } else {
                countySelect.empty().append(new Option('Selecione', ''));
                countySelect.prop('disabled', false);
            }
        }

        // Mostrar ou esconder a seção de membros com base na seleção atual
        const selectedOption = $('input[name="everyone_lives_main_member"]:checked').val();
        if (selectedOption == "0") {
            whoDoesNotLiveSection.show();
        } else {
            whoDoesNotLiveSection.hide();
        }

        // Manipulação de Checkboxes marcados na inicialização
        $('input[type="checkbox"][name="does_not_live_with[]"]:checked').each(function() {
            const checkbox = $(this);
            const memberId = checkbox.val();

            // Obter os dados de endereço dos atributos data-*
            const streetAddress = checkbox.data('street_address');
            const aptSte = checkbox.data('apte_ste');
            const city = checkbox.data('city');
            const state = checkbox.data('state');
            const zipcode = checkbox.data('zipcode');
            const county = checkbox.data('county');

            // Clonar o template de endereço
            let newAddress = $(addressTemplate).clone();

            // Preencher os campos com os dados existentes
            newAddress.find('input[name="street_address[]"]').val(streetAddress || '');
            newAddress.find('input[name="apte_ste[]"]').val(aptSte || '');
            newAddress.find('input[name="city[]"]').val(city || '');
            newAddress.find('select[name="state[]"]').val(state || '');
            newAddress.find('input[name="zipcode[]"]').val(zipcode || '');
            // O campo de county será preenchido via AJAX

            // Inserir a seção de endereço após o checkbox
            checkbox.closest('.form-check').after(newAddress);

            // Carregar os condados se o CEP existir
            if (zipcode && county) {
                loadCounties(newAddress.find('.zipcode-field'), newAddress.find('.county-field'), county);
            }
        });

        // Evento de mudança nos radio buttons
        $('input[name="everyone_lives_main_member"]').on('change', function() {
            if ($(this).val() == "0") {
                whoDoesNotLiveSection.show();
            } else {
                whoDoesNotLiveSection.hide();
                // Remover todas as seções de endereço
                $('.address-section').remove();
                // Desmarcar todos os checkboxes
                $('input[type="checkbox"][name="does_not_live_with[]"]').prop('checked', false);
            }
        });

        // Evento de mudança nos checkboxes
        $('body').on('change', 'input[type="checkbox"][name="does_not_live_with[]"]', function() {
            const checkbox = $(this);
            const memberId = checkbox.val();

            if (checkbox.is(':checked')) {
                // Obter os dados de endereço dos atributos data-*
                const streetAddress = checkbox.data('street_address');
                const aptSte = checkbox.data('apte_ste');
                const city = checkbox.data('city');
                const state = checkbox.data('state');
                const zipcode = checkbox.data('zipcode');
                const county = checkbox.data('county');

                // Clonar o template de endereço
                let newAddress = $(addressTemplate).clone();

                // Preencher os campos com os dados existentes
                newAddress.find('input[name="street_address[]"]').val(streetAddress || '');
                newAddress.find('input[name="apte_ste[]"]').val(aptSte || '');
                newAddress.find('input[name="city[]"]').val(city || '');
                newAddress.find('select[name="state[]"]').val(state || '');
                newAddress.find('input[name="zipcode[]"]').val(zipcode || '');
                // O campo de county será preenchido via AJAX

                // Inserir a seção de endereço após o checkbox
                checkbox.closest('.form-check').after(newAddress);

                // Carregar os condados se o CEP existir
                if (zipcode && county) {
                    loadCounties(newAddress.find('.zipcode-field'), newAddress.find('.county-field'), county);
                }
            } else {
                // Remover a seção de endereço correspondente
                checkbox.closest('.form-check').next('.address-section').remove();
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

        // Attach input event com debounce aos campos zipcode
        $('body').on('input', '.zipcode-field', debounce(function() {
            const zipcodeInput = this;
            const countySelect = $(zipcodeInput).closest('.address-section').find('.county-field');
            const currentCounty = $(zipcodeInput).closest('.address-section').find('.county-field').val();
            loadCounties(zipcodeInput, countySelect, currentCounty);
        }, 500));

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
                $('input[type="checkbox"][name="does_not_live_with[]"]:checked').each(function() {
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
