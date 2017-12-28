<?php

namespace App\Http\Controllers\Loans;

use App\BorrowerPersonalDetails;
use App\Http\Requests\Loan\LoanDetailsRequest;
use App\Loan;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoansController extends Controller
{

    /**
     * return borrower search view
    **/
    public function index(){

        $data = [
            'page' => 'search borrower'
        ];

        return view('teller.loans.index')->with($data);
    }

    /**
     * return new loan view
     **/
    public function newLoan($id){



        $borrower = User::findOrFail($id);


        if(!$borrower){
            return redirect()->back()->withError('That user does not exist!, contact admin');
        }

        if(!$borrower->hasRole('borrower')){
            return redirect()->back()->withError('This Borrower does qualify as a borrower!, contact admin');

        }

        if($borrower->complete !== 1){
            return redirect()->back()->withError('This Borrower profile is not complete!, complete profile first');

        }

        $borrower->fname =  User::findOrFail($id)->borrowerPersonalDetails()->first()->fname;
        $borrower->mobile =  User::findOrFail($id)->borrowerPersonalDetails()->first()->mobile;
        $borrower->address =  User::findOrFail($id)->borrowerPersonalDetails()->first()->address;

        $data = [
            'page' => 'new loan',
            'borrower' => $borrower
        ];

        return view('teller.loans.new')->with($data);
    }

    /**
     * Post loan details
     * @param LoanDetailsRequest|Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setLoanDetails(LoanDetailsRequest $request){


        $borrower = User::findOrFail($request->user_id);

        if($borrower->complete !== 1 ){
            return redirect()->back()->withError('This Borrower profile is not complete!, complete profile first');
        }

        if($request->total_amount < 1){

            return response()->json([
                'error' => 1,
                'message' => 'Amount must be more than 1'
            ], 406);
        }

        $payment_date  = new DateTime("+".$request->duration." months");


        $loanDetails = new Loan();

        $loanDetails->agent = $request->agent_id;
        $loanDetails->loan_type = $request->type;
        $loanDetails->amount_borrowed = $request->amount;
        $loanDetails->amount_to_pay = $request->total_amount;
        $loanDetails->duration = $request->duration;
        $loanDetails->payment_date = $payment_date;
        $loanDetails->interest_rate = $request->rate;
        $loanDetails->legal_fee = $request->legal_fee;
        $loanDetails->car_track_installation = $request->car_track;
        $loanDetails->car_track_maintenance = $request->car_track_maintenance;
        $loanDetails->kra = $request->kra_search;
        $loanDetails->processing_fee = $request->processing_fee;
        $loanDetails->logistics = $request->logistics;
        $loanDetails->mv = $request->mv;
        $loanDetails->discharge_fee = $request->discharge_fee;
        $loanDetails->description = $request->remarks;

        $borrower->loans()->save($loanDetails);

        return response()->json([
            'data' => $borrower
        ], 200);
    }

}
