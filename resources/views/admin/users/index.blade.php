@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h1>Lista de usuarios</h1>
@endsection

@section('content')
@if (session('success-create'))
<div class="alert alert-success d-flex align-items-center" role="alert"">

{{session('success-create')}}
        </div>
@elseif (session('success-update'))
<div class="alert alert-success d-flex align-items-center" role="alert"">

{{session('success-update')}}
        </div>
@elseif (session('success-delete'))
        <div class="alert alert-success d-flex align-items-center" role="alert"">

        {{session('success-delete')}}
                </div>
@endif
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre completo</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user )


                <tr>
                    <th>{{$user->id}}</th>
                    <th>{{$user->full_name}}</th>
                    <td>{{$user->email}}</td>


                    <td width="10px"><a href="{{route('users.edit',$user)}}"
                            class="btn btn-primary btn-sm mb-2">Editar</a>
                    </td>

                    <td width="10px">
                        <form action="{{route('users.destroy',$user)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-3">
        {{$users->links()}}
        </div>

    </div>
</div>
@endsection



