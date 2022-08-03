@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Rol: {{ $role->name }}</h2> <h2>Modulos</h2>
        </div>
    </div>
</div>
<div class="justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card m-0 justify-content-center">
            <div class="card-body">
                <div class="card-body">
                    <form action="{{ url('AsignatePermisoModule', $role->id) }}" method="post">
                    @csrf
                        <div class="form-group row">
                            @foreach ($NewListModule as $user_m_role)
                                <div class="col-3 col-sm-3 mb-4">
                                    <label>{{$user_m_role->title}}</label>    
                                    <div class="switch-button">
                                        <input type="checkbox" {{ $user_m_role->register_by == 1 ? 'checked' : '' }} name="{{$user_m_role->title}}" id="{{$user_m_role->title}}"><span>
                                        <label for="{{$user_m_role->title}}"></label></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    <div class="row pt-2 pt-sm-5 mt-1">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Regresar</a>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <p class="text-right">
                                <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                            </p>
                        </div>
                    </div>
                    </form>
                <div>
            </div>
        </div>
    </div>
</div>
@endsection