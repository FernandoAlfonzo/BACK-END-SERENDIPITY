@extends('layouts.main')
@section('viewContent')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Ventas (Pagos)</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <nav class="navbar navbar-expand-lg card-header">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        {{-- <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <form class="form-inline my-2 my-lg-0">
                                    <input name="search" class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar...">
                                </form>
                            </li>
                        </ul> --}}
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" 
                            onclick="location.href='{{ route('sales.create') }}'">Nueva ventas
                        </button>
                    </div>
                </nav>
                
                @if (false)
                    <div class="card-body">                        
                        <table class="table text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <!--@foreach ($roles as $role)
                                <tbody>
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>
                                            <div class="dd-nodrag btn-group ml-auto">
                                                <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Permisos" onclick="location.href='{{ url('ModulePermission',$role->id) }}'">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Editar" onclick="location.href='{{ route('role.edit',$role->id) }}'">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                                <form action="{{ route('role.destroy', $role->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminarlo?')">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>  
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            @endforeach-->
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                        Lo sentimos, no existe ningún registro.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection