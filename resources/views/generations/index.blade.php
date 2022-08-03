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
            <h2 class="pageheader-title"> Generaciones  </h2>
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
                {{-- <nav class="navbar navbar-expand-lg card-header">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        {{-- <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <form class="form-inline my-2 my-lg-0">
                                    <input name="search" class="form-control mr-sm-2 mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar...">
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
                 --}}

                 {{--<div class=" mt-3 ml-5">
                     
                                <form class="form-inline ">
                                <span class="fas fa-search"></span>
                                <input name="search" class="form-control ml-2" type="search" placeholder="Buscar..." aria-label="Buscar..." value="{{$searchUser}}">
                                </form>
                    </div>--}}
                @if (count($generations) > 0)
                    {{-- <h5 class="card-header">Recent Orders</h5> --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light text-center">
                                    <tr class="border-0">
                                        <th class="border-0">No. Generación</th>
                                        <th class="border-0">Nombre</th>
                                        <th class="border-0">Tipo de servicio</th>
                                        <th class="border-0">Oferta Educativa</th>
                                        <th class="border-0">Inicio</th>
                                        <th class="border-0">Finzalización</th>
                                        <th class="border-0">Estatus</th>
                                        <th class="border-0">Acciones</th>
                                    </tr>
                                </thead>
                                @foreach ($generations as $generation)
                                    <tbody class="text-center">
                                            <tr>
                                                <td>{{ $generation->id }}</td>
                                                <td>{{ $generation->name }}</td>
                                                <td>
                                                    @foreach ($type_services as $type_service)
                                                        @if ($type_service->offerId == $generation->id_service && $type_service->typeServiceId == $type_service->OfferIdtype)
                                                            {{ $type_service->typeServiceName }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($services as $service)
                                                        @if ($service->id == $generation->id_service)
                                                            {{ $service->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $generation->start_at }}</td>
                                                <td>{{ $generation->finish_at }}</td>
                                                <th>{{ $generation->status }}</th>
                                                {{-- <td>
                                                    <div class="switch-button switch-button-xs switch-button-success">
                                                        <input type="checkbox" {{ $collaborator->status == "on" ? 'checked' : '' }} name="status" id="stsCollab-{{ $collaborator->id }}" 
                                                            onclick="stsCollab({{$collaborator->id}}, event)">
                                                        <span>
                                                            <label for="stsCollab-{{ $collaborator->id }}"></label>
                                                        </span>
                                                    </div>
                                                </td> --}}
                                                <td>
                                                    <div class="dd-nodrag btn-group ml-auto">
                                                        <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles" onclick="location.href=''">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Editar" onclick="location.href='{{ route('generations.edit', $generation->id) }}'">
                                                                <i class="far fa-edit text-primary"></i>
                                                            </button>
                                                            {{-- @if ($generation->status != 'publicado') --}}
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" id="stsCollab{{ $generation->id }}" onclick="return delet({{$generation->id}}, event)">
                                                            <i class="far fa-trash-alt text-danger"></i>
                                                        </button>

                                                        {{-- <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Eliminar" id="stsCollab{{ $generation->id }}" onclick="return delet({{$generation->id}}, event)">
                                                            <i class="far fa-trash-alt text-danger"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                    </tbody>                                        
                                @endforeach
                            </table>
                            <div class="d-flex mt-2 justify-content-center">
                                {{ $generations->links() }}
                            </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Generación</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
            </div>
            <div class="modal-body">
                <p>Deseas eliminar esta Generación</p>
            </div>
            <div class="modal-footer">
                <form id="validationformActive" action="{{ url('generations/delete') }}" method="POST" data-parsley-validate="">
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