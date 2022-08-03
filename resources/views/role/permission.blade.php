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
                <div id="accordion">
                @foreach ($modulos as $module)
                    <div class="card">
                        @if( $module->id_parent == 0 )
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#<?php echo $module->id ?>" aria-expanded="true" aria-controls="<?php echo $module->id ?>">
                                    {{ $module->title }}
                                </button>
                            </h5>
                        </div>
                    
                        <div id="<?php echo $module->id ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                @foreach($submodulos as $m)
                                    @if($module->id==$m->id_parent)
                                        {{$m->title}}
                                    @endif
                                @endForeach
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection