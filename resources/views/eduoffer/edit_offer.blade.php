@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Editar {{-- {{ $type_service->name }} de --}} {{ $service->name }} </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <h5>
                                <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Regresar</a>
                            </h5>
                        </div>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <form id="editOffer" action="{{ url('updateOffer', $service->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" {{-- novalidate="" --}}>
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input id="name" name="name" type="text" placeholder="Nombre del servicio" value="{{ $service->name }}" class="form-control @error('name') is-invalid @enderror">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripción</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea id="description" name="description" placeholder="Descripción del servicio" class="form-control @error('description') is-invalid @enderror">{{ $service->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Categoría</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select class="selectpicker show-tick show-menu-arrow form-control @error('category') is-invalid @enderror" name="category" data-header="Selecciona una opción">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                            <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Duración</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input required type="number" name="duration_time" min="1" value="{{ $service->duration_time }}" placeholder="Cantidad de tiempo que durara el servicio" class="form-control">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <select class="selectpicker show-tick show-menu-arrow form-control @error('duration_type') is-invalid @enderror" name="duration_type" data-header="Selecciona una opción">
                                {{-- <option hidden selected></option> --}}
                                @foreach ($duration_types as $duration_type)
                                    <option value="{{ $duration_type->id }}">{{ $duration_type->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- <div>
                        <input id="id_type" name="id_type" type="hidden" value="{{ $type_service->id }}" required>
                    </div> --}}

                    {{-- <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Código</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="code" required placeholder="Código del servicio" class="form-control">
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Clave</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input type="text" name="long_code" placeholder="Clave del servicio" value="{{ $service->long_code }}" class="form-control @error('long_code') is-invalid @enderror">
                        </div>
                        @error('long_code')
                            <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Precio <i class="fas fa-dollar-sign"></i></label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input required type="number" name="min_cost" min="0" placeholder="Precio mínimo del servicio" value="{{ $service->min_cost }}" class="form-control">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input required type="number" name="max_cost" min="0" placeholder="Precio máximo del servicio" value="{{ $service->max_cost }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Estatus</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select class="selectpicker show-tick show-menu-arrow form-control @error('status') is-invalid @enderror" name="status" data-header="Selecciona una opción">
                                {{-- <option hidden selected>Categoría</option> --}}
                                @foreach ($list_status as $status)
                                <option value="{{ $status->id }}">{{ $status->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Imagen</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="file" name="url_image" id="selectImage" accept="image/jpeg,image/png" class="form-control @error('url_image') is-invalid @enderror">
                        </div>
                        @error('url_image')
                            <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                        <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            {{-- <h5 class="card-header text-center text-muted">Previsualización</h5> --}}
                            <div class="card-body preview-image">
                                <img src="{{ asset($service->url_image) }}" id="previewImage" class="img-fluid mr-3 mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection