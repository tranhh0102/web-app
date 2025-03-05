<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterExpenseController;
use App\Http\Controllers\MasterIncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::view('/stastic', 'pages.stastic')->name('stastic');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/',[HomeController::class, 'index'])->name('home');
    Route::get('/search',[HomeController::class, 'listSearch'])->name('home-search');
    Route::get('/transactions', [HomeController::class, 'getTransactions']);


    Route::prefix('/master-category')->group(function() {
        Route::prefix('/income')->group(function() {
            Route::get('/', [MasterIncomeController::class, 'index'])->name('mincome.index');
            Route::delete('/{id}', [MasterIncomeController::class, 'delete'])->name('mincome.delete');
            Route::post('/insert', [MasterIncomeController::class, 'insert'])->name('mincome.insert');
        });
        Route::prefix('/expense')->group(function() {
            Route::get('/', [MasterExpenseController::class, 'index'])->name('mexpense.index');
            Route::delete('/{id}', [MasterExpenseController::class, 'delete'])->name('mexpense.delete');
            Route::post('/insert', [MasterExpenseController::class, 'insert'])->name('mexpense.insert');
        });
    });
    Route::prefix('/transactions')->group(function() {
        //add expense and income
        Route::get('/add-expense', [TransactionController::class, 'addExpenses'])->name('transaction.add-expense');
        Route::get('/add-income', [TransactionController::class, 'addIncome'])->name('transaction.add-income');
        //update expense and income
        Route::get('/update-expense/{id}', [TransactionController::class, 'getUpdateExpense'])->name('transaction.update-expense');
        Route::get('/update-income/{id}', [TransactionController::class, 'getUpdateIncome'])->name('transaction.update-income');
        Route::post('/update-income/{id}', [TransactionController::class, 'updateIncome'])->name('transaction.update-income');
        Route::post('/update-expense/{id}', [TransactionController::class, 'updateExpense'])->name('transaction.update-expense');

        Route::post('/expense', [TransactionController::class, 'expenseTransaction'])->name('transaction.expense');
        Route::post('/income', [TransactionController::class, 'incomeTransaction'])->name('transaction.income');
        Route::post('/goals', [TransactionController::class, 'goalTransaction'])->name('transaction.goal');
        Route::post('/charity', [TransactionController::class, 'charityTransaction'])->name('transaction.charity');
    });
    Route::get('/statistic', [MasterExpenseController::class, 'index'])->name('statistic.index');
});

require __DIR__ . '/auth.php';
