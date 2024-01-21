<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [InvoiceController::class, 'index'])->name('invoices');

// only authenticated users can access the site
Route::middleware(['auth'])->group(function () {


    /* // Show all invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    // Show the create invoice form
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');

    // Store a new invoice
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');

    // Show a specific invoice
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

    // Show the edit invoice form
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');

    // Update the invoice
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');

    // Update the invoice status
    Route::patch('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');

    // Delete the invoice
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
 */




    Route::put('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
    //Route::patch('invoices/{invoice}', 'InvoiceController@update ')->name('invoices.update');
    //Route::get('invoices/{invoice}/pdf', 'InvoiceController@printPDF')->name('invoices.download');
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'printPDF'])->name('invoices.download');

    Route::resource('invoices', InvoiceController::class); // used previous of update Status route
});
