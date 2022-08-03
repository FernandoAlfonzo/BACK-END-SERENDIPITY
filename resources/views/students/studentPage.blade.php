<?php 

    use Carbon\Carbon;
    //dd($);

?>

@extends('layouts.main')
@section('viewContent')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">

<link rel="stylesheet" href="{{ asset('assets/libs/js/jquery-ui-1.13.1/jquery-ui.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Estado de cuenta</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-end">
                            <div class="row">
                                <button type="button" class="btn-search-student btn-primary" id="btn-search-student"
                                    data-toggle="tooltip" data-placement="top" title="Buscar Alumno">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                                <button type="button" class="btn-notification btn-secondary mx-3 not-active"
                                    data-toggle="tooltip" data-placement="top" title="Ver Documentos">
                                    <i class="fa-solid fa-folder"></i>
                                </button>
                                    <a href="#" class="btn btn-rounded btn-light active not-active">Nada por pagar <i class="fas fa-cash-register"></i></a>
                            </div>
                        </div>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">  
                <div class="text-center">
                    <h2 class="font-24 mb-0 text-primary">Nombre del alumno</h2>
                    <div class="user-avatar text-center d-block">
                        <img src="{{ asset('assets/images/account_state.png') }}" alt="Nombre del alumno" class="rounded-circle user-avatar-xxl">
                    </div>
                    <h4>Matrícula</h4>
                    <p>Profesión</p>
                </div>
            </div>
            <div class="card-body border-top">
                <h3 class="font-16">Información de Contacto</h3>
                <div class="">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><i class="fas fa-fw fa-envelope mr-2"></i>email@gmail.com</li>
                        <li class="mb-1"><i class="fas fa-fw fa-phone mr-2"></i>(900) 123 4567</li>
                    </ul>
                </div>
            </div>
            <div class="card-body border-top">
                <h3 class="font-16">Dirección</h3>
                <div class="">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><i class="fas fa-home"></i> Dirección completa.</li>
                        <li class="mb-1"><i class="fa-solid fa-city"></i> Ciudad, Estado.</li>
                        <li class="mb-1"><i class="fas fa-globe"></i> País.</li>
                    </ul>
                </div>
            </div>
            <div class="card-body border-top">
                <h3 class="font-16">Redes Sociales</h3>
                <div class="">
                    <ul class="mb-0 list-unstyled">
                    <li class="mb-1"><a href="#"><i class="fab fa-fw fa-facebook-square mr-1 facebook-color"></i>fb.me/michaelchristy</a></li>
                    <li class="mb-1"><a href="#"><i class="fab fa-fw fa-twitter-square mr-1 twitter-color"></i>twitter.com/michaelchristy</a></li>
                    <li class="mb-1"><a href="#"><i class="fab fa-fw fa-instagram mr-1 instagram-color"></i>instagram.com/michaelchristy</a></li>
                </ul>
                </div>
            </div>
            {{-- <div class="card-body border-top">
                <h3 class="font-16">Category</h3>
                <div>
                    <a href="#" class="badge badge-light mr-1">Fitness</a><a href="#" class="badge badge-light mr-1">Life Style</a><a href="#" class="badge badge-light mr-1">Gym</a>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
        <div class="influence-profile-content pills-regular">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-services-tab" data-toggle="pill" href="#pills-services" role="tab" aria-controls="pills-services" aria-selected="true">Servicios Adquiridos <i class="fas fa-graduation-cap"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-paid-payments-tab" data-toggle="pill" href="#pills-paid-payments" role="tab" aria-controls="pills-paid-payments" aria-selected="false">Pagos Realizados <i class="fas fa-donate"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-debit-payments-tab" data-toggle="pill" href="#pills-debit-payments" role="tab" aria-controls="pills-debit-payments" aria-selected="false">Pagos Atrasados <i class="fas fa-history"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-payable-tab" data-toggle="pill" href="#pills-payable" role="tab" aria-controls="pills-payable" aria-selected="false">Pagos por Vencer <i class="fa-solid fa-calendar-day"></i></a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab">
                    <div class="card">
                        <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light text-center">
                                            <tr class="border-0">
                                                <th class="border-0">Folio de compra</th>
                                                <th class="border-0">Fecha</th>
                                                <th class="border-0">Costo total</th>
                                                <th class="border-0">Estatus</th>
                                                <th class="border-0">Acciones</th>
                                                {{-- <th class="border-0">Más</th> --}}
                                            </tr>
                                        </thead>
                                            <tbody class="text-center">
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                            </tbody> 
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-paid-payments" role="tabpanel" aria-labelledby="pills-paid-payments-tab">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light text-center">
                                            <tr class="border-0">
                                                <th class="border-0">Folio</th>
                                                <th class="border-0">Método</th>
                                                <th class="border-0">Fecha</th>
                                                <th class="border-0">Monto</th>
                                                <th class="border-0">Folio de compra</th>
                                                <th class="border-0">Estatus</th>
                                                <th class="border-0">Opciones</th>
                                            </tr>
                                        </thead>
                                            <tbody class="text-center">
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                            </tbody> 
                                    </table>
                                </div>
                            </div>
                        </div> 
                </div>

                <div class="tab-pane fade" id="pills-debit-payments" role="tabpanel" aria-labelledby="pills-debit-payments-tab">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light text-center">
                                            <tr class="border-0">
                                                <th class="border-0">Fecha establecida</th>
                                                <th class="border-0">Monto</th>
                                                <th class="border-0">Folio de compra</th>
                                                <th class="border-0">Estatus</th>
                                                {{-- <th class="border-0">Más</th> --}}
                                            </tr>
                                        </thead>
                                            <tbody class="text-center">
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                            </tbody> 
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="tab-pane fade" id="pills-payable" role="tabpanel" aria-labelledby="pills-payable-tab">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light text-center">
                                            <tr class="border-0">
                                                <th class="border-0">Fecha estimada</th>
                                                <th class="border-0">Monto</th>
                                                <th class="border-0">Servicio adquirido</th>
                                                <th class="border-0">Detalles</th>
                                                <th class="border-0">Estatus</th>
                                                {{-- <th class="border-0">Más</th> --}}
                                            </tr>
                                        </thead>
                                            <tbody class="text-center">
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td>---</td>
                                            </tbody> 
                                    </table>
                                </div>
                            </div>                            
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="search-student-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SELECCIONAR ALUMNO</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    {{-- <form action="">
                        
                        {{-- <button class="btn btn-primary search-btn" type="submit">Search</button>
                    </form> --}}
                    <input id="search-student-input" name="search" class="form-control form-control-lg" type="search" placeholder="Buscar" aria-label="Buscar">
                    <button id="btn-search" class="btn btn-primary search-btn" type="button">Buscar</button>

                    {{-- <div id="results" class="bg-light border">
                        @if (count($students))
                            @foreach ($students as $student)          
                                <p class="p-2 border-bottom">{{$student->id . ' - ' . $student->name}} <a href="">Ir a</a></p>
                            @endforeach             
                        @endif
                    </div> --}}
                </div>
            </div>
            {{-- <div class="modal-footer">
            </div> --}}
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="{{ asset('assets/libs/js/jquery-ui-1.13.1/jquery-ui.min.js') }}"></script>

<script>
    $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
     }
 });
</script>

<script>
    $(document).ready(function() {
        $('#search-student-modal').modal('show');

        $('#btn-search-student').on('click',function(){
            $('#search-student-modal').modal('show');
        });
    });
</script>

{{-- <script>
    $('#search-student-input').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('students.search') }}",
                dataType: 'json',
                data: {
                    search: request.search
                },
                success: function(data) {
                    response(data);
                }
            })
        }
    })
</script> --}}

{{-- <script>
    window.addEventListener('load', function() {
        document.getElementById("search-student-input").addEventListener("keyup", () => {
            if ((document.getElementById("search-student-input").value.length) >= 1) {
                fetch(`/searchStudent?search=${document.getElementById("search-student-input").value}`, {method: 'get'})
                .then(response => response.text())
                .then(html => {document.getElementById("results").innerHTML = html})
            } else {
                document.getElementById("results").innerHTML = ""
            }
        });
    });
</script> --}}

{{-- <script>
    $('#btn-search').click(function(){
       //we will send data and recive data fom our AjaxController
        $.ajax({
            url:'searchStudent',
            data: 'Gio',
            type:'post',
            success: function (response) {
                alert(response);
            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error:function(x,xs,xt){
                //nos dara el error si es que hay alguno
                window.open(JSON.stringify(x));
                //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
            }
        });
    });
</script> --}}

@endsection