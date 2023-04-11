@extends('layouts.base')
@section('styles')
<link href="{{asset('css/login/css/login.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('title','Ingresar')
@section('content')
    

<img class="logo2" src="{{asset('img/logo2.png')}}" alt="Logo">
<form method="POST" class="form" action="{{route('login')}}">
    @csrf

    <div class="content-login">
        <div class="input-content">
            <input type="text" name="email" placeholder="Correo eléctronico" value="{{old('email')}}" autofocus>
            @error('email')
            <span class="text-danger">
                <span>{{$message}}</span>
            </span>
            @enderror

        </div>

        <div class="input-content">
            <input type="password" name="password" placeholder="Contraseña" value="">

            @error('password')
            <span class="text-danger">
                <span>{{$message}}</span>
            </span>
            @enderror

        </div>
    </div>

    <a href="{{route('password.request')}}" class="password-reset">Olvidé mi contraseña</a>

    <input type="submit" value="Iniciar sesión" class="button">
</form>

<p>¿No tienes una cuenta? <a href="{{route('register')}}" class="link">Crear cuenta</a></p>

@endsection