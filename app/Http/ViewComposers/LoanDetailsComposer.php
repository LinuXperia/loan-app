<?php

namespace App\Http\ViewComposers;

use App\Loan;
use App\Payment;
use Illuminate\View\View;

class LoanDetailsComposer
{



    /**
     * Create a new profile composer.
     *
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

        $totalLoan = Loan::totalLoan($view->user_id);

        $totalInterest = Loan::totalInterest($view->user_id);

        $totalPayment = Payment::totalPayment($view->user_id);

        $totalBalance =  ($totalLoan + $totalInterest )- $totalPayment;


        $view->with('totalLoan', $totalLoan);
        $view->with('totalInterest', $totalInterest);
        $view->with('totalPayment', $totalPayment);
        $view->with('totalBalance', $totalBalance);
    }
}