@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/quotation.css">
    <style>
        .relationship-container {
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }

        h2,
        h4 {
            color: #007bff;
            font-weight: bold;
        }

        .table {
            margin-top: 15px;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .alert {
            margin-top: 10px;
        }

        .spinner-border {
            margin-top: 10px;
        }

        .relationship-select.validated {
            border-color: green;
            background-image: url('data:image/svg+xml;base64,...');
            background-repeat: no-repeat;
            background-position: right;
        }

        .combo-hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="relationship-container">
        <h2>@lang('labels.relationMembers')</h2>

        <div id="messages"></div> <!-- Para exibir mensagens de erro ou sucesso -->
        @foreach ($relationships as $relationshipGroup)
            <h4>{{ $relationshipGroup['name'] }}</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('labels.member1')</th>
                        <th>@lang('labels.relationship')</th>
                        <th>@lang('labels.relationshipDetail')</th>
                        <th>@lang('labels.member2')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($relationshipGroup['relationships'] as $relation)
                        <tr>
                            <td>{{ $relation['member_from_name'] }}</td>
                            <td>
                                <select class="form-control relationship-select"
                                    data-member-from-id="{{ $relation['member_from_id'] }}"
                                    data-member-to-id="{{ $relation['member_to_id'] }}"
                                    data-selected="{{ $relation['relationship'] }}">
                                    <option value="">@lang('labels.relationshipSelect')</option>
                                    @foreach ($relationshipOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ $relation['relationship'] == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select
                                    class="form-control relationship-detail-select {{ $relation['relationship_detail'] ? '' : 'combo-hidden' }}"
                                    data-member-from-id="{{ $relation['member_from_id'] }}"
                                    data-member-to-id="{{ $relation['member_to_id'] }}"
                                    data-selected="{{ $relation['relationship_detail'] }}">
                                    <option value="">@lang('labels.relationshipDetailSelect')</option>
                                </select>
                            </td>
                            <td>{{ $relation['member_to_name'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <div class="text-center">
            <button id="save-relationships" class="btn btn-primary mt-3">@lang('labels.salvarRelationship')</button>
        </div>
    </div>

    <!-- Adicionar um spinner para o loading -->
    <div id="loading-spinner" style="display: none; text-align: center;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">@lang('labels.carregando')</span>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const csrf_token = '{{ csrf_token() }}';

            // Função para carregar detalhes do relacionamento via AJAX
            function loadRelationshipDetails(relationshipId, relationshipDetailSelect) {
                console.log('Iniciando loadRelationshipDetails para relationshipId:', relationshipId);

                const existingDetail = relationshipDetailSelect.getAttribute('data-selected');
                console.log('Existing detail (data-selected):', existingDetail);

                $.ajax({
                    url: `/relationship/combo-detail/${relationshipId}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    success: function(response) {
                        if (response && response.status === 'success' && response.data.length > 0) {
                            console.log('Detalhes recebidos:', response.data);

                            // Mostrar o select de detalhes
                            relationshipDetailSelect.classList.remove('combo-hidden');

                            // Limpar o select antes de preencher
                            relationshipDetailSelect.innerHTML =
                                '<option value="">@lang('labels.relationshipDetailSelect')</option>';

                            // Preencher o select com as opções disponíveis
                            response.data.forEach(function(option) {
                                const optionKey = Object.keys(option)[0];
                                const optionValue = option[optionKey];
                                const newOption = document.createElement('option');
                                newOption.value = optionKey;
                                newOption.textContent = optionValue;

                                // Adiciona o valor ao select
                                relationshipDetailSelect.appendChild(newOption);

                                // Selecionar automaticamente o valor existente
                                if (existingDetail && existingDetail == optionKey) {
                                    newOption.selected = true;
                                    console.log(
                                        `Selecionado o detalhe: ${optionKey} (${optionValue})`
                                    );
                                }
                            });

                            console.log('Select atualizado com detalhes:', relationshipDetailSelect);
                        } else {
                            console.warn('Nenhum detalhe encontrado ou resposta inválida:', response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro ao carregar detalhes do relacionamento:', errorThrown);
                    },
                });
            }

            // Inicializa os detalhes dos relacionamentos ao carregar a página
            document.querySelectorAll('.relationship-select').forEach(function(relationshipSelect) {
                const memberFromId = relationshipSelect.getAttribute('data-member-from-id');
                const memberToId = relationshipSelect.getAttribute('data-member-to-id');
                const selectedRelationship = relationshipSelect.value;

                const relationshipDetailSelect = document.querySelector(
                    `.relationship-detail-select[data-member-from-id="${memberFromId}"][data-member-to-id="${memberToId}"]`
                );

                console.log(
                    `Inicializando: relationshipId=${selectedRelationship}, memberFromId=${memberFromId}, memberToId=${memberToId}`
                );

                // Se já existir um relacionamento selecionado, carregar os detalhes
                if (selectedRelationship && relationshipDetailSelect) {
                    loadRelationshipDetails(selectedRelationship, relationshipDetailSelect);
                }
            });

            // Adicionar comportamento ao mudar o relacionamento
            document.querySelectorAll('.relationship-select').forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    const relationshipId = this.value;
                    const memberFromId = this.getAttribute('data-member-from-id');
                    const memberToId = this.getAttribute('data-member-to-id');

                    const relationshipDetailSelect = document.querySelector(
                        `.relationship-detail-select[data-member-from-id="${memberFromId}"][data-member-to-id="${memberToId}"]`
                    );

                    console.log(
                        `Alteração detectada: relationshipId=${relationshipId}, memberFromId=${memberFromId}, memberToId=${memberToId}`
                    );

                    // Limpar as opções e esconder o select de detalhes
                    relationshipDetailSelect.innerHTML =
                        '<option value="">@lang('labels.relationshipDetailSelect')</option>';
                    relationshipDetailSelect.classList.add('combo-hidden');

                    if (relationshipId) {
                        // Carregar os detalhes do relacionamento via AJAX
                        loadRelationshipDetails(relationshipId, relationshipDetailSelect);
                    }
                });
            });

            // Salvando os relacionamentos
            document.getElementById('save-relationships').addEventListener('click', function() {
                const householdRelationships = [];
                const relationshipsMap = {};

                // Coletar dados dos relacionamentos
                document.querySelectorAll('.relationship-select').forEach(function(selectElement) {
                    const memberFromId = selectElement.getAttribute('data-member-from-id');
                    const memberToId = selectElement.getAttribute('data-member-to-id');
                    const relationship = selectElement.value;

                    const relationshipDetailSelect = document.querySelector(
                        `.relationship-detail-select[data-member-from-id="${memberFromId}"][data-member-to-id="${memberToId}"]`
                    );
                    const relationshipDetail =
                        relationshipDetailSelect &&
                        !relationshipDetailSelect.classList.contains('combo-hidden') ?
                        relationshipDetailSelect.value :
                        null;

                    if (relationship !== "") {
                        if (!relationshipsMap[memberFromId]) {
                            relationshipsMap[memberFromId] = [];
                        }

                        relationshipsMap[memberFromId].push({
                            member_from_id: memberFromId,
                            member_to_id: memberToId,
                            relationship: relationship,
                            relationship_detail: relationshipDetail || null
                        });
                    }
                });

                for (const [memberFromId, relationships] of Object.entries(relationshipsMap)) {
                    householdRelationships.push({
                        relationships: relationships
                    });
                }

                // Exibir um loader enquanto os dados estão sendo enviados
                $('#loading-spinner').show();
                $('#messages').html('');

                const data = {
                    application_id: '{{ $application_id }}',
                    household_relatioships: householdRelationships
                };

                if (householdRelationships.length === 0) {
                    $('#messages').html('<div class="alert alert-warning">@lang('labels.nenhumRelacionamento').</div>');
                    Swal.fire({
                        icon: 'warning',
                        title: '@lang('labels.nenhumRelacionamento')',
                        showCancelButton: false,
                        confirmButtonText: '@lang('labels.clickOk')',
                    }).then(() => {
                        window.location.href =
                            "{{ route('livewire.tax', ['application_id' => $application_id]) }}";
                    });
                    setTimeout(() => {
                        window.location.href =
                            "{{ route('livewire.tax', ['application_id' => $application_id]) }}";
                    }, 2000);
                    return;
                }


                $.ajax({
                    url: '{{ route('relationship.storeorupdate') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    beforeSend: function() {
                        // Exibir modal de carregamento durante o envio
                        Swal.fire({
                            title: '@lang('labels.processando')...',
                            text: '@lang('labels.waitReload')',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal
                            .showLoading(); // Exibe o spinner de carregamento
                            }
                        });
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '@lang('labels.sucesso')!',
                                text: '@lang('labels.sucessoRelationships')!',
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.href =
                                    "{{ route('livewire.tax', ['application_id' => $application_id]) }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: response.message,
                                allowOutsideClick: false
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro na requisição:', errorThrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: '@lang('labels.ocorreuErroSalvarRelacoes').',
                            allowOutsideClick: false
                        });
                    }
                });

            });
        });
    </script>
@endsection
