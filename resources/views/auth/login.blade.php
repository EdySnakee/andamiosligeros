@extends('layouts.app_redes_login')

@section('css')
    <style>
        /* ========================================================
           ESTILOS GENERALES Y FONDO DE LA PÁGINA DE LOGIN
           ======================================================== */
        .login-page-body {
            background-color: #001229;
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(14, 51, 132, 0.6) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(255, 187, 1, 0.12) 0%, transparent 45%),
                linear-gradient(135deg, #07152b 0%, #001f47 50%, #001229 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-main-wrapper {
            width: 100%;
            padding: 2.5rem 1rem;
        }

        /* ========================================================
           TARJETA PRINCIPAL DEL LOGIN
           ======================================================== */
        .modern-login-card {
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px -15px rgba(0, 15, 45, 0.55), 0 0 2px rgba(255, 255, 255, 0.12);
            background: #ffffff;
            transition: box-shadow 0.3s ease;
        }

        /* ========================================================
           COLUMNA IZQUIERDA: IMAGEN DEL PERRITO (SB-ADMIN 2 CLASSIC)
           ======================================================== */
        .login-dog-image-col {
            width: 100%;
            height: 100%;
            min-height: 560px;
            background-image: url('{{ asset("script/img/dog-login.jpg") }}'), url('https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?auto=format&fit=crop&w=700&h=900&q=80');
            background-size: cover;
            background-position: center center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 32px 30px;
        }

        .dog-overlay-gradient {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0, 31, 71, 0.2) 0%, rgba(0, 23, 56, 0.82) 100%);
            pointer-events: none;
        }

        .dog-top-badge {
            position: relative;
            z-index: 2;
        }

        .badge-portal {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.6px;
            padding: 6px 14px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .dog-bottom-content {
            position: relative;
            z-index: 2;
            color: #ffffff;
        }

        .dog-brand-subtitle {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #ffbb01;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .dog-brand-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 6px;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }


        /* ========================================================
           COLUMNA DERECHA: FORMULARIO MODERNO
           ======================================================== */
        .login-form-wrapper {
            padding: 42px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100%;
        }

        .login-logo-img {
            max-width: 210px;
            height: auto;
            margin-bottom: 16px;
            transition: transform 0.25s ease;
        }

        .login-logo-img:hover {
            transform: scale(1.02);
        }

        .login-heading {
            font-family: 'Montserrat', sans-serif;
            font-size: 23px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .login-subtext {
            font-size: 13.5px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .form-label-custom {
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .input-with-icon {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s ease;
            z-index: 2;
        }

        .form-control-modern {
            height: 48px;
            border-radius: 12px;
            border: 1.5px solid #cbd5e1;
            padding-left: 44px;
            padding-right: 44px;
            font-size: 14px;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.25s ease;
            box-shadow: none;
        }

        .form-control-modern:focus {
            border-color: #002f6c;
            background-color: #ffffff;
            box-shadow: 0 0 0 3.5px rgba(0, 47, 108, 0.12);
            color: #0f172a;
        }

        .input-with-icon:focus-within .field-icon {
            color: #002f6c;
        }

        .btn-toggle-pass {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent !important;
            border: none !important;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer !important;
            padding: 8px 10px;
            line-height: 1;
            transition: color 0.2s ease;
            z-index: 25 !important;
            pointer-events: auto !important;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: none !important;
        }

        .btn-toggle-pass:hover,
        .btn-toggle-pass:focus,
        .btn-toggle-pass:active {
            color: #002f6c;
            outline: none !important;
            box-shadow: none !important;
        }

        /* TOGGLE RECORDAR SESIÓN */
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            margin-bottom: 0;
        }

        .remember-switch input {
            position: absolute;
            inset: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            margin: 0;
            z-index: 2;
        }

        .remember-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #cbd5e1;
            border-radius: 50px;
            transition: background-color .25s ease;
        }

        .remember-slider:before {
            content: "";
            position: absolute;
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            border-radius: 50%;
            transition: transform .25s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .2);
        }

        .remember-switch input:checked + .remember-slider {
            background-color: #002f6c;
        }

        .remember-switch input:checked + .remember-slider:before {
            transform: translateX(20px);
        }

        .remember-text {
            font-size: 13.5px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        /* BOTÓN DE ACCESO */
        .btn-login-submit {
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #002f6c 0%, #0e3384 100%);
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.3px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(0, 47, 108, 0.3);
            cursor: pointer;
        }

        .btn-login-submit:hover {
            background: linear-gradient(135deg, #00224d 0%, #002f6c 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(0, 47, 108, 0.4);
        }

        .btn-login-submit:active {
            transform: translateY(0);
        }

        .icon-arrow {
            transition: transform 0.2s ease;
        }

        .btn-login-submit:hover .icon-arrow {
            transform: translateX(4px);
        }

        .login-footer-info {
            color: #94a3b8;
            font-size: 12px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Responsividad */
        @media (max-width: 576px) {
            .login-form-wrapper {
                padding: 30px 22px;
            }
            .login-logo-img {
                max-width: 180px;
            }
            .login-heading {
                font-size: 20px;
            }
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-11 col-md-12">
                <div class="card modern-login-card my-3">
                    <div class="row no-gutters">
                        
                        {{-- COLUMNA IZQUIERDA: IMAGEN DEL PERRITO (CONSERVADA Y MEJORADA VISUALMENTE) --}}
                        <div class="col-lg-6 d-none d-lg-block position-relative">
                            <div class="login-dog-image-col">
                                <div class="dog-overlay-gradient"></div>
                                
                                {{-- BADGE SUPERIOR --}}
                                <div class="dog-top-badge">
                                    <span class="badge-portal">
                                        <i class="fas fa-shield-alt mr-1"></i> Panel de Control
                                    </span>
                                </div>

                                {{-- TARJETA DE TEXTO INFERIOR --}}
                                <div class="dog-bottom-content">
                                    <div class="dog-brand-subtitle">SISTEMA INTEGRAL</div>
                                    <h2 class="dog-brand-title">Andamios Ligeros</h2>
                                </div>
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA: FORMULARIO MODERNO --}}
                        <div class="col-lg-6">
                            <div class="login-form-wrapper">
                                
                                {{-- LOGO Y ENCABEZADO --}}
                                <div class="text-center mb-3">
                                    <a href="{{ url('/') }}" title="Ir al sitio web de Andamios Ligeros">
                                        <img class="login-logo-img" src="{{ url('web/img/logo-andamios-merida.webp') }}" alt="Andamios Ligeros">
                                    </a>
                                    <h1 class="login-heading">¡Bienvenido de nuevo!</h1>
                                    <p class="login-subtext">Ingresa tus credenciales para acceder al sistema</p>
                                </div>

                                {{-- FORMULARIO DE ACCESO --}}
                                <form class="user login-form" role="form" method="POST" action="{{ url('/login') }}" id="loginForm">
                                    {{ csrf_field() }}

                                    {{-- CAMPO EMAIL --}}
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label-custom">Correo Electrónico</label>
                                        <div class="input-with-icon">
                                            <span class="field-icon"><i class="fas fa-envelope"></i></span>
                                            <input type="email" 
                                                   class="form-control form-control-modern {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                                   name="email" 
                                                   id="email" 
                                                   aria-describedby="emailHelp" 
                                                   value="{{ old('email') }}" 
                                                   placeholder="correo@andamiosligeros.com" 
                                                   required 
                                                   autofocus>
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback d-block mt-1">
                                                <i class="fas fa-exclamation-circle mr-1"></i> <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- CAMPO PASSWORD CON TOGGLE --}}
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label-custom">Contraseña</label>
                                        <div class="input-with-icon">
                                            <span class="field-icon"><i class="fas fa-lock"></i></span>
                                            <input type="password" 
                                                   class="form-control form-control-modern {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                                                   name="password" 
                                                   id="password" 
                                                   placeholder="••••••••••••" 
                                                   required>
                                            <button type="button" class="btn-toggle-pass" id="btnTogglePassword" onclick="togglePassword(event)" title="Mostrar u ocultar contraseña" aria-label="Mostrar u ocultar contraseña">
                                                <i class="fas fa-eye" id="iconTogglePassword" style="pointer-events: none;"></i>
                                            </button>
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback d-block mt-1">
                                                <i class="fas fa-exclamation-circle mr-1"></i> <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- RECORDAR SESIÓN SWITCH --}}
                                    <div class="form-group d-flex align-items-center justify-content-between mb-4 pt-1">
                                        <div class="remember-wrap">
                                            <label class="remember-switch">
                                                <input type="hidden" name="remember" value="0">
                                                <input type="checkbox" name="remember" id="rememberCheck" value="1" {{ old('remember') ? 'checked' : '' }}>
                                                <span class="remember-slider"></span>
                                            </label>
                                            <label for="rememberCheck" class="remember-text mb-0 cursor-pointer">Recordar sesión</label>
                                        </div>
                                    </div>

                                    {{-- BOTÓN SUBMIT --}}
                                    <button type="submit" class="btn btn-login-submit btn-block" id="btnSubmitLogin">
                                        <span>Ingresar al Panel</span>
                                        <i class="fas fa-arrow-right ml-2 icon-arrow"></i>
                                    </button>
                                </form>

                                {{-- PIE DE PÁGINA --}}
                                <div class="login-footer-info text-center mt-4 pt-2">
                                    <small>© {{ date('Y') }} Andamios Ligeros • Todos los derechos reservados</small>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            var pass = document.getElementById('password');
            var icon = document.getElementById('iconTogglePassword');
            if (!pass) return;

            if (pass.type === 'password') {
                pass.type = 'text';
                if (icon) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            } else {
                pass.type = 'password';
                if (icon) {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        }
    </script>
@endsection

@section('js')
    <script>
        function togglePassword(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            var pass = document.getElementById('password');
            var icon = document.getElementById('iconTogglePassword');
            if (!pass) return;

            if (pass.type === 'password') {
                pass.type = 'text';
                if (icon) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            } else {
                pass.type = 'password';
                if (icon) {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        }

        $(document).ready(function() {
            // Event listener secundario por delegación
            $(document).on('click', '#btnTogglePassword', function(e) {
                togglePassword(e);
            });

            // Feedback visual en el botón de submit
            $('#loginForm').on('submit', function() {
                var $btn = $('#btnSubmitLogin');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Verificando...');
            });
        });
    </script>
@endsection
