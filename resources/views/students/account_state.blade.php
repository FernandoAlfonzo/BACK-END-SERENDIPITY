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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">

{{-- <meta name="csrf-token" content=" csrf_token() "> --}}

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Estado de cuenta de {{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }} </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                            <h5>
                                <a href="{{ route('students.index') }}"><i class="fas fa-arrow-left"></i> Regresar</a>
                            </h5>

                            <div class="row">
                                <button type="button" onclick="listDocs()" class="btn-notification btn-secondary mx-3"
                                    data-toggle="tooltip" data-placement="top" title="Ver Documentos">
                                    <i class="fa-solid fa-folder"></i>
                                </button>
    
                                @if (count($accounts) > 0 )
                                    <a href="#" onclick="paymentStudent({{ $student->id }}, event)" 
                                        class="btn btn-rounded btn-primary">Recibir pago <i class="fas fa-cash-register"></i>
                                    </a>
                                @else
                                    <a href="#" onclick="paymentStudent({{ $student->id }}, event)" 
                                        class="btn btn-rounded btn-light active not-active">Nada por pagar <i class="fas fa-cash-register"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{Session::get('message')}} <i class="fas fa-check"></i>
            <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
        </div>
@endif

<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">  
                <div class="text-center">
                    <h2 class="font-24 mb-0 text-primary">{{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }}</h2>
                    <div class="user-avatar text-center d-block">
                        <img src="{{ asset('assets/images/account_state.png') }}" alt="{{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }}" class="rounded-circle user-avatar-xxl">
                    </div>
                    <h4>{{ $student->enrollment }}</h4>
                    <p>Project Manager</p>
                </div>
            </div>
            <div class="card-body border-top">
                <h3 class="font-16">Información de Contacto</h3>
                <div class="">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><i class="fas fa-fw fa-envelope mr-2"></i>prueba@gmail.com</li>
                        <li class="mb-1"><i class="fas fa-fw fa-phone mr-2"></i>(900) 123 4567</li>
                    </ul>
                </div>
            </div>
            <div class="card-body border-top">
                <h3 class="font-16">Dirección</h3>
                <div class="">
                    <ul class="list-unstyled mb-0">
                        @if ($address != null)
                            <li class="mb-1"><i class="fas fa-home"></i> {{ $address->full_address . '.' }}</li>
                            <li class="mb-1"><i class="fa-solid fa-city"></i> {{ $address->city . ', ' . $address->state . '.' }} </li>
                            <li class="mb-1"><i class="fas fa-globe"></i> {{ $address->country . '.' }} </li>
                        @else
                            <li>Ninguna dirección registrada.</li>   
                        @endif
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
                    @if (count($purchased_services) > 0 )
                    <div class="card">
                            {{-- <h5 class="card-header">Recent Orders</h5> --}}
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
                                        @foreach ($purchased_services as $purchased_service)
                                            <tbody class="text-center">
                                                <tr>
                                                    <td class="text-uppercase">{{ $purchased_service->folio }}</td>
                                                    <td>{{ Carbon::parse($purchased_service->date)->format('d-m-Y') }}</td>
                                                    <td>${{ $purchased_service->total_cost }}</td>
                                                    <td>
                                                        <span class="mr-2 text-uppercase">
                                                            @if ($purchased_service->accStatus == 'PAGADO')
                                                                <span class="badge badge-success">{{ $purchased_service->accStatus }} <i class="fa-solid fa-circle-check"></i></span>
                                                            @else
                                                                <span class="badge badge-warning">{{ $purchased_service->accStatus }} <i class="fa-solid fa-circle-exclamation"></i></span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="dd-nodrag btn-group ml-auto">
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles de la compra" onclick="location.href=''">
                                                                <i class="fa-solid fa-basket-shopping"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody> 
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link " href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                        </ul>
                    </nav> --}}
                    @else
                        <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                            {{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }}, aún no cuenta con servicios adquiridos.
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="pills-paid-payments" role="tabpanel" aria-labelledby="pills-paid-payments-tab">
                    @if (count($payments) > 0)
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
                                        @foreach ($payments as $payment)
                                            <tbody class="text-center">
                                                <tr>
                                                    <td class="text-uppercase title-mdl">{{ $payment->folio }}</td>
                                                    <td>{{ $payment->payment_type_code }}</td>
                                                    <td>{{ Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>
                                                    <td>${{ $payment->amount }}</td>
                                                    <td class="text-uppercase">{{ $payment->saleInvoice}}</td>
                                                    <td><span class="badge badge-success">{{ $payment->status }} <i class="fa-solid fa-circle-check"></i> </span></td>
                                                    <td class="text-uppercase">
                                                        <div class="dd-nodrag btn-group ml-auto">
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Cancelar pago" id="stsCollab{{ $payment->id }}" onclick="return delet({{$payment->id}}, event)">
                                                                <i class="fa-solid fa-ban text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="switch-button switch-button-xs switch-button-success">
                                                            <input type="checkbox" {{ $collaborator->status == "on" ? 'checked' : '' }} name="status" id="stsCollab-{{ $collaborator->id }}" 
                                                                onclick="stsCollab({{$collaborator->id}}, event)">
                                                            <span>
                                                                <label for="stsCollab-{{ $collaborator->id }}"></label>
                                                            </span>
                                                        </div>
                                                    </td> --}}
                                                    {{-- <td>
                                                        <div class="dd-nodrag btn-group ml-auto">
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles del servicio" onclick="location.href=''">
                                                                <i class="fas fa-graduation-cap"></i>
                                                            </button>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            </tbody> 
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link " href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                            </ul>
                        </nav> --}}
                    @else
                        <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                            {{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }} aún no ha realizado algún pago.
                        </div>  
                    @endif 
                </div>

                <div class="tab-pane fade" id="pills-debit-payments" role="tabpanel" aria-labelledby="pills-debit-payments-tab">
                    @if (count($late_payments) > 0 )
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
                                        @foreach ($late_payments as $late_payment)
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>{{ Carbon::parse($late_payment->date)->format('d-m-Y') }}</td>
                                                    <td>${{ $late_payment->amount }}</td>
                                                    <td class="text-uppercase"></td>
                                                    <td class="text-uppercase">
                                                        <span class="mr-2">
                                                            @if ( $today > Date('Y-m-d', strtotime($late_payment->date . "+ 3 days")) )
                                                                {{-- <span class="badge-dot badge-danger"></span> --}}
                                                                <span class="badge badge-danger">PENDIENTE <i class="fa-solid fa-circle-exclamation"></i></span>
                                                                {{-- <span class="text-danger"><b>SIN PAGAR</b></span> --}}
                                                            @else
                                                                <span class="badge badge-warning">PENDIENTE <i class="fa-solid fa-circle-exclamation"></i></span>
                                                                {{-- <span class="badge-dot badge-warning"></span> --}}
                                                                {{-- <span class="text-warning"><b>POR PAGAR</b></span> --}}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="switch-button switch-button-xs switch-button-success">
                                                            <input type="checkbox" {{ $collaborator->status == "on" ? 'checked' : '' }} name="status" id="stsCollab-{{ $collaborator->id }}" 
                                                                onclick="stsCollab({{$collaborator->id}}, event)">
                                                            <span>
                                                                <label for="stsCollab-{{ $collaborator->id }}"></label>
                                                            </span>
                                                        </div>
                                                    </td> --}}
                                                    {{-- <td>
                                                        <div class="dd-nodrag btn-group ml-auto">
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles del servicio" onclick="location.href=''">
                                                                <i class="fas fa-graduation-cap"></i>
                                                            </button>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            </tbody> 
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                            {{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }} no tiene pagos atrasados.
                        </div> 
                    @endif
                </div>

                <div class="tab-pane fade" id="pills-payable" role="tabpanel" aria-labelledby="pills-payable-tab">
                    @if (count($payments_due) > 0 )
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
                                        @foreach ($payments_due as $payment_due)
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>{{ Carbon::parse($payment_due->date)->format('d-m-Y') }}</td>
                                                    <td>${{ $payment_due->amount }}</td>
                                                    <td>{{ $payment_due->service }}</td>
                                                    <td>{{ 'Generación: ' . $payment_due->generationNumb . ' ' . $payment_due->generationName }}</td>
                                                    <td><span class="badge badge-info">POR VENCER <i class="fa-solid fa-clock"></i></span></td>
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
                                                        {{-- <div class="dd-nodrag btn-group ml-auto">
                                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Detalles del servicio" onclick="location.href=''">
                                                                <i class="fas fa-graduation-cap"></i>
                                                            </button>
                                                        </div> --}}
                                                    </td>
                                                </tr>
                                            </tbody> 
                                        @endforeach
                                    </table>
                                </div>
                            </div>                            
                        </div>
                    @else
                            <div class="alert alert-danger fade show text-center" role="alert">
                                {{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }} aún no tiene pagos próximos por vencer.
                            </div> 
                    @endif
                    {{-- <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link " href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                        </ul>
                    </nav> --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal del formulario de registro de un nuevo pago --}}
<div class="modal fade" data-backdrop="static" id="receivePayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title-mdl text-uppercase" id="exampleModalLabel align-items-between">Registrar pago de <span>{{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }}</span>
                    {{-- Total a pagar: <span id="total_to_pay" class="text-danger"> ${{ $purchased_service->total_cost }} --}} </span>
                </h3>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Cerrar">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <form id="validationform" action="" method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        <input type="hidden" name="studentId" id="studentId" value="{{ $student->id }}">
                            <div class="form-group d-flex justify-content-between">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-form-label">Pago por</label>
                                            <select id="service" name="id_account" type="text" class="form-control selectpicker show-tick show-menu-arrow" 
                                                data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Servicio adquirido" onchange="setGeneration()" required>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->accountId }}">{{ $account->saleInvoice }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="col">
                                            <label class="col-form-label">Detalles</label>
                                            <input id="generation" type="text" disabled class="form-control">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-form-label">Fecha de pago</label>
                                            <input type="date" id="payment_date" name="payment_date" class="form-control" required>
                                        </div>

                                        <div class="col">
                                            <label class="col-form-label">Método</label>
                                            <select name="typeP ay" id="type_payment" class="form-control selectpicker show-tick show-menu-arrow" 
                                                data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Método de pago" required>
                                                @foreach ($payments_type as $payment_type)
                                                    <option value="{{ $payment_type->code }}">{{ $payment_type->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label class="col-form-label">Cuenta de destino</label>
                                            <select id="accountBank" class="form-control selectpicker show-tick show-menu-arrow" 
                                                data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Cuenta de destino" required>
                                                @foreach ($accounts_bank as $account_bank)
                                                    <option value = "{{ $account_bank->id }}">{{ $account_bank->label }}: {{ $account_bank->code2 }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <input type="hidden" name="code_rule" id="code_rule">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-form-label">Folio de ticket / Referencia de transacción</label>
                                            <input name="invoice" id="folio" type="text" class="form-control" required>
                                        </div>

                                        <div class="col">
                                            <label class="col-form-label">Monto</label>
                                            <input type="number" min="0" name="amount" id="amount" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-form-label">Comentario</label>
                                            <textarea name="comment" class="form-control text-uppercase" id="comment" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-space btn-primary" id="ok">Registrar</button>
                                <button type="reset" class="btn btn-space btn-secondary">Restablecer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Fin de modal de registro de pago --}}

{{-- Modal de resumen/confirmación del nuevo pago --}}
<div class="modal fade" data-backdrop="static" id="summaryPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h3 class="modal-title title-mdl text-uppercase" id="exampleModalLabel align-items-between">Recibir pago de <span class="text-primary">{{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }}</span> 
                    {{-- Total a pagar: <span id="total_to_pay" class="text-danger"> ${{ $purchased_service->total_cost }} --}} </span>
                </h3>
                {{-- <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a> --}}
            </div>
            <div class="modal-body">
                    <form id="validationform" action="{{ url('paymentRegistration') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                        @csrf
                        <input type="hidden" name="studentId" id="stdId">
                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col-3">
                                        <label class="col-form-label py-2">Compra</label>
                                        <input id="accService" name="id_account" type="hidden">
                                    </div>
                                    <div class="col-9">
                                        <div class="py-2 px-0">
                                            <input id="serviceName" type="text" class="form-summary summary" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-3">
                                        <label class="col-form-label">Detalles</label>
                                    </div>
                                    <div class="col-9">
                                        <div class="py-2 px-0">
                                            <input id="gen" type="text" class="form-summary summary" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-3">
                                        <label class="col-form-label">Fecha</label>
                                    </div>
                                    <div class="col-9">
                                       <div class="py-2 px-0">
                                            <input type="date" id="payDate" name="payment_date" class="form-summary summary" readonly>
                                       </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <label class="col-form-label">Monto</label>
                                    </div>
                                    <div class="col-9">
                                        <div class="py-2 px-0">
                                            <input type="number" min="0" name="amount" id="amountPay" class="form-summary summary" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <label class="col-form-label">Método</label>
                                    </div>
                                    <div class="col-9">
                                        <div class="py-2 px-0">
                                            <input name="payment_type_name" id="typeNamePay" class="form-summary summary" readonly>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="payment_type_code" id="typePay" readonly>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Cuenta de destino</label>
                                        <input type="hidden" name="id_account_bank"  id="acc_bank" readonly>
                                            <input id="acc_name_bank" class="form-summary summary" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Folio de ticket / Referencia de depósito</label>
                                        <input name="invoice" id="invoice" type="text" class="form-summary summary" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Comentario</label>
                                        <input name="comment" class="form-summary summary" id="commentUser" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="code_rule" id="codeRule">

                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="container-input">
                                            <label class="col-form-label">Comprobante de transferencia / depósito</label>
                                            <div class="row justify-content-between container-input">
                                                <input type="file" name="source" id="surce-file" accept="image/jpeg, image/jpg, image/png, .pdf" class="inputfile inputfile-1" {{-- data-multiple-caption="{count} archivos seleccionados" multiple --}}  onchange="previewFile()" required>
                                                <label for="surce-file">
                                                    <span class="iborrainputfile"><i class="fa-solid fa-paperclip"></i> Adjuntar comprobante</span>
                                                </label>
                                                <div class="" id="previewOption">
                                                    {{-- Botón para previsualizar el comprobante --}}
                                                    <button type="button" id="ticketPreview" class="btnPreview" disabled data-toggle="tooltip" data-placement="top" title="Ver comprobante" onclick="showPreviewFile()">
                                                        <i class="fas fa-eye text-primary"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-space btn-primary">Confirmar <i class="fa-solid fa-circle-check"></i></button>
                            <button type="button" class="btn btn-space btn-secondary" id="cancel">Cancelar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Fin de modal de resumen/confirmación del nuevo pago --}}

{{-- Modal de previsualización del comprobante de compra --}}
<div class="modal fade" data-backdrop="static" id="ticketModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-baseline">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Cerrar">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="ticket-preview">
                    {{-- <img src="" id="previewImage" class="img-fluid mx-auto d-block"> --}}
                    <embed id="previewImage" src="" type="application/pdf" frameborder="0" width="100%" height="100%">
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Fin de modal de previsualización del comprobante de compra --}}

{{-- Modal de confirmación de cancelación de pago --}}
<div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CANCELAR PAGO REALIZADO</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <p>¿Desea cancelar realmente este pago?</p>
            </div>
            <div class="modal-footer">
                <form id="validationformActive" action="{{ url('payments/delete') }}" method="POST" data-parsley-validate="">
                    @csrf
                        <input type="hidden" name="delete" id="delete">
                        <input type="hidden" name="studentId" value="{{ $student->id }}">
                        <button type="submit" class="btn btn-space btn-primary">Sí, cancelar</button>
                        <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">No, regresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Fin de modal de confirmación de cancelación de pago --}}

{{-- Modal de la lista de Documentos --}}
<div class="modal fade" id="Docs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title-mdl text-uppercase" id="exampleModalLabel">Documentos de {{ $person->name . ' ' . $person->last_father_name . ' ' . $person->last_mother_name }}</h3>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body md-b">
                @if (count($loadFiles) > 0)
                    <ul class="list-group mb-3">
                        @foreach ($loadFiles as $file)
                            <li id="notiContent" @if ($file->is_view == 0)
                                    class="list-group-item d-flex justify-content-between notificateDocs"
                                @else
                                    class="list-group-item d-flex justify-content-between"
                                @endif>
                                <div>
                                    <h5 class="my-0">{{ $file->labelNot }}</h5>
                                    <h6 class="text-muted">{{ $file->description }}</h6>
                                </div>
                                <div class="row align-items-center">
                                    <h6>{{ Carbon::parse($file->dateNot)->format('d-m-Y H:i') }}</h6>
                                    <button type="button" id="showPreviewDoc" @if ($file->is_view != 1) onclick="updateIsView({{ $file->idNotify }})" @endif class="btnPreviewDoc mx-2">
                                        <i class="fas fa-eye text-primary" id="eye" data-toggle="tooltip" data-placement="top" title="Ver Documento"></i>
                                        <i class="fa-solid fa-eye-low-vision text-primary" id="noeye" data-toggle="tooltip" data-placement="top" title="Ocultar Documento"></i>
                                    </button>
                                </div>
                            </li>
                            <div class="card card-figure card-transition" id="previewDoc">
                                <!-- .card-figure -->
                                <figure class="figure">
                                    <!-- .figure-img -->
                                    <div class="figure-attachment docs-preview">
                                        <embed src="{{ asset($file->path_file) }}" type="application/pdf" frameborder="0" width="100%" height="100%"> 
                                    </div>
                                    <!-- /.figure-img -->
                                    @if ($file->is_downloadable == 1)
                                        <figcaption class="figure-caption">
                                            <ul class="list-inline d-flex text-muted mb-0">
                                                <li class="list-inline-item text-end mr-auto">Descargar archivo</li>
                                                <li class="list-inline-item">
                                                    <a href="{{ asset($file->path_file) }}" download class="btnPreviewDoc" data-toggle="tooltip" data-placement="top" title="Descargar">
                                                        <span>
                                                            <i class="fa-solid fa-file-arrow-down text-primary"></i></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </figcaption>
                                    {{-- @else --}}
                                    @endif
                                </figure>
                                <!-- /.card-figure -->
                            </div>
                        @endforeach
                    </ul>
                @else
                   no hay 
                @endif
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
{{-- Fin de modal de la lista de Documentos --}}

{{-- Scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

{{-- Abrir modal de recibir pago --}}
<script>
    function paymentStudent (idStudent, event) {
        $('#receivePayment').val(idStudent);
        $('#receivePayment').modal('show');
    }

    function modalapaymet() {
        $('#modalpagos').modal('show');
    }
</script>

{{-- Selección dinámica de valores de acuerdo a la cuenta a pagar  --}}
@if (count($accounts) > 0)
    <script>
        function setGeneration() {
            var service = document.getElementById("service").value;
    
            // var generation = 'Generación ' + '{{ $account->generation }}' + ': ' + '{{ $account->generationName }}';
            var paymentRule = '{{ $account->codeRule }}';
            var payDate =  '{{ $actualDate }}'
    
            // document.querySelector("#generation").value = generation;
            document.querySelector("#code_rule").value = paymentRule;
            document.querySelector("#payment_date").value = payDate;
        }
    </script>

{{-- Fin de script --}}

{{-- Resumen de pago --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#ok', function() {
                var studentId = document.getElementById("studentId").value;
                var idAccount = document.getElementById("service").value;
                // var generation = document.getElementById("generation").value;
                var payment_date = document.getElementById("payment_date").value;
                var type_payment = document.getElementById("type_payment").value;
                var type_name_payment = $("#type_payment option:selected").text();
                var accountBank = document.getElementById("accountBank").value;
                var accountNameBank = $("#accountBank option:selected").text();
                var code_rule = document.getElementById("code_rule").value;
                var invoice = document.getElementById("folio").value;
                var amount = document.getElementById("amount").value;
                var fileSurce = document.getElementById("")
                var comment = document.getElementById("comment").value;

                $("#receivePayment").modal('hide');
                $('#summaryPayment').modal('show');
                document.querySelector("#stdId").value = studentId;
                document.querySelector("#accService").value = idAccount;
                document.querySelector("#serviceName").value = '{{ $account->saleInvoice }}'
                // document.querySelector("#gen").value = generation;
                document.querySelector("#payDate").value = payment_date;
                document.querySelector("#typePay").value = type_payment;
                document.querySelector("#typeNamePay").value = type_name_payment;
                document.querySelector("#acc_bank").value = accountBank;
                document.querySelector("#acc_name_bank").value = accountNameBank;
                document.querySelector("#codeRule").value = code_rule;
                document.querySelector("#invoice").value = invoice;
                document.querySelector("#amountPay").value = amount;
                document.querySelector("#commentUser").value = comment;
            })

            $(document).on('click', '#cancel', function() {
                $('#summaryPayment').modal('hide');
                $("#receivePayment").modal('show');
            })

            // Ocultar botón de ver ticket
            $('#ticketPreview').hide();
        });
    </script>
@endif
{{-- Fin de script --}}

{{-- Botón de subir ticket --}}
<script>
    'use strict';

    ( function ( document, window, index )
    {
        var inputs = document.querySelectorAll( '.inputfile' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label	 = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener( 'change', function( e )
            {
                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.querySelector( 'span' ).innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });
        });
    }( document, window, 0 ));
</script>
{{-- Fin de script --}}

{{-- Botón de la opción de ver ticket --}}
<script>
    function previewFile() {
        var sourceFile = document.getElementById("surce-file").value;
        var buttonPreview = document.querySelector("#ticketPreview");

        if (sourceFile.length > 0) {
            buttonPreview.disabled = false;
            $('#ticketPreview').show();
        } else {
            buttonPreview.disabled = true;
            $('#ticketPreview').hide();
        }
    }

    

    // Obtener referencia al input y a la imagen
    const $selectFile = document.querySelector("#surce-file"),
    $previewFile = document.querySelector("#previewImage");

    // Escuchar cuando cambie
    $selectFile.addEventListener("change", () => {
        // Los archivos seleccionados, pueden ser muchos o uno
        const file = $selectFile.files;
        // Si no hay archivos salimos de la función y quitamos la imagen
        if (!file || !file.length) {
            $previewFile.src = "";
            return;
        }
        // Ahora tomamos el primer archivo, el cual vamos a previsualizar
        const firstFile = file[0];
        // Lo convertimos a un objeto de tipo objectURL
        const objectURL = URL.createObjectURL(firstFile);
        // Y a la fuente de la imagen le ponemos el objectURL
        $previewFile.src = objectURL;
    });

    function showPreviewFile() {
        $("#ticketModalPreview").modal('show');
    }
</script>
{{-- Fin de script --}}

{{-- Modal de confirmación de cancelación --}}
<script>
    function delet(id,event){
        if(id){
            $('#delete').val(id);
            $('#Delete').modal('show');
        }
        event.preventDefault();
   }
</script>
{{-- Fin de script --}}

{{-- Modal de ver documento añadido --}}
<script>
    function listDocs(){
        $('#Docs').modal('show');
   }

    $(document).ready(function(){
    $("#previewDoc").hide();
    $("#noeye").hide();
    $('#showPreviewDoc').on('click',function(){
        if ($("#previewDoc").is(':hidden')) {
            $("#noeye").show();
            $("#eye").hide();
            $("#previewDoc").show();
        } else {
            $("#eye").show();
            $("#noeye").hide();
            $("#previewDoc").hide();
            }
            // if ($("#notiContent").hasClass("notificateDocs")) {
            //     $("#notiContent").removeClass("notificateDocs");
            // }
            //$("#notiContent").toggleClass("notificateDocs");
        });
    });
</script>
{{-- Fin de script --}}
    
<script>
    function updateIsView(idNotify) {
        // console.log(idNotify);
        $.get("/isActive/" + idNotify, function(data, status){
            if (status == 'success') {
                if ($("#notiContent").hasClass("notificateDocs")) {
                    $("#notiContent").removeClass("notificateDocs");
                }
            }
        });
    }
</script>

@endsection