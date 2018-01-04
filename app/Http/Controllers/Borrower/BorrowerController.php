<?php

namespace App\Http\Controllers\Borrower;

use App\BorrowerBankDetails;
use App\BorrowerNextOfKin;
use App\BorrowerPersonalDetails;
use App\BorrowerResidenceDetails;
use App\BorrowerWorkDetails;
use App\Http\Requests\Borrower\NextOfKinRequest;
use App\Loan;
use App\RefereesDetails;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Borrower\PersonalDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

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

        $details->account = $this->generateAccount();
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

        return response()->json([

            'message' => 'success',
        ], 200);


    }

    /**
     * customer list view
     * @param Builder $builder
     * @return $this
     */
    public function customerList(Builder $builder){

        if (request()->ajax()) {

            $model = User::withRole('customer')->get();

            foreach ($model as $m){
                $m->registered_by = User::registeredBy($m->registered_by);
                $m->idNumber = User::find($m->id)->borrowerPersonalDetails()->first()->idNumber;
                $m->account = User::find($m->id)->borrowerPersonalDetails()->first()->account;
                $m->mobile = User::find($m->id)->borrowerPersonalDetails()->first()->mobile;

            }

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                        return '<a href="details/'.$model->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $data = [
            'page' => 'customer list'
        ];

        $html = $builder->columns([

            ['data' => 'account', 'name' => 'account', 'title' => 'Account No.'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Sur Name'],
                ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
                [
                    'data' => 'idNumber',
                    'name' => 'idNumber',
                    'title' => 'ID Number',
                ],
                [
                    'data' => 'complete',
                    'name' => 'complete',
                    'title' => 'Complete',
                    'render' => 'function(){
                    
                                     return data == \'1\' ? \'complete\' : \'incomplete\'
                                }',
                ],
                ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Phone No.'],

                ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
                ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

            ]);

        return view('customer.borrowerList')->with(compact('html'))->with($data);

    }

    /**
     * customer details view
     * @param Builder $builder
     * @param $id
     * @return $this
     */
    public function getCustomerDetails(Builder $builder, $id){

        $personalDetails = User::findOrFail($id)->borrowerPersonalDetails;
        $personalDetails->email = User::findOrFail($id)->email;
        $personalDetails->status = User::findOrFail($id)->status;
        $personalDetails->approved = User::findOrFail($id)->approved;

        $nextOfKinDetails = User::findOrFail($id)->borrowerNextOfKin;
        $bankDetails = User::findOrFail($id)->borrowerBankDetails;

        $customer = User::findOrFail($id);

        if (request()->ajax()) {

            $loan = Loan::where('user_id', $id);


            return DataTables::of($loan)
                ->addColumn('action', function ($loan) {
                    return '<a href="/customer/'.$loan->user_id . '/loan/'.$loan->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $html = $builder->columns([

            ['data' => 'reference_no', 'name' => 'reference_no', 'title' => 'Reference No.'],
            ['data' => 'amount_borrowed', 'name' => 'amount_borrowed', 'title' => 'Amount Borrowed'],
            ['data' => 'amount_to_pay', 'name' => 'amount_to_pay', 'title' => 'Amount To Pay'],
            ['data' => 'duration', 'name' => 'duration', 'title' => 'Duration (months)'],
            [
                'data' => 'approved',
                'name' => 'approved',
                'title' => 'Approved',
                'render' => 'function(){
                    
                                     return data == \'1\' ? \'Approved\' : \'Not Approved\'
                                }',
            ],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Borrowed Date'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

        ]);

        $data = [
            'page' => 'customer details',
            'personalDetails' => $personalDetails,
            'nextOfKinDetails' => $nextOfKinDetails,
            'bankDetails' => $bankDetails,
            'user_id' => $personalDetails->user_id,
            'customer' => $customer
        ];


        return view('customer.customerDetails')->with(compact('html'))->with($data);
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
     * @param Builder $builder
     * @return view
     */
    public function unApprovedCustomer(Builder $builder){

        $users = User::where('approved', null)->withRole('customer')->get();

        foreach ($users as $user){

            $user->registred_by_name = User::getNameFromId($user->registered_by);
            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
        }

        if (request()->ajax()) {


            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '<a href="details/'.$users->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $html = $builder->columns([

            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile No.'],
            ['data' => 'registred_by_name', 'name' => 'registred_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Registred On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

        ]);

        $data = [
            'page' => 'Un approved Customer Accounts',
        ];


        return view('customer.unapproved')->with(compact('html'))->with($data);

    }


    /**
     * approved customers
     * @param Builder $builder
     * @return view
     */
    public function approvedCustomer(Builder $builder){

        $users = User::where('approved', true)->withRole('customer')->get();

        foreach ($users as $user){

            $user->registred_by_name = User::getNameFromId($user->registered_by);
            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
        }

        if (request()->ajax()) {


            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '<a href="details/'.$users->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $html = $builder->columns([

            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile No.'],
            ['data' => 'registred_by_name', 'name' => 'registred_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Registred On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

        ]);

        $data = [
            'page' => 'Approved Customer Accounts',
        ];


        return view('customer.approved')->with(compact('html'))->with($data);

    }

    /**
     * declined customers
     * @param Builder $builder
     * @return view
     */
    public function declinedCustomer(Builder $builder){

        $users = User::where([['status', '=', 'declined'], ['approved', '=', false]])->withRole('customer')->get();

        foreach ($users as $user){

            $user->registred_by_name = User::getNameFromId($user->registered_by);
            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
        }

        if (request()->ajax()) {


            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '<a href="details/'.$users->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $html = $builder->columns([

            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile No.'],
            ['data' => 'registred_by_name', 'name' => 'registred_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Registred On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

        ]);

        $data = [
            'page' => 'Declined Customer Accounts',
        ];


        return view('customer.declined')->with(compact('html'))->with($data);

    }

    /**
     * dormant customers
     * @param Builder $builder
     * @return view
     */
    public function dormantCustomer(Builder $builder){

        $users = User::where([['status', '=', 'dormant'], ['approved', '=', true]])->withRole('customer')->get();

        foreach ($users as $user){

            $user->registred_by_name = User::getNameFromId($user->registered_by);
            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
        }

        if (request()->ajax()) {


            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '<a href="details/'.$users->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $html = $builder->columns([

            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile No.'],
            ['data' => 'registred_by_name', 'name' => 'registred_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Registred On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

        ]);

        $data = [
            'page' => 'Dormant Customer Accounts',
        ];


        return view('customer.dormant')->with(compact('html'))->with($data);

    }


    /**
     * blacklisted customers
     * @param Builder $builder
     * @return view
     */
    public function blacklistedCustomer(Builder $builder){

        $users = User::where('status', 'blacklisted')->withRole('customer')->get();

        foreach ($users as $user){

            $user->registred_by_name = User::getNameFromId($user->registered_by);
            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
        }

        if (request()->ajax()) {


            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '<a href="details/'.$users->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $html = $builder->columns([

            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile No.'],
            ['data' => 'registred_by_name', 'name' => 'registred_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Registred On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],

        ]);

        $data = [
            'page' => 'Blacklisted Customer Accounts',
        ];


        return view('customer.blacklisted')->with(compact('html'))->with($data);

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
    public function blacklistcustomer(Request $request){

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
