@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Agregar Organización</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <form id="form" data-parsley-validate="" method="POST" enctype="multipart/form-data" action="{{ route('organizations.update', $organization['id']) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Nombre comercial</label>
                        <div class="col-9 col-lg-10">
                            <input id="name_commercial" name="name_commercial" type="text" value="{{ $organization['name_commercial'] }}" required data-parsley-type="text" placeholder="Nombre comercial" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Razón social</label>
                        <div class="col-9 col-lg-10">
                            <input id="name_business" name="name_business" value="{{ $organization['name_business'] }}" type="text" required data-parsley-type="text" placeholder="Razón social" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Direccón</label>
                        <div class="col-9 col-lg-10">
                            <input id="address" name="address" type="text" value="{{ $organization['address'] }}" required data-parsley-type="text" placeholder="Direccón" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">RFC</label>
                        <div class="col-9 col-lg-10">
                            <input id="RFC" name="RFC" type="text" value="{{ $organization['address'] }}" required data-parsley-type="text" placeholder="RFC" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Teléfono</label>
                        <div class="col-3 col-lg-4">
                            <input id="phone" name="phone" type="tel" value="{{ $organization['phone'] }}" required data-parsley-type="text" placeholder="Teléfono" class="form-control">
                        </div>

                        <label class="col-3 col-lg-2 col-form-label text-right">Correo</label>
                        <div class="col-3 col-lg-4">
                            <input id="email" name="email" type="email" value="{{ $organization['email'] }}" required data-parsley-type="text" placeholder="Correo" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Redes Sociales</label>
                        <div class="col-9 col-lg-10">
                            <textarea name="social_networks" id="social_networks" value="{{ $organization['social_networks'] }}" rows="5" cols="10" placeholder="Redes Sociales" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="formFileMultiple" class="form-label col-3 col-lg-2 col-form-label text-right">Imagen</label>
                            <div class="col-9 col-lg-10">
                                <div class="input-file-container">
                                    <div class="input-file">
                                        <p class="input-file__name">Seleccionar imagen</p>
                                        <button type="button" class="input-file__button">
                                        <i class="fas fa-upload"></i>
                                        </button>
                                        <input type="file" name="avatarInput" value="{{ $organization['url_logo'] }}" id="avatarInput">
                                    </div>
                                    <img src="{{ asset($organization['url_logo']) }}" class="image-preview" alt="preview image">
                                </div>

                            </div>
                    </div>

                    <div class="row pt-2 pt-sm-5 mt-1">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <a href="{{ route('organizations.index') }}"><i class="fas fa-arrow-left"></i> Regresar</a>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <p class="text-right">
                                <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection