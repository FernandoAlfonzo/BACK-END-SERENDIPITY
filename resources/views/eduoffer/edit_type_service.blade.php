@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Editar tipo de servicio | {{ $type_service->name }}</h2>
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

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <form id="validationform" action="{{ route('educativeoffer.update', $type_service->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input id="name" name="name" type="text" required value="{{ $type_service->name }}" placeholder="Nombre del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripción</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea id="description" name="description" placeholder="Descripción del servicio" required class="form-control">{{ $type_service->description }}</textarea>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Duración del servicio</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0 date">
                            <input id="start_at" name="start_at" type="date" required class="form-control datetimepicker-input" data-toggle="tooltip" data-placement="top" title="Fecha de inicio">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input id="finish_at" name="finish_at" type="date" required class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha de finalización">
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Código</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="code" value="{{ $type_service->code }}" required placeholder="Código del servicio" class="form-control">
                        </div>
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
                                <img src="{{ asset($type_service->url_image) }}" id="previewImage" class="img-fluid mr-3 mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Editar</button>
                            <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection