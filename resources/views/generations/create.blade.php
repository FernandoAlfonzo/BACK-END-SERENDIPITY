<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

@extends('layouts.main')
@section('viewContent')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/select2_multiple/select2multi.min.css') }}">
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Nueva Generación de {{ $service->name }} </h2>
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

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="tab-regular">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">Datos generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rules-tab" data-toggle="tab" href="#rules" role="tab" aria-controls="rules" aria-selected="false">Reglas de pago</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Vendedores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="modules-tab" data-toggle="tab" href="#modules" role="tab" aria-controls="modules" aria-selected="false">Módulos y Docentes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profiles-tab" data-toggle="tab" href="#profiles" role="tab" aria-controls="modules" aria-selected="false">Profesión</a>
            </li>
        </ul>
        <form id="validationform" action="{{ route('generations.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <input type="hidden" value="{{ $service->id }}" name="id_service">
                    
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="name" placeholder="Nombre de la generación" class="form-control @error('discount') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Descripción</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea name="description" placeholder="Descripción de la generación" class="form-control @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Código</label>
                        <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0">
                            <input type="text" name="code" placeholder="Código de la generación" class="form-control @error('discount') is-invalid @enderror">
                        </div>

                        <label class="ol-sm-4 col-lg-2 mb-3 mb-sm-0 col-form-label text-sm-right">Clave</label>
                        <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0">
                            <input type="text" name="long_code" placeholder="Clave de la generación" class="form-control @error('discount') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Plataforma</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-1">
                            <select class="form-control" name="selectPlatform" id="selectPlatform">
                                <option value="">Selecciona una opción</option>
                                @foreach ($plataformas as $item)
                                <option value="{{$item->label}}">{{$item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                        <a onclick="otherPlatform()" style="cursor: pointer;">+ Otra plataforma</a>
                    </div>

                  
                    <div id="divOtherPlatform" class="form-group row" >
                        <label class="col-6 col-sm-3 col-form-label text-sm-right">Otra Plataforma</label>
                        <div class="col-6 col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input id="add_platform" type="text" name="add_platform" class="form-control" placeholder="Agregue un link de la plataforma">
                        </div>
                        <a onclick="CancelOtherPlatform()" style="cursor: pointer;">Cancelar</a>
                    </div>


                    <div id="divOtherPlatform" class="form-group row" >
                        <label class="col-6 col-sm-3 col-form-label text-sm-right">Descuento</label>
                        <div class="col-6 col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input id="discount" type="number" value="0" name="discount" class="form-control">
                        </div>
                    </div>

                    <input type="hidden" value="{{ $service->duration_time }}" name="duration_time" id="duration_time">

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Duración</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input id="start_at" name="start_at" type="date" class="form-control datetimepicker-input @error('start_at') is-invalid @enderror" 
                                data-toggle="tooltip" data-placement="top" title="Fecha de incio" onchange="getDates()">
                            @error('start_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input id="finish_at" name="finish_at" type="date" class="form-control datetimepicker-input @error('finish_at') is-invalid @enderror" 
                                data-toggle="tooltip" data-placement="top" title="Fecha de finalización">
                            @error('finish_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Estatus</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select class="selectpicker show-tick show-menu-arrow form-control @error('category') is-invalid @enderror" name="status" data-header="Selecciona una opción">
                                {{-- <option hidden selected>Categoría</option> --}}
                                {{-- @foreach ($categories as $category)
                                
                                @endforeach --}}
                                <option value="no publicado">No publicado</option>
                            </select>
                        </div>
                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="rules" role="tabpanel" aria-labelledby="rules-tab">
                    <div class="form-group row justify-content-center">
                        @foreach ($payment_rules as $rule)
                                <div class="col-sm-4 col-lg-4 mb-4 mb-sm-0 text-center">
                                    <label class="col-form-label">{{ $rule->name }}</label>
                                    <div class="form-control bd-none">
                                        <div class="switch-button switch-button-success" data-toggle="tooltip" data-placement="right" title="{{ $rule->description }}">
                                            <input type="checkbox" value="{{ $rule->id }}" name="payment_rules[]" id="pay-rules-{{ $rule->id }}"><span>
                                        <label for="pay-rules-{{ $rule->id }}"></label></span>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                    <div class="form-group row justify-content-center">
                        @if (count($salesmen) > 0)
                            @foreach ($salesmen as $sale)
                                <div class="col-sm-4 col-lg-4 mb-4 mb-sm-0 text-center">
                                    <label class="col-form-label">{{ $sale->name . ' ' . $sale->lastNameF . ' ' . $sale->lastNameM }}</label>
                                    <div class="form-control bd-none">
                                        <div class="switch-button switch-button-success">
                                            <input type="checkbox" value="{{ $sale->idCollab }}" name="salesmen[]" id="pay-rules-{{ $sale->idCollab }}"><span>
                                        <label for="pay-rules-{{ $sale->idCollab }}"></label></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2>No hay datos</h2>
                        @endif
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade justify-content-center" id="modules" role="tabpanel" aria-labelledby="modules-tab">
                   <div class="row">
                        <label class="col-form-label text-sm-center">Coordinador</label>
                        <div class="col-sm-12 col-lg-3 col-lg-3 mb-3 mb-sm-0">
                            <select name="id_coordinator" id="selectTeacher" class="selectpicker show-tick show-menu-arrow form-control @error('id_teacher') is-invalid @enderror" 
                                is-invalid data-toggle="tooltip" data-placement="top" title="Docente titular" data-live-search="true" data-header="Selecciona una opción">
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->namePerson . ' ' . $teacher->personLastFName . ' ' . $teacher->personLastMName }}</option>
                                @endforeach
                            </select>
                        </div>
                   </div><hr>
                    <div class="row" id="list_fields">
                        <div class="col-12 col-ms-12 col-lg-12" id="field">
                            <div class="row modules">
                                <label class="col-12 col-sm-3 col-lg-2 col-form-label text-sm-center">Módulos</label>
                                <div class="col-12 col-sm-4 col-lg-4 mb-3 mb-sm-0"><br>
                                    <input id="start_at" name="modules[]" type="text" placeholder="Nombre del módulo" class="form-control datetimepicker-input @error('modules') is-invalid @enderror">
                                    @error('modules')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class=" col-12 col-sm-4 col-lg-2 mb-3 mb-sm-0">
                                    <label>Semanas de duración</label>
                                    <input id="duration" name="duration[]" type="number" placeholder="Duración" class="form-control datetimepicker-input @error('modules') is-invalid @enderror">
                                    @error('modules')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class=" col-12 col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                    <label>Docente</label>
                                    <select name="id_teachers[]" id="selectTeacher" class="selectpicker show-tick show-menu-arrow form-control @error('id_teacher') is-invalid @enderror" 
                                        is-invalid data-toggle="tooltip" data-placement="top" title="Docente a cargo" data-live-search="true" data-header="Selecciona una opción">
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->namePerson . ' ' . $teacher->personLastFName . ' ' . $teacher->personLastMName }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_teacher')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right"></label>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <a class="btn btn-outline-success" id="add_field" data-toggle="tooltip" data-placement="left" title="Agregar otro módulo">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade justify-content-center" id="profiles" role="tabpanel" aria-labelledby="profiles-tab">
                    <div class="row"> 
                        <h4>Perfil de profesión permitidas</h4>
                        <div class="col-12 col-md-12 col-lg-12">
                            <select class="js-example-basic-multiple" name="profesion[]" multiple="multiple" style="width: 100%">
                            @foreach ($profile_profesion as $profesion)
                                <option value="{{ $profesion->id }}">{{$profesion->label}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div> 
                    <hr>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- jquery 3.3.1 -->
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2_multiple/select2multi.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script>
    $('.js-example-basic-multiple').select2({
  placeholder: 'Selecciona las profesiones permitidas',
  width: 'resolve',
  minimumResultsForSearch: Infinity
});
        ///funcionnalidad de agregar los moduls a la generación
        var max_fields = 20;   //max de 10 campos
        var x = 0;

        var new_platform = {{$new_platform}}
        console.log(new_platform);
        if (new_platform == 0) {
            $('#divOtherPlatform').attr("style", "display: none !important;")
        }

        $('#add_field').click (function(e) {
                $(document).ready(function() {
                        $('select'). selectpicker();
                });
                
                e.preventDefault();     //prevenir novos clicks
                // if (x < max_fields) {
                        $('#field').append('\
                         <div class="row modules">\
                                <label class="col-12 col-sm-3 col-lg-2 col-form-label text-sm-center"></label>\
                                <div class="col-12 col-sm-4 col-lg-4 mb-3 mb-sm-0"><br>\
                                    <input id="start_at" name="modules[]" type="text" placeholder="Nombre del módulo" class="form-control datetimepicker-input">\
                                </div>\
                                <div class=" col-12col-sm-4 col-lg-2 mb-3 mb-sm-0">\
                                    <label>Duración en Semanas</label>\
                                    <input id="duration" name="modules[]" type="number" placeholder="Duración" class="form-control datetimepicker-input">\
                                </div>\
                                <div class=" col-12 col-sm-4 col-lg-3 mb-3 mb-sm-0">\
                                    <label>Docente</label>\
                                    <select name="id_teachers[]" id="selectTeacher" class="selectpicker show-tick show-menu-arrow form-contro" \
                                        is-invalid data-toggle="tooltip" data-placement="top" title="Docente a cargo" data-live-search="true" data-header="Selecciona una opción">\
                                        @foreach ($teachers as $teacher)\
                                            <option value="{{ $teacher->id }}">{{ $teacher->namePerson . ' ' . $teacher->personLastFName . ' ' . $teacher->personLastMName }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                                <a href="#" class="remove_field text-right"><i class="fas fa-times-circle text-danger"></i> Quitar </a>\
                            </div>');
                        x++;
                //}
        });
        // Remover o div anterior
        $('#field').on("click",".remove_field",function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
        });
        ///funcionalidad para pasar al siguiente apartado de la vista
        $('.btnNext').click(function(){
        $('.nav-item > .active').parent().next('li').find('a').trigger('click');
        });
        /////////////// 
    
    function getDates() {
        var startDate = new Date(document.getElementById("start_at").value);
        var date = new Date(startDate);

        var getWeeks = document.getElementById("duration_time").value;
        var converToDays =  (parseInt(getWeeks)*7);

        date.setDate(date.getDate() + (converToDays + 1));

        var day = ((date.getDate()) >= 10) ? (date.getDate()) : '0' + (date.getDate());
        var month = ((date.getMonth() + 1) >= 10) ? (date.getMonth()+1) : '0' + (date.getMonth() + 1);
        var finishDate = date.getFullYear() + "-" + month + "-" + day;

        document.querySelector("#finish_at").value = finishDate;
    }

    function otherPlatform(){
        $('#divOtherPlatform').attr("style", "display: flex !important;")
        $('#selectPlatform').attr('disabled', 'disabled');
        $('#selectPlatform').val('');
    }

    function CancelOtherPlatform(){
        $('#divOtherPlatform').attr("style", "display: none !important;")
        $('#selectPlatform').removeAttr('disabled', 'disabled');
        $('#add_platform').val('');
        
    }
</script>

@endsection