@extends('layouts.app')

@section('styles')
<style>
    .breadcrumb-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table thead th {
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .btn-primary,
    .btn-warning {
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .breadcrumb-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .right-content {
            margin-top: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>
@endsection







@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" id="success-alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" id="error-alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="breadcrumb-header d-flex justify-content-between align-items-center">
    <div class="my-auto">
        <h4 class="page-title text-center">@lang('labels.applications')</h4>
    </div>
    <div class="right-content d-flex align-items-center">
        <a href="{{ route('livewire.primary-contact-quotation') }}" class="btn btn-primary btn-lg me-3">
            {{ $isClient ? __('labels.novaAplicacaoClient') : __('labels.novaAplicacao') }}
        </a>
        <a href="{{ route('quickQuotation') }}" class="btn btn-success btn-lg">
            {{ __('labels.quickQuotation') }}
        </a>
    </div>
</div>
<div class="right-content d-flex align-items-center">
    <button type="button" class="btn btn-danger btn-lg" id="delete-selected" style="display: none;">
        {{ __('labels.deleteSelectedbutton') }}
    </button>
</div>


<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0" id="basic-edit">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th class="text-center">@lang('labels.nome')</th>
                                <th class="text-center">@lang('labels.sobreNome')</th>
                                {{-- <th class="text-center">@lang('labels.campoMiddleName')</th> --}}
                                <th class="text-center">@lang('labels.campoNumero')</th>
                                <th class="text-center">@lang('labels.dataCriacao')</th>
                                <th class="text-center">@lang('labels.textAcoes')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($application as $app)
                            @php
                            if (isset($app->application)) {
                            // Caso do Admin, acessando HouseholdMember e Application
                            $householdMember = $app;
                            $applicationData = $householdMember->application ?? null;

                            $firstName = $householdMember->firstname ?? 'N/A';
                            $lastName = $householdMember->lastname ?? 'N/A';
                            $middleName = $householdMember->middlename ?? 'N/A';
                            $ssn = $householdMember->ssn ?? 'N/A';
                            $createdAt = $householdMember->created_at
                            ? \Carbon\Carbon::parse($householdMember->created_at)->format(
                            'm/d/Y',
                            )
                            : 'N/A';
                            } else {
                            // Caso do Cliente, acessando Application e HouseholdMember (field_type == 0)
                            $applicationData = $app;
                            $householdMembers = $applicationData->householdMembers ?? collect();

                            // Filtrar o HouseholdMember com field_type == 0
                            $householdMember = $householdMembers->firstWhere('field_type', 0);

                            // Se houver um householdMember com field_type == 0, pegar os dados
                            if ($householdMember) {
                            $firstName = $householdMember->firstname ?? 'N/A';
                            $lastName = $householdMember->lastname ?? 'N/A';
                            //$middleName = $householdMember->middlename ?? 'N/A';
                            $ssn = $householdMember->ssn ?? 'N/A';
                            $createdAt = $applicationData->created_at
                            ? \Carbon\Carbon::parse($applicationData->created_at)->format(
                            'm/d/Y',
                            )
                            : 'N/A';
                            }
                            }

                            // Verificar se há planos
                            $hasPlans = $applicationData->plans->isNotEmpty();
                            @endphp

                            @if ($householdMember)
                            <tr data-application-id="{{ $applicationData->id }}">
                                <td style="text-align: center;"><input type="checkbox"
                                        class="application-checkbox" value="{{ $applicationData->id }}"></td>
                                <td>{{ $applicationData->id }}</td>
                                <td>{{ $firstName }}</td>
                                <td>{{ $lastName }}</td>
                                {{-- <td>{{ $middleName }}</td> --}}
                                <td>{{ $ssn }}</td>
                                <td class="text-center">
                                    {{ $createdAt }}
                                </td>

                                <td class="text-center">
                                    <!-- Exibe os botões dependendo de quem é o usuário e se há planos -->
                                    @if ($isClient)
                                    @if ($hasPlans)
                                    <!-- Exibe o botão de Ver Dados, já que o cliente tem planos -->
                                    <button type="button"
                                        onclick="window.location.href='{{ route('livewire.view-data-quotation', $applicationData->id) }}'"
                                        class="btn btn-warning">
                                        <i class="fas fa-eye"></i> @lang('labels.visualizarDados')
                                    </button>
                                    @else
                                    <!-- Exibe o botão de Ver Cotação, pois o cliente não tem planos -->
                                    <button type="button"
                                        onclick="window.open('/quotation/{{ $applicationData->id }}','_blank')"
                                        class="btn btn-primary">
                                        <i class="fas fa-list"></i> @lang('labels.verCotacao')
                                    </button>
                                    @endif

                                    <!-- Adiciona o botão de exclusão para o cliente -->
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDeleteApplication({{ $applicationData->id }})">
                                        <i class="fas fa-trash-alt"></i> @lang('labels.buttonExcluir')
                                    </button>
                                    @else
                                    <!-- Para admin e agente, exibe ambos os botões -->
                                    <button type="button"
                                        onclick="window.location.href='{{ route('livewire.view-data-quotation', $applicationData->id) }}'"
                                        class="btn btn-warning">
                                        <i class="fas fa-eye"></i> @lang('labels.visualizarDados')
                                    </button>
                                    <button type="button"
                                        onclick="window.open('/quotation/{{ $applicationData->id }}','_blank')"
                                        class="btn btn-primary">
                                        <i class="fas fa-list"></i> @lang('labels.verCotacao')
                                    </button>

                                    <!-- Adiciona o botão de exclusão para admin e agente -->
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDeleteApplication({{ $applicationData->id }})">
                                        <i class="fas fa-trash-alt"></i> @lang('labels.buttonExcluir')
                                    </button>
                                    @endif
                                </td>

                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">@lang('labels.semDados')</td>
                            </tr>
                            @endforelse
                        </tbody>



                    </table>
                </div>

                <!-- Paginação -->
                @if ($application instanceof \Illuminate\Pagination\LengthAwarePaginator && $application->hasPages())
                <div class="mt-4">
                    {{ $application->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const title = @json(__('labels.tituloExcluir'));
    const text = @json(__('labels.textExcluir'));
    const excluir = @json(__('labels.textExcluirConfirm'));
    const cancelar = @json(__('labels.buttonCancelar'));
    const excluirerro = @json(__('labels.textExcluirErro'));

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Função para exibir a confirmação de exclusão
        window.confirmDeleteApplication = function(applicationId) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: excluir,
                cancelButtonText: cancelar
            }).then((result) => {
                if (result.isConfirmed) {
                    // Iniciar o loading
                    Swal.fire({
                        title: '@lang('
                        labels.deleting ')...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    deleteApplication(applicationId).then(() => Swal.close());
                }
            });
        };

        // Selecionar ou desmarcar todos os checkboxes
        $('#select-all').change(function() {
            $('.application-checkbox').prop('checked', this.checked);
            toggleDeleteSelectedButton();
        });

        // Mostrar ou esconder o botão "Excluir Selecionados" quando os checkboxes individuais forem alterados
        $('.application-checkbox').change(function() {
            toggleDeleteSelectedButton();
        });
        // Função para excluir a aplicação via AJAX
        window.deleteApplication = function(applicationId) {
            return $.ajax({
                url: `/application/delete/${applicationId}`,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '@lang('
                            labels.deleted ')!',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            $(`tr[data-application-id="${applicationId}"]`).remove();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: excluirerro,
                        confirmButtonText: 'Ok'
                    });
                }
            });
        };



        $('#delete-selected').click(function() {
            const selectedIds = $('.application-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                Swal.fire('@lang('
                    labels.deleteSelected ').', '', 'info');
                return;
            }
            const title2 = `{{ __('labels.deleteXSelected', ['value' => ':value']) }}`.replace(
                ':value', selectedIds.length);
            const text2 = `{{ __('labels.deleteXSelectedConfirm', ['value' => ':value']) }}`.replace(
                ':value', selectedIds.length);

            Swal.fire({
                title: title2,
                text: text2,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('
                labels.buttonExcluir ')',
                cancelButtonText: '@lang('
                labels.buttonCancelar ')'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Iniciar o loading antes da exclusão
                    Swal.fire({
                        title: '@lang('
                        labels.deleting ')...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Exclui cada item individualmente e espera todas as requisições terminarem
                    Promise.all(selectedIds.map(id => window.deleteApplication(id)))
                        .then(() => {
                            Swal.fire('@lang('
                                labels.deletedAll ')', '', '@lang('
                                labels.sucesso ')');
                        })
                        .catch(error => {
                            Swal.fire('Erro', '@lang('
                                labels.erroDeleteApplication ').', 'error');
                        })
                        .finally(() => {
                            Swal.close(); // Fechar o loading após a exclusão
                        });
                }
            });
        });
    });

    // Função para mostrar ou esconder o botão "Excluir Selecionados" conforme os checkboxes
    function toggleDeleteSelectedButton() {
        const selectedCount = $('.application-checkbox:checked').length;
        if (selectedCount > 0) {
            $('#delete-selected').show(); // Mostrar botão
        } else {
            $('#delete-selected').hide(); // Esconder botão
        }
    }
</script>
@endsection