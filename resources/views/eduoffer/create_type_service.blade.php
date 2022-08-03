@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Agregar nuevo tipo de servicio </h2>
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
                <form id="validationform" action="{{ route('educativeoffer.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                    @csrf
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input id="name" name="name" type="text" required placeholder="Nombre del servicio" required class="form-control @error('name') is-invalid @enderror">
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripción</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea id="description" name="description" placeholder="Descripción del servicio" required class="form-control @error('description') is-invalid @enderror"></textarea>
                        </div>
                        @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Código</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="code" required placeholder="Código del servicio" class="form-control @error('code') is-invalid @enderror">
                        </div>
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Imagen</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="file" name="url_image" id="selectImage" accept="image/jpeg,image/png" class="form-control @error('url_image') is-invalid @enderror">
                        </div>
                        @error('url_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            {{-- <h5 class="card-header text-center text-muted">Previsualización</h5> --}}
                            <div class="card-body preview-image">
                                <img src="https://i.ibb.co/0Jmshvb/no-image.png" id="previewImage" class="img-fluid mr-3 mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Agregar</button>
                            <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection