@extends('layouts.main')
@section('viewContent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Editar Colaborador | {{ $collaborator->name . ' ' . $collaborator->lastNameF . ' ' . $collaborator->lastNameM }} </h2>
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
                <form id="validationform" action="{{ url('collaborator/update') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $collaborator->id }}">
                    <input type="hidden" name="personId" value="{{ $collaborator->personId }}">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre(s)</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input id="name" name="name" type="text" value="{{ $collaborator->name }}" placeholder="Nombre(s) del colaborador" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>                     
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Apellidos</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input id="name" name="last_father_name" type="text" value="{{ $collaborator->lastNameF }}" placeholder="Apellido Paterno" class="form-control @error('last_father_name') is-invalid @enderror">
                        </div>
                        @error('last_father_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input id="name" name="last_mother_name" type="text" value="{{ $collaborator->lastNameM }}" placeholder="Apellido Materno" class="form-control @error('last_mother_name') is-invalid @enderror">
                        </div>
                        @error('last_mother_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Fecha de nacimiento</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0 date">
                            <input id="birth_date" name="birth_date" type="date" value="{{ $collaborator->birth_date }}" class="form-control datetimepicker-input @error('birth_date') is-invalid @enderror" 
                                data-toggle="tooltip" data-placement="top" title="Fecha de nacimiento">
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Género</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select name="gender" class="selectpicker show-tick show-menu-arrow form-control @error('gender') is-invalid @enderror" 
                                data-header="Selecciona una opción"data-toggle="tooltip" data-placement="top" title="Género del colaborador">
                                @foreach ($gender_list as $gender)
                                    @if ($gender->is_active != 0)
                                        <option value="{{ $gender->code }}" {{ $collaborator->gender == $gender->code ? 'selected' : ''}}>{{ $gender->label }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Código</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="collaborator_code" value="{{ $collaborator->collaborator_code }}" placeholder="Código del colaborador" class="form-control @error('code') is-invalid @enderror">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Especialidad</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select name="specialties" class="selectpicker show-tick show-menu-arrow form-control @error('specialties') is-invalid @enderror" 
                                is-invalid data-toggle="tooltip" data-placement="top" title="En qué se especializa el colaborador" data-live-search="true" data-header="Selecciona una opción">
                                <option value="1">Psicología</option>
                                <option value="2">Docencia</option>
                                <option value="3">Trabajo social</option>
                            </select>
                            @error('id_teacher')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Puesto</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <label class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" value="1" {{ $collaborator->is_coordinator == 1 ? 'checked' : ''}} name="is_coordinator" class="custom-control-input form-control @error('is_coordinator') is-invalid @enderror">
                                    <span class="custom-control-label">Coordinador</span>
                                @error('is_coordinator')
                                <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                            <label class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" value="1" {{ $collaborator->is_teacher == 1 ? 'checked' : ''}} name="is_teacher" class="custom-control-input form-control @error('is_teacher') is-invalid @enderror">
                                    <span class="custom-control-label">Profesor</span>
                                @error('is_teacher')
                                <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                            <label class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" value="1" {{ $collaborator->is_salesmen == 1 ? 'checked' : ''}} name="is_salesmen" class="custom-control-input form-control @error('is_salesmen') is-invalid @enderror">
                                    <span class="custom-control-label">Vendedor</span>
                                @error('is_salesmen')
                                   <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                            <label class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" value="1" {{ $collaborator->is_organization == 1 ? 'checked' : ''}} name="is_organization" id="organization" class="custom-control-input form-control @error('is_organization') is-invalid @enderror">
                                    <span class="custom-control-label">Administrativo</span>
                                    @error('is_organization')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </label>
                        </div>
                    </div>

                    <div class="form-group row" id="salary">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Salario <i class="fas fa-dollar-sign"></i></label>
                        <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0 date">
                            <input name="salary" type="number" value="{{ $collaborator->salary }}" class="form-control datetimepicker-input @error('salary') is-invalid @enderror" placeholder="Ingrese el salario">
                            @error('salary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Características</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea id="characteristics" name="characteristics" placeholder="Características" class="form-control @error('characteristics') is-invalid @enderror">{{ $collaborator->characteristics }}</textarea>
                            @error('characteristics')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Fecha de inicio de labores</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0 date">
                            <input id="start_at" name="start_at" type="date" value="{{ $collaborator->start_at }}" class="form-control datetimepicker-input @error('start_at') is-invalid @enderror" data-toggle="tooltip" data-placement="top" title="Fecha de inicio de labores">
                            @error('start_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Unidad de negocio</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select name="business_unit[]" class="selectpicker show-tick show-menu-arrow form-control @error('business_unit') is-invalid @enderror" 
                                    multiple data-actions-box="true" data-header="Puedes seleccionar una o varias opciones" data-toggle="tooltip" 
                                        data-placement="top" title="Unidad de negocio a la que pertenece">
                                        @foreach ($business_unit_list as $business_unit)
                                            @if ($business_unit->is_active != 0)
                                                <option value="{{ $business_unit->id }}" {{ $collaborator->business_unit == $business_unit->id ? 'selected' : ''}}>{{ $business_unit->label }}</option>
                                            @endif
                                        @endforeach
                                </select>
                                @error('business_unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Área</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select class="selectpicker show-tick show-menu-arrow form-control @error('area') is-invalid @enderror" name="area" data-header="Selecciona una opción" data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Área dónde laborará">
                                @foreach ($area_list as $area)
                                    @if ($area->is_active != 0)
                                        <option value="{{ $area->id }}" {{ $collaborator->area == $area->id ? 'selected' : ''}}>{{ $area->label }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('area')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Actividades</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <textarea id="activities" name="activities" placeholder="Descripción de las actividades que desempeñará el colaborador" class="form-control @error('activities') is-invalid @enderror">{{ $collaborator->activities }}</textarea>
                            @error('activities')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Precio</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input required type="number" name="min_cost" min="0" placeholder="Precio mínimo del servicio" class="form-control">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input required type="number" name="max_cost" min="0" placeholder="Precio máximo del servicio" class="form-control">
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Estatus</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                <div class="switch-button switch-button-success">
                                    <input type="checkbox" {{ $collaborator->status == 'on' ? 'checked' : ''}} name="status" id="status" class="form-control @error('status') is-invalid @enderror"><span>
                                <label for="status"></label></span>
                                </div>
                            </div>
                                
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Estatus</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <select class="selectpicker show-tick show-menu-arrow form-control @error('status') is-invalid @enderror" name="status" data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Estatus en el que se encuentra el colaborador">
                                @foreach ($status_list as $status)
                                    @if ($status->is_active != 0)
                                        <option value="{{ $status->id }}" {{ $collaborator->status == $status->id ? 'selected' : ''}}>{{ $status->label }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Fotografía</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="file" name="url_photo" id="selectImage" accept="image/jpeg,image/png" class="form-control @error('url_photo') is-invalid @enderror" data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Fotografía del colaborador">
                            @error('url_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            {{-- <h5 class="card-header text-center text-muted">Previsualización</h5> --}}
                            <div class="card-body preview-image">
                                <img src="{{ asset($collaborator->url_photo) }}" id="previewImage" alt="{{ $collaborator->name }}" class="img-fluid mr-3 mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Editar</button>
                            <a href="{{ route('collaborator.index') }}" class="btn btn-space btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    if( $('#organization').prop('checked')) {
        $("#salary").show();
    } else {
        $('#salary').hide();
    }
</script>
<script>
    $(document).ready(function(){
    $('#organization').on('change',function(){
        if (this.checked) {
            $("#salary").show();
        } else {
            $("#salary").hide();
        } 
        });
    });
</script>
@endsection