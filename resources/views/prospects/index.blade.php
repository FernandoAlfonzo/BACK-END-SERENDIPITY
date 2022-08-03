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
            <h2 class="pageheader-title"> Prospectos </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{Session::get('message')}}
            <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
        </div>
@endif

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                {{-- <nav class="navbar navbar-expand-lg card-header">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <form class="form-inline my-2 my-lg-0">
                                    <input name="search" class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar...">
                                </form>
                            </li>
                        </ul>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" 
                            onclick="location.href='{{ route('prospects.create') }}'"> Nuevo Prospectos
                        </button>
                    </div>
                </nav> --}}

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light text-center">
                                    <tr class="border-0">
                                        <th class="border-0">ID</th>
                                        <th class="border-0">Matrícula</th>
                                        <th class="border-0">Nombre</th>
                                        <th class="border-0">Apellidos</th>
                                        <th class="border-0">Acciones</th>
                                    </tr>
                                </thead>
                                @foreach ($prospecs as $prospec)
                                    <tbody class="text-center">
                                            <tr>
                                                <td>{{$prospec->id}}</td>
                                                <td>{{$prospec->enrollment}}</td>
                                                <td>{{$prospec->name}}</td>
                                                <td>{{$prospec->lastFName}} {{$prospec->lastMName}}</td>
                                                <td>
                                                    <div class="dd-nodrag btn-group ml-auto">
                                                        
                                                        <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Editar" onclick="location.href=''">
                                                            <i class="far fa-edit text-primary"></i>
                                                        </button>
                                                        <form action="" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminarlo?')">
                                                                <i class="far fa-trash-alt text-danger"></i>
                                                            </button>
                                                        </form>  
                                                    </div>
                                                </td>
                                            </tr>
                                    </tbody>                                        
                                    @endforeach
                            </table>
                        </div>
                    </div>
                
                    {{-- <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                        Lo sentimos, no existe ningún registro.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> --}}
                
            </div>
        </div>
    </div>
</div>


@endsection

