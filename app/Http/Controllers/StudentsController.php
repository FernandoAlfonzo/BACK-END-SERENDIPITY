<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Student;
use App\Models\Role;
use App\Models\user_role;
use App\Models\addres;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Account;
use App\Models\identification;
use App\Models\Rsc_file;
use App\Models\Billing_information;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use File;
use Carbon\Carbon;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $searchUser = trim($request->get('search'));
        $students = DB::table('students')
            ->join('persons', 'persons.id', 'students.id_person')
            ->where('students.is_active', 1)
            ->where('persons.name', 'LIKE', '%' . $searchUser . '%')
            ->select('students.*', 'persons.id as personId', 'persons.name as name', 'persons.last_father_name as lastFName', 'persons.last_mother_name as lastMName')
            ->orderBy('id', 'asc')
            ->paginate(10);
            
        
        return view('students.index', ['students' => $students, 'searchUser' => $searchUser]);
    }

    public function studentPage(Request $request)
    {
        return view('students.studentPage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $gender_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get();

        $currency_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CURRENCY')
        ->select('cat_catalogs.*')
        ->get();

        $Use_of_cfdi = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CFDI')
        ->select('cat_catalogs.*')
        ->get();

        // $Payment_method = DB::table('cat_catalogs')
        // ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        // ->where('cat_types.code', '=', 'SYST_METODODEPAGO')
        // ->select('cat_catalogs.*')
        // ->get();

        $Way_to_pay = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_PAYMENT')
        ->select('cat_catalogs.*')
        ->get();

        $Physical_or_moral_person = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_PERSONA')
        ->select('cat_catalogs.*')
        ->get();





        return view('students.create', compact('gender_list', 'currency_list', 'Use_of_cfdi', 'Way_to_pay', 'Physical_or_moral_person'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request);
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_father_name' => ['required', 'string', 'max:255'],
            'last_mother_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'email' => ['required', 'string', 'max:255'],      
            'full_address' => ['required', 'string', 'max:255'],      
            'city' => ['required', 'string', 'max:255'],      
            'postal_code' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],  
            
            'Img_Curp' => ['image', 'mimes:jpeg,png', 'max:5000'],
            'Img_Ine' => ['image', 'mimes:jpeg,png', 'max:5000'],
            'Data_Identificacion' => ['image', 'mimes:jpeg,png', 'max:5000'],
            'Data_Certificado' => ['image', 'mimes:jpeg,png', 'max:5000'], //
            'Data_Cedula' => ['image', 'mimes:jpeg,png', 'max:5000'],
            'Data_Titulo' => ['image', 'mimes:jpeg,png', 'max:5000'],
            'Data_Cedula' => ['image', 'mimes:jpeg,png', 'max:5000'],
        ]);

        $person = new Person();
        $person->name = $request->input('name');
        $person->last_father_name = $request->input('last_father_name');
        $person->last_mother_name = $request->input('last_mother_name');
        $person->gender = $request->input('gender');
        $request->birth_date = $request->input('birth_date');
        $person->is_active = true;
        $person->created_by = Auth::user()->id;
        $person->created_at = Date(now());
        $person->save(); //Se crea la persona que será el nuevo alumno

        $student = new Student();
        $student->id_person = $person->id;
        $student->enrollment = 'SER' . $student->id . 'AL' . mt_rand(0, 999);
        // if($request['status']){ $request['status'] = 1;}
        $student->status = 'ALUMNO';
        $student->is_active = 1;
        $student->id_adm_organization = Auth::user()->id;
        $student->created_by = Auth::user()->id;
        $student->created_at = Date(now());
        $student->save(); //Se guarda el nuevo alumno que corresponde a la persona creada

        $user = new User();
        $user->id_person = $person->id;
        $user->email = $request->input('email');
        $user->password = Hash::make($student->enrollment);
        $user->email_verified_at = null;
        $user->status = 1;
        $user->is_active = true;
        $user->created_by = Auth::user()->id;
        $user->updated_by = null;
        $person->login_for_google = false;
        $user->save(); //Guarda los datos en la BD
      
        $roles=DB::table('roles')
        ->where('roles.code', '=', 'SYST_ROLE_ALUMNO')
        ->get()
        ->first();

         $role_user = user_role::Create([
            'id_user' => $user->id,
            'id_role' => $roles->id,
        ]);

        $address = new addres();
        $address->id_person = $person->id;
        $address->full_address = $request->input('full_address');
        //$address->location = $request->input('location');
        $address->city = $request->input('city');
        $address->postal_code = $request->input('postal_code');
        $address->state = $request->input('state');
        $address->country = $request->input('country');
        //$address->profession = $request->input('profession');
        $address->is_active = 1;
        $address->id_adm_organization = Auth::user()->id;
        $address->created_by = Auth::user()->id;
        $address->created_at = Date(now());
        $address->save(); //Se guarda la dirección de dicha persona-alumno


        if ($request->hasFile('CURP')) {
            $file = $request->file('CURP');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('CURP')->move($destinyPath, $fileName);
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "CURP";
            $identification->Code2 = $request['Curp'];  
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        
        }

        if ($request->hasFile('INE')) {
            $file = $request->file('INE');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('INE')->move($destinyPath, $fileName);
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "INE";
            $identification->Code2 = $request['Ine'];  
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        }

        if ($request->hasFile('Data_Identificacion')) {
            $file = $request->file('Data_Identificacion');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('Data_Identificacion')->move($destinyPath, $fileName);
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "Data_Identificacion"; 
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        }
        

        if ($request->hasFile('Data_Certificado')) {
            $file = $request->file('Data_Certificado');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('Data_Certificado')->move($destinyPath, $fileName);
            //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "Data_Certificado"; 
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        }
        
        if ($request->hasFile('Data_Cedula')) {
            $file = $request->file('Data_Cedula');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('Data_Cedula')->move($destinyPath, $fileName);
            //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "Data_Cedula"; 
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        }
        

        if ($request->hasFile('Data_Titulo')) {
            $file = $request->file('Data_Titulo');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('Data_Titulo')->move($destinyPath, $fileName);
            //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "Data_Titulo"; 
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        }
        
        
        if ($request->hasFile('Data_Estudiante')) {
            $file = $request->file('Data_Estudiante');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('Data_Estudiante')->move($destinyPath, $fileName);
            //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "Data_Estudiante"; 
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->id_adm_organization = $student->id_adm_organization;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno
        }

        $Billing = new Billing_information();
        $Billing->id_person=$person->id;
        $Billing->name=$request['BillingName'];
        $Billing->cat_id_type_person_billing=$request['BillingTypePerson'];
        $Billing->RFC=$request['BillingRFC'];
        $Billing->cat_id_CFDI=$request['BillingCFDI'];
        $Billing->cat_id_type_payment=$request['BillingMethodPago'];
        $Billing->cat_id_way_to_pay=$request['BillingWayPay'];
        $Billing->cat_id_currency=$request['BillingCurrencyList'];

        if ($request['BillingCheckboxAddress'] == "on") {
            $Billing->full_address = $address->full_address;
            //$address->location = $request->input('location');
            $Billing->city =  $address->city;
            $Billing->postal_code = $address->postal_code;
            $Billing->state = $address->state;
            $Billing->country = $address->country;
            $Billing->id_address = $address->id;
            $Billing->address_check = 1;
        } else {
            $Billing->full_address = $request['Billing_full_address'];
            //$address->location = $request->input('location');
            $Billing->city =  $request['Billing_city'];
            $Billing->postal_code =  $request['Billing_postal_code'];
            $Billing->state =  $request['Billing_state'];
            $Billing->country =  $request['Billing_country'];
            $Billing->address_check = 0;
        }
        

        $Billing->is_active=1;

        $Billing->save();

        Session::flash('message','Se registró correctamente');
        return redirect()->route('students.index');

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accountState($id)
    {   
        $student = Student::findOrFail($id);

        $person = Person::where('is_active', 1)
            ->where('id', $student->id_person)
            ->get()
            ->first();

        $user = User::where('is_active', 1)
            ->where('id_person', $student->id_person)
            ->first();

        $address = addres::where('is_active', 1)
            ->where('id_person', $student->id_person)
            ->get()
            ->first();

        // Servicios adquiridos
        $purchased_services = Sale::join('account', 'account.id_sale', 'sales.id')
            ->where('sales.is_active', 1)
            ->where('sales.id_student', $student->id)
            ->select('sales.folio as folio', 'sales.date_sale as date', 'sales.type_payment','sales.total as total_cost', 'account.status as accStatus')
            ->orderBy('sales.date_sale', 'desc')
            ->get();

        $accounts_bank=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_BANK')
            ->select('cat_catalogs.*')
            ->get();

        $today = Date('Y-m-d');
        // Sumando una semana a la fecha actual
        $untilDay = strtotime($today . "+ 7 days");
        $lateDays = strtotime($today . "- 3 days");

        // Pagos realizados
        // $payments = Payment::join('account', 'account.id', 'payment.id_account')
        //     ->join('sales', 'sales.id', 'account.id_sale')
        //     ->join('sales_detail', 'sales_detail.id_sales', 'sales.id')
        //     ->join('generations', 'generations.id', 'sales_detail.id_generation')
        //     ->join('commercial_product', 'commercial_product.id', 'generations.id_service')
        //     ->select('payment.id', 'payment.folio', 'payment.payment_type_code', 'payment.payment_date', 'payment.amount', 'payment.status', 'commercial_product.name as service', 'generations.name as nameGen')
        //     ->where('payment.is_active', 1)
        //     ->where('payment.status', 'IDENTIFICADO')
        //     ->where('sales.id_student', $student->id)
        //     ->get();
        $payments = Payment::join('account', 'account.id', 'payment.id_account')
            ->join('sales', 'sales.id', 'account.id_sale')
            ->select('payment.id', 'payment.folio', 'payment.payment_type_code', 'payment.payment_date', 'payment.amount', 'payment.status', 'sales.folio as saleInvoice')
            ->where('payment.is_active', 1)
            ->where('payment.status', 'IDENTIFICADO')
            ->where('sales.id_student', $student->id)
            ->get();

        // Pagos atrasados
        $late_payments = Sale::join('account', 'account.id_sale', 'sales.id')
            ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            ->where('account.is_active', 1)
            ->where('account_calendar_detail.is_active', 1)
            ->where('sales.id_student', $student->id)
            ->where('account_calendar_detail.status', '!=', 'PAGADO')
            ->where('account_calendar_detail.date_calendar', '<=', Date('Y-m-d', $lateDays))
            ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'sales.folio as saleInvoice')
            ->orderBy('account_calendar_detail.date_calendar', 'desc')
            ->get();

        // Pagos por vencer
            // ->join('sales_detail', 'sales_detail.id_sales', 'sales.id')
            // ->join('generations', 'generations.id', 'sales_detail.id_generation')
            // ->join('commercial_product', 'commercial_product.id', 'generations.id_service')
        $payments_due = Sale::join('account', 'account.id_sale', 'sales.id')
            ->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            ->where('account.is_active', 1)
            ->where('account_calendar_detail.is_active', 1)
            ->where('sales.id_student', $student->id)
            ->where('account_calendar_detail.status', '!=', 'PAGADO')
            ->where('account_calendar_detail.date_calendar', '>=', Date('Y-m-d'))
            ->where('account_calendar_detail.date_calendar', '<', Date('Y-m-d', $untilDay))
            ->select('account_calendar_detail.date_calendar as date', 'account_calendar_detail.original_amount as amount', 'sales.folio as saleInvoice')
            ->orderBy('account_calendar_detail.date_calendar', 'asc')
            ->get();

        // Cuentas por pagar
            // ->join('generations', 'generations.id', 'sales_detail.id_generation')
            // ->join('commercial_product', 'commercial_product.id', 'generations.id_service')
            // ->join('sales_detail', 'sales_detail.id_sales', 'sales.id')
        $accounts = Account::join('sales', 'sales.id', 'account.id_sale')
            //->join('account_calendar_detail', 'account_calendar_detail.id_account', 'account.id')
            ->where('account.is_active', 1)
            ->where('sales.id_student', $student->id)
            ->where('account.status', '!=', 'PAGADO')
            ->select('account.id as accountId', 'sales.type_payment as paymentType', 'account.code_rule as codeRule', 'sales.folio as saleInvoice')
            ->get();
        
        // Tipos de pagos para su registro
        $payments_type = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_PAYMENT')
        ->where('cat_catalogs.code', '!=', 'SYS_PAYMENT_OXXO')
        ->select('cat_catalogs.code', 'cat_catalogs.label', 'cat_catalogs.description')
        ->get();

        $loadFiles = Rsc_file::join('notifications', 'notifications.id', 'rsc_files.id_notification')
            ->where('rsc_files.id_user', $user->id)
            ->where('notifications.id_user', $user->id)
            ->where('notifications.is_active', 1)
            ->where('rsc_files.is_active', 1)
            ->select('notifications.id as idNotify', 'notifications.label as labelNot', 'notifications.description', 'notifications.created_at as dateNot', 'notifications.is_view', 'rsc_files.path_file', 'rsc_files.is_downloadable')
            ->orderBy('rsc_files.id', 'desc')
            ->get();

        // Fecha actual
        $newDate = Date(now());
        $actualDate = Carbon::parse($newDate)->format('Y-m-d');
        //dd($actualDate);
        return view('students.account_state', compact('student', 'person', 'address', 'purchased_services', 'payments', 'late_payments', 'payments_due', 'accounts', 'payments_type', 'actualDate', 'today', 'untilDay', 'accounts_bank', 'loadFiles'));
    }

    public function searchStudent(Request $request)
    {
        $search = $request['search'];

        $students = Person::where('name', 'LIKE', '%' . $search . '%')
            ->get();

        return view('students.studentPage')->with('students', $students);
    }

    /**
     * Registrar un pago.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function paymentRegister(Request $request)
    {   
        $payment = new Payment();
        $payment = $request->inp
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gender_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get();

        $student = DB::table('students')
        ->where('students.id', $id)
        ->get()
        ->first();

       $person = DB::table('students')
       ->join('persons', 'persons.id', '=', 'students.id_person') 
       ->join('address', 'persons.id', '=', 'address.id_person') 
       ->join('users', 'persons.id', '=', 'users.id_person') 
       //->join('identifications', 'persons.id', '=', 'identifications.id_person') 
       ->where('students.id', $id)
        ->get()
        ->first();

        $identification_person = DB::table('identifications')
        ->where('identifications.id_person', $person->id_person)
        ->where('identifications.is_validate', 0)
        ->get();

        $address = DB::table('address')
        ->where('address.id_person', $person->id_person)
        ->first();

        $gender_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get();

        $currency_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CURRENCY')
        ->select('cat_catalogs.*')
        ->get();

        $Use_of_cfdi = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CFDI')
        ->select('cat_catalogs.*')
        ->get();

        $Payment_method = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_METODODEPAGO')
        ->select('cat_catalogs.*')
        ->get();

        $Way_to_pay = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_FORMADEPAGO')
        ->select('cat_catalogs.*')
        ->get();

        $Physical_or_moral_person = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_PERSONA')
        ->select('cat_catalogs.*')
        ->get();

        // dd($person);
        
        
        $edit = Student::findOrFail($id);
        return view('students.edit', compact('edit','gender_list','person','identification_person','student','address', 'currency_list', 'Use_of_cfdi', 'Payment_method', 'Way_to_pay', 'Physical_or_moral_person'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {  
        //dd($request['status']);
        $person = Person::find($request['id_person']);
        $person->name= $request->input('name');
        $person->last_father_name = $request->input('last_father_name');
        $person->last_mother_name = $request->input('last_mother_name');
        $person->gender = $request->input('gender');
        $person->birth_date = $request->input('birth_date');
        $person->is_active = true;
        $person->updated_by = Auth::user()->id;
        $person->save(); //Guarda los datos en la BD
        
        $address = addres::find($request['id_address']);
        $address->full_address = $request['full_address'];
        $address->city = $request['city'];
        $address->state = $request['state'];
        $address->country = $request['country'];
        $address->postal_code = $request['postal_code'];
        $address->save(); //Guarda los datos en la BD

        $user = User::find($request['id']);
        $user->email = $request['email']; 
        $user->save(); //Guarda los datos en la BD
        
        

    if ($request->hasFile('CURP')) {
        try{
        $identification_person = DB::table('identifications')
        ->where('identifications.id_person', $request['id_person'])
        ->where('identifications.code', 'CURP')
        ->get();
        if($identification_person[0]->is_validate==0){
        
        $file = $request->file('CURP');
        $destinyPath = 'Dstudents/';
        $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
        $uploadFile = $request->file('CURP')->move($destinyPath, $fileName);
        File::delete($identification_person[0]->url_img);
        $img_route = $destinyPath.$fileName;
        $identification = identification::find($identification_person[0]->id);
        $identification->id_person = $person->id;
        $identification->code = "CURP";
        if($request['Curp']){
            $identification->code2 = $request['Curp'];
        }
        $identification->url_img =$img_route;
        $identification->save(); //Se guarda la dirección de dicha persona-alumno         
    }
} 
catch (\Exception $ex) { 
    $file = $request->file('CURP');
    $destinyPath = 'Dstudents/';
    $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
    $uploadFile = $request->file('CURP')->move($destinyPath, $fileName);
    $img_route = $destinyPath.$fileName;
    $identification = new identification();
    $identification->id_person = $person->id;
    $identification->code = "CURP";
    $identification->Code2 = $request['Curp'];  
    $identification->url_img =$img_route;
    $identification->is_active = 1;
    $identification->is_validate = 0;
    $identification->save(); //Se guarda la dirección de dicha persona-alumno


}
}

        if ($request->hasFile('INE')) {
            try{

            $identification_person = DB::table('identifications')
            ->where('identifications.id_person', $request['id_person'])
            ->where('identifications.code', 'INE')
            ->get();
            if($identification_person[0]->is_validate==0){
            
            $file = $request->file('INE');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('INE')->move($destinyPath, $fileName);
            File::delete($identification_person[0]->url_img);
            $img_route = $destinyPath.$fileName;
            $identification = identification::find($identification_person[0]->id);
            $identification->id_person = $person->id;
            $identification->code = "INE";
            if($request['Ine']){
                $identification->code2 = $request['Ine'];  
            }
            $identification->url_img =$img_route;
            $identification->save(); //Se guarda la dirección de dicha persona-alumno         
            }
        } 
        catch (\Exception $ex) { 

            $file = $request->file('INE');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('INE')->move($destinyPath, $fileName);
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "INE";
            $identification->Code2 = $request['Ine'];  
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->is_validate = 0;
            $identification->save(); //Se guarda la dirección de dicha persona-
        }
        }

            if ($request->hasFile('Data_Identificacion')) {
                try{
                $identification_person = DB::table('identifications')
                ->where('identifications.id_person', $request['id_person'])
                ->where('identifications.code', 'Data_Identificacion')
                ->get();
                if($identification_person[0]->is_validate==0){
                $file = $request->file('Data_Identificacion');
                $destinyPath = 'Dstudents/';
                $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                $uploadFile = $request->file('Data_Identificacion')->move($destinyPath, $fileName);
                File::delete($identification_person[0]->url_img);
                $img_route = $destinyPath.$fileName;
                $identification = identification::find($identification_person[0]->id);
                $identification->id_person = $person->id;
                $identification->code = "Data_Identificacion";
                $identification->url_img =$img_route;
                $identification->save(); //Se guarda la dirección de dicha persona-alumno         
                }
            } 
            catch (\Exception $ex) { 

                $file = $request->file('Data_Identificacion');
            $destinyPath = 'Dstudents/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('Data_Identificacion')->move($destinyPath, $fileName);
            $img_route = $destinyPath.$fileName;
            $identification = new identification();
            $identification->id_person = $person->id;
            $identification->code = "Data_Identificacion"; 
            $identification->url_img =$img_route;
            $identification->is_active = 1;
            $identification->is_validate = 0;
            $identification->save(); //Se guarda la dirección de dicha persona-
            }
            }
    
                if ($request->hasFile('Data_Certificado')) {
                    try{ 

                    $identification_person = DB::table('identifications')
                    ->where('identifications.id_person', $request['id_person'])
                    ->where('identifications.code', 'Data_Certificado')
                    ->get();
                    if($identification_person[0]->is_validate==0){
                    
                    $file = $request->file('Data_Certificado');
                    $destinyPath = 'Dstudents/';
                    $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                    $uploadFile = $request->file('Data_Certificado')->move($destinyPath, $fileName);
                    File::delete($identification_person[0]->url_img);
                    $img_route = $destinyPath.$fileName;
                    $identification = identification::find($identification_person[0]->id);
                    $identification->id_person = $person->id;
                    $identification->code = "Data_Certificado";  
                    $identification->url_img =$img_route;
                    $identification->save(); //Se guarda la dirección de dicha persona-alumno         
                    }
                } 
                catch (\Exception $ex) {
                    
                    $file = $request->file('Data_Certificado');
                    $destinyPath = 'Dstudents/';
                    $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                    $uploadFile = $request->file('Data_Certificado')->move($destinyPath, $fileName);
                    //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
                    $img_route = $destinyPath.$fileName;
                    $identification = new identification();
                    $identification->id_person = $person->id;
                    $identification->code = "Data_Certificado"; 
                    $identification->url_img =$img_route;
                    $identification->is_active = 1;
                    $identification->is_validate = 0;
                    $identification->save(); //Se guarda la dirección de dicha persona-alumno
                 }
                }

                    if ($request->hasFile('Data_Cedula')) {
                        try{
                        $identification_person = DB::table('identifications')
                        ->where('identifications.id_person', $request['id_person'])
                        ->where('identifications.code', 'Data_Cedula')
                        ->get();
                        if($identification_person[0]->is_validate==0){
                        
                        $file = $request->file('Data_Cedula');
                        $destinyPath = 'Dstudents/';
                        $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                        $uploadFile = $request->file('Data_Cedula')->move($destinyPath, $fileName);
                        File::delete($identification_person[0]->url_img);
                        $img_route = $destinyPath.$fileName;
                        $identification = identification::find($identification_person[0]->id);
                        $identification->id_person = $person->id;
                        $identification->code = "Data_Cedula";  
                        $identification->url_img =$img_route;
                        $identification->save(); //Se guarda la dirección de dicha persona-alumno         
                        }
                    }
                    catch (\Exception $ex) { 
                        $file = $request->file('Data_Cedula');
                        $destinyPath = 'Dstudents/';
                        $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                        $uploadFile = $request->file('Data_Cedula')->move($destinyPath, $fileName);
                        //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
                        $img_route = $destinyPath.$fileName;
                        $identification = new identification();
                        $identification->id_person = $person->id;
                        $identification->code = "Data_Cedula"; 
                        $identification->url_img =$img_route;
                        $identification->is_active = 1;
                        $identification->is_validate = 0;
                        $identification->save(); //Se guarda la dirección de dicha persona-alumno
                    }
            }
                        if ($request->hasFile('Data_Titulo')) {

                        try{
                            $identification_person = DB::table('identifications')
                            ->where('identifications.id_person', $request['id_person'])
                            ->where('identifications.code', 'Data_Titulo')
                            ->get();
                            
                            if($identification_person[0]->is_validate==0){
                            
                            $file = $request->file('Data_Titulo');
                            $destinyPath = 'Dstudents/';
                            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                            $uploadFile = $request->file('Data_Titulo')->move($destinyPath, $fileName);
                            File::delete($identification_person[0]->url_img);
                            $img_route = $destinyPath.$fileName;
                            $identification = identification::find($identification_person[0]->id);
                            $identification->id_person = $person->id;
                            $identification->code = "Data_Titulo";  
                            $identification->url_img =$img_route;
                            $identification->save(); //Se guarda la dirección de dicha persona-alumno         
                            }
                        }
                        catch (\Exception $ex) {
                            $file = $request->file('Data_Titulo');
                            $destinyPath = 'Dstudents/';
                            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                            $uploadFile = $request->file('Data_Titulo')->move($destinyPath, $fileName);
                            $img_route = $destinyPath.$fileName;
                            $identification = new identification();
                            $identification->id_person = $person->id;
                            $identification->code = "Data_Titulo"; 
                            $identification->url_img =$img_route;
                            $identification->is_active = 1;
                            $identification->is_validate = 0;
                            $identification->save(); //Se guarda la dirección de dicha persona-alumno
                            }
                    }
                    
                    if ($request->hasFile('Data_Estudiante')) {
                                try{
                                $identification_person = DB::table('identifications')
                                ->where('identifications.id_person', $request['id_person'])
                                ->where('identifications.code', 'Data_Estudiante')
                                ->get();
                                if($identification_person[0]->is_validate==0){
                                
                                $file = $request->file('Data_Estudiante');
                                $destinyPath = 'Dstudents/';
                                $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                                $uploadFile = $request->file('Data_Estudiante')->move($destinyPath, $fileName);
                                File::delete($identification_person[0]->url_img);
                                $img_route = $destinyPath.$fileName;
                                $identification = identification::find($identification_person[0]->id);
                                $identification->id_person = $person->id;
                                $identification->code = "Data_Estudiante";  
                                $identification->url_img =$img_route;
                                $identification->save(); //Se guarda la dirección de dicha persona-alumno         
                                }
                            }
                            catch (\Exception $ex) {
                                $file = $request->file('Data_Estudiante');
                                $destinyPath = 'Dstudents/';
                                $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
                                $uploadFile = $request->file('Data_Estudiante')->move($destinyPath, $fileName);
                                //$collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
                                $img_route = $destinyPath.$fileName;
                                $identification = new identification();
                                $identification->id_person = $person->id;
                                $identification->code = "Data_Estudiante"; 
                                $identification->url_img =$img_route;
                                $identification->is_active = 1;
                                $identification->is_validate = 0;
                                $identification->save(); //Se guarda la dirección de dicha persona-alumno 
                             }
                      }
             
        //dd($user->email.' '.$request['email']);
        Session::flash('message','se edito correctamente');
        return redirect()->route('students.index');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $student = Student::findOrFail($request['delete']);
        $student->is_active = 0;
        $student->save(); //Guarda los datos en la BD
        Session::flash('message','Se elimino correctamente');
        return redirect()->route('students.index');
        //
    }

    

}
