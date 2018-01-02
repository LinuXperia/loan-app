<?php

namespace App\Http\Controllers\Loans;

use App\BorrowerPersonalDetails;
use App\Http\Requests\Loan\LoanDetailsRequest;
use App\Http\Requests\Loan\LoanPaymentRequest;
use App\Loan;
use App\Payment;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Webpatser\Uuid\Uuid;

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
        $loanDetails->slug = str_replace('-', '',Uuid::generate()->string);

        if($borrower->loans()->save($loanDetails)){

            $loanDetails->reference_no = 'LOAN/'. date('Y') . '/' . date('m'). '/' . date('d') . '/' . (1000 + $loanDetails->id);
            $loanDetails->save();
        }

        return response()->json([
            'data' => $loanDetails->id
        ], 200);
    }

    /**
     * update loan details
     * @param LoanDetailsRequest|Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLoanDetails(LoanDetailsRequest $request){

        $loanDetails = Loan::findOrFail($request->loan_id);

        if(!$loanDetails){
            return response()->json([
                'error' => 1,
                'message' => 'Select the correct loan'
            ]);
        }

        if ($loanDetails->status == 'paid'){
            return response()->json([
                'error' => 1,
                'message' => 'Loan Fully Paid'
            ]);
        }

        if($request->duration !==  $loanDetails->duration){

            $payment_date  = new DateTime("+".$request->duration." months");
        }else{

            $payment_date = $loanDetails->duration;
        }


        $loanDetails->loan_type = $request->type !==  $loanDetails->loan_type ? $request->type : $loanDetails->loan_type;
        $loanDetails->amount_borrowed = $request->amount !==  $loanDetails->amount_borrowewed ? $request->amount : $loanDetails->amount_borrowewed;
        $loanDetails->amount_to_pay = $request->total_amount !==  $loanDetails->amount_to_pay ? $request->total_amount : $loanDetails->amount_to_pay;
        $loanDetails->duration = $request->duration !==  $loanDetails->duration ? $request->duration : $loanDetails->duration;
        $loanDetails->payment_date = $payment_date;
        $loanDetails->interest_rate = $request->rate !==  $loanDetails->interest_rate ? $request->rate : $loanDetails->interest_rate;
        $loanDetails->legal_fee = $request->legal_fee !==  $loanDetails->legal_fee ? $request->legal_fee : $loanDetails->legal_fee;
        $loanDetails->car_track_installation = $request->car_track !==  $loanDetails->car_track_installation ? $request->car_track : $loanDetails->car_track_installation;
        $loanDetails->car_track_maintenance = $request->car_track_maintenance !==  $loanDetails->car_track_maintenance ? $request->car_track_maintenance : $loanDetails->car_track_maintenance;
        $loanDetails->kra = $request->kra_search !==  $loanDetails->kra ? $request->kra_search : $loanDetails->kra;
        $loanDetails->processing_fee = $request->processing_fee !==  $loanDetails->processing_fee ? $request->processing_fee : $loanDetails->processing_fee;
        $loanDetails->logistics = $request->logistics !==  $loanDetails->logistics ? $request->logistics : $loanDetails->logistics;
        $loanDetails->mv = $request->mv !==  $loanDetails->mv ? $request->mv : $loanDetails->mv;
        $loanDetails->discharge_fee = $request->discharge_fee !==  $loanDetails->discharge_fee ? $request->discharge_fee : $loanDetails->discharge_fee;
        $loanDetails->description = $request->remarks !==  $loanDetails->remarks ? $request->remarks : $loanDetails->remarks;

        $loanDetails->save();

        return response()->json([
            'data' => $loanDetails->id
        ], 200);
    }

    /**
     * Post loan files
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param $ |Request $request
     */
    public function fileUpload(Request $request){

        if(!$request->loan_id){
            return response()->json([
                'error' => 1,
                'message' => 'error no loan id'
            ], 406);
        }

        $loan = Loan::findOrFail($request->loan_id);

        //validate
        $request->validate([
            'image' => 'required'
        ]);

        $image = $request->get('image');

        $path = 'public/firstLine/borrower/loan/'.$loan->user_id . '/' . $loan->slug;

        if (!is_dir($path)){

            Storage::makeDirectory($path);
        }


        $location = Storage::putFileAs(
            $path, $image, 'test.png'
        );

    }




    /**
     * get loan payment view
     * @param LoanPaymentRequest $request
     * @param $id
     * @return view
     */
    public function loanPayment($id){

        $loan =Loan::findOrFail($id);

        $data = [
            'page' => $loan->reference_no . ' /payment',
            'loan' => $loan
        ];

        return view('teller.loans.payment')->with($data);
    }

    /**
     * Post loan details
     * @param LoanPaymentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setLoanPaymentDetails(LoanPaymentRequest $request){

        $loan = Loan::findOrFail($request->loan_id);

        if(!$loan){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This loan does not exist']
                ]
            ], 422);
        }

        if($loan->approved === false){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This loan has not been approved. Contact admin']
                ]
            ], 422);
        }

        if($loan->status === 'paid'){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This loan has fully been paid. Contact admin']
                ]
            ], 422);
        }

        //calculate loan balance

        $balance_before = Payment::loanBalance($loan->id, $loan->amount_to_pay);


        if($request->amount > $balance_before){
            return response()->json([
                'errors' => [
                    'amount'  => [
                        "Amount exceeds loan balance: Balance: ksh.".number_format($balance_before, 2)
                    ]
                ]
            ], 422);
        }

        $payment = new Payment();

        $payment->agent = Auth()->user()->id;
        $payment->amount = $request->amount;
        $payment->payment_mode = $request->mode;
        $payment->cheque_no = $request->cheque_no ? $request->cheque_no : '';
        $payment->mpesa_no = $request->mpesa ? $request->mpesa : '';
        $payment->slug = str_replace('-', '',Uuid::generate()->string);
        $payment->description = $request->description;

        if($loan->payments()->save($payment)){

            $payment->reference_no = 'PAYMENT/'. date('Y') . '/' . date('m'). '/' . date('d') . '/' . $loan->id . '/' . (1000 + $payment->id);
            $payment->save();
        }

        $afterPayment = Payment::loanBalance($loan->id, $loan->amount_to_pay);

       /* if($afterPayment === 0){
            $status = 'paid';
        }elseif ($afterPayment !== 0){
            $status = 'partial';
        }else {
            $status = 'unpaid';
        }

        $loan->status = $status;
        $loan->save();*/

        //send confirm email waiting payment approval


        return response()->json([
            'data' => [
                'payment_id' => $payment->id,
                'balance' => number_format($afterPayment, 2)
                ]
        ], 200);

    }
    /**
     * update loan payment details
     * @param LoanPaymentRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePaymentDetails(LoanPaymentRequest $request){


        $payment = Payment::findOrFail($request->payment_id);


        if(!$payment){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This payment does not exist']
                ]
            ], 422);
        }

        //calculate loan balance

        $loan = Loan::where('id', $payment->loan_id)->first();

        //reset payed amount
        $payment->amount = 0;
        $payment->save();

        $balance_before = Payment::loanBalance($loan->id, $loan->amount_to_pay);


        if($request->amount > $balance_before){
            return response()->json([
                'errors' => [
                    'amount'  => [
                        "Amount exceeds loan balance: Balance: ksh.".number_format($balance_before, 2)
                    ]
                ]
            ], 422);
        }

        $payment->amount = $request->amount;
        $payment->payment_mode = $request->mode !==  $payment->payment_mode ? $request->mode : $payment->payment_mode;
        $payment->cheque_no = $payment->cheque_no !== $request->cheque ? $request->cheque : $payment->cheque_no;
        $payment->mpesa_no = $payment->mpesa_no !== $request->mpesa ? $request->mpesa : $payment->mpesa_no;;

        $payment->description = $request->description !==  $payment->description ? $request->description : $payment->description;

        $payment->save();

        //send confirm email waiting payment approval


        return response()->json([
            'data' => [
                'payment_id' => $payment->id,
                'balance' => number_format(Payment::loanBalance($loan->id, $loan->amount_to_pay), 2)
            ]
        ], 200);
    }


    /**
     * approve loan
     * @param $id
     */
    public function approveLoan($id){

        //role: admin


    }


}
