<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('pruebapi', 'App\Http\Controllers\Api\PruebapiController@pruebas');


Route::get('test', 'App\Http\Controllers\Api\AuthController@test');
///rutas de auth
Route::post('login', 'App\Http\Controllers\Api\AuthController@authenticate');
Route::post('google-login', 'App\Http\Controllers\Api\AuthController@googleAuthenticate');
Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('resetpass', 'App\Http\Controllers\Api\AuthController@resetPassword'); 
Route::post('resetpassValidate', 'App\Http\Controllers\Api\AuthController@resetPasswordValidate');
Route::post('newPassword', 'App\Http\Controllers\Api\AuthController@newpassword');
Route::post('validateExistEmail', 'App\Http\Controllers\Api\AuthController@validateExistEmail');
Route::post('updateEmailValidate', 'App\Http\Controllers\Api\AuthController@updateEmailValidate');


//Apis para catalogos
Route::post('get/catalog/code', 'App\Http\Controllers\Api\CatalogController@getCatalogByCode');
Route::post('get/cat_type/code', 'App\Http\Controllers\Api\Cat_TypesController@getCat_typeByCode');

Route::post('getAllService', 'App\Http\Controllers\Api\EduOfferController@getAllService');
Route::post('getOferByIdService', 'App\Http\Controllers\Api\EduOfferController@getOferByIdService');
Route::post('getDataUser', 'App\Http\Controllers\Api\UserController@getAllDataUser');
Route::post('updateDataUser', 'App\Http\Controllers\Api\UserController@UpdateAllDataUser');
Route::post('getAllStudents', 'App\Http\Controllers\Api\StudentsController@getStudentsAll');
Route::post('documents', 'App\Http\Controllers\Api\StudentsController@document');
Route::post('validate_D', 'App\Http\Controllers\Api\StudentsController@validate_doc');
Route::post('getAllResourceByPayment', 'App\Http\Controllers\Api\StudentsController@getAllResourceByPayment');
Route::post('getAllDataInvoice', 'App\Http\Controllers\Api\FacturaController@getAllDataInvoice'); 
Route::get('alum_grafic', 'App\Http\Controllers\Api\StudentsController@alumnBymost');
Route::get('grafic_collaborator', 'App\Http\Controllers\Api\StudentsController@collaborator');
Route::get('alum_grafic_pros', 'App\Http\Controllers\Api\StudentsController@alumnBymost_pros');
Route::get('generationsGrafic', 'App\Http\Controllers\Api\StudentsController@generations_grafic');

Route::post('getDataUser', 'App\Http\Controllers\Api\UserController@getAllDataUser');
Route::post('updateDataUser', 'App\Http\Controllers\Api\UserController@UpdateAllDataUser');
Route::post('methodPayments', 'App\Http\Controllers\Api\Cat_TypesController@getAllMethodPayment');

Route::post('paymentDetail', 'App\Http\Controllers\Api\PaymentsController@Payments');
Route::post('dataAccount', 'App\Http\Controllers\Api\DetailsPaymentController@PaymentsDetails');
Route::post('dataTicket', 'App\Http\Controllers\Api\TicketController@dataTicket');
Route::post('learning', 'App\Http\Controllers\Api\LearningController@Learning');
Route::post('listStudents', 'App\Http\Controllers\Api\ListStudentsController@ListStudents');
Route::post('saveImgPayment', 'App\Http\Controllers\Api\PaymentsController@saveImgPayment');
//Apis require token
Route::group(['middleware' => ['jwt.verify']], function() {
    //Todo lo que este dentro de este grupo requiere verificación de usuario.
    Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout');
  
    
});

Route::post('buyService', 'App\Http\Controllers\Api\SalesController@BuyService');

Route::post('notificacionesConekta', 'App\Http\Controllers\ConektaController@notificaciones');


// 1