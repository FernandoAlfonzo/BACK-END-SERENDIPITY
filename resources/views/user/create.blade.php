@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Nuevo Usuario </h2>
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
                <form id="validationform" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                    @csrf
                    
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre (s)</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input id="name" name="name" type="text" placeholder="Nombre (s) de la persona" class="form-control @error('name') is-invalid @enderror">
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Apellidos</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input required type="text" name="last_father_name" placeholder="Apellido Paterno" class="form-control">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input required type="text" name="last_mother_name" placeholder="Apellidos Materno" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Email</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input type="email" name="email" placeholder="Correo Electrónico / Email" class="form-control @error('email') is-invalid @enderror">
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Contraseña</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input required type="password" name="password" placeholder="Contraseña" class="form-control">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <input required type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="form-control">
                        </div>
                    </div>

                    <div class="m-0 form-group text-center justify-content-center align-items-center">
                        <h5 class="card-header">Rol(es) del usuario</h5>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0 mx-auto mt-2">
                            <select id="IdRole" name="IdRole" class="selectpicker show-tick show-menu-arrow form-control @error('category') is-invalid @enderror" data-header="Selecciona una opción">
                                @foreach($roles as $item)
                                    @if($item->is_active != 0)
                                    <option value="{{ $item->id }}">{{ $item->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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