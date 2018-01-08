<?php
/**
 * Created by PhpStorm.
 * User: amon
 * Date: 1/8/18
 * Time: 10:48 AM
 */

namespace app\Http\ViewComposers;


use App\Loan;
use App\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgentStatisticsComposer
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

        $totalLoanAmount = Loan::dailyAmountByAgent(Auth::user()->id);
        $totalPaymentAmount = Payment::dailyAmountByAgent(Auth::user()->id);
        $totalLoansIssued = Loan::DailyAmountCountByAgent(Auth::user()->id);
        $totalPaymentsReceived = Payment::DailyAmountCountByAgent(Auth::user()->id);


        $view->with('totalLoanAmount', $totalLoanAmount);
        $view->with('totalPaymentAmount', $totalPaymentAmount);
        $view->with('totalLoansIssued', $totalLoansIssued);
        $view->with('totalPaymentsReceived', $totalPaymentsReceived);

    }
}