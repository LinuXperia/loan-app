<?php

namespace App\Http\Controllers\Borrower;

use App\BorrowerBankDetails;
use App\BorrowerNextOfKin;
use App\BorrowerPersonalDetails;
use App\BorrowerResidenceDetails;
use App\BorrowerWorkDetails;
use App\DataTables\Accounts\AllDataTable;
use App\DataTables\Accounts\ApprovedDataTable;
use App\DataTables\Accounts\BlacklistDataTable;
use App\DataTables\Accounts\CustomerLoanDataTable;
use App\DataTables\Accounts\DeclinedDataTable;
use App\DataTables\Accounts\DormantDataTable;
use App\DataTables\Accounts\UnapprovedDataTable;
use App\Http\Requests\Borrower\NextOfKinRequest;
use App\Loan;
use App\Mail\CustomerAccountApproved;
use App\Mail\CustomerCompleteAccount;
use App\RefereesDetails;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Borrower\PersonalDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;



class BorrowerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns new customer view
     **/
    public function newcustomer(){

        $data = [
            'page' => 'New customer'
        ];

        return view('customer.new', $data);
    }

    /**
     * validate and post personal details
     * @param PersonalDetails $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function personalDetails(PersonalDetails $request){

        //create user

        $user = User::create([
            'name' =>$request->sname,
            'email' => $request->email,
            'password' =>  bcrypt($request->email),
            'registered_by' => Auth::user()->id,
        ]);

        //attach role
        $role = Role::findOrFail(3);
        $user->attachRole($role);


        //store personal details

        $details = new BorrowerPersonalDetails();

        $details->account = $this->generateAccountNumber();
        $details->title = $request->title;
        $details->fname = $request->fname;
        $details->sname = $request->sname;
        $details->lname = $request->lname;
        $details->nationality = $request->nationality;
        $details->idNumber = $request->idNumber;
        $details->pin = $request->pin;
        $details->mobile = $request->mobile;
        $details->telephone = $request->telephone;
        $details->dob = $request->dob;
        $details->address = $request->address;
        $details->office = $request->office;
        $details->home = $request->home;
        $details->marital = $request->marital;
        $details->education = $request->education;

      $user->borrowerPersonalDetails()->save($details);

        //return user
        return response()->json([
            'data' =>$user
        ], 200);

    }

    /**
     * validate and update personal details
     * @param PersonalDetails $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePersonalDetails(PersonalDetails $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $userDetails = BorrowerPersonalDetails::where('user_id', $request->id)->first();

        if(!$userDetails){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        $userDetails->title = $request->title !==  $userDetails->title ? $request->title : $userDetails->title;
        $userDetails->fname = $request->fname !==  $userDetails->fname ? $request->fname : $userDetails->fname;
        $userDetails->sname = $request->sname !==  $userDetails->sname ? $request->sname : $userDetails->sname;
        $userDetails->lname = $request->lname !==  $userDetails->lname ? $request->lname : $userDetails->lname;;
        $userDetails->nationality = $request->nationality !==  $userDetails->nationality ? $request->nationality : $userDetails->nationality;
        $userDetails->idNumber = $request->idNumber !==  $userDetails->idNumber ? $request->idNumber : $userDetails->idNumber;
        $userDetails->pin = $request->pin !==  $userDetails->pin ? $request->pin : $userDetails->pin;
        $userDetails->mobile = $request->mobile !==  $userDetails->mobile ? $request->mobile : $userDetails->mobile;
        $userDetails->telephone = $request->telephone !==  $userDetails->telephone ? $request->telephone : $userDetails->telephone;
        $userDetails->dob = $request->dob !==  $userDetails->dob ? $request->dob : $userDetails->dob;
        $userDetails->address = $request->address !==  $userDetails->address ? $request->address : $userDetails->address;
        $userDetails->office = $request->office !==  $userDetails->office ? $request->office : $userDetails->office;
        $userDetails->home = $request->home !==  $userDetails->home ? $request->home : $userDetails->home;
        $userDetails->marital = $request->marital !==  $userDetails->marital ? $request->marital : $userDetails->marital;
        $userDetails->education = $request->education !==  $userDetails->education ? $request->education : $userDetails->education;

        $userDetails->save();

        //return user
        return response()->json([
            'data' => $userDetails
        ], 200);
    }


    /**
     *post next of kin details
     * @param NextOfKinRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function nextOfKin(NextOfKinRequest $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        $details = new BorrowerNextOfKin();

        $details->name = $request->name;
        $details->relationship = $request->relationship;
        $details->phone = $request->phone;
        $details->email = $request->email;
        $details->address = $request->address;

        $user->borrowerNextOfKin()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);
    }

    /**
     *post next of kin details
     * @param NextOfKinRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNextOfKin(NextOfKinRequest $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        $details = BorrowerNextOfKin::where('user_id',$request->id)->first();

        $details->name = $request->name !==  $details->name ? $request->name : $details->name;
        $details->relationship = $request->relationship !==  $details->relationship ? $request->relationship : $details->relationship;
        $details->phone = $request->phone !==  $details->phone ? $request->phone : $details->phone;
        $details->email = $request->email !==  $details->email ? $request->email : $details->email;
        $details->address = $request->address !==  $details->address ? $request->address : $details->address;

        $details->save();

        return response()->json([

            'id' => $details,
        ], 200);
    }

    /**
     * post next of bank details
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bankDetails(Request $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        //validate

        $request->validate([
            'name' => 'required',
            'branch' => 'required',
            'type' => 'required',
            'facility' => 'required',
            'amount' => 'required|numeric',
        ]);

        $details = new BorrowerBankDetails();

        $details->name = $request->name;
        $details->branch = $request->branch;
        $details->type = $request->type;
        $details->facility = $request->facility;
        $details->amount = $request->amount;

        $user->BorrowerBankDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post customer residence details
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function residenceDetails(Request $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        //validate

        $request->validate([
            'address' => 'required',
            'stay' => 'required',
            'previous' => 'nullable',
            'house' => 'required',
            'permanent_address' => 'nullable',
        ]);

        $details = new BorrowerResidenceDetails();

        $details->address = $request->address;
        $details->stay = $request->stay;
        $details->previous = $request->previous;
        $details->house = $request->house;
        $details->permanent_address = $request->permanent_address;

        $user->BorrowerResidenceDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post customer work details
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function workDetails(Request $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        //validate

        $request->validate([
            'employer' => 'required',
            'years' => 'required|numeric',
            'address' => 'required',
            'phone' => 'required',
            'occupation' => 'required',
            'tenure' => 'required',
            'previous_employer' => '',
        ]);

        $details = new BorrowerWorkDetails();

        $details->employer = $request->employer;
        $details->employment_type = $request->employment_type;
        $details->years = $request->years;
        $details->address = $request->address;
        $details->phone = $request->phone;
        $details->occupation = $request->occupation;
        $details->tenure = $request->tenure;
        $details->previous_employer = $request->previous_employer;

        $user->BorrowerWorkDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post customer business details
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function businessDetails(Request $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        //validate

        $request->validate([
            'business_name' => 'required',
            'years' => 'required|numeric',
            'address' => 'required',
            'phone' => 'required',
            'physical_address' => 'required',
            'gross' => 'required|numeric',
            'nature' => 'required',
        ]);

        $details = new BorrowerWorkDetails();

        $details->business_name = $request->business_name;
        $details->employment_type = $request->employment_type;
        $details->years = $request->years;
        $details->address = $request->address;
        $details->phone = $request->phone;
        $details->business_physical_address = $request->physical_address;
        $details->business_gross = $request->gross;
        $details->business_nature = $request->nature;

        $user->BorrowerWorkDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post customer referees details
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refereesDetails(Request $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        //validate

        $request->validate([
            'name' => 'required',
            'relationship' => 'required',
            'acquainted' => 'required|numeric',
            'nationality' => 'required',
            'home_phone' => 'nullable|numeric',
            'work_phone' => 'nullable|numeric',
            'mobile_phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $details = new RefereesDetails();

        $details->name = $request->name;
        $details->relationship = $request->relationship;
        $details->acquainted = $request->acquainted;
        $details->nationality = $request->nationality;
        $details->home_phone = $request->home_phone;
        $details->work_phone = $request->work_phone;
        $details->mobile_phone = $request->mobile_phone;
        $details->email = $request->email;
        $details->address = $request->address;

        $user->refereesDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * Account Uploads
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accountUploads(Request $request){

        $request->validate([
            'image' => 'required',
            'upload' => 'required'
        ]);

        $imageName = $request->upload.'.png';

        $img = Image::make($request->get('image'))->encode('png', 100);

        $user = User::findOrFail($request->id);

        $path = storage_path(). '/app/public/uploads/account/'. $user->borrowerPersonaldetails->account .'/';

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
     * complete customers profile
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeProfile(Request $request){

        //get user
        if(!$request->id){
            return response()->json([
                'message' => 'no user found',
            ], 406);
        }

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([

                'message' => 'no user found',
            ], 406);
        }

        $user->complete = true;
        $user->save();

        $pdf = PDF::loadView('customer.pdf.accountDetails', ['user' => $user]);
        //send email
        Mail::to($user)->send(new CustomerCompleteAccount($user, $pdf));

        return response()->json([

            'message' => 'success',
        ], 200);


    }

    /**
     * upload customer avatar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(Request $request){

        $request->validate([
            'avatar' => 'required',
        ]);

        $imageName = $request->id.'.png';

        $img = Image::make($request->get('avatar'))->resize(240, 240)->encode('png', 100);

        $path = storage_path(). '/app/public/uploads/avatars/';

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
     * customer list view
     * @param AllDataTable $dataTable
     * @return $this
     */
    public function customerList(AllDataTable $dataTable){

        $data = [
            'page' => 'customer list'
        ];

        return $dataTable->render('customer.borrowerList', $data);
    }

    /**
     * customer details view
     * @param CustomerLoanDataTable $dataTable
     * @param $id
     * @return $this
     */
    public function getCustomerDetails(CustomerLoanDataTable $dataTable, $id){

        $personalDetails = User::findOrFail($id)->borrowerPersonalDetails;
        $personalDetails->email = User::findOrFail($id)->email;
        $personalDetails->status = User::findOrFail($id)->status;
        $personalDetails->approved = User::findOrFail($id)->approved;

        $nextOfKinDetails = User::findOrFail($id)->borrowerNextOfKin;
        $bankDetails = User::findOrFail($id)->borrowerBankDetails;

        $customer = User::findOrFail($id);

        $data = [
            'page' => 'customer details',
            'personalDetails' => $personalDetails,
            'nextOfKinDetails' => $nextOfKinDetails,
            'bankDetails' => $bankDetails,
            'user_id' => $personalDetails->user_id,
            'customer' => $customer,
        ];

        return $dataTable->with('id',$id)->render('customer.customerDetails', $data);

    }

    /**
     * return customer loan details
     * @param $user_id
     * @param $loan_id
     * @return view
     */
    public function getCustomerLoanDetails($user_id, $loan_id){


        $loan = Loan::findOrFail($loan_id);

        $loan->issued_by = User::getNameFromId($loan->agent);

        if($loan->approved !== null){

            $loan->approved_by = User::getNameFromId($loan->approved_by);
        }

        //user details
        $userDetails = borrowerPersonalDetails::where('user_id',$user_id)->first();
        $userDetails->email = User::findOrFail($user_id)->email;

        $loan->loanBalance = Loan::loanBalance($loan_id, $loan->amount_to_pay);

        $data = [
            'page' => 'loan details',
            'user_id' => $user_id,
            'user' => $userDetails,
            'loan' => $loan
        ];



        return view('customer.loanDetails')->with($data);
    }

    /**
     * unapproved customers
     * @param UnapprovedDataTable $dataTable
     * @return view
     */
    public function unApprovedCustomer(UnapprovedDataTable $dataTable){

        $data = [
            'page' => 'unapproved customer accounts'
        ];

        return $dataTable->render('customer.unapproved', $data);

    }


    /**
     * approved customers
     * @param ApprovedDataTable $dataTable
     * @return view
     */
    public function approvedCustomer(ApprovedDataTable $dataTable){

        $data = [
            'page' => 'approved customer accounts'
        ];

        return $dataTable->render('customer.approved', $data);
    }

    /**
     * declined customers
     * @param DeclinedDataTable $dataTable
     * @return view
     */
    public function declinedCustomer(DeclinedDataTable $dataTable){

        $data = [
            'page' => 'declined customer accounts'
        ];

        return $dataTable->render('customer.declined', $data);

    }

    /**
     * dormant customers
     * @param DormantDataTable $dataTable
     * @return view
     */
    public function dormantCustomer(DormantDataTable $dataTable){

        $data = [
            'page' => 'dormant customer accounts'
        ];

        return $dataTable->render('customer.dormant', $data);

    }

    /**
     * blacklisted customers
     * @param BlacklistDataTable $dataTable
     * @return view
     */
    public function blacklistedCustomer(BlacklistDataTable $dataTable){

        $data = [
            'page' => 'customer list'
        ];

        return $dataTable->render('customer.blacklisted', $data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeApproveStatus(Request $request){

        $customer = User::findOrFail($request->id);

        if(!$customer){
            return response()->json([
                'errors' => [
                    'approved' => [
                        'This customer does not exist'
                    ]
                ]
            ], 406);
        }

        $approved = '';

        if($request->status == 'active'){

            $approved = true;

        }elseif ($request->status == 'declined'){

            $approved = false;
        }

        $customer->approved = $approved;
        $customer->status = $request->status;
        $customer->save();

         if($customer->approved == true && $customer->status == 'active'){
             //send approved account email

             Mail::to($customer)->send(new CustomerAccountApproved($customer));
         }

        return response()->json([
            'success' => [
                'approved' => [
                    'Approved Status Updated'
                ],
                'status' => $approved
            ]
        ], 200);
    }

    /**
     * activate or deactivate customer account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeActiveStatus(Request $request){

        $customer = User::findOrFail($request->id);

        if(!$customer){
            return response()->json([
                'errors' => [
                    'approved' => [
                        'This customer does not exist'
                    ]
                ]
            ], 406);
        }
        if($customer->complete == false){
            return response()->json([
                'errors' => [
                    'approved' => [
                        'This customer account is not complete for approval.'
                    ]
                ]
            ], 406);
        }

        $approved = '';

        if($request->status == 'active'){

            $approved = true;

        }elseif ($request->status == 'dormant'){

            $approved = $customer->approved;
        }


        $customer->approved = $approved;
        $customer->status = $request->status;
        $customer->save();

        return response()->json([
            'success' => [
                'approved' => [
                    'Account status has been updated'
                ]
            ]
        ], 200);
    }

    /**
     * blacklist customer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blacklistCustomer(Request $request){

        $customer = User::findOrFail($request->id);

        if(!$customer){
            return response()->json([
                'errors' => [
                    'approved' => [
                        'This customer does not exist'
                    ]
                ]
            ], 406);
        }

        $approved = '';

        if($request->status == 'active'){

            $approved = true;

        }elseif ($request->status == 'blacklisted'){

            $approved = $customer->approved;
        }

        $customer->approved = $approved;
        $customer->status = $request->status;
        $customer->save();

        return response()->json([
            'success' => [
                'approved' => [
                    'Blacklist status has been updated'
                ]
            ]
        ], 200);
    }


    /**
     * download account details
     * @param $id
     */
    public function downloadAccountDetails($id){

        $user = User::findOrFail($id);

        if(!$user){
            return back()->withError('No User found');
        }

        $pdf = PDF::loadView('customer.pdf.accountDetails', ['user' => $user]);

        return $pdf->download($user->name . '_account_details.pdf');
    }


    /**
     * generate account number
     * @return int
     */
    protected  function generateAccountNumber() {

        $number = mt_rand(1000000000, 9999999999); // better than rand()

        // call the same function if the account number exists already
        if (BorrowerPersonalDetails::accountNumberExist($number)) {

            return $this->generateAccountNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

}
