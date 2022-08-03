@extends('layouts.main')
@section('viewContent')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Colaboradores </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{Session::get('message')}}
            <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
        </div>
@endif

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <nav class="navbar navbar-expand-lg card-header">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" 
                            onclick="location.href='{{ route('collaborator.create') }}'"> Nuevo Colaborador
                        </button>
                        <div class="ml-5">
                                <form class="form-inline ">
                                <span class="fas fa-search"></span> <input name="search" class="form-control ml-2  mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar..." value="{{$searchUser}}">
                                </form>
                            
                        </div> 
                    </div>
                </nav>
                
                @if (count($collaborators) > 0)
                    {{-- <h5 class="card-header">Recent Orders</h5> --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light text-center">
                                    <tr class="border-0">
                                        <th class="border-0">Código</th>
                                        <th class="border-0">Foto</th>
                                        <th class="border-0">Nombre</th>
                                        <th class="border-0">Cargo (s)</th>
                                        <th class="border-0">Especialidades</th>
                                        <th class="border-0">Inicio el</th>
                                        <th class="border-0">Area</th>
                                        {{-- <th class="border-0">Actividades</th> --}}
                                        <th class="border-0">Estatus</th>
                                        <th class="border-0">Acciones</th>
                                    </tr>
                                </thead>
                                @foreach ($collaborators as $collaborator)
                                    <tbody class="text-center">
                                            <tr>
                                                <td>{{ $collaborator->collaborator_code }}</td>
                                                <td>
                                                    <div class="coll-img m-r-10">
                                                        <img src="{{ asset($collaborator->url_photo) }}" alt="{{ $collaborator->name }}" class="user-avatar-lg rounded-circle" width="45">
                                                    </div>
                                                </td>
                                                <td>{{ $collaborator->name . ' ' . $collaborator->lastNameF . ' ' . $collaborator->lastNameM }}</td>
                                                <td>{{ $collaborator->is_coordinator == 1 ? 'Coordinador' : '' }} {{ $collaborator->is_teacher == 1 ? 'Docente' : '' }} {{ ' ' }} {{ $collaborator->is_salesmen == 1 ? 'Vendedor' : '' }} {{ ' ' }} {{ $collaborator->is_organization == 1 ? 'Administrativo' : '' }}</td>
                                                <td>{{ $collaborator->specialties }}</td>
                                                <td>{{ $collaborator->start_at }}</td>
                                                <td>{{ $collaborator->area }}</td>
                                                <td>
                                                    <div class="switch-button switch-button-xs switch-button-success">
                                                        <input type="checkbox" {{ $collaborator->status == "on" ? 'checked' : '' }} name="status" id="stsCollab-{{ $collaborator->id }}" 
                                                            onclick="stsCollab({{$collaborator->id}}, event)">
                                                        <span>
                                                            <label for="stsCollab-{{ $collaborator->id }}"></label>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dd-nodrag btn-group ml-auto">
                                                        <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Ver mas" onclick="location.href=''">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Editar" onclick="location.href='{{ route('collaborator.edit', $collaborator->id) }}'">
                                                            <i class="far fa-edit text-primary"></i>
                                                        </button>
                                                           <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" id="stsCollab{{ $collaborator->id }}" onclick="return delet({{$collaborator->id}}, event)">
                                                                <i class="far fa-trash-alt text-danger"></i>
                                                        </button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                    </tbody>                                        
                                @endforeach
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                        Lo sentimos, no existe ningún registro.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stsCollabDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DESHABILITAR USUARIO</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
            </div>
            <div class="modal-body">
                <p>¿Deseas deshabilitar realmente al usuario</p>
            </div>
            <div class="modal-footer">
                <form id="validationformDelete" action="{{ url('collaborator/statusCollabDelete') }}" method="POST" data-parsley-validate="">
                    @csrf
                        <input type="hidden" name="stsCollab" id="stsCollab" value="">
                        <input type="hidden" name="idCollabDelete" id="idCollabDelete">
                        <button type="submit" class="btn btn-space btn-primary">Deshabilitar</button>
                        <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stsCollabActive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Habilitar Usuario</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
            </div>
            <div class="modal-body">
                <p>Deseas habilitar al usuario</p>
            </div>
            <div class="modal-footer">
                <form id="validationformActive" action="{{ url('collaborator/statusCollabActive') }}" method="POST" data-parsley-validate="">
                    @csrf
                        <input type="hidden" name="stsCollab" id="stsCollab" value="on">
                        <input type="hidden" name="idCollabActive" id="idCollabActive">
                        <button type="submit" class="btn btn-space btn-primary">Habilitar</button>
                        <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
            </div>
            <div class="modal-body">
                <p>Deseas eliminar al usuario</p>
            </div>
            <div class="modal-footer">
                <form id="validationformActive" action="{{ url('collaborator/delete') }}" method="POST" data-parsley-validate="">
                    @csrf
                        <input type="hidden" name="delete" id="delete">
                        <button type="submit" class="btn btn-space btn-primary">Eliminar</button>
                        <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function stsCollab (idCollab, event) {
        
        if( !$('#stsCollab-'+idCollab).prop('checked') ) {
            $('#idCollabDelete').val(idCollab)
            $('#stsCollabDelete').modal('show')
           
            console.log('si');
        }

        if( $('#stsCollab-'+idCollab).prop('checked') ) {
            $('#idCollabActive').val(idCollab)
            $('#stsCollabActive').modal('show')
            console.log('no');
        }
        event.preventDefault();

    }
    function delet(id,event){
        if(id){
            //console.log(id);
            $('#delete').val(id);
            $('#Delete').modal('show');
        }
        event.preventDefault();
   }
</script>
@endsection