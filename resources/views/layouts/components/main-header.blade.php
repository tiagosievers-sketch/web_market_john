@php

    $user = auth()->user();

    $isClient = !$user->is_admin && !$user->easy_id;

@endphp

<div class="main-header side-header sticky nav nav-item">
    <div class="container-fluid main-container">
        <div class="main-header-left">
            <div class="responsive-logo">
                <a href="{{ url('index') }}" class="header-logo">
                    <img src="{{ asset('img/logo.png') }}" class="logo-1" alt="logo">
                    <img src="{{ asset('img/logo.png') }}" class="dark-logo-1" alt="logo">
                </a>
            </div>
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="header-icons fe fe-x"></i></a>
            </div>
            <div class="main-header-center ms-3 d-sm-none d-md-none d-lg-block">
                <input class="form-control" placeholder="Search for anything..." type="search">
                <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
            </div>
        </div>

        <div class="main-header-right">
            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
            </button>

            <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <ul class="nav nav-item navbar-nav-right ms-auto">

                        {{-- @if (!auth()->user()->has_idm_refresh_token)
                            <!-- Adicionando o novo link aqui -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(route('idm.idm_connect')) }}">
                                    <i class="fas fa-link"></i> EDE Integration
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(route('idm.idm_refresh')) }}">
                                    <i class="fas fa-link"></i> EDE Refresh Token
                                </a>
                            </li>
                        @endif --}}

                        <!-- Language Dropdown -->
                        <li class="nav-item dropdown countries">
                            <a href="javascript:void(0);" class="d-flex nav-item nav-link country-flag1"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="background-color: #007bff; color: white;">
                                <span class="avatar country-Flag me-0 align-self-center bg-transparent">
                                    <!-- Bandeira do idioma selecionado -->
                                    @if (app()->getLocale() == 'en')
                                        <img src="{{ asset('img/estados-unidos.png') }}" alt="English"
                                            style="width: 24px;">
                                    @else
                                        <img src="{{ asset('img/brasil.png') }}" alt="Portuguese" style="width: 24px;">
                                    @endif
                                </span>
                                <div class="my-auto">
                                    <strong
                                        class="me-2 ms-2 my-auto">{{ app()->getLocale() == 'en' ? 'English' : 'Portuguese' }}</strong>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-start dropdown-menu-arrow">
                                <a href="{{ route('localization.change', 'en') }}" class="dropdown-item d-flex"
                                    style="background-color: white; color: black;">
                                    <span class="avatar me-1 align-self-center bg-transparent">
                                        <img src="{{ asset('img/estados-unidos.png') }}" alt="English"
                                            style="width: 24px;">
                                    </span>
                                    <span class="mt-2">English</span>
                                </a>
                                <a href="{{ route('localization.change', 'pt') }}" class="dropdown-item d-flex"
                                    style="background-color: white; color: black;">
                                    <span class="avatar me-1 align-self-center bg-transparent">
                                        <img src="{{ asset('img/brasil.png') }}" alt="Portuguese" style="width: 24px;">
                                    </span>
                                    <span class="mt-2">Portuguese</span>
                                </a>
                                <a href="{{ route('localization.change', 'es') }}" class="dropdown-item d-flex"
                                    style="background-color: white; color: black;">
                                    <span class="avatar me-1 align-self-center bg-transparent">
                                        <img src="{{ asset('img/espanha.png') }}" alt="spanish" style="width: 24px;">
                                    </span>
                                    <span class="mt-2">Spanish</span>
                                </a>
                            </div>
                        </li>

                        <!-- Theme toggle (light/dark) -->
                        <li class="dropdown nav-item main-layout">
                            <a class="new nav-link theme-layout nav-link-bg layout-setting">
                                <span class="dark-layout">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24"
                                        height="24" viewBox="0 0 24 24">
                                        <path
                                            d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z" />
                                    </svg>
                                </span>
                                <span class="light-layout">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24"
                                        height="24" viewBox="0 0 24 24">
                                        <path
                                            d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z" />
                                    </svg>
                                </span>
                            </a>
                        </li>

                        <!-- Logout Button with Fixed User Profile Image -->
                        <li class="dropdown main-profile-menu nav nav-item nav-link">
                            <a class="profile-user d-flex" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <!-- Imagem de usuário fixa -->
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
                            </a>
                            <div class="dropdown-menu">
                                <div class="main-header-profile bg-primary p-3">
                                    <div class="d-flex wd-100p">
                                        <div class="main-img-user">
                                            <!-- Mesma imagem fixa dentro do dropdown -->
                                            @if (!$isClient)
                                                <!-- Imagem do Agente -->
                                                <img src="https://img.freepik.com/free-vector/hand-drawn-bodyguard-illustration_23-2150308174.jpg?t=st=1728310020~exp=1728313620~hmac=85ef7251f5b46648136b7e00539161380c725fd70e0f8d8bf349ad38bd93239d&w=740"
                                                    alt="Profile" class="profile-icon"
                                                    style="width: 60px; height: 60px; border-radius: 50%;">
                                            @else
                                                <!-- Imagem do Cliente -->
                                                <img src="https://img.freepik.com/free-vector/young-man-black-shirt_1308-173618.jpg?t=st=1727210566~exp=1727214166~hmac=1a00ca1e3c5a29b2ba15d02cd2de9c5747d1dc62730fbc62af25acfb1241cc15&w=740"
                                                    alt="Profile" class="profile-icon"
                                                    style="width: 60px; height: 60px; border-radius: 50%;">
                                            @endif
                                        </div>
                                        <div class="ms-3 my-auto">
                                            <h6>{{ auth()->user()->name }}</h6>
                                            <span>{{ auth()->user()->email }}</span>
                                            <a class="dropdown-item" href="{{ route('user.profile') }}"
                                                style="color: white; transition: all 0.4s ease;">
                                                <i class="bx bx-user"
                                                    style="color: white; transition: all 0.4s ease;"></i>
                                                @lang('labels.profile')
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="bx bx-log-out"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
