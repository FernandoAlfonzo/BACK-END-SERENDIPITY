<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Person;
use App\Models\addres;
use App\Models\Generations;
use App\Models\Collaborator;
use App\Models\RulePayment;
use App\Models\commercial_product;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\cat_catalog;
use App\Models\Student;
use App\Models\Account;
use App\Models\Account_calendar_detail;
use App\Models\user_role;
use Str;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Hash;

class SalesController extends Controller
{
    public function BuyService(Request $request)
    {
        $data = $request->only('id_user','type_payment_code','total', 'subtotal', 'iva', 'listOfertSold', 'code_paymet_rules','code_salesman');
        $data_new_user = $request->only('name','last_father_name','last_mother_name', 'phone','id_country', 'state', 'email');

        $validator = Validator::make($data, [
            'type_payment_code' => 'required',
            'total' => 'required',
            'subtotal' => 'required',
            'listOfertSold' => 'required',
        ],[
            'type_payment_code.required' => 'Tipo de pago requerido',
            'total.required' => 'Total pagado es requerido',
            'listOfertSold.required' => 'Id de la generación es requerido'
        ]);

        ///validar si es una compra de fuera
        $id_user = $request['id_user'];
        $type_payment_code = $request['type_payment_code'];
        $total = $request['total'];
        $subtotal = $request['subtotal'];
        $iva = $request['iva'];
        $listOfertSold = $request['listOfertSold'];
        $code_paymet_rules = $request['code_paymet_rules'];
        $code_salesman = $request['code_salesman'];

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        if($id_user == null && $id_user == ""){
            $validator_new_user = Validator::make($data_new_user, [
                'name' => 'required',
                'last_father_name' => 'required',
                'phone' => 'required',
                'id_country' => 'required',
                'state' => 'required',
                'email' => 'required',
            ],[
                'name.required' => 'Nombre es requerido',
                'last_father_name.required' => 'Apellido paterno requerido',
                'phone.required' => 'El número de teléfono es requerido',
                'id_country.required' => 'El país es requerido',
                'state.required' => 'El Estado es requerido',
                'email.required' => 'El Correo es requerido'
            ]);
            ///Validamos que los campos necesrios enten para guardar a un nuevo prospecto
            if ($validator_new_user->fails()) {
                return response()->json(['error' => $validator_new_user->messages()], 400);
            }

            //Guardado de datos para un nuevo prospecto
            //guardado de una persona
            $new_person = Person::create([
                'name' => $request['name'],
                'last_father_name' => $request['last_father_name'],
                'last_mother_name' => $request['last_mother_name'],
                'phone' => $request['phone'],
                'is_active' => 1,
                'created_at' => Date(now())
            ]);
            //Guardado de dirección de usaurio
            $new_addres = addres::create([
                'id_person' => $new_person->id,
                'state' => $request['state'],
                'country' => $request['country'],
                'is_active' => 1,
                'created_at' => Date(now())
            ]);
            //guardado datos de usuario
            $new_student = Student::create([
                'id_person' => $new_person->id,
                'enrollment' => 'ALU' . $new_person->id . mt_rand(0, 999),
                'status' => 'PROSPECTO',
                'is_active' => 1,
                'created_at' => Date(now())
            ]);
            //guardado de usuarios
            $new_user = User::create([
                'id_person' => $new_person->id,
                'email' => $request['email'],
                'password' => Hash::make($new_student->enrollment),
                'email_verified_at' => null,
                'status' => 1,
                'is_active' => true,
                'updated_by' => null,
                'login_for_google' => false
            ]);

            $roles=DB::table('roles')
            ->where('roles.code', '=', 'SYST_ROLE_ALUMNO')
            ->get()
            ->first();
            //guardado de el rol al alumno
            $role_user = user_role::Create([
                'id_user' => $new_user->id,
                'id_role' => $roles->id,
            ]);

            //seleasigna el valor nuevo del usuario al variable
            $id_user = $new_user->id;
        }
    
        //try {
            
              //extraemos datos de regla de pago
        if ($code_paymet_rules!=null) {
            $rulePayments = RulePayment::where('code', '=', $code_paymet_rules)
            ->where('is_active', '=', 1)
            ->get()
            ->first();
        } else {
            $rulePayments = RulePayment::where('code', '=', 'SYST_UNO_PAYMENT')
            ->where('is_active', '=', 1)
            ->get()
            ->first();
        }
        
        $montoSubscription = $rulePayments->registration_amount;
        
        //extraemos datos de usuario
        $dataUser = DB::table('users')
        ->join('persons', 'persons.id', '=', 'users.id_person')
        ->Leftjoin('address', 'address.id_person','=','users.id_person')
        ->Leftjoin('identifications', 'identifications.id_person','=','users.id_person')
        ->Leftjoin('students', 'students.id_person','=','users.id_person')
        ->where('users.id', '=', $id_user)
        ->orWhere('students.enrollment', '=', $id_user)
        ->where('users.is_active', '=', 1)
        ->select('users.*', 'persons.id as idPerson','persons.name as namePerson', 'persons.last_father_name as last_father_namePerson','persons.last_mother_name as last_mother_namePerson','persons.gender as genderPerson','persons.birth_date as birth_datePerson'
        ,'persons.phone as phonePerson','students.enrollment as enrollmentStudent')
        ->get()
        ->first();
        
        $dateSale = Carbon::now(); // Se calcula la fecha de hoy para la compra
        $formatTime = $dateSale->toTimeString();
        $dateSale->toDateString();// hora de venta
        $formatdate = Carbon::createFromFormat('Y-m-d H:i:s', $dateSale);
     
        //valida si tiene vendedor si no le asigna un por default
        if ($code_salesman!=null) {
            $salesman = Collaborator::where('collaborator_code', '=', $code_salesman)
            ->where('is_active', '=', 1)
            ->get()
            ->first();
        } else {
            $salesman = Collaborator::where('collaborator_code', '=', 'SERONLINE')
            ->where('is_active', '=', 1)
            ->get()
            ->first();
        }

         //extraemos datos de estudiante
         $student = Student::where('id_person', '=', $dataUser->idPerson)
         ->where('is_active', '=', 1)
         ->get()
         ->first();

          //extraemos datos del tipo de pago
          $typePayment = cat_catalog::where('code', '=', $type_payment_code)
          ->where('is_active', '=', 1)
          ->get()
          ->first();

        if ($rulePayments->included == false) {
            $total + $rulePayments->registration_amount;
        }

        if ($rulePayments->discount == true) {
            
        }
        //dd($formatdate);
        //se guarda los datos de venta
        $RegisterSale = Sale::create([
             'folio' => Str::random(10),
             'date_sale' => $formatdate,
             'time_sale' => $formatTime,
             'id_salesman' => $salesman->id,
             'id_student' => $student->id,
             'type_payment' => $typePayment->code,
             'subtotal' => $subtotal,
             'iva' => $iva,
             'total' => $total,
             'is_active' => 1
        ]);
        
        foreach ($listOfertSold as $key => $value) {
           
            //extraemos datos de la generación
            $generatios = Generations::where('id', '=', $value['idGeneration'])
            ->where('is_active', '=', 1)
            ->get()
            ->first();
            
            //extraemos datos de la generación
            $commercialProduct = commercial_product::where('id', '=', $generatios->id_service)
            ->where('is_active', '=', 1)
            ->get()
            ->first();
            //registra los datos del detalle de la compra
            $RegisterSaleDetail = Sale_detail::create([
                'id_sales' => $RegisterSale->id,
                'amount' => $value['monto'],
                'subtotal' => $value['monto'],
                'id_generation' => $generatios->id,
                'label_generations' => $generatios->name,
                'code_generations'=> $generatios->code,
                'start_at_generations' => $generatios->start_at,
                'id_user' => $dataUser->id,
                'name_user' => $dataUser->namePerson,
                'last_father_name_user' => $dataUser->last_father_namePerson,
                'last_mother_name_user' => $dataUser->last_mother_namePerson,
                'id_payment_rules' => $rulePayments->id,
                'name_rule' => $rulePayments->name,
                'code_rule' => $rulePayments->code,
                'registration_amount_rule' => $rulePayments->registration_amount,
                'is_required_rule' => $rulePayments->is_required,
                'period_rule' => $rulePayments->period,
                'id_cat_periodicity_rule' => $rulePayments->id_cat_periodicity,
                'label_cat_periodicity_rule' => $rulePayments->label_cat_periodicity,
                'code_cat_periodicity_rule' => $rulePayments->code_cat_periodicity,
                'id_cat_type_rule' => $rulePayments->id_cat_type,
                'label_cat_type_rule' => $rulePayments->label_cat_type,
                'code_cat_type_rule' => $rulePayments->code_cat_type,
                'id_cat_frequency_rule' => $rulePayments->id_cat_frequency,
                'label_cat_frequency_rule' => $rulePayments->label_cat_frequency,
                'code_cat_frequency_rule' => $rulePayments->code_cat_frequency,
                'discount_type_rule' => $rulePayments->discount,
                'included_rule' => $rulePayments->included,
                'id_commercial_product' => $commercialProduct->id,
                'label_commercial_product' => $commercialProduct->name,
                'code_commercial_product' => $commercialProduct->code,
                'duration_type_commercial_product' => $commercialProduct->finish_at,
                'is_private' => 0,
                'is_active' => 1
            ]);
        }

           //registra la cuenta de la compra
           $account = Account::create([
            'id_sale' => $RegisterSale->id,
            'original_amount' => $total,
            'subtotal' => $subtotal,
            'id_user' => $dataUser->id,
            'name_user' => $dataUser->namePerson,
            'last_father_name_user' => $dataUser->last_father_namePerson,
            'last_mother_name_user' => $dataUser->last_mother_namePerson,
            'id_payment_rules' => $rulePayments->id,
            'name_rule' => $rulePayments->name,
            'code_rule' => $rulePayments->code,
            'registration_amount_rule' => $rulePayments->registration_amount,
            'is_required_rule' => $rulePayments->is_required,
            'period_rule' => $rulePayments->period,
            'id_cat_periodicity_rule' => $rulePayments->id_cat_periodicity,
            'label_cat_periodicity_rule' => $rulePayments->label_cat_periodicity,
            'code_cat_periodicity_rule' => $rulePayments->code_cat_periodicity,
            'id_cat_type_rule' => $rulePayments->id_cat_type,
            'label_cat_type_rule' => $rulePayments->label_cat_type,
            'code_cat_type_rule' => $rulePayments->code_cat_type,
            'id_cat_frequency_rule' => $rulePayments->id_cat_frequency,
            'label_cat_frequency_rule' => $rulePayments->label_cat_frequency,
            'code_cat_frequency_rule' => $rulePayments->code_cat_frequency,
            'discount_type_rule' => $rulePayments->discount,
            'included_rule' => $rulePayments->included,
            'id_collaborator' => $salesman->id,
            'collaborator_code' => $salesman->collaborator_code,
            'is_private' => 0,
            'is_active' => 1,
            'status' => 'PENDIENTE'
        ]);

        if ($rulePayments->code == "SYST_UNO_PAYMENT") {
            //Se guarda el calendario de pago cuando es decontado
            $calendar = Account_calendar_detail::create([
                'id_account' => $account->id,
                'date_calendar' => $dateSale,
                'is_not_required' => false,
                'status' => statusCalendar::PENDING,
                'system_comment' => '',
                'original_amount' => $total,
                'tax_charge_amount' => 100,
                'charge_amount' => $total,
                'tax_payment_amount' => $total,
                'payment_amount' => $total,
                'order_number' => 1,
                'order_number_calendar' => 1,
                'is_private' => 0,
                'is_active' => 1
            ]);
        } else {
            
            if ($rulePayments->code_cat_type == "SYST_TYPAY_CDT") {//pgos a credito

                if ($rulePayments->code_cat_periodicity == "SYST_PLZ_MES") {//pagos a meses

                    switch (trim($rulePayments->code_cat_frequency)) {//Selecicona la frecuencia de pagos

                        case 'SYST_FREPAY_QNC':
                            $numberPayment = $this->getPeriodicityInMonth($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $this->StoreCalendar($account->id, $formatdate, $total, $numberPayment, 15);
                            break;
                        
                        case 'SYST_FREPAY_SEM':
                            $numberPayment = $this->getPeriodicityInMonth($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $this->StoreCalendar($account->id, $formatdate, $total, $numberPayment, 7);
                            break;

                        case 'SYST_FREPAY_MNS': 
                            $numberPayment = $this->getPeriodicityInMonth($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $paymentCalendar = $total / $numberPayment;
                            $ListPayment = [];
                            $dateControl = $formatdate; 
                            for ($i=1; $i <= $numberPayment ; $i++) {
                                
                                if ($i == 1) {
                                    $dateControl = Carbon::parse($dateControl)->addDays(30)->toDateString();
                                    $calendar = Account_calendar_detail::create([
                                        'id_account' => $account->id,
                                        'date_calendar' => $dateControl,
                                        'is_not_required' => false,
                                        'status' => statusCalendar::PENDING,
                                        'system_comment' => '',
                                        'original_amount' => $paymentCalendar,
                                        'tax_charge_amount' => 100,
                                        'charge_amount' => $paymentCalendar,
                                        'tax_payment_amount' => $paymentCalendar,
                                        'payment_amount' => $paymentCalendar,
                                        'order_number' => 1,
                                        'order_number_calendar' => $i,
                                        'is_private' => 0,
                                        'is_active' => 1
                                    ]);
                                }
                            }
    
                        default:
                            false;
                    }

                    //$newDate = Carbon::parse($formatdate)->addDays(15)->toDateString();
                    //$format = Carbon::parse($newDate)->format('d-m-Y');
                    //$newDate1 = Carbon::parse($format)->addDays(15)->toDateString();
                   //dd(Carbon::parse($newDate1)->format('d-m-Y'));
                } else if($rulePayments->code_cat_periodicity == "SYST_PLZ_QNC"){

                    switch (trim($rulePayments->code_cat_frequency)) {//Selecicona la frecuencia de pagos

                        case 'SYST_FREPAY_QNC':
                            $numberPayment = $this->getPeriodicityInbiweekly($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $this->StoreCalendar($account->id, $formatdate, $total, $numberPayment, 15);
                            break;
                        
                        case 'SYST_FREPAY_SEM':
                            $numberPayment = $this->getPeriodicityInbiweekly($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $this->StoreCalendar($account->id, $formatdate, $total, $numberPayment, 7);
                            break;

                        case 'SYST_FREPAY_MNS': 
                            $numberPayment = $this->getPeriodicityInbiweekly($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $paymentCalendar = $total / $numberPayment;
                            $dateControl = $formatdate; 
                            for ($i=1; $i <= $numberPayment ; $i++) {
                                
                                if ($i == 1) {
                                    $dateControl = Carbon::parse($dateControl)->addDays(30)->toDateString();
                                    $calendar = Account_calendar_detail::create([
                                        'id_account' => $account->id,
                                        'date_calendar' => $dateControl,
                                        'is_not_required' => false,
                                        'status' => statusCalendar::PENDING,
                                        'system_comment' => '',
                                        'original_amount' => $paymentCalendar,
                                        'tax_charge_amount' => 100,
                                        'charge_amount' => $paymentCalendar,
                                        'tax_payment_amount' => $paymentCalendar,
                                        'payment_amount' => $paymentCalendar,
                                        'order_number' => 1,
                                        'order_number_calendar' => $i,
                                        'is_private' => 0,
                                        'is_active' => 1
                                    ]);
                                }
                            }
    
                        default:
                            false;
                    }

                }  else if($rulePayments->code_cat_periodicity == "SYST_PLZ_ANUAL"){
                    switch (trim($rulePayments->code_cat_frequency)) {//Selecicona la frecuencia de pagos

                        case 'SYST_FREPAY_QNC':
                            $numberPayment = $this->getPeriodicityInYear($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $this->StoreCalendar($account->id, $formatdate, $total, $numberPayment, 15);
                            break;
                        
                        case 'SYST_FREPAY_SEM':
                            $numberPayment = $this->getPeriodicityInYear($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $this->StoreCalendar($account->id, $formatdate, $total, $numberPayment, 7);
                            break;

                        case 'SYST_FREPAY_MNS': 
                            $numberPayment = $this->getPeriodicityInYear($rulePayments->code_cat_frequency);
                            $numberPayment = $numberPayment * $rulePayments->period;
                            $paymentCalendar = $total / $numberPayment;
                            $dateControl = $formatdate; 
                            for ($i=1; $i <= $numberPayment ; $i++) {
                                
                                if ($i == 1) {
                                    $dateControl = Carbon::parse($dateControl)->addDays(30)->toDateString();
                                    $calendar = Account_calendar_detail::create([
                                        'id_account' => $account->id,
                                        'date_calendar' => $dateControl,
                                        'is_not_required' => false,
                                        'status' => statusCalendar::PENDING,
                                        'system_comment' => '',
                                        'original_amount' => $paymentCalendar,
                                        'tax_charge_amount' => 100,
                                        'charge_amount' => $paymentCalendar,
                                        'tax_payment_amount' => $paymentCalendar,
                                        'payment_amount' => $paymentCalendar,
                                        'order_number' => 1,
                                        'order_number_calendar' => $i,
                                        'is_private' => 0,
                                        'is_active' => 1
                                    ]);
                                }
                            }
    
                        default:
                            false;
                    }
                }
            }
        }
        
            return response()->json([
                'message' => 'Se guardo correcto la venta',
                'id_account' => $account->id
            ], Response::HTTP_OK);

        /*} catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al guardar',
                'error' => $th
            ], 401);
        }*/

    }

    public function StoreCalendar($id_account, $dateControl, $total, $numberPayment, $frecuencyPayment)
    {
        $paymentCalendar = $total / $numberPayment;
        for ($i=1; $i <= $numberPayment ; $i++) {
            if ($i == 1) {
                $calendar = Account_calendar_detail::create([
                    'id_account' => $id_account,
                    'date_calendar' => $dateControl,
                    'is_not_required' => false,
                    'status' => statusCalendar::PENDING,
                    'system_comment' => '',
                    'original_amount' => $paymentCalendar,
                    'tax_charge_amount' => 100,
                    'charge_amount' => $paymentCalendar,
                    'tax_payment_amount' => $paymentCalendar,
                    'payment_amount' => $paymentCalendar,
                    'order_number' => 1,
                    'order_number_calendar' => $i,
                    'is_private' => 0,
                    'is_active' => 1
                ]);
            }else{
                $dateControl = Carbon::parse($dateControl)->addDays($frecuencyPayment)->toDateString();
                $calendar = Account_calendar_detail::create([
                    'id_account' => $id_account,
                    'date_calendar' => $dateControl,
                    'is_not_required' => false,
                    'status' => statusCalendar::PENDING,
                    'system_comment' => '',
                    'original_amount' => $paymentCalendar,
                    'tax_charge_amount' => 100,
                    'charge_amount' => $paymentCalendar,
                    'tax_payment_amount' => $paymentCalendar,
                    'payment_amount' => $paymentCalendar,
                    'order_number' => 1,
                    'order_number_calendar' => $i,
                    'is_private' => 0,
                    'is_active' => 1
                ]);
            }
        }
    }

    public function getPeriodicityInYear($code_frecuency)
    {   
        $days;
        $code_frecuency = $code_frecuency == null ? "" : $code_frecuency;
        switch (trim($code_frecuency)) {
            case 'PER_DIA':
                $days = 365.0;
				break;
            case "SYST_FREPAY_SEM":
                $days = 365.0/7.0;
                break;
            case "PER_CAT":
                $days = 365.0/14.0;
                break;
            case "SYST_FREPAY_QNC":
                $days = 365.0/15.0;
                break;
            case "SYST_FREPAY_MNS":
                $days = 365.0/30.0;
                break;
            case "PER_ANIO":
                $days = 1.0;
                break;

            default:
                $days = 0;
        }
        return $days;
    }

    
    public function getPeriodicityInMonth($code_frecuency)
    {   
        $factor;
        $code_frecuency = $code_frecuency == null ? "" : $code_frecuency;
        switch (trim($code_frecuency)) {
            case "PER_DIA":
				$factor = 30;
				break;
			case "SYST_FREPAY_SEM":
				$factor = 4;
				break;
			case "PER_CAT":
				$factor = 2;
				break;
			case "SYST_FREPAY_QNC":
				$factor = 2;
				break;
			case "SYST_FREPAY_MNS":
				$factor = 1;
				break;
			case "PER_ANIO":
				$factor = 1.0 / 12.0;
				break;
            default:
                $factor = 0;
        }
        return $factor;
    }

    public function getPeriodicityInbiweekly($code_frecuency)
    {   
        $days;
        $code_frecuency = $code_frecuency == null ? "" : $code_frecuency;
        switch (trim($code_frecuency)) {
            case "PER_DIA":
				$factor = 15;
				break;
			case "SYST_FREPAY_SEM":
				$factor = 2;
				break;
			case "PER_CAT":
				$factor = 1;
				break;
			case "SYST_FREPAY_QNC":
				$factor = 1;
				break;
			case "SYST_FREPAY_MNS":
				$factor = 0;
				break;
			case "PER_ANIO":
				$factor = 0;
				break;
            default:
                $factor = 0;
        }
        return $days;
    }
}



abstract class statusCalendar
{
    const COMPLETE = 'COMPLETE';
    const EXPIRED = 'EXPIRED';
    const REJECTED = 'REJECTED';
    const PENDING = 'PENDING';
}
