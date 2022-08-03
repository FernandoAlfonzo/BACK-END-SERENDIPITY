@extends('layouts.main')
@section('viewContent')

<style>
    

</style>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Agregar Subcatálogo</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <form id="form" data-parsley-validate="" method="POST" enctype="multipart/form-data" action="{{ url('storeSubcatalog') }}" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Nombre</label>
                        <div class="col-9 col-lg-10">
                            <input id="label" name="label" type="text" required data-parsley-type="text" placeholder="Nombre" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Descripción</label>
                        <div class="col-9 col-lg-10">
                            <input id="description" name="description" type="text" required data-parsley-type="text" placeholder="Descripción" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código</label>
                        <div class="col-9 col-lg-10">
                            <input id="code" name="code" type="text" data-parsley-type="text" placeholder="Código" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código 2</label>
                        <div class="col-9 col-lg-10">
                            <input id="code2" name="code2" type="text" data-parsley-type="text" placeholder="Código 2" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código 3</label>
                        <div class="col-9 col-lg-10">
                            <input id="code3" name="code3" type="text" data-parsley-type="text" placeholder="Código 3" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-lg-2 col-form-label text-right">Contenido</div>
                        <div class="col-9 col-lg-10">
                        <textarea name="long_code" class="my-editor form-control" id="my-editor" cols="30" rows="10"></textarea>
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
                                        <input type="file" name="avatarInput" id="avatarInput">
                                    </div>
                                    <img src="https://i.ibb.co/0Jmshvb/no-image.png" class="image-preview" alt="preview image">
                                </div>

                            </div>
                    </div>
                    
                    <div>
                        <input id="code" name="id_cat_types" type="hidden" value="{{ $id_type->id }}" required>
                    </div>

                    <div class="row pt-2 pt-sm-5 mt-1">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Regresar</a>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <p class="text-right">
                                <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-space btn-primary">Agregar</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
 

CKEDITOR.replace('my-editor');
</script>

@endsection