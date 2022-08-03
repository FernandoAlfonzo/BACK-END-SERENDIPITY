@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Agregar nuevo servicio</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <form id="validationform" action="{{ url('storeOffer') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                    @csrf
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input id="name" name="name" type="text" required placeholder="Nombre del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripción</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea id="description" name="description" placeholder="Descripción del servicio" required class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Categoría</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <select class="selectpicker show-tick show-menu-arrow form-control" name="category" data-header="Selecciona una opción">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Tipo</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <select class="selectpicker show-tick show-menu-arrow form-control" name="type" data-header="Selecciona una opción">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Módulos</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" required name="modules" placeholder="Módulos del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Tópicos</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" required name="topical" placeholder="Tópicos del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Duración del servicio</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0 date">
                            <input id="start_at" name="start_at" type="date" required class="form-control datetimepicker-input" data-toggle="tooltip" data-placement="top" title="Fecha de inicio">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input id="finish_at" name="finish_at" type="date" required class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha de finalización">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Código</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="code" required placeholder="Código del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Clave</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="long_code" required placeholder="Clave del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Precio</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input required type="number" name="min_cost" min="0" placeholder="Precio mínimo del servicio" class="form-control">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input required type="number" name="max_cost" min="0" placeholder="Precio máximo del servicio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Promociones</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" required name="promotion" placeholder="Promociones o descuentos" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Estatus</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="status" required placeholder="Type something" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Imagen</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="file" name="image" required="" class="form-control">
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