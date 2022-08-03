@extends('layouts.main')
@section('viewContent')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title"> Oferta Educativa </h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                        onclick="location.href='{{ route('educativeoffer.create') }}'"> Nuevo Tipo de Servicio
                    </button>
                </div>
            </nav>
            <div class="row justify-content-center">
                @if (count($type_services) > 0)
                    @foreach ($type_services as $type_service)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3 class="text-primary">{{ $type_service->name }}</h3>
                                </div>
                                <div class="card-body preview-image">
                                <img src="{{ asset($type_service->url_image) }}" id="previewImage" class="img-fluid mr-3 mx-auto d-block">
                            </div>
                                <div class="card-body text-center">
                                    <p class="card-text">{{ $type_service->description }}</p>
                                </div>
                                <div class="card-footer p-0 text-center d-flex justify-content-center ">
                                    <div class="card-footer-item card-footer-item-bordered">
                                        <a href="{{ url('listOffer', $type_service->id) }}" class="card-link" data-toggle="tooltip" data-placement="top" title="Ver oferta"><i class="fa-solid fa-bars-staggered text-dark"></i></a>
                                    </div>
                                    <div class="card-footer-item card-footer-item-bordered">
                                        <a href="{{ route('educativeoffer.edit', $type_service->id) }}" class="card-link" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit text-primary"></i></a>
                                    </div>
                                    <div class="card-footer-item card-footer-item-bordered">
                                        <form action="{{ route('educativeoffer.destroy', $type_service->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-link btn-form" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminarlo?')">
                                                <i class="far fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning alert-danger fade show text-center col-10" role="alert">
                        Lo sentimos, no existe ningún registro.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
        </div>
    </div>
@endsection