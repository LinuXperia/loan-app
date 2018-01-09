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

use Barryvdh\DomPDF\Facade as PDF;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//change password
Route::post('/change-password','HomeController@changePassword')->name('agent.changePassword');

/**
===============================================================================
 ****************************ADMIN ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' =>['auth','role:admin']], function (){

    //admin dashboard
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');

    //admin dashboard
    Route::get('/profile', 'AdminController@profile')->name('admin.profile');

    //new agent
    Route::get('/new-agent', 'AdminController@newAgent')->name('new.agent');

    //post new agent
    Route::post('/new-agent', 'AdminController@createNewAgent')->name('new.agent');

    //active agents
    Route::get('/active-agents', 'AdminController@activeAgents')->name('active.agents');

    //inactive agents
    Route::get('/inactive-agents', 'AdminController@inActiveAgents')->name('inactive.agents');

    //all agents
    Route::get('/all-agents', 'AdminController@allAgents')->name('all.agents');

    //agent details
    Route::get('/agent/details/{id}', 'AdminController@agentsDetails')->name('agent.details');

    //Change Account status
    Route::put('/change-status', 'AdminController@changeStatus')->name('agent.change.status');

});


/**
===============================================================================
****************************Agent ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'agent', 'namespace' => 'Teller', 'middleware' => ['auth','role:agent']], function (){

    //dashboard
    Route::get('/dashboard', 'TellerController@index')->name('agent.dashboard');

    //profile
    Route::get('/profile', 'TellerController@profile')->name('agent.profile');


});


/**
===============================================================================
 ****************************CUSTOMER ROUTES**************************************
===============================================================================
 **/

Route::group(/**
 *
 */
    ['prefix' => 'customer', 'namespace' => 'Borrower', 'middleware' => 'auth'], function (){

    //new customer
    Route::get('/new-customer', 'BorrowerController@newCustomer')->middleware('role:agent')->name('new.customer');

    //post personal details form vue
    Route::post('/customer-personal-details', 'BorrowerController@personalDetails')->middleware('role:agent')->name('customer.personalDetails');

    //update personal details form vue
    Route::put('/update-customer-personal-details', 'BorrowerController@updatePersonalDetails')->middleware('role:agent')->name('customer.updatePersonalDetails');

    //post customer next of kin
    Route::post('/customer-next-of-kin', 'BorrowerController@nextOfKin')->middleware('role:agent')->name('customer.nextOfKin');

    //update customer next of kin
    Route::put('/update-customer-next-of-kin', 'BorrowerController@updateNextOfKin')->middleware('role:agent')->name('customer.updateNextOfKin');

    //post customer bank details
    Route::post('/customer-bank-details', 'BorrowerController@bankDetails')->middleware('role:agent')->name('customer.bankDetails');

    //post customer residence details
    Route::post('/customer-residence-details', 'BorrowerController@residenceDetails')->middleware('role:agent')->name('customer.residenceDetails');

    //post customer work details
    Route::post('/customer-work-details', 'BorrowerController@workDetails')->middleware('role:agent')->name('customer.workDetails');

    //post customer business details
    Route::post('/customer-self-employment-details', 'BorrowerController@businessDetails')->middleware('role:agent')->name('customer.businessDetails');

    //post customer referees details
    Route::post('/customer-referees-details', 'BorrowerController@refereesDetails')->middleware('role:agent')->name('customer.refereesDetails');

    //post customer uploads
    Route::post('/account-uploads','BorrowerController@accountUploads')->name('account.uploads');

    //post customer referees details
    Route::post('/complete-profile', 'BorrowerController@completeProfile')->middleware('role:agent')->name('customer.completeProfile');

    //customer list view
    Route::get('/list-of-customers', 'BorrowerController@customerList')->name('customer.list');

    //customer Details
    Route::get('/details/{id}', 'BorrowerController@getCustomerDetails')->name('customer.details');

    //upload avatar
    Route::post('/upload-avatar','BorrowerController@uploadAvatar')->name('upload.avatar');

    //customer loan details
    Route::get('/{user_id}/loan/{loan_id}','BorrowerController@getCustomerLoanDetails')->name('customer.loanDetails');

    //unapproved customers
    Route::get('/unapproved-customers', 'BorrowerController@unApprovedCustomer')->middleware('role:admin')->name('unapproved.customers');

    //approved customers
    Route::get('/approved-customers', 'BorrowerController@approvedCustomer')->middleware('role:admin')->name('approved.customers');

    //declined customers
    Route::get('/declined-customers', 'BorrowerController@declinedCustomer')->middleware('role:admin')->name('declined.customers');

    //dormant customers
    Route::get('/dormant-customers', 'BorrowerController@dormantCustomer')->middleware('role:admin')->name('dormant.customers');

    //blacklisted customers
    Route::get('/blacklisted-customers', 'BorrowerController@blacklistedCustomer')->middleware('role:admin')->name('blacklisted.customers');

    //change customer approve status
    Route::put('/change-approve-status', 'BorrowerController@changeApproveStatus')->middleware('role:admin')->name('change.customers.approve.status');

    //change customer active status
    Route::put('/change-active-status', 'BorrowerController@changeActiveStatus')->middleware('role:admin')->name('change.customers.active.status');

    //blacklist customer
    Route::put('/blacklist-customer', 'BorrowerController@blacklistCustomer')->middleware('role:admin')->name('blacklist.customer');

    //download customer details
    Route::get('/download-account-details/{id}','BorrowerController@downloadAccountDetails')->name('download.account.details');

});

/**
===============================================================================
 ****************************LOAN ROUTES**************************************
===============================================================================
 **/

Route::group(['prefix' => 'loans', 'namespace' => 'Loans', 'middleware' => 'auth'], function () {

    //search loan customer
    Route::get('/index', 'LoansController@index')->middleware('role:agent')->name('loans.index');

    //Loan Details
    Route::get('/{id}/new', 'LoansController@newLoan')->name('loan.new');

    //post loan details
    Route::post('/loan-details', 'LoansController@setLoanDetails')->middleware('role:agent')->name('loan.details');

    //update loan details
    Route::post('/loan-details-update', 'LoansController@updateLoanDetails')->name('loan.update.details');

    //loan upload
    Route::post('/loan-uploads', 'LoansController@loanFileUpload')->name('loan.fileUpload');

    //approve loan
    Route::put('/approve-loan','LoansController@approveLoan')->middleware('role:admin')->name('approve.loan');

    //get approved loan
    Route::get('/approved','LoansController@approvedLoans')->middleware('role:admin')->name('approved.loans');

    //get all loan
    Route::get('/all','LoansController@allLoans')->middleware('role:admin')->name('all.loans');

    //get declined loan
    Route::get('/declined','LoansController@declinedLoans')->middleware('role:admin')->name('declined.loans');

    //unapproved payments list
    Route::get('/unapproved','LoansController@unapprovedLoans')->middleware('role:admin')->name('unapproved.loans');

    //download loan details
    Route::get('/download-loan-details/{id}', 'LoansController@downloadLoanDetails')->name('download.loan.details');

    Route::group(['prefix' => 'payment'], function (){
        //loan payment
        Route::get('/payment/{id}', 'LoansController@loanPayment')->name('loan.payment');

        //post loan payment details
        Route::post('/payment-details', 'LoansController@setLoanPaymentDetails')->middleware('role:agent')->name('loan.payment.details');

        //update loan payment
        Route::put('/payment-details-update', 'LoansController@updatePaymentDetails')->name('loan.update.payment');

        //upload loan payment cheque
        Route::post('/loan-payments-uploads', 'LoansController@paymentUploads')->name('loan.payment.uploads');

        //unapproved payments list
        Route::get('/unapproved', 'LoansController@unapprovedPayments')->middleware('role:admin')->name('unapproved.payments');

        //approved payments list
        Route::get('/approved', 'LoansController@approvedPayments')->middleware('role:admin')->name('approved.payments');

        //declined payments list
        Route::get('/declined', 'LoansController@declinedPayments')->middleware('role:admin')->name('declined.payments');

        //all payments list
        Route::get('/all', 'LoansController@allPayments')->middleware('role:admin')->name('all.payments');

        //approve payments list
        Route::put('/approve-payment', 'LoansController@approvePayment')->middleware('role:admin')->name('approve.payments');

        //loan payments details
        Route::get('/details/{id}', 'LoansController@paymentDetails')->name('payment.detials');

        //download loan payment details
        Route::get('/download-loan-payment-details/{id}', 'LoansController@downloadLoanPaymentDetails')->name('download.loan.payment.details');
    });

});