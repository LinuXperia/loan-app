<?php

namespace App\Http\ViewComposers;

use App\Loan;
use App\Payment;
use Illuminate\View\View;

class LoanStatisticsComposer
{

    /**
     * Create a new profile composer.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...


    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $dailyLoan = Loan::dailyLoan();
        $dailyPayment = Payment::dailyPayment();
        $approvedLoans = Loan::dailyApprovedLoans();
        $approvedPayments = Payment::dailyApprovedPayments();

        $view->with('dailyLoan', $dailyLoan);
        $view->with('dailyPayment', $dailyPayment);
        $view->with('approvedLoans', $approvedLoans);
        $view->with('approvedPayments', $approvedPayments);

    }
}