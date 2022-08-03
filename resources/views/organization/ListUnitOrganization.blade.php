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

@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('message')}}
        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
    </div>
@endif

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Unidades de Negocio </h2>
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
                        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('organizations.create') }}">Nueva Organización</a>
                    </div>
                </nav> 
                
                @if (count($organizations) > 0)
                    <div class="card-body">                        
                        <table class="table text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Logo</th>
                                    <th>Nombre comercial</th>
                                    <th>Razón social</th>
                                    <th>Unidades de Negocio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            @foreach ($organizations as $organization)
                                @if($organization->id_parent == 0)
                                    <tbody>
                                        <tr>
                                            <td>{{ $organization->id }}</td>
                                            <td>
                                                <div class="m-r-10"><img src="{{ asset($organization->url_logo) }}"class="user-avatar-lg rounded-circle" width="45"></div>
                                            </td>
                                            <td>{{ $organization->name_commercial }}</td>
                                            <td>{{ $organization->name_business }}</td>
                                            <td>
                                                <div class="dd-nodrag btn-group ml-auto">
                                                    <button class="btn btn-sm btn-outline-light" onclick="">
                                                        <i class="fas fa-th-list"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dd-nodrag btn-group ml-auto">
                                                    <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Editar" onclick="location.href='{{ route('organizations.edit',$organization->id) }}'">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <!--<form action="{{ route('catalog.destroy', $organization->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminarlo?')">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>  -->
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            @endforeach
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