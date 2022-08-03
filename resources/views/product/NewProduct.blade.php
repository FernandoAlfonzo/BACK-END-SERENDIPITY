@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Agregar Regla de pago</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <form id="form" data-parsley-validate="" method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Nombre</label>
                        <div class="col-9 col-lg-10">
                            <input id="name" name="name" type="text" required data-parsley-type="text" placeholder="Nombre" class="form-control">
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
                        <div class="col-3 col-lg-4">
                            <input id="code" name="code" type="text" required data-parsley-type="text" placeholder="Código" class="form-control">
                        </div>
                        <label class="col-3 col-lg-2 col-form-label text-right">Monto de inscripción</label>
                        <div class="col-3 col-lg-4">
                            <input id="registration_amount" name="registration_amount" type="number" required data-parsley-type="text" placeholder="Descripción" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-lg-2 col-form-label text-right">Plazo</label>
                        <div class="col-4 col-lg-4">
                            <input id="period" name="period" type="text" required data-parsley-type="text" placeholder="Plazo" class="form-control">
                        </div>
                        <label class="col-3 col-lg-2 col-form-label text-right"></label>
                        <div class="col-4 col-lg-4">
                            <select id="periodicity" name="periodicity" class="selectpicker show-tick show-menu-arrow form-control">
                                <option value="" selected>Selecciona una opción</option>
                                @foreach($plazos as $item)
                                    <option value="{{ $item->id }}">{{ $item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Tipo</label>
                        <div class="col-3 col-lg-4">
                            <select id="periodicity" name="type" class="selectpicker show-tick show-menu-arrow form-control">
                                <option value="" selected>Selecciona una opción</option>
                                @foreach($types as $item)
                                    <option value="{{ $item->id }}">{{ $item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-3 col-lg-2 col-form-label text-right">Frecuencia</label>
                        <div class="col-3 col-lg-4">
                            <select id="periodicity" name="frequency" class="selectpicker show-tick show-menu-arrow form-control">
                                <option value="" selected>Selecciona una opción</option>
                                @foreach($frequencys as $item)
                                    <option value="{{ $item->id }}">{{ $item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-lg-2 col-form-label text-right">Requerido</label>
                        <div class="col-2 col-lg-2">
                            <div class="switch-button switch-button-success">
                                <input type="checkbox" checked="" name="check-require" id="check-require"><span>
                                <label for="check-require"></label></span>
                            </div>
                        </div>
                        <label class="col-2 col-lg-2 col-form-label text-right">Descuento</label>
                        <div class="col-2 col-lg-2">
                            <div class="switch-button switch-button-success">
                                <input type="checkbox" checked="" name="check-discount" id="check-discount"><span>
                                <label for="check-discount"></label></span>
                            </div>
                        </div>
                        <label class="col-2 col-lg-2 col-form-label text-right">Incluido</label>
                        <div class="col-2 col-lg-2">
                            <div class="switch-button switch-button-success">
                                <input type="checkbox" checked="" name="check-included" id="check-included"><span>
                                <label for="check-included"></label></span>
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
                                <button type="submit" class="btn btn-space btn-primary">Agregar</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection