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

@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('message')}}
        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
    </div>
@endif

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Usuarios </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <nav class="navbar navbar-expand-lg card-header">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" 
                            onclick="location.href='{{ route('user.create') }}'">Nuevo Usuario
                        </button>
                        <div class="ml-5">
                                <form class="form-inline ">
                                <span class="fas fa-search"></span> <input name="search" class="form-control ml-2  mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar..." value="{{$searchUser}}">
                                </form>
                            
                        </div> 
                    </div>
                </nav>
                
                @if (count($users) > 0)
                    <div class="card-body">                        
                        <table class="table text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>Fecha de registro</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            @foreach ($users as $user)
                                <tbody>
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->lastNameF . ' ' . $user->lastNameM }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->NameRol }}</td>
                                        <td>
                                            <div class="dd-nodrag btn-group ml-auto">
                                                @if($user->name != 'admin')
                                                <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Editar" onclick="location.href='{{ url('edit/user', $user->id) }}'">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" id="stsCollab{{ $user->id }}" onclick="return delet({{$user->id}}, event)">
                                                        <i class="far fa-trash-alt text-danger"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            @endforeach
                        </table>
                        <div class="d-flex mt-4 justify-content-center">
                            {{ $users->links() }}
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
                <form id="validationformActive" action="{{ url('user/delete') }}" method="POST" data-parsley-validate="">
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