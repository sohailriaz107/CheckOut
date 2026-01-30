<?php

use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\Merchant\MerchantController;
use App\Http\Controllers\Admin\Merchant\MerchantDataTableController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Transactions\TransactionsController;
use App\Http\Controllers\Admin\Transactions\TransactionTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProcessingPaymentController;
use App\Http\Controllers\DemoPaymentController;
use App\Http\Controllers\SandboxPaymentProcessingController;
use App\Http\Controllers\SandBoxPaymentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserDataTableController;
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


// direct Payment
Route::get('direct-sandbox-payment', [DirectSandboxPaymentProcessingController::class, 'directSandboxPayment']);


//Partial Payments
Route::get('sandbox-payment', [SandboxPaymentProcessingController::class, 'sandboxPayment']);
Route::get('sandbox-payment-credit-buy', [SandboxPaymentProcessingController::class, 'sandboxPaymentCreditBuy']);
Route::get('sandbox-payment-confirmed', [SandboxPaymentProcessingController::class, 'sandboxPaymentConfirmed'])->name('sandbox.confirmation');
Route::get('/sandbox-due-payment', [SandboxPaymentProcessingController::class, 'sandboxDuePayment'])->name('sandbox.due.payment');
Route::get('/sandbox-due-payment-buy-credit', [SandboxPaymentProcessingController::class, 'sandboxDuePaymentBuyCredit'])->name('sandbox.due.payment.buy.credit');
Route::get('/sandbox-return/{response}', [SandboxPaymentProcessingController::class, 'sandboxReturn'])->name('sandbox.return');
Route::get('/sandbox-payment-cancel', [SandboxPaymentProcessingController::class, 'sandboxCancel'])->name('sandbox.cancel');
Route::get('/sandbox-pay-pal-success', [SandboxPaymentProcessingController::class, 'DemoPayPalSuccess'])->name('sandbox.payPalSuccess');
Route::get('/sandbox-pay-pal-success-partial-pay', [SandboxPaymentProcessingController::class, 'PayPalSuccessPartialPay'])->name('sandbox.payPalSuccess.PartialPay');
Route::post('/sandbox-payment-credit-card', [SandboxPaymentProcessingController::class, 'sandboxCredtCardPayment'])->name('sandbox.payment.credit.card');
Route::post('/sandbox-pay-pal', [SandboxPaymentProcessingController::class, 'SandboxPayPal'])->name('payment.sandbox.payPal');
Route::post('/sandbox-user-credit', [SandboxPaymentProcessingController::class, 'sandboxUserCreditPayment'])->name('payment.sandbox.user.credit');
Route::get('/backpocket-payment/no-item-in-cart/{url?}', [SandboxPaymentProcessingController::class, 'noItemToPay'])->name('payment.no.item.to.pay');
//


Route::get('/', [HomeController::class, 'DemoForm'])->name('backpocket.payment.demo');

Route::get('backpocket-payment/payment-demo', [DemoPaymentController::class, 'DemoPayment'])->name('backpocket.demo.payment.submit');

Route::get('backpocket-payment/sandbox', [SandBoxPaymentController::class, 'sandboxPortal'])->name('backpocket.sandbox.portal');
Route::get('backpocket-payment/sandbox-credit', [SandBoxPaymentController::class, 'sandboxPortalCredtBuy'])->name('backpocket.sandbox.portal.credit');


Route::get('/backpocket-payment/live', [PaymentController::class, 'getData'])->name('payment.getData');
Route::get('payment', [ProcessingPaymentController::class, 'payment']);

Route::post('/payment-submit', [ProcessingPaymentController::class, 'paymentSubmit'])->name('payment.paymentSubmit');
Route::get('/pay-pal', [ProcessingPaymentController::class, 'payPal'])->name('payment.payPal');

Route::get('/pay-pal-success', [ProcessingPaymentController::class, 'payPalSuccess'])->name('payment.payPalSuccess'); 

Route::get('/userCredit-submit', [ProcessingPaymentController::class, 'userCredit'])->name('payment.userCredit');

Route::get('/live-return/{response}', [PaymentController::class, 'liveReturn'])->name('payment.live.return');

Route::get('/success', [HomeController::class, 'success'])->name('payment.success');
Route::get('/error', [HomeController::class, 'error'])->name('payment.error');

Auth::routes(['register' => false]);


Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

    Route::get('/admin-dashboard', [DashBoardController::class, 'index'])->name('admin.dashboard');
    Route::group(['prefix' => 'Transactions', 'name' => 'admin'], function () {
        Route::get('/', [TransactionsController::class, 'index'])->name('admin.transactions.index');
        Route::post('transations-datatable', TransactionTableController::class)->name('admin.transactions.datatable');
        Route::get('show/{transaction}', [TransactionsController::class, 'show'])->name('admin.transactions.show');
    });
    Route::group(['prefix' => 'settings', 'name' => 'admin'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/update-paypal', [SettingController::class, 'updatePaypal'])->name('admin.settings.update.paypal');
        Route::post('/update-credit', [SettingController::class, 'updateCredit'])->name('admin.settings.update.credit');
    });

    Route::group(['prefix' => 'merchants', 'name' => 'admin'], function () {
        Route::get('/', [MerchantController::class, 'index'])->name('admin.merchants.index');
        Route::post('merchant-datatable', MerchantDataTableController::class)->name('admin.merchants.datatable');
        Route::get('create', [MerchantController::class, 'create'])->name('admin.merchants.create');
        Route::post('add', [MerchantController::class, 'add'])->name('admin.merchants.add');
        Route::get('edit/{merchant}', [MerchantController::class, 'edit'])->name('admin.merchants.edit');
        Route::post('update/{merchant}', [MerchantController::class, 'update'])->name('admin.merchants.update');
        Route::get('delete/{merchant}', [MerchantController::class, 'delete'])->name('admin.merchants.delete');
        Route::get('status/{merchant}', [MerchantController::class, 'status'])->name('admin.merchants.status');
        Route::get('show/{merchant}', [MerchantController::class, 'show'])->name('admin.merchants.show');
        
    });
    Route::post('/change-secret-id', [MerchantController::class, 'changeSecretId']);
    Route::group(['middleware' => ['role:Admin']], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::get('user-delete/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::post('users-datatable', UserDataTableController::class)->name('admin.user.datatable');
    });
   
    
});
Route::get('user-profile', [UserController::class, 'profile'])->name('user.profile');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
