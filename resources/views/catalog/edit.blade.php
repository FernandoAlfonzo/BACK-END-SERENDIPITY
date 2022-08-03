@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Actualizar Catálogo {{ $type['label'] }}</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <form id="form" data-parsley-validate="" method="POST" action="{{ route('catalog.update', $type['id']) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Nombre</label>
                        <div class="col-9 col-lg-10">
                            <input id="label" name="label" type="text" value="{{ $type['label'] }}" required data-parsley-type="text" placeholder="Nombre" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Descripción</label>
                        <div class="col-9 col-lg-10">
                            <input id="description" name="description" type="text" value="{{ $type['description'] }}" required data-parsley-type="text" placeholder="Descripción" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Código</label>
                        <div class="col-9 col-lg-10">
                            <input id="code" name="code" type="text" value="{{ $type['code'] }}" required data-parsley-type="text" placeholder="Descripción" class="form-control">
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
@endsection