{{-- <style>
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
</style>

@php

    $user = auth()->user();

    $isClient = !$user->is_admin && !$user->easy_id;


@endphp

<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <!-- você pode ajustar o estilo aqui -->
            <h1 style="color: white;"></h1>
        </div>
        <div class="main-sidemenu">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div class="main-img-user avatar-xl">
                        <!-- Imagem do usuário -->
                        @if (!$isClient)
                            <!-- Imagem do Agente -->
                            <img src="https://img.freepik.com/free-vector/hand-drawn-bodyguard-illustration_23-2150308174.jpg?t=st=1728310020~exp=1728313620~hmac=85ef7251f5b46648136b7e00539161380c725fd70e0f8d8bf349ad38bd93239d&w=740"
                                alt="Profile" class="profile-icon"
                                style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                            <!-- Imagem do Cliente -->
                            <img src="https://img.freepik.com/free-vector/young-man-black-shirt_1308-173618.jpg?t=st=1727210566~exp=1727214166~hmac=1a00ca1e3c5a29b2ba15d02cd2de9c5747d1dc62730fbc62af25acfb1241cc15&w=740"
                                alt="Profile" class="profile-icon"
                                style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                        <span class="avatar-status profile-status bg-green"></span>
                    </div>
                    <div class="user-info">
                        <!-- Nome e Email do usuário -->
                        <h4 class="fw-semibold mt-3 mb-0 user-name" style="color: #0056b3;">
                            {{ $user->name ?? 'Usuário Desconhecido' }}</h4>
                        <span class="mb-0 text-muted">{{ $user->email ?? 'Email não disponível' }}</span>
                    </div>
                </div>
            </div>

            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                        <span class="side-menu__label">Home</span>
                    </a>
                </li>
            </ul>

        </div>
    </aside>
</div> --}}
