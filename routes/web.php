<?php

use App\Http\Controllers\catalogController;
use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\eduOfferController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\subcatalogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenerationsController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RulePaymentController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProspectsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
// Route::post('login', 'App\Http\Controllers\Auth\LoginController@validateLogin');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/', DashboardController::class);

//rutas de roles
Route::resource('role', roleController::class);

//Rutas de usuarios
Route::get('edit/user/{id}', 'App\Http\Controllers\UserController@edit');
Route::post('update/user', 'App\Http\Controllers\UserController@update');
Route::post('user/delete', 'App\Http\Controllers\UserController@destroy');
Route::resource('user', UserController::class);

//rutas de asignacion de permisos
Route::get('configPermission/{id}', 'App\Http\Controllers\roleController@Permission');
Route::post('AsignatePermisoModule/{id_role}', 'App\Http\Controllers\roleController@AsignatePermisoModule');
Route::get('ModulePermission/{id}', 'App\Http\Controllers\roleController@ModulePermission');
Route::post('role/delete', 'App\Http\Controllers\roleController@destroy');

//permisos
Route::resource('role', roleController::class);

//Rutas para los catálogos y subcatálogos
Route::resource('catalog', catalogController::class);
Route::get('createSubcatalog/{id}', 'App\Http\Controllers\catalogController@createSubcatalog');
Route::post('storeSubcatalog', 'App\Http\Controllers\catalogController@storeSubcatalog');
Route::get('editSubcatalog/{id}', 'App\Http\Controllers\catalogController@editSubcatalog');
Route::put('updateSubcatalog/{id}', 'App\Http\Controllers\catalogController@updateSubcatalog');
//Route::delete('destroySubcatalog/{id}', 'App\Http\Controllers\catalogController@destroySubcatalog');
Route::post('catalog/delete', 'App\Http\Controllers\catalogController@destroy');
Route::post('subcatalog/delete', 'App\Http\Controllers\catalogController@destroySubcatalog');
//Route::resource('subcatalog', subcatalogController::class);

//Rutas para los colaboradores
Route::resource('collaborator', CollaboratorsController::class);
Route::post('collaborator/update', 'App\Http\Controllers\CollaboratorsController@update');
Route::post('collaborator/statusCollabDelete', 'App\Http\Controllers\CollaboratorsController@stsCollab');
Route::post('collaborator/statusCollabActive', 'App\Http\Controllers\CollaboratorsController@stsCollab');
Route::post('collaborator/delete', 'App\Http\Controllers\CollaboratorsController@destroy');

//Rutas de oferta educativa
Route::resource('educativeoffer', eduOfferController::class);
Route::get('listOffer/{id}', 'App\Http\Controllers\eduOfferController@listOffer');
Route::get('createOffer/{id}', 'App\Http\Controllers\eduOfferController@createOffer');
Route::post('storeOffer', 'App\Http\Controllers\eduOfferController@storeOffer');
Route::get('editOffer/{id}', 'App\Http\Controllers\eduOfferController@editOffer');
Route::put('updateOffer/{id}', 'App\Http\Controllers\eduOfferController@updateOffer');
Route::delete('destroyOffer/{id}', 'App\Http\Controllers\eduOfferController@destroyOffer');

//Rutas de la Generaciones
Route::resource('generations', GenerationsController::class);
Route::get('generations/create/{id}', 'App\Http\Controllers\GenerationsController@createGeneration');
Route::post('generations/delete', 'App\Http\Controllers\GenerationsController@destroy');

///Rutas de organización
Route::resource('organizations', OrganizationController::class);
Route::get('BusinessUnit/{id}', 'App\Http\Controllers\OrganizationController@ListBusinessUnit');
Route::get('CreateBusinessUnit/{id}', 'App\Http\Controllers\OrganizationController@CreateBusinessUnit');
Route::post('storeBusinessUnit', 'App\Http\Controllers\OrganizationController@storeBusinessUnit');
Route::get('editBusinessUnit/{id}', 'App\Http\Controllers\OrganizationController@editBusinessUnit');
Route::put('updateBusinessUnit/{id}', 'App\Http\Controllers\OrganizationController@updateBusinessUnit');
Route::post('BusinessUnit/delete', 'App\Http\Controllers\OrganizationController@destroyBusinessUnit');
///Rutas de ventas (pagos)
Route::resource('sales', SalesController::class);

//Rutas Conekta
Route::get('getAllClients', 'App\Http\Controllers\ConektaController@getClients');
Route::get('createOxxoPay', 'App\Http\Controllers\ConektaController@OrderOXXOPay');
Route::get('createOxxoPayFind', 'App\Http\Controllers\ConektaController@OrderOXXOPayFind');


//Rutas de reglas de pago
Route::resource('products', RulePaymentController::class);
Route::post('product/delete', 'App\Http\Controllers\RulePaymentController@destroy');

//Rutas de pagos
Route::resource('payments', PaymentsController::class);
Route::get('allPayments', 'App\Http\Controllers\PaymentsController@all_payments');
Route::get('latePayments', 'App\Http\Controllers\PaymentsController@late_payments');
Route::get('duePayments', 'App\Http\Controllers\PaymentsController@due_payments');
Route::post('paymentRegistration', 'App\Http\Controllers\PaymentsController@store');
Route::get('payments/register', 'App\Http\Controllers\PaymentsController@register');
Route::get('unpayments', 'App\Http\Controllers\PaymentsController@unidentifiedPayments');
Route::post('payments/delete', 'App\Http\Controllers\PaymentsController@destroy');
Route::get('accounts/{userId}', 'App\Http\Controllers\PaymentsController@getAccounts');

Route::post('/paymentFrom', 'App\Http\Controllers\PaymentsController@paymentFrom');


//Rutas para prospectos
Route::resource('prospects', ProspectsController::class);

//Rutas para alumnos
Route::resource('students', StudentsController::class);
Route::get('students/account_state/{id}', 'App\Http\Controllers\StudentsController@accountState');
Route::post('students/update', 'App\Http\Controllers\StudentsController@update');
Route::post('student/delete', 'App\Http\Controllers\StudentsController@destroy');
Route::get('students/edit/{id}', 'App\Http\Controllers\StudentsController@edit');

Route::get('studentPage', 'App\Http\Controllers\StudentsController@studentPage');

Route::get('students/account_state/{id}', 'App\Http\Controllers\StudentsController@accountState');
Route::get('searchStudent', 'App\Http\Controllers\StudentsController@searchStudent')->name('students.search');

//Rutas para las notificaciones
Route::resource('notifications', NotificationsController::class);
Route::get('isActive/{idNotify}', 'App\Http\Controllers\NotificationsController@updateNotify');

