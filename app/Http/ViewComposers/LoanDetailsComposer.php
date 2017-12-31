<?php

namespace App\Http\ViewComposers;

use App\Loan;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoanDetailsComposer
{

    /**
     * @var UserRepository
     */

    /**
     * Create a new profile composer.
     *
     * @param $user_id
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

        $totalLoan = Loan::totalLoan($view->personalDetails->user_id);
        $totalInterest = Loan::totalInterest($view->personalDetails->user_id);

        //TODO:totalPayment
        //TODO:totalBalance


        $view->with('totalLoan', $totalLoan);
        $view->with('totalInterest', $totalInterest);
        $view->with('totalPayment', '0');
        $view->with('totalBalance', '0');
    }
}