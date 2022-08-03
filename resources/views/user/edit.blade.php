@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Editar Usuario {{ $user->email }}</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <form id="form" data-parsley-validate="" method="POST" action="{{ url('update/user') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <input type="hidden" name="personId" value="{{ $user->personId }}">
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Nombre</label>
                        <div class="col-9 col-lg-10">
                            <input id="name" name="name" type="text" required value="{{ $user->name }}" data-parsley-type="text" placeholder="Nombre" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Apellido Paterno</label>
                        <div class="col-9 col-lg-10">
                            <input id="last_father_name" name="last_father_name" value="{{ $user->last_father_name }}" type="text" required data-parsley-type="text" placeholder="Apellido Paterno" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Apellido Materno</label>
                        <div class="col-9 col-lg-10">
                            <input id="last_mother_name" name="last_mother_name" value="{{ $user->last_mother_name }}" type="text" required data-parsley-type="text" placeholder="Apellido Materno" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Email</label>
                        <div class="col-9 col-lg-10">
                            <input id="email" name="email" type="email" required value="{{ $user->email }}" data-parsley-type="email" placeholder="Email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Contraseña</label>
                        <div class="col-9 col-lg-10">
                            <input id="password" name="password" value="" type="password" required placeholder="Contraseña" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-lg-2 col-form-label text-right">Confirmar</label>
                        <div class="col-9 col-lg-10">
                            <input id="password" name="password_confirmation" type="password" required placeholder="Confirmar contraseña" class="form-control" disabled>
                        </div>
                    </div>

                        <h5 class="card-header">Rol(es) del usuario</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <!--<label class="col-2 col-sm-2 mb-4">Alumno</label>
                                <div class="col-2 col-sm-2 mb-4">
                                    <div class="switch-button switch-button-success">
                                        <input type="checkbox" checked="" name="check-role" id="check-role"><span>
                                    <label for="check-role"></label></span>
                                    </div>
                                </div>-->
                                <div class="col-6 col-sm-6 mb-4">
                                    <select id="IdRole" name="IdRole" class="form-control" required>
                                        <option value="">Selecciona una opción</option>
                                        @foreach($roles as $item)
                                            @if($item->is_active != 0)
                                            <option value="{{ $item->id }}" {{ $item->id == $role_user->id_role ? 'selected' : ''}}>{{ $item->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    <div class="row pt-2 pt-sm-5 mt-1">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <a href="javascript:history.back()"><i class="fas fa-undo-alt"></i> Regresar</a>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <p class="text-right">
                                <a class="btn btn-space btn-secondary" href="{{ url('/user') }}">Cancelar</a>
                                <button type="submit" class="btn btn-space btn-primary">Editar</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection