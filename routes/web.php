<?php

use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesarchivesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\invoices_details;

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
    return view('auth.login');
});
Route::get('/index',function(){
    return view('index');
});

Auth::routes();
Route::get('/sections/{id}', [SectionsController::class,'edit'])->name('sections.edit');                                  
Route::get('/products/{id}', [ProductsController::class,'edit'])->name('products.edit');                                  
Route::put('/sections/{id}',[SectionsController::class,'update'])->name('sections.update');
Route::post('/products/{id}',[ProductsController::class,'update'])->name('products.update');
Route::get('/delsections/{id}',[SectionsController::class,'destroy'])->name('section.destroy');
Route::get('delete',[ProductsController::class,'destroy'])->name('product.destroy');
Route::resource('invoices', InvoicesController::class);
Route::get('invoices/create',[InvoicesController::class,'create'])->name('invoices.create');
Route::get('edit_invoice/{id}',[InvoicesController::class,'edit'])->name('invoices.edit');
Route::post('updatinvoice',[InvoicesController::class,'update'])->name('invoices.update');
Route::delete('deleteinvoice',[InvoicesController::class,'destroy'])->name('invoices.destroy');
Route::get('section/{id}',[InvoicesController::class,'getproduct'])->name('invoices.getproduct');
Route::get('Status_show/{id}',[InvoicesController::class,'show'])->name('Status_show');
Route::post('Status_update/{id}',[InvoicesController::class,'Status_update'])->name('Status_update');
Route::get('Invoices_paid',[InvoicesController::class,'Invoices_paid']);
Route::get('Invoices_unpaid',[InvoicesController::class,'Invoices_unpaid']);
Route::get('Print_invoice/{id}',[InvoicesController::class,'print_invoice']);
Route::get('Invoices_Partial',[InvoicesController::class,'Invoices_Partial']);
Route::get('/InvoicesDetails/{id}',[InvoicesDetailsController::class,'edit'])->name('invoices.edit');
Route::post('delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::patch('updatearchive',[InvoicesarchivesController::class,'update'])->name('updatearchive');
Route::delete('deletearchive',[InvoicesarchivesController::class,'destroy'])->name('deletearchive');
Route::get('/open_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file'])->name('open_file');
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'download'])->name('download');
Route::resource('sections', SectionsController::class);
Route::resource('products',ProductsController::class);
Route::resource('InvoicesAttachments',InvoicesAttachmentsController::class);
Route::resource('Invoicesarchives',InvoicesarchivesController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('export_invoices', [InvoicesController::class,'export']);
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');

// Route::get('unreadNotifications_count', 'InvoicesController@unreadNotifications_count')->name('unreadNotifications_count');

// Route::get('unreadNotifications', 'InvoicesController@unreadNotifications')->name('unreadNotifications');

Route::get('invoices_report',[Invoices_Report::class,'index']);
Route::post('Search_invoices',[Invoices_Report::class,'Search_invoices']);
Route::get('Customers_report',[Customers_Report::class,'index']);
Route::post('Search_customers',[Customers_Report::class,'Search_customers']);