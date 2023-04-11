@extends('adminlte::page')

@section('title', 'Panel de Administracion')

@section('content_header')
    <h1>Bienvenidos </h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.   {{ Auth::user()->full_name }}</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop