<?php

namespace App\Http\Controllers\Loans;

use App\DataTables\Loans\AllDataTable;
use App\DataTables\Loans\ApprovedDataTable;
use App\DataTables\Loans\DeclinedDataTable;
use App\DataTables\Loans\NewDataTable;
use App\Http\Requests\Loan\LoanDetailsRequest;
use App\Http\Requests\Loan\LoanPaymentRequest;
use App\DataTables\Payments\NewDataTable as NewPaymentDataTable;
use App\DataTables\Payments\AllDataTable as AllPaymentDataTable;
use App\DataTables\Payments\DeclinedDataTable as DeclinedPaymentDataTable;
use App\DataTables\Payments\ApprovedDataTable as ApprovedPaymentDataTable;
use App\Loan;
use App\Mail\ApprovedLoan;
use App\Mail\ApprovedPayment;
use App\Mail\NewLoan;
use App\Mail\NewPayment;
use App\Payment;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Webpatser\Uuid\Uuid;
use Barryvdh\DomPDF\Facade as PDF;

class LoansController extends Controller
{

    /**
     * return customer search view
    **/
    public function index(){

        $data = [
            'page' => 'search customer'
        ];

        return view('agent.loans.index')->with($data);
    }

    /**
     * return new loan view
     * @param $id
     * @return $this
     */
    public function newLoan($id){


        $customer = User::findOrFail($id);


        if(!$customer){
            return redirect()->back()->withError('That user does not exist!, Select Correct User');
        }

        if(!$customer->hasRole('customer')){

            return redirect()->back()->withError('This customer does qualify as a customer!, contact admin');

        }

        if($customer->complete === false){

            return redirect()->back()->withError('This customer profile is not complete!, complete profile first');
        }

        if($customer->approved === null){

            return redirect()->back()->withError('This customer account is not approved!, contact admin to approve');
        }

        if($customer->approved === false){

            return redirect()->back()->withError('This customer account has been declined!, contact admin to approve');
        }

        if($customer->status !== 'active'){
            return redirect()->back()->withError('This customer  account is ' .$customer->status .'!, contact admin to approve');
        }

        $customer->fname =  User::findOrFail($id)->borrowerPersonalDetails()->first()->fname;
        $customer->mobile =  User::findOrFail($id)->borrowerPersonalDetails()->first()->mobile;
        $customer->address =  User::findOrFail($id)->borrowerPersonalDetails()->first()->address;

        $data = [
            'page' => 'new loan',
            'customer' => $customer
        ];

        return view('agent.loans.new')->with($data);
    }

    /**
     * Post loan details
     * @param LoanDetailsRequest|Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setLoanDetails(LoanDetailsRequest $request){


        $customer = User::findOrFail($request->user_id);

        if($customer->complete !== 1 ){
            return redirect()->back()->withError('This customer profile is not complete!, complete profile first');
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

        if($customer->loans()->save($loanDetails)){

            $loanDetails->reference_no = 'LOAN/'. date('Y') . '/' . date('m'). '/' . date('d') . '/' . (1000 + $loanDetails->id);
            $loanDetails->save();
        }

        $pdf = PDF::loadView('loans.pdf.loanDetails', ['loan' => $loanDetails]);
        Mail::to($customer)->send(new NewLoan($loanDetails, $pdf));

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
    public function loanFileUpload(Request $request){

        if(!$request->id){
            return response()->json([
                'errors' => [
                    'upload' => ['error no loan id']
                ]

            ], 406);
        }

        $request->validate([
            'image' => 'required',
            'upload' => 'required'
        ]);

        $imageName = $request->upload.'.png';

        $img = Image::make($request->get('image'))->encode('png', 100);

        $loan = Loan::findOrFail($request->id);

        $path = storage_path(). '/app/public/uploads/loans/'. $loan->user->borrowerPersonaldetails->account .'/'.$loan->id.'/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        \File::put($path . $imageName, $img);

        return response()->json([
            'success' => [
                'upload' => ['file uploaded successfully.']
            ],
        ], 200);
    }

    /**
     * all loans
     * @param AllDataTable $dataTable
     * @return $this
     */
    public function allLoans(AllDataTable $dataTable){

        $data = [
            'page' => 'all loans'
        ];

        return $dataTable->render('loans.all', $data);
    }

    /**
     * Approved loans
     * @param ApprovedDataTable $dataTable
     * @return $this

     */
     public function approvedLoans(ApprovedDataTable $dataTable){

         $data = [
             'page' => 'approved loans'
         ];

         return $dataTable->render('loans.approved', $data);
     }

    /**
     * Declined loans
     * @param DeclinedDataTable $dataTable
     * @return $this
     */
    public function declinedLoans(DeclinedDataTable $dataTable){
        $data = [
            'page' => 'declined loans'
        ];

        return $dataTable->render('loans.declined', $data);
    }

    /**
     * unApproved loans
     * @param NewDataTable $dataTable
     * @return $this
     */
    public function unapprovedLoans(NewDataTable $dataTable){

        $data = [
            'page' => 'new loans'
        ];

        return $dataTable->render('loans.unapproved', $data);
    }

    /**
     * get loan payment view
     * @param $id
     * @return view
     * @internal param LoanPaymentRequest $request
     */
    public function loanPayment($id){

        $loan =Loan::findOrFail($id);

        $data = [
            'page' => $loan->reference_no . ' /payment',
            'loan' => $loan
        ];

        return view('agent.loans.payment')->with($data);
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
            ], 406);
        }

        if($loan->approved === null){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This loan has not been approved. Contact admin']
                ]
            ], 406);
        }

        if($loan->approved === false){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This loan has not been declined. Contact admin']
                ]
            ], 406);
        }

        if($loan->status === 'paid'){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This loan has fully been paid. Contact admin']
                ]
            ], 406);
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
            ], 406);
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

        //send confirm email waiting payment approval
        $pdf = PDF::loadView('payments.pdf.paymentDetails', ['payment' => $payment]);
        Mail::to($payment->loan->user)->send(new NewPayment($payment, $pdf));

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePaymentDetails(LoanPaymentRequest $request){


        $payment = Payment::findOrFail($request->payment_id);


        if(!$payment){
            return response()->json([
                'errors' => [
                    'reference_no'  => ['This payment does not exist']
                ]
            ], 406);
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
            ], 406);
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
     *Loan Payment uploads
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentUploads(Request $request){

        if(!$request->id){
            return response()->json([
                'errors' => [
                    'upload' => ['error no payment id']
                ]

            ], 406);
        }

        $request->validate([
            'image' => 'required',
            'upload' => 'required'
        ]);

        $imageName = $request->upload.'.png';

        $img = Image::make($request->get('image'))->encode('png', 100);

        $payment = Payment::findOrFail($request->id);

        $path = storage_path(). '/app/public/uploads/payments/'. $payment->loan->user->borrowerPersonaldetails->account.'/'.$payment->loan->id.'/' .'/'.$payment->id.'/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        \File::put($path . $imageName, $img);

        return response()->json([
            'success' => [
                'upload' => ['file uploaded successfully.']
            ],
        ], 200);
    }

    /**
     * approve loan
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveLoan(Request $request){

        $loan = Loan::findOrFail($request->id);

        if(!$loan){
            return response()->json([
                'errors' => [
                    'approved'  => ['This loan does not exist']
                ]
            ], 406);
        }

        $loan->approved = $request->status;
        $loan->approved_by = Auth::user()->id;
        $loan->approved_date = Carbon::now();
        $loan->payment_date = Carbon::today()->addMonths($loan->duration);

        $loan->save();


        //TODO:send loan approve email
        Mail::to($loan->user)->send(new ApprovedLoan($loan));

        return response()->json([
            'success' => [
                'approved'  => ['Loan has been approved. refresh page']
            ]
        ], 200);
    }

    /**
     * payment Details
     * @param $id
     * @return $this
     */
    public function paymentDetails($id){

        $payment = Payment::findOrFail($id);

        if (!$payment){

            return back()->withError('Payment Not Found');
        }

        $loan = Loan::findOrFail($payment->loan_id);

        if (!$loan){

            return back()->withError('Loan Not Found');
        }

        if($loan->approved !== null){

            $loan->issued_by = User::getNameFromId($loan->agent);
        }

        $payment->received_by = User::getNameFromId($payment->agent);

        $loan->balance = Loan::loanBalance($loan->id, $loan->amount_to_pay);

        $data = [
            'page' => 'Loan Payment details',
            'loan' => $loan,
            'payment' => $payment
        ];

        return view('payments.details')->with($data);
    }

    /**
     * unapproved payments
     * @param \App\DataTables\Payments\NewDataTable $dataTable
     * @return $this
     * @internal param Builder $builder
     */
    public function unapprovedPayments(NewPaymentDataTable $dataTable){

        $data = [
            'page' => 'new loan payments'
        ];

        return $dataTable->render('payments.unapproved', $data);
    }

    /**
     * approved payments
     * @param ApprovedPaymentDataTable $dataTable
     * @return $this
     */
    public function approvedPayments(ApprovedPaymentDataTable $dataTable){

        $data = [
            'page' => 'approved loan payments'
        ];

        return $dataTable->render('payments.approved', $data);
    }

    /**
     * declined payments
     * @param DeclinedPaymentDataTable $dataTable
     * @return $this
     */
    public function declinedPayments(DeclinedPaymentDataTable $dataTable){

        $data = [
            'page' => 'declined loan payments'
        ];

        return $dataTable->render('payments.declined', $data);
    }

    /**
     * all payments
     * @param AllPaymentDataTable $dataTable
     * @return $this
     */
    public function allPayments(AllPaymentDataTable $dataTable){

        $data = [
            'page' => 'all loan payments'
        ];

        return $dataTable->render('payments.all', $data);
    }

    /**
     * approve payment
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvePayment(Request $request){

        $payment = Payment::findOrFail($request->id);

        if(!$payment){
            return response()->json([
                'errors' => [
                    'approved'  => ['This payment does not exist']
                ]
            ], 406);
        }

        $payment->approved = $request->status;
        $payment->save();

        $loan = Loan::findOrFail($payment->loan_id);

        $loanBalance = Loan::loanBalance($loan->id, $loan->amount_to_pay);

        if($loanBalance === 0){
            $status = 'paid';
        }elseif ($loanBalance > 0){
            $status = 'partial';
        }else {
            $status = 'unpaid';
        }

        $loan->status = $status;
        $loan->save();

        Mail::to($loan->user)->send(new ApprovedPayment($payment));

        return response()->json([
            'success' => [
                'approved'  => ['This payment has been approved and updated. refresh page to confirm']
            ]
        ], 200);
    }

    /**
     * download loan details
     * @param $id
     */
    public function downloadLoanDetails($id){

        $loan = Loan::findOrFail($id);

        if(!$loan){
            return back()->withError('No loan found');
        }

        $pdf = PDF::loadView('loans.pdf.loanDetails', ['loan' => $loan]);

        return $pdf->download($loan->user->name . '_loan_details.pdf');
    }

    /**
     * download loan details
     * @param $id
     */
    public function downloadLoanPaymentDetails($id){

        $payment = Payment::findOrFail($id);

        if(!$payment){
            return back()->withError('No payment found');
        }

        $pdf = PDF::loadView('payments.pdf.paymentDetails', ['payment' => $payment]);

        return $pdf->download($payment->loan->user->name .'_loan_payment_details.pdf');
    }
}
