@extends('layouts.app_redes_login')


@section('content')
    <style>
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
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
            background-color: #d1d5db;
            border-radius: 50px;
            transition: .3s ease;
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
            transition: .3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .2);
        }

        .remember-switch input:checked+.remember-slider {
            background-color: #1E4587;
            /* azul corporativo */
        }

        .remember-switch input:checked+.remember-slider:before {
            transform: translateX(22px);
        }

        .remember-text {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }
    </style>


    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <img width="250px" src="{{ url('web/img/logo-andamios-merida.webp') }}"
                                        alt=""><br><br>
                                    <h1 class="h4 text-gray-900 mb-4">Bienvenido!</h1>
                                </div>
                                <form class="user" role="form" method="POST" action="{{ url('/login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" class="form-control form-control-user" name="email"
                                            id="email" aria-describedby="emailHelp" value="{{ old('email') }}"
                                            placeholder="Escribe tu correo electrónico">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input type="password" class="form-control form-control-user" name="password"
                                            id="password" placeholder="Contraseña">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group remember-wrap">
                                        <label class="remember-switch">
                                            <input type="hidden" name="remember" value="0">
                                            <input type="checkbox" name="remember" id="rememberCheck" value="1"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <span class="remember-slider"></span>
                                        </label>
                                        <span class="remember-text">Recordar sesión</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <div class="text-center">
                                </div>
                                <div class="text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
