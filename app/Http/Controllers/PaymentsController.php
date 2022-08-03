<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Payment_detail;
use App\Models\Account;
use App\Models\Account_calendar_detail;
use App\Models\Sale;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_payments(Request $request)
    {   
        $today = Date('Y-m-d');
        // Sumando una semana a la fecha actual
        $untilDay = strtotime($today . "+ 7 days");
        $lateDays = strtotime($today . "- 3 days");

        $paymentMethods=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_PAYMENT')
            ->select('cat_catalogs.*')
            ->get();

        if ($request) {
            $name = trim($request->get('name'));
            $dateInitial = trim($request->get('dateInit'));
            $dateFinish = trim($request->get('dateFinish'));
            $method = $request->get('method');

            //Sólo Nombre
            if ($name != null && $dateInitial == null && $dateFinish == null && $method == null) {
                //dd($name);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%') 
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Sólo por fecha
            elseif ($dateInitial != null && $dateFinish == null && $name == null && $method == null) {
                //dd($dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('payment.payment_date', $dateInitial)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('payment.payment_date', 'desc')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Sólo rango de fechas
            elseif ($dateInitial != null && $dateFinish != null && $name == null && $method == null) {
                //dd($dateFinish);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', '=', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('payment.payment_date', '>=', $dateInitial)
                    ->where('payment.payment_date', '<=', $dateFinish)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('payment.payment_date', 'desc')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Sólo método de pago
            elseif ($method != null && $name == null && $dateInitial == null && $dateFinish == null ) {
                //dd($method);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', '=', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('payment.payment_type_code', '=', $method)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('payment.payment_date', 'desc')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por Nombre y fecha
            elseif ($name != null && $dateInitial != null && $dateFinish == null && $method == null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('payment.payment_date', '=', $dateInitial)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por Nombre y rango de fechas
            elseif ($name != null && $dateInitial != null && $dateFinish != null && $method == null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('payment.payment_date', '>=', $dateInitial)
                    ->where('payment.payment_date', '<=', $dateFinish)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();
            
                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por Nombre y método de pago
            elseif ($name != null && $dateInitial == null && $dateFinish == null && $method != null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('payment.payment_type_code', '=', $method)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por Nombre, fecha y método de pago
            elseif ($name != null && $dateInitial != null && $dateFinish == null && $method != null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('payment.payment_date', '=', $dateInitial)
                    ->where('payment.payment_type_code', '=', $method)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();
                        
                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por fecha y método de pago
            elseif ($name == null && $dateInitial != null && $dateFinish == null && $method != null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('payment.payment_date', '=', $dateInitial)
                    ->where('payment.payment_type_code', '=', $method)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por rango de fechas y método de pago
            elseif ($name == null && $dateInitial != null && $dateFinish != null && $method != null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('payment.payment_date', '>=', $dateInitial)
                    ->where('payment.payment_date', '<=', $dateFinish)
                    ->where('payment.payment_type_code', '=', $method)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();

                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
            //Por todos los filtros
            elseif ($name != null && $dateInitial != null && $dateFinish != null && $method != null) {
                //dd($name . ' ' . $dateInitial);
                $payments = Payment::join('account', 'account.id', 'payment.id_account')
                    ->join('sales', 'sales.id', 'account.id_sale')
                    ->where('payment.is_active', 1)
                    ->where('payment.status', '=', 'IDENTIFICADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('payment.payment_date', '>=', $dateInitial)
                    ->where('payment.payment_date', '<=', $dateFinish)
                    ->where('payment.payment_type_code', '=', $method)
                    ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->get();
            
                return view('payments.all', compact('payments', 'today', 'paymentMethods'));
            }
        }

        // Pagos realizados
        $payments = Payment::join('account', 'account.id', 'payment.id_account')
            ->join('sales', 'sales.id', 'account.id_sale')
            ->where('payment.is_active', 1)
            ->where('payment.status', '=', 'IDENTIFICADO')
            ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_type_name as typePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            ->orderBy('payment.payment_date', 'desc')
            ->get();

        return view('payments.all', compact('payments', 'today', 'paymentMethods'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function late_payments(Request $request)
    {   
        $today = Date('Y-m-d');
        // Sumando una semana a la fecha actual
        $untilDay = strtotime($today . "+ 7 days");
        $lateDays = strtotime($today . "- 3 days");

        if ($request) {
            $name = trim($request->get('name'));
            $dateInitial = $request->get('dateInit');
            // $dateFinish = trim($request->get('dateFinish'));

            //Sólo Nombre
            if ($name != null && $dateInitial == null) {
                //dd($name);
                $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
                    ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
                    ->where('account.is_active', 1)
                    ->where('account_calendar_detail.is_active', 1)
                    ->where('account_calendar_detail.status', '!=', 'PAGADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%') 
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('account_calendar_detail.date_calendar', '<=', Date('Y-m-d', $lateDays))
                    ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('account_calendar_detail.date_calendar', 'desc')
                    ->get();

                return view('payments.late', compact('late_payments', 'today'));
            }   
            //Sólo por fecha
            elseif ($dateInitial != null && $name == null) {
                $lateDay = strtotime($dateInitial . "- 3 days");

                $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
                    ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
                    ->where('account.is_active', 1)
                    ->where('account_calendar_detail.is_active', 1)
                    ->where('account_calendar_detail.status', '!=', 'PAGADO')
                    ->where('account_calendar_detail.date_calendar', '<=', $dateInitial)
                    ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('account_calendar_detail.date_calendar', 'desc')
                    ->get();

                return view('payments.late', compact('late_payments', 'today'));
            }
            //Sólo rango de fechas
            // elseif ($dateInitial != null && $dateFinish != null && $name == null) {
            //     $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            //         ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            //         ->where('account.is_active', 1)
            //         ->where('account_calendar_detail.is_active', 1)
            //         ->where('account_calendar_detail.status', '!=', 'PAGADO')
            //         ->where('account_calendar_detail.date_calendar', '>=', $dateInitial)
            //         ->where('account_calendar_detail.date_calendar', '<=', $dateFinish)
            //         ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            //         ->orderBy('account_calendar_detail.date_calendar', 'desc')
            //         ->get();

            //     return view('payments.late', compact('late_payments', 'today'));
            // }
            //Por Nombre y fecha
            // elseif ($name != null && $dateInitial != null && $dateFinish == null) {
            //     $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            //         ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            //         ->where('account.is_active', 1)
            //         ->where('account_calendar_detail.is_active', 1)
            //         ->where('account_calendar_detail.status', '!=', 'PAGADO')
            //         ->where('account.name_user', 'LIKE', '%' . $name . '%')
            //         ->where('account_calendar_detail.date_calendar', '=', $dateInitial)
            //         ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            //         ->orderBy('account_calendar_detail.date_calendar', 'desc')
            //         ->get();

            //     return view('payments.late', compact('late_payments', 'today'));
            // }
            //Por todos los filtros
            elseif ($name != null && $dateInitial != null) {
                $lateDays = strtotime($dateInitial . "- 3 days");

                $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
                    ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
                    ->where('account.is_active', 1)
                    ->where('account_calendar_detail.is_active', 1)
                    ->where('account_calendar_detail.status', '!=', 'PAGADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%')
                    ->where('account_calendar_detail.date_calendar', '<=', $dateInitial)
                    ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('account_calendar_detail.date_calendar', 'desc')
                    ->get();

                return view('payments.late', compact('late_payments', 'today'));
            }
        }

        // Pagos atrasados
        $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            ->where('account.is_active', 1)
            ->where('account_calendar_detail.is_active', 1)
            ->where('account_calendar_detail.status', '!=', 'PAGADO')
            ->where('account_calendar_detail.date_calendar', '<=', Date('Y-m-d', $lateDays))
            ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            ->orderBy('account_calendar_detail.date_calendar', 'desc')
            ->get();

        return view('payments.late', compact('late_payments', 'today'));
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function due_payments(Request $request)
    {   
        $today = Date('Y-m-d');
        // Sumando una semana a la fecha actual
        $untilDay = strtotime($today . "+ 7 days");
        $lateDays = strtotime($today . "- 3 days");

        if ($request) {
            $name = trim($request->get('name'));
            $dateInitial = trim($request->get('dateInit'));
            // $dateFinish = trim($request->get('dateFinish'));

            //Sólo Nombre
            if ($name != null && $dateInitial == null) {
                $due_payments = Sale::join('account', 'account.id_sale', 'sales.id')
                    ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
                    ->where('account.is_active', 1)
                    ->where('account_calendar_detail.is_active', 1)
                    ->where('account_calendar_detail.status', '!=', 'PAGADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%') 
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('account_calendar_detail.date_calendar', '>=', Date('Y-m-d'))
                    ->where('account_calendar_detail.date_calendar', '<', Date('Y-m-d', $untilDay))
                    ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('account_calendar_detail.date_calendar', 'asc')
                    ->get();

                return view('payments.due', compact('due_payments', 'today'));
            }   
            //Sólo por fecha
            elseif ($dateInitial != null && $name == null) {
                $untilDay = strtotime($dateInitial . "+ 7 days");
                
                $due_payments = Sale::join('account', 'account.id_sale', 'sales.id')
                    ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
                    ->where('account.is_active', 1)
                    ->where('account_calendar_detail.is_active', 1)
                    ->where('account_calendar_detail.status', '!=', 'PAGADO')
                    ->where('account_calendar_detail.date_calendar', '>=', $dateInitial)
                    ->where('account_calendar_detail.date_calendar', '<', Date('Y-m-d', $untilDay))
                    ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('account_calendar_detail.date_calendar', 'asc')
                    ->get();

                return view('payments.due', compact('due_payments', 'today'));
            }
            //Sólo rango de fechas
            // elseif ($dateInitial != null && $dateFinish != null && $name == null) {
            //     $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            //         ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            //         ->where('account.is_active', 1)
            //         ->where('account_calendar_detail.is_active', 1)
            //         ->where('account_calendar_detail.status', '!=', 'PAGADO')
            //         ->where('account_calendar_detail.date_calendar', '>=', $dateInitial)
            //         ->where('account_calendar_detail.date_calendar', '<=', $dateFinish)
            //         ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            //         ->orderBy('account_calendar_detail.date_calendar', 'desc')
            //         ->get();

            //     return view('payments.late', compact('late_payments', 'today'));
            // }
            //Por Nombre y fecha
            // elseif ($name != null && $dateInitial != null && $dateFinish == null) {
            //     $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            //         ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            //         ->where('account.is_active', 1)
            //         ->where('account_calendar_detail.is_active', 1)
            //         ->where('account_calendar_detail.status', '!=', 'PAGADO')
            //         ->where('account.name_user', 'LIKE', '%' . $name . '%')
            //         ->where('account_calendar_detail.date_calendar', '=', $dateInitial)
            //         ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'account_calendar_detail.status', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            //         ->orderBy('account_calendar_detail.date_calendar', 'desc')
            //         ->get();

            //     return view('payments.late', compact('late_payments', 'today'));
            // }
            //Por todos los filtros
            elseif ($name != null && $dateInitial != null) {
                $untilDay = strtotime($dateInitial . "+ 7 days");
                
                $due_payments = Sale::join('account', 'account.id_sale', 'sales.id')
                    ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
                    ->where('account.is_active', 1)
                    ->where('account_calendar_detail.is_active', 1)
                    ->where('account_calendar_detail.status', '!=', 'PAGADO')
                    ->where('account.name_user', 'LIKE', '%' . $name . '%') 
                    // ->orWhere('account.last_father_name_user', 'LIKE', '%' . $name . '%')
                    // ->orWhere('account.last_mother_name_user', 'LIKE', '%' . $name . '%')
                    ->where('account_calendar_detail.date_calendar', '>=', $dateInitial)
                    ->where('account_calendar_detail.date_calendar', '<', Date('Y-m-d', $untilDay))
                    ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
                    ->orderBy('account_calendar_detail.date_calendar', 'asc')
                    ->get();

                return view('payments.due', compact('due_payments', 'today'));
            }
        }

        // Pagos por vencer
        $due_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            ->where('account.is_active', 1)
            ->where('account_calendar_detail.is_active', 1)
            ->where('account_calendar_detail.status', '!=', 'PAGADO')
            ->where('account_calendar_detail.date_calendar', '>=', Date('Y-m-d'))
            ->where('account_calendar_detail.date_calendar', '<', Date('Y-m-d', $untilDay))
            ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            ->orderBy('account_calendar_detail.date_calendar', 'asc')
            ->get();

        return view('payments.due', compact('due_payments', 'today'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unidentifiedPayments()
    {      
        $accounts_bank=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_BANK')
            ->select('cat_catalogs.*')
            ->get();

        $unpayments = Payment::join('account', 'account.id', 'payment.id_account')
            ->join('sales', 'sales.id', 'account.id_sale')
            //->select('payment.id', 'payment.folio', 'payment.payment_type_code', 'payment.payment_date', 'payment.amount', 'payment.status', 'sales.folio as saleInvoice')
            ->where('payment.is_active', 1)
            ->where('payment.status', 'NO IDENTIFICADO')
            //->where('sales.id_student', $student->id)
            ->select('payment.id as idPay', 'payment.folio as payInvoice', 'payment.status as payStatus', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'payment.payment_type_code as typePaymentCode', 'payment.payment_type_name as typePaymentName', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
            ->get();

        return view('payments.unpayments', compact('unpayments', 'accounts_bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getAccounts($userId)
    {   
        //dd($request);
        if ($userId) {
            $accounts = Account::join('sales', 'sales.id', 'account.id_sale')
                ->select('account.id as accountId', 'account.id_user as userId', 'sales.folio as saleInvoice')
                ->where('account.id_user', $userId)
                ->where('account.status', '!=', 'PAGADO')
                ->orderBy('account.id', 'asc')
                ->get();

            foreach ($accounts as $account) {
                $accountsList[$account->accountId] = $account->saleInvoice;
            }

            //return response()->json($accountsList);
            return response()->json([
                'message' => 'Datos obtenidos',
                'listAccount' => $accounts
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //dd($request);
        //Registro de un nuevo ingreso (pago) no indentificado
        $payment = new Payment();
        $payment->id_account = $request->input('id_account');
        $payment->id_cat_currency = 1;
        $payment->currency_name = 'PESOS MEXICANOS';
        $payment->currency_code = 'MXN';
        $payment->method_code = $request->input('code_rule');
        $payment->payment_type_name = $request->input('payment_type_name');
        $payment->payment_type_code = $request->input('payment_type_code');
        $payment->folio = $request->input('invoice');
        $payment->payment_date = $request->input('payment_date');
        $payment->amount = $request->input('amount');
        $payment->user_comment = $request->input('comment');
        if ($request->hasFile('source')) {
            $file = $request->file('source');
            $destinyPath = 'payments/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('source')->move($destinyPath, $fileName);
            $payment->source = $uploadFile/* $destinyPath . $fileName */;
        }
        $payment->id_account_bank = $request->input('id_account_bank');
        
        $account_bank = DB::table('cat_catalogs')
            ->select('label', 'code2')
            ->where('is_active', 1)
            ->where('id', $payment->id_account_bank)
            ->first();
        
        $payment->label_account_bank = $account_bank->label;
        $payment->code_account_bank = $account_bank->code2;
        $payment->system_comment = 'REGISTRO DE PAGO';
        $payment->status = 'NO IDENTIFICADO';
        $payment->is_active = 1;
        $payment->id_adm_organization = Auth::user()->id;
        $payment->created_by = Auth::user()->id;
        $payment->save();

        //Variable para obtener el monto pagado
        $payAmount=$payment->amount;
        //Datos de la cuenta
        $account = Account::where('id', $payment->id_account)
        ->where('is_active', 1)
        ->first();
        
        //Detalles del calendario de pagos que corresponde a la cuenta
        $account_calendar_detail = Account_calendar_detail::where('id_account', $account->id)
            ->where('is_active', 1)
            ->where('status', '!=' , 'PAGADO')
            ->get();
        //dd($account_calendar_detail);
        //obtener el saldo total
        /* $saldo_total = DB::select('SELECT sum(acd.original_amount - pd.amount) as saldo_total FROM payment as p 
            INNER JOIN payment_detail as pd ON p.id=pd.id_payment 
            INNER JOIN account_calendar_detail as acd ON pd.id_account_calendar_detail = acd.id
            INNER JOIN account as a ON acd.id_account = a.id
            WHERE a.id = :id_account    
            AND p.status="IDENTIFICADO"
            AND acd.status="PENDIENTE"
            AND p.is_active=1
            AND pd.is_active=1
            AND acd.is_active=1
            AND a.is_active=1
            GROUP BY a.id', ['id_account'=>$account->id]); */
        $studentId = $request->input('studentId');

        $is_payment_ok = false;

        foreach( $account_calendar_detail as $acc_cal_det ) {
            // Sí aún queda saldo para abonar el siguiente vencimiento
            if ($payAmount > 0) {
                $id_acd = Account_calendar_detail::where('id_account', $account->id)
                    ->where('is_active', 1)
                    ->where('status', '!=' , 'PAGADO')
                    ->first();

                $saldo_parcial = DB::select('SELECT acd.original_amount - sum(pd.amount) as saldo_total_vencimiento FROM payment as p 
                    INNER JOIN payment_detail as pd ON p.id=pd.id_payment 
                    INNER JOIN account_calendar_detail as acd ON pd.id_account_calendar_detail = acd.id
                    INNER JOIN account as a ON acd.id_account = a.id
                    WHERE pd.id_account_calendar_detail = :id_acc_cal_det
                    AND p.status="IDENTIFICADO"
                    AND acd.status="PENDIENTE"
                    AND p.is_active=1
                    AND pd.is_active=1
                    AND acd.is_active=1
                    AND a.is_active=1
                    GROUP BY acd.id', ['id_acc_cal_det' => $acc_cal_det->id]);

                $first_payment = DB::table('account_calendar_detail')
                    ->where('id_account', $payment->id_account)
                    ->select('original_amount')
                    ->first();
                    
                if (count($saldo_parcial) > 0) {
                    $saldo_vencimiento = $saldo_parcial[0]->saldo_total_vencimiento;
                } else { $saldo_vencimiento = $first_payment->original_amount; }

                $accountId = $account->id;
                //dd($payment->method_code);
                if($account->code_rule == 'SYST_UNO_PAYMENT') // PAGOS DE CONTADO
                {
                    if($payAmount >= $saldo_vencimiento) { //PAGO DE CONTADO EN UNA SOLA EXHIBICIÓN
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail(); 
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $acc_cal_det->payment_amount; 
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'REGISTRO DE PAGO';
                        $payment_calendar_detail->status = 'COMPLETADO';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        $payment_calendar_detail->save();

                        //Actualizamos variable del Monto del Pago 
                        //si es mayor al saldo del vencimiento lo actualizamos a 0
                        $payAmount=0;

                        //Se actualiza el status del account_calendar detail
                        $update_account_calendar_detail = Account_calendar_detail::findOrFail($payment_calendar_detail->id_account_calendar_detail);
                        $update_account_calendar_detail->status = 'PAGADO';
                        $update_account_calendar_detail->save();

                        // Se verifica la cantidad de vencimientos 'PAGADOS'
                        $paid_dates = Account_calendar_detail::where('status', 'PAGADO')
                            ->where('id_account', $accountId)
                            ->count();
                        // Se verifica la cantidad de vencimientos totales
                        $total_dates = Account_calendar_detail::where('id_account', $accountId)->count();
                        // Se actualiza el cambio de status de la cuenta si todos los vencimientos asociados a esta están 'PAGADOS'
                        if ($paid_dates == $total_dates) {
                            $update_account_status = Account::findOrFail($accountId);
                            $update_account_status->status = 'PAGADO';
                            $update_account_status->save();
                        }

                        $is_payment_ok = true;
                    } else { //PAGO DE CONTADO EN PARCIALIDADES
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail(); 
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $payment->payment_amount;
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'Algo';
                        $payment_calendar_detail->status = 'PARCIAL';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        //dd($payment_calendar_detail);
                        //dd($payAmount);
                        $payment_calendar_detail->save();

                        $payAmount=0;

                        $is_payment_ok =true; 
                    }              
                }
                else //PAGOS A CREDITO
                {
                    if($payAmount >= $saldo_vencimiento) {
                        $exchange = $payAmount - $saldo_vencimiento;
                        $payAmount = $saldo_vencimiento;
                        
                        //dd($exchange);
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail();
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $acc_cal_det->payment_amount; 
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'REGISTRO DE PAGO';
                        $payment_calendar_detail->status = 'COMPLETADO';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        $payment_calendar_detail->save();

                        //Actualizamos variable del Monto del Pago 
                        //si es mayor al saldo del vencimiento lo actualizamos a 0
                        $payAmount = $exchange;
                        //dd($payAmount);
                        //Se actualiza el status del account_calendar detail
                        $update_account_calendar_detail = Account_calendar_detail::findOrFail($payment_calendar_detail->id_account_calendar_detail);
                        $update_account_calendar_detail->status = 'PAGADO';
                        $update_account_calendar_detail->save();

                        // Se verifica la cantidad de vencimientos 'PAGADOS'
                        $paid_dates = Account_calendar_detail::where('status', 'PAGADO')
                            ->where('id_account', $accountId)
                            ->count();
                        // Se verifica la cantidad de vencimientos totales
                        $total_dates = Account_calendar_detail::where('id_account', $accountId)->count();
                        // Se actualiza el cambio de status de la cuenta si todos los vencimientos asociados a esta están 'PAGADOS'
                        if ($paid_dates == $total_dates) {
                            $update_account_status = Account::findOrFail($accountId);
                            $update_account_status->status = 'PAGADO';
                            $update_account_status->save();
                        }

                        $is_payment_ok = true;
                    } else { // PAGOS PARCIALES A CRÉDITO
                        //$amPyment = $payAmount - $saldo_vencimiento;
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail();
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $payment->payment_amount;
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'Algo';
                        $payment_calendar_detail->status = 'PARCIAL';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        //dd($payment_calendar_detail);
                        $payment_calendar_detail->save();

                        $payAmount=0;
                        //dd($payAmount);
                            
                        $is_payment_ok =true;  
                    }              
                }
            }

        }//foreach

        if ($is_payment_ok = true) {
            //Se actualiza el status
            $payment = Payment::findOrFail($payment->id);
            $payment->status = 'IDENTIFICADO';
            $payment->save();
            
            Session::flash('message','Pago registrado exitósamente');
            return redirect()->action('App\Http\Controllers\StudentsController@accountState', $studentId);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) // "Conciliación" de pagos
    {
        //Reasignación de ingreso (pago) no indentificado
        $payment = Payment::findOrFail($id);
        $payment->id_account = $request->input('id_account');
        $payment->id_account_bank = $request->input('id_account_bank');
        $payment->user_comment = $request->input('comment');

        $account_bank = DB::table('cat_catalogs')
            ->select('label', 'code')
            ->where('is_active', 1)
            ->where('id', $payment->id_account_bank)
            ->first();
        
        $payment->label_account_bank = $account_bank->label;
        $payment->code_account_bank = $account_bank->code2;
        $payment->folio = $request->input('invoice');

        //Variable para obtener el monto pagado
        $payAmount=$payment->amount;

        //Datos de la cuenta
        $account = Account::where('id', $payment->id_account)
        ->where('is_active', 1)
        ->first();
        
        //Detalles del calendario de pagos que corresponde a la cuenta
        $account_calendar_detail = Account_calendar_detail::where('id_account', $account->id)
            ->where('is_active', 1)
            ->where('status', '!=' , 'PAGADO')
            ->get();

        $studentId = $request->input('studentId');

        $is_payment_ok = false;

        foreach( $account_calendar_detail as $acc_cal_det ) {
            // Sí aún queda saldo para abonar el siguiente vencimiento
            if ($payAmount > 0) {
                $id_acd = Account_calendar_detail::where('id_account', $account->id)
                    ->where('is_active', 1)
                    ->where('status', '!=' , 'PAGADO')
                    ->first();
                //dd($id_acd);
                $saldo_parcial = DB::select('SELECT acd.original_amount - sum(pd.amount) as saldo_total_vencimiento FROM payment as p 
                    INNER JOIN payment_detail as pd ON p.id=pd.id_payment 
                    INNER JOIN account_calendar_detail as acd ON pd.id_account_calendar_detail = acd.id
                    INNER JOIN account as a ON acd.id_account = a.id
                    WHERE pd.id_account_calendar_detail = :id_acc_cal_det
                    AND p.status="IDENTIFICADO"
                    AND acd.status="PENDIENTE"
                    AND p.is_active=1
                    AND pd.is_active=1
                    AND acd.is_active=1
                    AND a.is_active=1
                    GROUP BY acd.id', ['id_acc_cal_det' => $acc_cal_det->id]);

                $first_payment = DB::table('account_calendar_detail')
                    ->where('id_account', $payment->id_account)
                    ->select('original_amount')
                    ->first();
                    
                if (count($saldo_parcial) > 0) {
                    $saldo_vencimiento = $saldo_parcial[0]->saldo_total_vencimiento;
                } else { $saldo_vencimiento = $first_payment->original_amount; }

                $accountId = $account->id;
                //dd($payment->method_code);
                if($account->code_rule == 'SYST_UNO_PAYMENT') // PAGOS DE CONTADO
                {
                    if($payAmount >= $saldo_vencimiento) { //PAGO DE CONTADO EN UNA SOLA EXHIBICIÓN
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail(); 
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $acc_cal_det->payment_amount; 
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'REGISTRO DE PAGO';
                        $payment_calendar_detail->status = 'COMPLETADO';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        $payment_calendar_detail->save();

                        //Actualizamos variable del Monto del Pago 
                        //si es mayor al saldo del vencimiento lo actualizamos a 0
                        $payAmount=0;

                        //Se actualiza el status del account_calendar detail
                        $update_account_calendar_detail = Account_calendar_detail::findOrFail($payment_calendar_detail->id_account_calendar_detail);
                        $update_account_calendar_detail->status = 'PAGADO';
                        $update_account_calendar_detail->save();

                        // Se verifica la cantidad de vencimientos 'PAGADOS'
                        $paid_dates = Account_calendar_detail::where('status', 'PAGADO')
                            ->where('is_active', 1)
                            ->where('id_account', $accountId)
                            ->count();
                        // Se verifica la cantidad de vencimientos totales
                        $total_dates = Account_calendar_detail::where('id_account', $accountId)->count();
                        // Se actualiza el cambio de status de la cuenta si todos los vencimientos asociados a esta están 'PAGADOS'
                        if ($paid_dates == $total_dates) {
                            $update_account_status = Account::findOrFail($accountId);
                            $update_account_status->status = 'PAGADO';
                            $update_account_status->save();
                        }

                        $is_payment_ok = true;
                    } else { //PAGO DE CONTADO EN PARCIALIDADES
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail(); 
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $payment->payment_amount;
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'Algo';
                        $payment_calendar_detail->status = 'PARCIAL';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        //dd($payment_calendar_detail);
                        //dd($payAmount);
                        $payment_calendar_detail->save();

                        $payAmount=0;

                        $is_payment_ok =true; 
                    }              
                }
                else //PAGOS A CREDITO
                {
                    if($payAmount >= $saldo_vencimiento) {
                        $exchange = $payAmount - $saldo_vencimiento;
                        $payAmount = $saldo_vencimiento;
                        
                        //dd($exchange);
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail();
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $acc_cal_det->payment_amount; 
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'REGISTRO DE PAGO';
                        $payment_calendar_detail->status = 'COMPLETADO';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        $payment_calendar_detail->save();

                        //Actualizamos variable del Monto del Pago 
                        //si es mayor al saldo del vencimiento lo actualizamos a 0
                        $payAmount = $exchange;
                        //dd($payAmount);
                        //Se actualiza el status del account_calendar detail
                        $update_account_calendar_detail = Account_calendar_detail::findOrFail($payment_calendar_detail->id_account_calendar_detail);
                        $update_account_calendar_detail->status = 'PAGADO';
                        $update_account_calendar_detail->save();

                        // Se verifica la cantidad de vencimientos 'PAGADOS'
                        $paid_dates = Account_calendar_detail::where('status', 'PAGADO')
                            ->where('id_account', $accountId)
                            ->count();
                        // Se verifica la cantidad de vencimientos totales
                        $total_dates = Account_calendar_detail::where('id_account', $accountId)->count();
                        // Se actualiza el cambio de status de la cuenta si todos los vencimientos asociados a esta están 'PAGADOS'
                        if ($paid_dates == $total_dates) {
                            $update_account_status = Account::findOrFail($accountId);
                            $update_account_status->status = 'PAGADO';
                            $update_account_status->save();
                        }

                        $is_payment_ok = true;
                    } else { // PAGOS PARCIALES A CRÉDITO
                        //$amPyment = $payAmount - $saldo_vencimiento;
                        //Se crea el registro en payment_calendar_detail
                        $payment_calendar_detail = new Payment_detail();
                        $payment_calendar_detail->id_payment = $payment->id;
                        $payment_calendar_detail->id_account_calendar_detail = $id_acd->id; // O consulta SQL
                        $payment_calendar_detail->folio = $payment->folio;
                        //$payment_calendar_detail->description
                        $payment_calendar_detail->payment_date = $payment->payment_date;
                        $payment_calendar_detail->payment_amount = $payment->payment_amount;
                        $payment_calendar_detail->tax_payment_amount = $acc_cal_det->tax_payment_amount; // O consulta SQL
                        $payment_calendar_detail->amount = $payAmount;
                        //$payment_calendar_detail->percentage_tax_amount = 
                        $payment_calendar_detail->user_comment = $payment->user_comment;
                        $payment_calendar_detail->system_comment = 'Algo';
                        $payment_calendar_detail->status = 'PARCIAL';
                        $payment_calendar_detail->is_active = 1;
                        $payment_calendar_detail->id_adm_organization = Auth::user()->id;
                        //$payment_calendar_detail->name_adm_organization
                        $payment_calendar_detail->created_by = Auth::user()->id;
                        //dd($payment_calendar_detail);
                        $payment_calendar_detail->save();

                        $payAmount=0;
                        //dd($payAmount);
                            
                        $is_payment_ok =true;  
                    }              
                }
            }

        }//foreach

        if ($is_payment_ok = true) {
            //Se actualiza el status
            $payment->status = 'IDENTIFICADO';
            $payment->system_comment = 'CONCILIACIÓN DE PAGO CANCELADO';
            $payment->updated_by = Auth::user()->id;
            $payment->updated_at = Date(now());

            // $payment = Payment::findOrFail($payment->id);
            // $payment->status = 'IDENTIFICADO';
            $payment->save();
            
            Session::flash('message','Pago IDENTIFICADO con éxito');
            return redirect()->action('App\Http\Controllers\PaymentsController@unidentifiedPayments');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $studentId = $request->input('studentId');
        $payment = Payment::findOrFail($request['delete']);
        $payment->status = 'NO IDENTIFICADO';
        $payment_calendar_detail = Payment_detail::where('id_payment', $payment->id)->get();
        foreach ($payment_calendar_detail as $pcd) {
            $pcd->is_active = 0;
            $pcd->status = 'CANCELADO';
            $account_calendar_detail = Account_calendar_detail::where('id', $pcd->id_account_calendar_detail)->first();
            if ($account_calendar_detail->status == 'PAGADO') {
                $account_calendar_detail->status = 'PENDIENTE';
            }
            $account = Account::where('id', $account_calendar_detail->id_account)->first();
            if ($account->status == 'PAGADO') {
                $account->status = 'PENDIENTE';
            }

            $pcd->save();
            $account_calendar_detail->save();
            $account->save();
        }

        $payment->save(); //Guarda los datos en la BD
        Session::flash('message','El pago ha sido cancelado correctamente');
        return redirect()->action('App\Http\Controllers\StudentsController@accountState', $studentId);
    }

    // Funciones para los filtros de búsqudea
    // public function paymentFrom(Request $request) 
    // {
    //     // if ($request['name'] OR /* $request->get('dateInit') AND $request->get('datefinish') OR */$request['method']) {
            
    //     // }
    //     $student = trim($request->get('name'));
    //         $method = $request->get('method');

    //         $payments = Payment::join('account', 'account.id', 'payment.id_account')
    //         ->join('sales', 'sales.id', 'account.id_sale')
    //         ->where('payment.is_active', 1)
    //         ->where('payment.status', 'IDENTIFICADO')
    //         ->where('account.name_user', 'LIKE', '%' . $student . '%')
    //         // ->orWhere('sales.type_payment', 'LIKE', $method)
    //         ->select('payment.folio as payInvoice', 'payment.status as payStatus', 'sales.type_payment as saleTypePayment', 'payment.payment_date', 'payment.amount as payAmount', 'sales.folio as saleInvoice', 'account.name_user as name', 'account.last_father_name_user as lastFName', 'account.last_mother_name_user as lastMName')
    //         ->get();

    //         return view('payments.index', compact('payments'));
    // }
}
