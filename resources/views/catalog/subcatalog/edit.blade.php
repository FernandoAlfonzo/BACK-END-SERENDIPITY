@extends('layouts.main')
@section('viewContent')

<style>
    
.input-file-container {
	width: 300px;
}

.input-file {
	width: 265px;
	height: 38px;
	border: 1px solid #16858F;
	display: flex;
	flex-wrap: wrap;
	position: relative;
	border-radius: 8px;
	overflow: hidden;
}

#avatarInput {
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	opacity: 0;
}

.input-file__name {
	width: 83%;
	display: flex;
	align-items: center;
	font-size: 12px;
	padding: 0 15px ;
	margin: 0;
	color: #16858F;
}

.input-file__button {
	width: 17%;
	font-size: 2em;
	padding: 0;
	border: none;
	background-color: #10BAB9;
	color: #ffffff;
}

.image-preview { 
	width: 70%;
	display: block;
	margin: 20px auto 0;
	border-radius: 8px;
}
</style>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Actualizar Subcatálogo {{ $subcatalog['label'] }}</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <form id="form" data-parsley-validate="" method="POST" enctype="multipart/form-data" action="{{ url('updateSubcatalog', $subcatalog['id']) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Nombre</label>
                        <div class="col-9 col-lg-10">
                            <input id="label" name="label" type="text" value="{{ $subcatalog['label'] }}" required data-parsley-type="text" placeholder="Nombre" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Descripción</label>
                        <div class="col-9 col-lg-10">
                            <input id="description" name="description" type="text" value="{{ $subcatalog['description'] }}" required data-parsley-type="text" placeholder="Descripción" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código</label>
                        <div class="col-9 col-lg-10">
                            <input id="code" name="code" type="text" value="{{ $subcatalog['code'] }}" data-parsley-type="text" placeholder="Código" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código 2</label>
                        <div class="col-9 col-lg-10">
                            <input id="code2" name="code2" type="text" value="{{ $subcatalog['code2'] }}" data-parsley-type="text" placeholder="Código 2" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código 3</label>
                        <div class="col-9 col-lg-10">
                            <input id="code3" name="code3" type="text" value="{{ $subcatalog['code3'] }}" data-parsley-type="text" placeholder="Código 3" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-lg-2 col-form-label text-right">Contenido</div>
                        <div class="col-9 col-lg-10">
                        <textarea name="long_code" class="my-editor form-control" id="long_code" cols="30" rows="10">{{ $subcatalog['long_code'] }}</textarea>
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
                                        <input type="file" name="avatarInput" value="{{ $subcatalog['url_imagen'] }}" id="avatarInput">
                                    </div>
                                    <img src="{{ asset($subcatalog['url_imagen']) }}" class="image-preview" alt="preview image">
                                </div>

                            </div>
                    </div>
                    <div class="row pt-2 pt-sm-5 mt-1">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Regresar</a>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <p class="text-right">
                                <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-space btn-primary">Actualizar</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const avatarInput = document.querySelector('#avatarInput');
    const avatarName = document.querySelector('.input-file__name');
    const imagePreview = document.querySelector('.image-preview');

avatarInput.addEventListener('change', e => {
	let input = e.currentTarget;
	let fileName = input.files[0].name;
	avatarName.innerText = `File: ${fileName}`;

	const fileReader = new FileReader();
	fileReader.addEventListener('load', e => {
		let imageData = e.target.result;
		imagePreview.setAttribute('src', imageData);
	})

	fileReader.readAsDataURL(input.files[0]);
});

CKEDITOR.replace('long_code');
</script>
@endsection