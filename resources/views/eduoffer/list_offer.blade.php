@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Oferta Educativa | {{ $type_service->name }} </h2>
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
            <nav class="navbar navbar-expand-lg card-header">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <form class="form-inline my-2 my-lg-0">
                                <input name="search" class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar...">
                            </form>
                        </li>
                    </ul> --}}
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" 
                        onclick="location.href='{{ url('createOffer', $type_service->id) }}'"> Nueva Oferta
                    </button>
                </div>
            </nav>
            <div class="row justify-content-center">
                @if (count($services) > 0)
                    @foreach ($services as $service)
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="product-thumbnail">
                                <div class="product-img-head">
                                    <div class="product-img image-service"> 
                                        <img class="" src="{{ asset($service->url_image) }}" alt="{{ $service->name }}" class="img-fluid">
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-head w-100">
                                        <div class="">
                                            <h3 class="product-title align-middle title-mdl name-service">{{ $service->name }}</h3>
                                        </div>
                                        <div class="price-service">
                                            <div class="product-price">${{ $service->min_cost }}.00
                                                <i class="fa-solid fa-left-right"></i>
                                                ${{ $service->max_cost }}.00
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-btn text-center">
                                        <a href="{{ url('generations/create', $service->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nueva generación"><i class="fas fa-user-graduate"></i> Nueva generación</a>
                                        <a href="{{ url('/editOffer', $service->id, $service->name) }}" class="btn btn-outline-light text-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit"></i></a>
                                        {{-- <a href="{{ route('educativeoffer.show', $service->id) }}" class="btn btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles"><i class="fas fa-eye"></i></a> --}}
                                        <form class="btn" action="{{ url('destroyOffer', $service->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-light" onclick="return confirm('¿Seguro que deseas eliminarlo?')" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="far fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="product-content text-center">
                                    <div class="product-content-head align-content-center">
                                        <h3 class="product-title">{{ $service->name }}</h3>

                                        <div class="text-center">
                                            <div class="card-text d-inline-block">
                                            <p class="card-text text-dark">${{ $service->max_cost }}.00</p>
                                            </div>
                                            <p class="card-text text-dark">${{ $service->min_cost }}.00</p>
                                        </div>

                                    </div>
                                    <div class="product-btn">
                                        <a href="{{ url('generations/create', $service->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nueva generación"><i class="fas fa-user-graduate"></i> Nueva generación</a>
                                        <a href="{{ url('/editOffer', $service->id, $service->name) }}" class="btn btn-outline-light text-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit"></i></a>
                                        {{-- <a href="{{ route('educativeoffer.show', $service->id) }}" class="btn btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles"><i class="fas fa-eye"></i></a>
                                        <form class="btn" action="{{ url('destroyOffer', $service->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-light" onclick="return confirm('¿Seguro que deseas eliminarlo?')" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="far fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning alert-danger fade show text-center col-10" role="alert">
                        Lo sentimos, no existe ningún registro.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link " href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div> --}}
            </div>
        </div>
{{--         <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="product-sidebar">
                <div class="product-sidebar-widget">
                    <h4 class="mb-0">E-Commerce Filter</h4>
                </div>
                <div class="product-sidebar-widget">
                    <h4 class="product-sidebar-widget-title">Category</h4>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cat-1">
                        <label class="custom-control-label" for="cat-1">Categories #1</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cat-2">
                        <label class="custom-control-label" for="cat-2">Categories #2</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cat-3">
                        <label class="custom-control-label" for="cat-3">Categories #3</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cat-4">
                        <label class="custom-control-label" for="cat-4">Categories #4</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cat-5">
                        <label class="custom-control-label" for="cat-5">Categories #5</label>
                    </div>
                </div>
                <div class="product-sidebar-widget">
                    <h4 class="product-sidebar-widget-title">Size</h4>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="size-1">
                        <label class="custom-control-label" for="size-1">Small</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="size-2">
                        <label class="custom-control-label" for="size-2">Medium</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="size-3">
                        <label class="custom-control-label" for="size-3">Large</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="size-4">
                        <label class="custom-control-label" for="size-4">Extra Large</label>
                    </div>
                </div>
                <div class="product-sidebar-widget">
                    <h4 class="product-sidebar-widget-title">Brand</h4>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="brand-1">
                        <label class="custom-control-label" for="brand-1">Brand Name #1</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="brand-2">
                        <label class="custom-control-label" for="brand-2">Brand Name #2</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="brand-3">
                        <label class="custom-control-label" for="brand-3">Brand Name #3</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="brand-4">
                        <label class="custom-control-label" for="brand-4">Brand Name #4</label>
                    </div>
                </div>
                <div class="product-sidebar-widget">
                    <h4 class="product-sidebar-widget-title">Color</h4>
                    <div class="custom-control custom-radio custom-color-blue ">
                        <input type="radio" id="color-1" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="color-1">Blue</label>
                    </div>
                    <div class="custom-control custom-radio custom-color-red ">
                        <input type="radio" id="color-2" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="color-2">Red</label>
                    </div>
                    <div class="custom-control custom-radio custom-color-yellow ">
                        <input type="radio" id="color-3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="color-3">Yellow</label>
                    </div>
                    <div class="custom-control custom-radio custom-color-black ">
                        <input type="radio" id="color-4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="color-4">Black</label>
                    </div>
                </div>
                <div class="product-sidebar-widget">
                    <h4 class="product-sidebar-widget-title">Price</h4>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="price-1">
                        <label class="custom-control-label" for="price-1">$$</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="price-2">
                        <label class="custom-control-label" for="price-2">$$$</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="price-3">
                        <label class="custom-control-label" for="price-3">$$$$</label>
                    </div>
                </div>
                <div class="product-sidebar-widget">
                    <a href="#" class="btn btn-outline-light">Reset Filter</a>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- <div class="modal fade" id="registerGeneration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Nueva Generación</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Docente(s):</label>
                  <input type="text" name="" class="form-control" id="recipient-name" placeholder="Nombre del docente a cargo">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Promociones:</label>
                    <input type="text" class="form-control" id="recipient-name">
                </div>

                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Fechas <i class="fas fa-calendar-alt"></i> :</label>
                    <div class="row">
                        <div class="col-sm-2 col-lg-6">
                            <input required type="date" class="form-control datetimepicker-input" data-toggle="tooltip" data-placement="top" title="Fecha de inicio">
                        </div>
                        <div class="col-sm-2 col-lg-6">
                            <input required type="date" class="form-control datetimepicker-input" data-toggle="tooltip" data-placement="top" title="Fecha de finzalización">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Clave:</label>
                    <input type="text" class="form-control" id="recipient-name">
                </div>
                
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Estatus:</label>
                    <input type="text" class="form-control" id="recipient-name">
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Recipient:</label>
                    <input type="text" class="form-control" id="recipient-name">
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Reglas de pago:</label>
                    <input type="text" class="form-control" id="recipient-name">
                  </div>
              </form>
            </div>
            <div class="modal-footer">
                <form id="validationformDelete" action="{{ route('generations.store') }}" method="POST" data-parsley-validate="">
                    @csrf
                        <input type="hidden" name="idServiceGeneration" id="idServiceGeneration">
                        <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                        <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
          </div>
        </div>
    </div> --}}

    {{-- <script>
        function newGeneration(idService, nameService, event) {
            $('#idServiceGeneration').val(idService)
            $('#nameService').val(nameService)
            $('#registerGeneration').modal('show')

            console.log(idService);
        } 
    </script> --}}

@endsection