@extends('layout.main')

@section('title', 'Gestão Financeira')

@section('content')
        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession
        <div id="form-index">
            <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="email" value="{{ __('Email') }}">E-mail:</label>
                <input type="text" name="email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password" value="{{ __('Password') }}">Senha:</label>
                <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="block mt-4" id="help-register">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
            
                    @if (Route::has('password.request'))
                        <p>
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        </p>
                    @endif
            </div>
            <input type="submit" class="btn btn-primary" value="Entre">
            </form>
                <div id="help-register">
                    <p>ou</p>
                    <p><a href="http:/register" id="link-register">Cadastre-se</a></p>
                </div>
        </div>
@endsection