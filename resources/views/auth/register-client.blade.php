<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('labels.registerClient')</title>

    <!-- Links de CSS, Bootstrap, etc. -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        /* Estilos personalizados */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.5rem;
            text-align: center;
            padding: 1rem;
        }

        .form-group label {
            font-weight: bold;
            color: #495057;
        }

        .form-control {
            border-radius: 4px;
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            margin-top: 20px;
        }

        .container {
            max-width: 600px;
        }

        /* Melhorar visualização em telas pequenas */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
              @lang('labels.registerClient')
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('client.register.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">@lang('labels.name')</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required>
                        <small id="name-error" class="text-danger"></small> 
                    </div>

                    <div class="form-group">
                        <label for="email">@lang('labels.email')</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required>
                                <small id="email-error" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="password">@lang('labels.password')</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                            <small id="password-error" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">@lang('labels.confirmPassword')</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                                <small id="password-error2" class="text-danger"></small>
                    </div>

                     <!-- Código do Agente (Opcional) -->
                            <div class="form-group">
                                <label for="agent_code">@lang('labels.agentCode')</label>
                                <input type="text" name="agent_code" class="form-control" id="agent_code"
                                    value="{{ request()->get('agent_code') }}" {{ request()->get('agent_code') ? 'readonly' : '' }}>
                            </div>

                    <!-- Hidden input to send is_admin = 0 -->
                    <input type="hidden" name="is_admin" value="0">

                    <button type="submit" class="btn btn-primary">@lang('labels.cadastrar')</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //validacao do campo nome
        const nameField = document.getElementById('name');
        nameField.addEventListener('input', function () {
            const nameError = document.getElementById('name-error');
            if (nameField.value.length < 3) {
                nameError.textContent = '@lang('labels.atLeast')';
            } else {
                nameError.textContent = '';
            }
        });

        // Validação do campo de e-mail
        const emailField = document.getElementById('email');
        emailField.addEventListener('input', function () {
            const emailError = document.getElementById('email-error');
            if (!emailField.value.includes('@')) {
                emailError.textContent = '@lang('labels.validEmail')';
            } else {
                emailError.textContent = '';
            }
        });

        // Validação do campo de senha
        const passwordField = document.getElementById('password');
        passwordField.addEventListener('input', function () {
            const passwordError = document.getElementById('password-error');
            if (passwordField.value.length < 8) {
                passwordError.textContent = '@lang('labels.passwordLength').';
            } else {
                passwordError.textContent = '';
            }
        });
        const passwordField2 = document.getElementById('password_confirmation');
        passwordField2.addEventListener('input', function () {
            const passwordError = document.getElementById('password-error2');
            if (passwordField2.value.length < 8) {
                passwordError.textContent = '@lang('labels.passwordLength').';
            } else {
                passwordError.textContent = '';
            }
        });
    });
</script>

