<?php

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
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
===============================================================================
 ****************************ADMIN ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'admin'], function (){

    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
});


/**
===============================================================================
****************************TELLER ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'teller', 'namespace' => 'Teller', 'middleware' => ['auth','role:teller']], function (){

    Route::get('/dashboard', 'TellerController@index')->name('teller.dashboard');



});


/**
===============================================================================
 ****************************BORROWER ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'borrower', 'namespace' => 'Borrower', 'middleware' => ['auth','role:teller,admin']], function (){

    //new borrower
    Route::get('/new-borrower', 'BorrowerController@newBorrower')->name('new.borrower');

    //post personal details form vue
    Route::post('/borrower-personal-details', 'BorrowerController@personalDetails')->name('borrower.personalDetails');

    //update personal details form vue
    Route::put('/update-borrower-personal-details', 'BorrowerController@updatePersonalDetails')->name('borrower.updatePersonalDetails');

    //post borrower next of kin
    Route::post('/borrower-next-of-kin', 'BorrowerController@nextOfKin')->name('borrower.nextOfKin');

    //update borrower next of kin
    Route::put('/update-borrower-next-of-kin', 'BorrowerController@updateNextOfKin')->name('borrower.updateNextOfKin');

    //post borrower bank details
    Route::post('/borrower-bank-details', 'BorrowerController@bankDetails')->name('borrower.bankDetails');

    //post borrower residence details
    Route::post('/borrower-residence-details', 'BorrowerController@residenceDetails')->name('borrower.residenceDetails');

    //post borrower work details
    Route::post('/borrower-work-details', 'BorrowerController@workDetails')->name('borrower.workDetails');

    //post borrower business details
    Route::post('/borrower-self-employment-details', 'BorrowerController@businessDetails')->name('borrower.businessDetails');

    //post borrower referees details
    Route::post('/borrower-referees-details', 'BorrowerController@refereesDetails')->name('borrower.refereesDetails');

    //post borrower referees details
    Route::post('/complete-profile', 'BorrowerController@completeProfile')->name('borrower.completeProfile');

    //borrower list view
    Route::get('/list-of-borrowers', 'BorrowerController@borrowerList')->name('borrower.list');

    //borrower list
    Route::get('/get-borrower-list', 'BorrowerController@getBorrowerList')->name('getBorrowerList');

    //borrower Details
    Route::get('/details/{id}', 'BorrowerController@getBorrowerDetails')->name('borrower.details');

});

/**
===============================================================================
 ****************************LOAN ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'loans', 'namespace' => 'Loans', 'middleware' => ['auth','role:teller,admin']], function () {

    //search loan borrower
    Route::get('/index', 'LoansController@index')->name('loans.index');

    //search loan borrower
    Route::get('/{id}', 'LoansController@newLoan')->name('loan.new');

    //post loan details
    Route::post('/loan-details', 'LoansController@setLoanDetails')->name('loan.details');

    //post loan details
    Route::post('/loan-details-update', 'LoansController@updateLoanDetails')->name('loan.update.details');

    //loan upload
    Route::post('/upload', 'LoansController@fileUpload')->name('loan.fileUpload');

});