@extends('layouts.app')

<style>
    .card {
        max-width: 600px;
        margin: 0 auto;
    }

    .card-header {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card-body p {
        margin: 0.5rem 0;
    }

    .profile-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    .nav-item .nav-link {
        color: #007bff;
        font-size: 1rem;
        display: flex;
        align-items: center;
        margin-top: 10px;
        padding-left: 5px;
    }

    .nav-item .nav-link i {
        margin-right: 8px;
        font-size: 1.2rem;
    }

    .nav-item .nav-link:hover {
        text-decoration: underline;
        color: #0056b3;
    }
</style>

@section('content')
    <!-- Profile Container -->
    <div class="container mt-4">
        <!-- Caixa com borda -->
        <div class="card border-primary">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <!-- Simbolo do perfil -->
                <div class="me-3">
                    @if (!$isClient)
                        <!-- Imagem do Agente -->
                        <img src="https://img.freepik.com/free-vector/hand-drawn-bodyguard-illustration_23-2150308174.jpg?t=st=1728310020~exp=1728313620~hmac=85ef7251f5b46648136b7e00539161380c725fd70e0f8d8bf349ad38bd93239d&w=740"
                            alt="Profile" class="profile-icon" style="width: 60px; height: 60px; border-radius: 50%;">
                    @else
                        <!-- Imagem do Cliente -->
                        <img src="https://img.freepik.com/free-vector/young-man-black-shirt_1308-173618.jpg?t=st=1727210566~exp=1727214166~hmac=1a00ca1e3c5a29b2ba15d02cd2de9c5747d1dc62730fbc62af25acfb1241cc15&w=740"
                            alt="Profile" class="profile-icon" style="width: 60px; height: 60px; border-radius: 50%;">
                    @endif
                </div>
                <!-- Informações do perfil -->
                <div>
                    <h4>@lang('labels.infoPerfil')</h4>
                </div>
            </div>

            <!-- Linha separadora -->
            <hr class="my-2">

            <!-- Parte inferior com Nome, Email e Data de Ingresso -->
            <div class="card-body">
                <p><strong>@lang('labels.nome'): </strong>{{ $user->name }}</p>
                <p><strong>@lang('labels.enderecoEmail'): </strong>{{ $user->email }}</p>
                <p><strong>@lang('labels.dataRegistro'): </strong>{{ $user->created_at->format('m/d/Y') }}</p>
                <br><br>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="showLoading()">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="profile_image_pdf" class="form-label">@lang('labels.uploadProfileImage')</label>
                        <input type="file" class="form-control" id="profile_image_pdf" name="profile_image_pdf"
                            accept="image/*" onchange="previewImage(event)">
                    </div>

                    <!-- Previsão da imagem e botão de remoção -->
                    <div class="mb-3" id="imagePreviewContainer" style="position: relative;">
                        @if ($user->profile_image_pdf)
                            <img id="imagePreview" src="{{ Storage::url($user->profile_image_pdf) }}"
                                alt="@lang('labels.profileImagePreview')"
                                style="width: 150px; height: auto; border-radius: 5px; margin-top: 10px;">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeImage()"
                                style="position: absolute; top: 10px; right: 10px;">X</button>
                        @else
                            <img id="imagePreview"
                                style="display: none; width: 150px; height: auto; border-radius: 5px; margin-top: 10px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">@lang('labels.buttonSalvar')</button>
                </form>
            </div>
            <br><br>

            <!-- Botões para geração de código e link -->
            <div class="card-footer">
                @if (!$isClient)
                    <button class="btn btn-success btn-lg ml-2" onclick="copyAgentCode()">
                        @lang('labels.copyCodeAgent')
                    </button>
                    <button class="btn btn-info btn-lg ml-2" onclick="generateAgentLink()">
                        @lang('labels.gerarLink')
                    </button>
                @endif
            </div>

            <!-- Links de EDE -->
            <!-- <div class="card-footer">
                <ul class="list-unstyled">
                    @if (!auth()->user()->has_idm_refresh_token)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(route('idm.idm_connect')) }}">
                                <i class="fas fa-link"></i> EDE Integration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(route('idm.idm_refresh')) }}">
                                <i class="fas fa-redo-alt"></i> EDE Refresh Token
                            </a>
                        </li>
                    @endif
                </ul>
            </div> -->

        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if ($agentCode)
            const agentCode = "{{ $agentCode }}";

            function copyAgentCode() {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(agentCode).then(function() {
                        alert('@lang('labels.codAgent')');
                    }, function(err) {
                        console.error('Erro ao copiar o código: ', err);
                    });
                } else {
                    const textArea = document.createElement("textarea");
                    textArea.value = agentCode;
                    textArea.style.position = "fixed";
                    textArea.style.opacity = 0;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        const successful = document.execCommand('copy');
                        const msg = successful ? '@lang('labels.codAgent')' : 'Erro ao copiar o código';
                        alert(msg);
                    } catch (err) {
                        console.error('Erro ao copiar o código com fallback: ', err);
                    }
                    document.body.removeChild(textArea);
                }
            }

            function generateAgentLink() {
                const currentLocale = "{{ app()->getLocale() }}";
                const baseUrl = window.location.origin;
                const agentLink = `${baseUrl}/register/client?agent_code=${agentCode}&locale=${currentLocale}`;

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(agentLink).then(function() {
                        alert('@lang('labels.linkCopiado')');
                    }, function(err) {
                        console.error('Erro ao copiar o link: ', err);
                    });
                } else {
                    const textArea = document.createElement("textarea");
                    textArea.value = agentLink;
                    textArea.style.position = "fixed";
                    textArea.style.opacity = 0;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        const successful = document.execCommand('copy');
                        const msg = successful ? '@lang('labels.linkCopiado')' : 'Erro ao copiar o link';
                        alert(msg);
                    } catch (err) {
                        console.error('Erro ao copiar o link com fallback: ', err);
                    }
                    document.body.removeChild(textArea);
                }
            }
        @endif

        function showLoading() {
            Swal.fire({
                title: '@lang('labels.carregando')',
                text: '@lang('labels.carregandoImagem')',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('imagePreviewContainer');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.src = '';
            }
        }

        function removeImage() {
            Swal.fire({
                title: '@lang('labels.removerImagem')?',
                text: '@lang('labels.removerImagemConfirm')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('labels.yesRemoved')',
                cancelButtonText: '@lang('labels.buttonCancelar')'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route('profile.image.delete') }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    '@lang('labels.removed')!',
                                    '@lang('labels.sucessoRemoved')',
                                    'success'
                                );
                                document.getElementById('imagePreview').style.display = 'none';
                                document.getElementById('profile_image_pdf').value =
                                    ''; // Limpa o input de upload
                            } else {
                                Swal.fire(
                                    'Erro!',
                                    '@lang('labels.problemRemover')',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            Swal.fire(
                                'Erro!',
                                '@lang('labels.problemRemover')',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endsection
