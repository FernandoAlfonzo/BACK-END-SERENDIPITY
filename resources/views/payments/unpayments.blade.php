<?php
  
    use Carbon\Carbon;

?>

@extends('layouts.main')
@section('viewContent')
@inject('students', 'App\Services\Students')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Conciliaciones</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
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

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    @if (count($unpayments) > 0)
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light text-center">
                            <tr class="border-0">
                                <th class="border-0">Id</th>
                                <th class="border-0">Folio</th>
                                <th class="border-0">Método</th>
                                <th class="border-0">Fecha de pago</th>
                                <th class="border-0">Monto</th>
                                <th class="border-0">Por</th>
                                <th class="border-0">De</th>
                                <th class="border-0">Estatus</th>
                                <th class="border-0">Acciones</th>
                            </tr>
                        </thead>
                        @foreach ($unpayments as $unpayment)
                            <tbody class="text-center">
                                <tr>
                                    <td>{{ $unpayment->idPay }}</td>
                                    <td class="text-uppercase">{{ $unpayment->payInvoice }}</td>
                                    <td>{{ $unpayment->typePaymentName }}</td>
                                    <td>{{ Carbon::parse($unpayment->payment_date)->format('d-m-Y') }}</td>
                                    <td>${{ $unpayment->payAmount }}</td>
                                    <td class="text-uppercase">{{ $unpayment->saleInvoice }}</td>
                                    <td>{{ $unpayment->name . ' ' . $unpayment->lastFName . ' ' . $unpayment->lastMName }}</td>
                                    <td><span class="badge badge-warning text-uppercase">{{ $unpayment->payStatus }} <i class="fa-solid fa-triangle-exclamation"></i></span></td>
                                    <td>
                                        {{-- <div class="dd-nodrag btn-group ml-auto">
                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Ver comprobante de pago" onclick="">
                                                <i class="fa-solid fa-file-invoice-dollar text-primary"></i>
                                            </button>
                                        </div> --}}
                                        <div class="dd-nodrag btn-group ml-auto">
                                            <button class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="Conciliar pago" onclick="reconcilePayment('{{ $unpayment->idPay }}', '{{ $unpayment->payment_date }}', '{{ $unpayment->typePaymentName }}', '{{ $unpayment->payInvoice }}', '{{ $unpayment->payAmount }}')">
                                                <i class="fa-solid fa-cash-register text-primary"></i>
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
    @else
        <div class="alert alert-warning alert-danger fade show text-center" role="alert">
            Sin pagos NO IDENTIFICADOS por el momento.
        </div>
    @endif
</div>

@if (count($unpayments) > 0)
    {{-- Modal para conciliar un pago --}}
    <div class="modal fade" id="conciliationPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title-mdl text-uppercase" id="exampleModalLabel">Conciliar pago</h3>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body" id="app">
                    <input type="hidden" id="idPay" value="">
                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Alumno</label>
                                        <select v-model="selected_user" @change="loadAccounts" id="userId" data-old="{{ old('userId') }}" class="form-control selectpicker show-tick show-menu-arrow" 
                                            data-header="Selecciona una opción" data-live-search="true" data-toggle="tooltip" data-placement="top" title="Ingresar nombre del alumno" required>
                                            @foreach ($students->get() as $item => $student)
                                                <option value="{{ $item }}">{{ $student }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Compra</label>
                                        <select v-model="selected_account" id="accountId" data-old="{{ old('accountId') }}" class="custom-select text-uppercase" required>
                                            <option v-for="(account, item) in accounts" v-bind:value="account.accountId">@{{account.saleInvoice}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Fecha de pago</label>
                                        <input type="date" id="payDate" class="form-control" required disabled>
                                    </div>

                                    <div class="col">
                                        <label class="col-form-label">Método</label>
                                        <input class="form-control" id="typePayName" required disabled>
                                    </div>

                                    <div class="col">
                                        <label class="col-form-label">Cuenta de destino</label>
                                        <select id="accountBank" class="form-control selectpicker show-tick show-menu-arrow" 
                                            data-header="Selecciona una opción" data-toggle="tooltip" data-placement="top" title="Cuenta de destino" required>
                                            @foreach ($accounts_bank as $account_bank)
                                                <option value = "{{ $account_bank->id }}">{{ $account_bank->label }}: {{ $account_bank->code2 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Folio de ticket / Referencia de transacción</label>
                                        <input id="payInvoice" type="text" class="form-control text-uppercase" required>
                                    </div>

                                    <div class="col">
                                        <label class="col-form-label">Monto</label>
                                        <input type="number" id="payAmount" min="0" class="form-control" required disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-form-label">Comentario</label>
                                        <textarea class="form-control text-uppercase" id="comment" cols="30" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                                <button type="button" class="btn btn-space btn-primary" id="accept">Aceptar</button>
                                <button class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Fin de Modal para conciliar un pago --}}

    {{-- Modal de resumen/confirmación del nuevo pago --}}
    <div class="modal fade" data-backdrop="static" id="summaryConciliation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h3 class="modal-title title-mdl text-uppercase" id="exampleModalLabel align-items-between">RESUMEN DE CONCILIACIÓN DE PAGO</h3>
                </div>
                <div class="modal-body">
                        <form id="validationform" action="{{ route('payments.update', $unpayment->idPay) }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_id" id="payment_id">

                            <div class="form-group d-flex justify-content-between">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="col-form-label">Alumno</label>
                                        </div>
                                        <div class="col-9">
                                            <div class="py-2 px-0">
                                                <input type="hidden" name="userId" id="user_id" readonly>
                                                <input id="user_person_name" class="form-summary summary" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <label class="col-form-label">Compra</label>
                                        </div>
                                        <div class="col-9">
                                            <div class="py-2 px-0">
                                                <input id="accService" name="id_account" type="hidden">
                                                <input id="sale_invoice" class="form-summary summary text-uppercase" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <label class="col-form-label">Fecha de pago</label>
                                        </div>
                                        <div class="col-9">
                                        <div class="py-2 px-0">
                                            <input type="date" id="pay_date" class="form-summary summary" readonly>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <label class="col-form-label">Método</label>
                                        </div>
                                        <div class="col-9">
                                            <div class="py-2 px-0">
                                                <input id="type_name_pay" class="form-summary summary" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <label class="col-form-label">Monto</label>
                                        </div>
                                        <div class="col-9">
                                            <div class="py-2 px-0">
                                                <input type="number" min="0" id="amount_pay" class="form-summary summary" readonly>
                                            </div>
                                        </div>
                                    </div>
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
                                            <input name="invoice" id="folio" type="text" class="form-summary summary text-uppercase" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-form-label">Comentario</label>
                                            <input name="comment" id="comment_user" class="form-summary summary text-uppercase" id="commentUser" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="code_rule" id="codeRule">
                            
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
@endif

{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<script src="{{ asset('assets/libs/js/Vue/vue.js') }}"></script>
<script src="{{ asset('assets/libs/js/axios.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

{{-- Abrir modal para conciliar pago --}}
<script>
    function reconcilePayment(idPay, payDate, typePayName, payInvoice, payAmount) {
        $('#idPay').val(idPay);
        $('#payDate').val(payDate);
        $('#typePayName').val(typePayName);
        $('#payInvoice').val(payInvoice);
        $('#payAmount').val(payAmount);

        $('#conciliationPayment').modal('show');
    }
</script>
{{-- Fin de modal para conciliar pago --}}

{{-- Selector dinámico de cuenta-alumno --}}
<script type="text/javascript">
    var app = new Vue({
        el: '#app',
        data: {
            selected_user: '',
            selected_account: '',
            accounts: [],
        },
        mounted() {
            document.getElementById('accountId').disabled = true;
            
            this.selected_user = document.getElementById('userId').getAttribute('data-old');
            if (this.selected_user != '') {
                loadAccounts();
            }

            this.selected_user = document.getElementById('accountId').getAttribute('data-old');
        },
        methods: {
            loadAccounts() {
                document.getElementById('accountId').disabled = true;
                this.selected_account = '';

                if (this.selected_user != '') {
                    console.log(this.selected_user);
                    axios.get( 'accounts/'+this.selected_user ).then(response => {
                        this.accounts = response.data.listAccount;
                        document.getElementById('accountId').disabled = false;
                    });
                }
            }
        }
    });
</script>
{{-- Fin de Selector dinámico de cuenta-alumno --}}

<script>
    $(document).ready(function() {
        $(document).on('click', '#accept', function() {
            var paymentId = document.getElementById("idPay").value;
            var userId = document.getElementById("userId").value;
            var userPersonName = $("#userId option:selected").text();
            var accountId = document.getElementById("accountId").value;
            var saleInvoice = $("#accountId option:selected").text();
            var paymentDate = document.getElementById("payDate").value;
            var paymentType = document.getElementById("typePayName").value;
            var accountBank = document.getElementById("accountBank").value;
            var accountNameBank = $("#accountBank option:selected").text();
            var payInvoice = document.getElementById("payInvoice").value;
            var payAmount = document.getElementById("payAmount").value;
            var comment = document.getElementById("comment").value;

            console.log(userPersonName);
            console.log(saleInvoice);
            console.log(accountNameBank);
            $("#conciliationPayment").modal('hide');
            $('#summaryConciliation').modal('show');

            document.querySelector("#payment_id").value = paymentId;
            document.querySelector("#user_id").value = userId;
            document.querySelector("#user_person_name").value = userPersonName;
            document.querySelector("#accService").value = accountId;
            document.querySelector("#sale_invoice").value = saleInvoice;
            document.querySelector("#pay_date").value = paymentDate;
            document.querySelector("#type_name_pay").value = paymentType;
            document.querySelector("#acc_bank").value = accountBank;
            document.querySelector("#acc_name_bank").value = accountNameBank;
            document.querySelector("#folio").value = payInvoice;
            document.querySelector("#amount_pay").value = payAmount;
            document.querySelector("#comment_user").value = comment;

            $(document).on('click', '#cancel', function() {
                $('#summaryConciliation').modal('hide');
                $("#conciliationPayment").modal('show');
            })
        });
    });
</script>
    
@endsection