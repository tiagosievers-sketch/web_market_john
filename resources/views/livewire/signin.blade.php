@extends('layouts.custom-app')

@section('styles')
<style>
    /* Custom Styling */
    .bg-primary-transparent {
        background: linear-gradient(135deg, #007bff 30%, #0056b3 90%);
    }

    .login {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 0 20px;
    }

    .card-sigin {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 20px;
    }

    .main-signup-header h2,
    .main-signup-header h5 {
        text-align: center;
    }

    .main-signup-header h2 {
        color: #007bff;
    }

    .btn-main-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    /* Center align for the footer links */
    .main-signin-footer {
        text-align: center;
    }

    .login-btn {
        margin-top: 20px;
    }

    /* Styling for Facebook and Google Buttons */
    .btn-facebook {
        background-color: #4267B2 !important;
        border-color: #4267B2 !important;
        color: white !important;
    }

    .btn-google {
        background-color: #DB4437 !important;
        border-color: #DB4437 !important;
        color: white !important;
    }

    /* Responsiveness for mobile devices */
    @media (max-width: 768px) {
        .bg-primary-transparent {
            display: none;
        }
    }
</style>
@endsection

@section('content')

@section('custom-body3')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="ltr error-page1 main-body bg-light text-dark error-3">
    <div class="page">
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                    <div class="row wd-100p mx-auto text-center">
                        <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                            <div class="image-container">
                                <img src="{{ asset('img/logo2easy.png') }}"
                                    class="my-auto ht-xl-40p wd-md-60p wd-xl-40p mx-auto" alt="2easy logo">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The content half -->
                <div class="col-md-6 col-lg-6 col-xl-5 bg-white py-4">
                    <div class="login d-flex align-items-center py-2">
                        <!-- Login Form-->
                        <div class="container p-0">
                            <div class="row">
                                <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            {{-- <h2>2 Easy</h2> --}}
                                            <h5 class="fw-semibold mb-4">{{ __('Please sign in to continue.') }}</h5>
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif

                                            <!-- Language Selection Dropdown -->
                                            <div class="form-group">
                                                <label>{{ __('Select Language') }}</label>
                                                <select id="language-select" class="form-control" required>
                                                    <option value="en"
                                                        {{ session('my_locale') == 'en' ? 'selected' : '' }}>English
                                                    </option>
                                                    <option value="pt"
                                                        {{ session('my_locale') == 'pt' ? 'selected' : '' }}>Portuguese
                                                    </option>
                                                </select>
                                            </div>

                                            <!-- Login Form -->
                                            <form id="loginForm" method="POST" action="{{ route('auth.login') }}">
                                                @csrf
                                                <!-- Hidden Field for Preferred Language -->
                                                <input type="hidden" name="language" id="language"
                                                    value="{{ session('my_locale', 'en') }}">

                                                <div class="form-group">
                                                    <label>{{ __('Email') }}</label>
                                                    <input name="email" id="email" class="form-control"
                                                        placeholder="{{ __('Enter your email') }}" type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('Password') }}</label>
                                                    <input name="password" id="password" class="form-control"
                                                        placeholder="{{ __('Enter your password') }}" type="password">
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-main-primary btn-block login-btn">{{ __('Sign In') }}</button>
                                            </form>

                                            <!-- Facebook and Google Buttons -->
                                            <!-- <div class="row row-xs mt-3">
                                                    <div class="col-sm-6">
                                                        <a href="{{ route('auth.facebook.login') }}"
                                                            class="btn btn-facebook btn-block btn-b">
                                                            <i class="fab fa-facebook-f"></i>
                                                            {{ __('Signup with Facebook') }}
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="{{ route('auth.google.login') }}"
                                                            class="btn btn-google btn-block btn-b">
                                                            <i class="fab fa-google"></i> {{ __('Signup with Google') }}
                                                        </a>
                                                    </div>
                                                </div> -->

                                            {{-- <div class="main-signin-footer mt-5">
                                                <p><a href="{{ url('forgot') }}">{{ __('Forgot password?') }}</a></p>
                                            <p>{{ __("Don't have an account?") }} <a href="{{ url('signup') }}">{{ __('Create an Account') }}</a></p>
                                        </div> --}}



                                        <div class="main-signin-footer mt-5">
                                            <p class="text-white hover:text-black transition-colors duration-300">{{ __("Don't have an account?") }}</p>
                                            <a href="{{ route('agent.register') }}" class="btn btn-primary text-white hover:text-black transition-colors duration-300">I'm an Agent</a>
                                            <a href="{{ route('client.register') }}" class="btn btn-secondary text-white hover:text-black transition-colors duration-300">I'm a Client</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const languageSelect = document.getElementById('language-select');
        const languageInput = document.getElementById('language');

        // Update hidden language input when the language is selected
        languageSelect.addEventListener('change', function() {
            const selectedLanguage = this.value;
            languageInput.value = selectedLanguage;
            console.log('Language selected:', selectedLanguage);
        });
    });

    setTimeout(function() {
        let alertElements = document.querySelectorAll('.alert');
        alertElements.forEach(function(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(function() {
                alert.remove(); // Remove do DOM após o fade-out
            }, 300); // Tempo para o fade-out (300ms)
        });
    }, 5000); // 5000ms = 5 segundos
</script>

@endsection