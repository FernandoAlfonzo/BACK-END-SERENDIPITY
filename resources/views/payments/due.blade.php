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
            <h2 class="pageheader-title">Pagos por Vencer</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row">
                        <nav class="navbar navbar-light w-100">
                            <form class="form-inline w-100">
                                {{-- @csrf --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <input class="form-control form-control-lg w-100" name="name" id="nameStsPay" type="search" placeholder="Nombre del alumno" aria-label="Search">
                                        </div>
        
                                        <div class="col d-flex">
                                            <input class="form-control date w-100" type="date" name="dateInit" id="">
                                        </div>
        
                                        {{-- <div class="col d-flex">
                                            <input class="form-control date w-100" type="date" name="dateFinish" id="">
                                        </div> --}}
        
                                        <div class="col">
                                            <button class="btn btn-primary my-2 my-sm-0" type="submit">Filtar <i class="fa-solid fa-filter"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </nav>
                    </div>

                    @if (count($due_payments) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light text-center">
                                    <tr class="border-0">
                                        <th class="border-0">Folio de Compra</th>
                                        <th class="border-0">Fecha estimada</th>
                                        <th class="border-0">Monto</th>
                                        <th class="border-0">De</th>
                                        <th class="border-0">Estatus</th>
                                        {{-- <th class="border-0">Acciones</th> --}}
                                    </tr>
                                </thead>
                                @foreach ($due_payments as $due_payment)
                                    <tbody class="text-center">
                                        <tr>
                                            <td class="text-uppercase">{{ $due_payment->saleInvoice }}</td>
                                            <td>{{ $due_payment->date }}</td>
                                            <td>${{ $due_payment->amount }}</td>
                                            <td>{{ $due_payment->name . ' ' . $due_payment->lastFName . ' ' . $due_payment->lastMName }}</td>
                                            <td class="text-uppercase"><span class="badge badge-info">POR VENCER <i class="fa-solid fa-clock"></i></span></td>
                                            {{-- <td>
                                            <div class="switch-button switch-button-xs switch-button-success">
                                                <input type="checkbox" {{ $collaborator->status == "on" ? 'checked' : '' }} name="status" id="stsCollab-{{ $collaborator->id }}" 
                                                    onclick="stsCollab({{$collaborator->id}}, event)">
                                                    <span>
                                                        <label for="stsCollab-{{ $collaborator->id }}"></label>
                                                    </span>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    </tbody> 
                                @endforeach 
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning alert-danger fade show text-center" role="alert">
                            No hay pagos por vencer.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection