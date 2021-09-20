<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login', ['baseUrl' => env('BASE_URL')]);
});

Route::get('/about', function () {
    return view('about', ['baseUrl' => env('BASE_URL')]);
});

Route::get('/users-page', function () {
    return view('users', [
        'baseUrl' => env('BASE_URL'),
        'users' => User::all()
    ]);
});

Route::get('/payment-admin', function () {
    $usersMapped  = [];

    foreach (User::all() as   $user) {
        array_push($usersMapped, [
            'user' => $user,
            'payments' => Payment::where('user_id', '=', $user->id)->get()
        ]);
    }

    return view('payment-admin', [
        'baseUrl' => env('BASE_URL'),
        'users' => json_encode($usersMapped),
        'roles' => Role::all()
    ]);
});

Route::get('/payment-admin/{id}', function ($id) {
    $payment = Payment::where("id", "=", $id)->first();

    $paymentDetails = [];

    if ($payment) {
        $paymentDetails = UserController::mapPaymentsToPaymentDetails([$payment]);
    }

    return view('payment-user-detail', [
        'baseUrl' => env('BASE_URL'),
        'payment' => json_encode($payment),
        'paymentDetails' => json_encode($paymentDetails)
    ]);
});



Route::get('/payment-user', function () {
    return view('payment-user', ['baseUrl' => env('BASE_URL')]);
});

Route::post('/auth-login', [UserController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/jwt-verify-test', [PaymentController::class, 'jwt_verify_test']);
});



Route::get('/test-send-payment', function () {
    $make_pay = new Payment;


    Payment::updateOrCreate(['id' => 0], [$make_pay]);


    // return [
    //     'test' => 'hellloi',
    //     'hi' => 'people!'
    // ];
});

// Users
Route::get('/users', [UserController::class, 'all']);
Route::get('/user-get', [UserController::class, 'get']);
Route::post('/users-save-batch', [UserController::class, 'save_batch']);

// Get user payments
Route::get('/user-get-payments', [UserController::class, 'getPayments']);
Route::get('/user-get-payment-details', [UserController::class, 'getPaymentDetails']);



// Users populate
Route::get('/users-populate', [UserController::class, 'populate']);

Route::get('/products', [ProductController::class, 'all']);
Route::get('/products-dummy-create', [ProductController::class, 'dummy_create']);

Route::post('/payments-save', [PaymentController::class, 'save']);

// Payment Detail
Route::get('/paymentdetails', [PaymentDetailController::class, 'all']);
Route::post('/paymentdetails-save', [PaymentDetailController::class, 'save']);

Route::get('/paymentdetails-test-add', [PaymentDetailController::class, 'testAdd']);
Route::post('/paymentdetails-save-batch', [PaymentDetailController::class, 'saveBatch']);
