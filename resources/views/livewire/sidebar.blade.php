<style>
    .app-sidebar {
        color: #87ceeb;
        font-family: 'Arial', sans-serif;
    }

    .main-sidemenu {
        padding: 15px;
    }

    .side-item-category {
        padding: 10px 15px;
        font-size: 16px;
        color: #87ceeb;
        text-transform: uppercase;
    }

    .app-sidebar__user {
        padding: 20px 15px;
        border-bottom: 1px solid #87ceeb;
    }

    .member-link {
        color: white;
        display: block;
        padding: 10px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .member-link:hover {
        background-color: #0056b3;
    }

    .member-link {
        display: block;
        padding: 10px;
        background-color: #f0f0f0;
        /* Fundo cinza claro */
        color: #333;
        /* Cor do texto */
        text-decoration: none;
        /* Remove o sublinhado */
        border-radius: 4px;
        margin-bottom: 5px;
    }

    .member-link:hover {
        background-color: #d1d1d1;
        /* Cor mais escura no hover */
        color: #0056b3;
        /* Cor azul no texto ao passar o mouse */
    }

    .member-link:active {
        background-color: #bdbdbd;
        /* Cor ao clicar */
        color: #004080;
    }

    .member-link .icon {
        margin-left: 10px;
        /* Ajusta o espaçamento do ícone */
    }

    .member-link.selected {
        background-color: #007bff;
        /* ajuste a cor para a que desejar */
        color: #fff;
    }

    .side-menu__item.active {
        border: 2px solid #007bff;
        /* Borda azul */
        background-color: #f8f9fa;
        /* Fundo cinza claro */
        color: #007bff;
        /* Texto azul */
        border-radius: 5px;
        /* Bordas arredondadas */
    }
</style>

@php
$user = auth()->user();
$isClient = !$user->is_admin && !$user->easy_id;
@endphp

<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <h1 style="color: white;"></h1>
        </div>
        <div class="main-sidemenu">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div class="main-img-user avatar-xl">
                        @if (!$isClient)
                        <img src="https://img.freepik.com/free-vector/hand-drawn-bodyguard-illustration_23-2150308174.jpg?t=st=1728310020~exp=1728313620~hmac=85ef7251f5b46648136b7e00539161380c725fd70e0f8d8bf349ad38bd93239d&w=740"
                            alt="Profile" class="profile-icon"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                        <img src="https://img.freepik.com/free-vector/young-man-black-shirt_1308-173618.jpg?t=st=1727210566~exp=1727214166~hmac=1a00ca1e3c5a29b2ba15d02cd2de9c5747d1dc62730fbc62af25acfb1241cc15&w=740"
                            alt="Profile" class="profile-icon"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                        <span class="avatar-status profile-status bg-green"></span>
                    </div>
                    <div class="user-info">
                        <h4 class="fw-semibold mt-3 mb-0 user-name" style="color: #0056b3;">
                            {{ $user->name ?? 'Usuário Desconhecido' }}
                        </h4>
                        <span class="mb-0 text-muted">{{ $user->email ?? 'Email não disponível' }}</span>
                    </div>
                </div>
            </div>
            @php
            $currentMemberId = request('member_id'); // Captura o `member_id` da URL

            @endphp
            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item {{ $currentRoute === 'index' ? 'active' : '' }}"
                        href="{{ url('index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                        <span class="side-menu__label">Home</span>
                    </a>
                </li>
                <br>

                <li class="slide">
                    <a class="side-menu__item {{ $currentRoute === 'quick-quotation' ? 'active' : '' }}"
                        href="{{ url('quick-quotation') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                        </svg>
                        <span class="side-menu__label">@lang('labels.quickQuotation')</span>
                    </a>
                </li>
                @if($showMenuAll)

                @if ($showMenuPrimaryContact)
                <li class="slide">
                    <a id="btnPrimaryContact" class="side-menu__item
                                {{ $currentRoute === 'livewire.primary-contact' || $currentRoute === 'livewire.primary-contact-edit' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 2C7.41 2 3.86 4.73 2.71 8.75c-.04.15-.06.31-.06.47 0 3.31 2.69 6 6 6h1v2H6v2h4c.55 0 1 .45 1 1v3h2v-3c0-.55.45-1 1-1h4v-2h-3v-2h1c3.31 0 6-2.69 6-6 0-.16-.02-.32-.06-.47C20.14 4.73 16.59 2 12 2zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
                        </svg>
                        <span class="side-menu__label">Primary Contact</span>
                    </a>
                </li>
                @endif
                @if ($showMenuHouseHold)
                <li class="slide">
                    <a id="btnHouseHold" class="side-menu__item
                                {{ $currentRoute === 'livewire.household' || $currentRoute === 'livewire.household-edit' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18a8 8 0 110-16 8 8 0 010 16zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                        </svg>
                        <span class="side-menu__label">HouseHold</span>
                    </a>
                </li>
                @endif
                @if ($showMenuRelationship)
                <li class="slide">
                    <a id="btnRelationship" class="side-menu__item
                                {{ $currentRoute === 'livewire.relationship' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M18 2.06A11.96 11.96 0 0 0 4 2.06c0 5.45 3.55 10.29 8.54 11.33.37.38.92.38 1.29 0C15.45 12.35 19 6.51 19 2.06a11.97 11.97 0 0 0-11.96 11.96zM8 13a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        </svg>
                        <span class="side-menu__label">Relationship</span>
                    </a>
                </li>
                @endif


                @if ($showTaxMenuTax)
                <li class="slide">
                    <a id="btnTax" class="side-menu__item {{ $currentRoute === 'livewire.tax' ? 'active' : '' }}"
                        href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 4.36 5.45 9.31 6.35 10.2.37.38.92.38 1.29 0C13.55 18.31 19 13.36 19 9c0-3.87-3.13-7-7-7zm0 14.55c-1.06-1.06-4.93-5.18-4.93-8.55 0-2.73 2.2-4.93 4.93-4.93 2.73 0 4.93 2.2 4.93 4.93 0 3.37-3.87 7.49-4.93 8.55zM11 6h2v2h-2zm0 4h2v4h-2z" />
                        </svg>
                        <span class="side-menu__label">Tax</span>
                    </a>
                </li>
                @endif


                @if ($showMenuAdditioanlInformation)
                <li class="slide">
                    <a id="btnAdditionalInformation" class="side-menu__item
                                {{ $currentRoute === 'livewire.additional-information' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M14 2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 16h8c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H8c-.55 0-1 .45-1 1v12c0 .55.45 1 1 1zm4-5.5c0-.28-.22-.5-.5-.5h-3c-.28 0-.5.22-.5.5v3c0 .28.22.5.5.5h3c.28 0 .5-.22.5-.5v-3zm-1.5 1c0 .28-.22.5-.5.5H10c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5h3c.28 0 .5.22.5.5v3z" />
                        </svg>
                        <span class="side-menu__label">Additional Information</span>
                    </a>
                </li>
                @endif
                @if ($showMenuAdress)
                <li class="slide">
                    <a id="btnAddress" class="side-menu__item
                                {{ $currentRoute === 'livewire.address-applicant' || $currentRoute === 'livewire.address-applicant-edit' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 3.87 3.13 7 7 7 1.44 0 2.75-.61 3.82-1.53l.83.82C11.08 15.66 12 14.15 12 12.59 12 9.13 14.13 6 17 6c1.87 0 3.5 1.13 4.22 2.72l.83-.82C20.87 8.61 19 6.15 17 5.37 14.13 2 12 2zm0 14.55c-1.06-1.06-4.93-5.18-4.93-8.55 0-2.73 2.2-4.93 4.93-4.93 2.73 0 4.93 2.2 4.93 4.93 0 3.37-3.87 7.49-4.93 8.55z" />
                        </svg>
                        <span class="side-menu__label">Addresses</span>
                    </a>
                </li>
                @endif
                @if ($showMenuMembers)
                <li class="slide">
                    <a id="btnMembers" class="side-menu__item
                                {{ $currentRoute === 'livewire.members' || $currentRoute === 'livewire.members-edit' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M16 11c0-1.66-1.34-3-3-3-1.66 0-3 1.34-3 3 0 1.66 1.34 3 3 3 1.66 0 3-1.34 3-3zm-2-8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-2zm-10 4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h2c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2h-2z" />
                        </svg>
                        <span class="side-menu__label">Members</span>
                    </a>
                </li>
                @endif
                @if ($showMenuIncome)
                <li class="slide">
                    <a id="btnIncome" class="side-menu__item
                                {{ $currentRoute === 'livewire.income' || $currentRoute === 'livewire.income-edit' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 3.87 3.13 7 7 7 1.44 0 2.75-.61 3.82-1.53l.83.82C11.08 15.66 12 14.15 12 12.59 12 9.13 14.13 6 17 6c1.87 0 3.5 1.13 4.22 2.72l.83-.82C20.87 8.61 19 6.15 17 5.37 14.13 2 12 2zm0 14.55c-1.06-1.06-4.93-5.18-4.93-8.55 0-2.73 2.2-4.93 4.93-4.93 2.73 0 4.93 2.2 4.93 4.93 0 3.37-3.87 7.49-4.93 8.55z" />
                        </svg>
                        <span class="side-menu__label">Income</span>
                    </a>
                </li>
                @endif
                @if ($showMenuAdditionalQuestion)
                <li class="slide">
                    <a id="btnAdditionalQuestion" class="side-menu__item
                                {{ $currentRoute === 'livewire.additional-question' || $currentRoute === 'livewire.additional-question-edit' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18a8 8 0 110-16 8 8 0 010 16zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                        </svg>
                        <span class="side-menu__label">Additional Question</span>
                    </a>
                </li>
                @endif
                @if ($showMenuFinalize)
                <li class="slide">
                    <a id="btnFinalize" class="side-menu__item
                                {{ $currentRoute === 'livewire.finalize' ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 11H7V9h2v2zm4 0h-2V9h2v2zm4 0h-2V9h2v2z" />
                        </svg>
                        <span class="side-menu__label">Finalize</span>
                    </a>
                </li>
                @endif


                @if (isset($membersInfo) && !empty($membersInfo))
                <li class="slide">
                    <h5 class="side-item-category">Membros</h5>
                    @foreach ($membersInfo as $index => $member)
                    <a class="member-link {{ $currentMemberId == $member['id'] || (is_null($currentMemberId) && $index == 0) ? 'selected' : '' }}"
                        href="{{ url('/members/' . $member['application_id'] . '?member_id=' . $member['id']) }}">
                        {{ $member['firstname'] }} {{ $member['lastname'] }}

                        {{-- Exibir o ícone de acordo com o valor de `answered` --}}
                        @if ($member['answered'] === true)
                        <span class="icon">
                            <i class="fas fa-check" style="color: green; width: 22px;"></i>
                            {{-- Certinho verde para quem respondeu --}}
                        </span>
                        @else
                        {{-- Ícone cinza para quem não respondeu --}}
                        {{-- <span class="icon">
                            <i class="fas fa-check-circle" style="color: gray;"></i> Certinho cinza para quem não respondeu --}}
                        {{-- </span> --}}
                        @endif
                    </a>
                    @endforeach
                </li>
                @endif
                @endif


            </ul>
        </div>
    </aside>
</div>


<script>
    const application_id = '{{ $application_id }}';

    //showMenuPrimaryContact
    document.getElementById('btnPrimaryContact').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.confirm ')',
            text: '@lang('
            labels.confirmDeletePrimaryContact ')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: '@lang('
            labels.buttonCancelar ')',
        }).then((result) => {
            if (result.isConfirmed) {
                // Exibir modal de carregamento durante a exclusão
                Swal.fire({
                    title: '@lang('
                    labels.processando ')...',
                    text: '@lang('
                    labels.waitReload ')',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/household/ajax/deletehousholdata/${application_id}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            application_id: application_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                '@lang('
                                labels.deleted ')!',
                                '@lang('
                                labels.successDeleted ')',
                                'success'
                            ).then(() => {
                                // Mostrar modal de carregamento enquanto a página recarrega
                                Swal.fire({
                                    title: '@lang('
                                    labels.carregando ')...',
                                    text: '@lang('
                                    labels.aguarde ')',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                window.location.href =
                                    "{{ route('livewire.primary-contact-edit', ':application_id') }}"
                                    .replace(
                                        ':application_id', application_id
                                    );
                            });
                        } else {
                            Swal.fire('Erro!', data.message || 'Erro ao apagar os dados.', 'error');
                            console.error('Detalhes do erro:', data.details ||
                                'Nenhum detalhe fornecido.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        Swal.fire('Erro!', '@lang('
                            labels.errorDelete ').', 'error');
                    });
            }
        });
    });
    //showMenuHouseHold
    document.getElementById('btnHouseHold').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.confirm ')',
            text: '@lang('
            labels.confirmDeleteHouseHold ')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: '@lang('
            labels.buttonCancelar ')',
        }).then((result) => {
            if (result.isConfirmed) {
                // Exibir modal de carregamento durante a exclusão
                Swal.fire({
                    title: '@lang('
                    labels.processando ')...',
                    text: '@lang('
                    labels.waitReload ')',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/household/ajax/deletehousholdata/${application_id}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            application_id: application_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                '@lang('
                                labels.deleted ')!',
                                '@lang('
                                labels.successDeleted ')',
                                'success'
                            ).then(() => {
                                // Mostrar modal de carregamento enquanto a página recarrega
                                Swal.fire({
                                    title: '@lang('
                                    labels.carregando ')...',
                                    text: '@lang('
                                    labels.aguarde ')',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                window.location.href =
                                    "{{ route('livewire.household', ':application_id') }}"
                                    .replace(
                                        ':application_id', application_id
                                    );
                            });
                        } else {
                            Swal.fire('Erro!', data.message || 'Erro ao apagar os dados.', 'error');
                            console.error('Detalhes do erro:', data.details ||
                                'Nenhum detalhe fornecido.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        Swal.fire('Erro!', '@lang('
                            labels.errorDelete ').', 'error');
                    });
            }
        });
    });


    //showTaxMenuRelationship
    document.getElementById('btnRelationship').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.confirm ')',
            text: '@lang('
            labels.confirmDeleteRelationship ')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: '@lang('
            labels.buttonCancelar ')',
        }).then((result) => {
            if (result.isConfirmed) {
                // Exibir modal de carregamento durante a exclusão
                Swal.fire({
                    title: '@lang('
                    labels.processando ')...',
                    text: '@lang('
                    labels.waitReload ')',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/relationship/deleteRelationship/${application_id}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            application_id: application_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                '@lang('
                                labels.deleted ')!',
                                '@lang('
                                labels.successDeleted ')',
                                'success'
                            ).then(() => {
                                // Mostrar modal de carregamento enquanto a página recarrega
                                Swal.fire({
                                    title: '@lang('
                                    labels.carregando ')...',
                                    text: '@lang('
                                    labels.aguarde ')',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                window.location.href =
                                    "{{ route('livewire.relationship', ':application_id') }}"
                                    .replace(
                                        ':application_id', application_id
                                    );
                            });
                        } else {
                            Swal.fire('Erro!', data.message || 'Erro ao apagar os dados.', 'error');
                            console.error('Detalhes do erro:', data.details ||
                                'Nenhum detalhe fornecido.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        Swal.fire('Erro!', '@lang('
                            labels.errorDelete ').', 'error');
                    });
            }
        });
    });



    //tax
    document.getElementById('btnTax').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.confirm ')',
            text: '@lang('
            labels.confirmDelete ')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: '@lang('
            labels.buttonCancelar ')',
        }).then((result) => {
            if (result.isConfirmed) {
                // Exibir modal de carregamento durante a exclusão
                Swal.fire({
                    title: '@lang('
                    labels.processando ')...',
                    text: '@lang('
                    labels.waitReload ')',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/tax/deletetaxdata/${application_id}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            application_id: application_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                '@lang('
                                labels.deleted ')!',
                                '@lang('
                                labels.successDeletedTax ')',
                                'success'
                            ).then(() => {
                                // Mostrar modal de carregamento enquanto a página recarrega
                                Swal.fire({
                                    title: '@lang('
                                    labels.carregando ')...',
                                    text: '@lang('
                                    labels.aguarde ')',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                window.location.href =
                                    "{{ route('livewire.tax', ':application_id') }}"
                                    .replace(
                                        ':application_id', application_id
                                    );
                            });
                        } else {
                            Swal.fire('Erro!', data.message || 'Erro ao apagar os dados.', 'error');
                            console.error('Detalhes do erro:', data.details ||
                                'Nenhum detalhe fornecido.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        Swal.fire('Erro!', '@lang('
                            labels.errorDelete ').', 'error');
                    });
            }
        });
    });


    //additional Information
    document.getElementById('btnAdditionalInformation').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.confirm ')',
            text: '@lang('
            labels.confirmDeleteAdditional ')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: '@lang('
            labels.buttonCancelar ')',
        }).then((result) => {
            if (result.isConfirmed) {

                fetch(`/additionalinformation/deleteadditional/${application_id}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            application_id: application_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                '@lang('
                                labels.deleted ')!',
                                '@lang('
                                labels.successDeleted ')',
                                'success'
                            ).then(() => {
                                window.location.href =
                                    "{{ route('livewire.additional-information', ':application_id') }}"
                                    .replace(
                                        ':application_id', application_id);
                            });
                        } else {
                            Swal.fire('Erro!', data.message || 'Erro ao apagar os dados.', 'error');
                            console.error('Detalhes do erro:', data.details ||
                                'Nenhum detalhe fornecido.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        Swal.fire('Erro!', '@lang('
                            labels.errorDelete ').', 'error');
                    });
            }
        });
    });

    //address
    document.getElementById('btnAddress').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.carregando ')',
            text: '@lang('
            labels.aguarde ')',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const applicationId = '{{ $application_id }}';

        // Redireciona após exibir o modal
        setTimeout(() => {
            window.location.href =
                "{{ route('livewire.address-applicant', ':application_id') }}"
                .replace(':application_id', applicationId);
        }, 1500); // Adiciona um pequeno atraso para exibir o modal
    });


    //showMenuMembers
    document.getElementById('btnMembers').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.carregando ')',
            text: '@lang('
            labels.aguarde ')',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const applicationId = '{{ $application_id }}';

        // Redireciona após exibir o modal
        setTimeout(() => {
            window.location.href =
                "{{ route('livewire.members', ':application_id') }}"
                .replace(':application_id', applicationId);
        }, 1000); // Adiciona um pequeno atraso para exibir o modal
    });



    //showMenuIncome
    document.getElementById('btnIncome').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.carregando ')',
            text: '@lang('
            labels.aguarde ')',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const applicationId = '{{ $application_id }}';

        // Redireciona após exibir o modal
        setTimeout(() => {
            window.location.href =
                "{{ route('livewire.income-edit', ':application_id') }}"
                .replace(':application_id', applicationId);
        }, 1000); // Adiciona um pequeno atraso para exibir o modal
    });


    //showMenuAdditionalQuestion
    document.getElementById('btnAdditionalQuestion').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '@lang('
            labels.carregando ')',
            text: '@lang('
            labels.aguarde ')',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const applicationId = '{{ $application_id }}';

        // Redireciona após exibir o modal
        setTimeout(() => {
            window.location.href =
                "{{ route('livewire.additional-question-edit', ':application_id') }}"
                .replace(':application_id', applicationId);
        }, 1000); // Adiciona um pequeno atraso para exibir o modal
    });
</script>