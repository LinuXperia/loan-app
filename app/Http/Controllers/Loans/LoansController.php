<?php

namespace App\Http\Controllers\Loans;

use App\BorrowerPersonalDetails;
use App\Http\Requests\Loan\LoanDetailsRequest;
use App\Loan;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $borrower->loans()->save($loanDetails);

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
                'data' => 'error no loan id'
            ], 406);
        }

        //validate
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        } else {
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/').$fileName);
            return response()->json(['error'=>false]);
        }
    }

}
