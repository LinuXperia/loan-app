<?php
/**
 * Created by PhpStorm.
 * User: amon
 * Date: 1/8/18
 * Time: 10:20 AM
 */

namespace app\Http\ViewComposers;

use App\Loan;
use App\Payment;
use App\User;
use Illuminate\View\View;


class SideBarComposer
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

        $unapprovedAccounts= User::unapprovedAccounts();

        $unapprovedLoans= Loan::unapprovedLoans();

        $unapprovedPayments = Payment::unapprovedPayments();


        $view->with('unapprovedAccounts', $unapprovedAccounts);
        $view->with('unapprovedLoans', $unapprovedLoans);
        $view->with('unapprovedPayments', $unapprovedPayments);
    }

}