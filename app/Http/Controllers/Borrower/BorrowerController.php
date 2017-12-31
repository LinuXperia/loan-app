<?php

namespace App\Http\Controllers\Borrower;

use App\BorrowerBankDetails;
use App\BorrowerNextOfKin;
use App\BorrowerPersonalDetails;
use App\BorrowerResidenceDetails;
use App\BorrowerWorkDetails;
use App\Http\Requests\Borrower\NextOfKinRequest;
use App\Http\ViewComposers\LoanDetailsComposer;
use App\Loan;
use App\RefereesDetails;
use App\Repositories\UserRepository;
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
    /**
     * Returns new borrower view
     **/
    public function newBorrower(){


        $data = [
            'page' => 'New Borrower'
        ];

        return view('teller.borrower.new', $data);
    }

    /**
     * validate and post personal details
     * @param PersonalDetails $request
     */
    public function personalDetails(PersonalDetails $request){

        //validate

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
     * @param Request $request
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
     * @param Request $request
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
    **/
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

        $user->borrowerBankDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post borrower residence details
     * @param Request $request
     **/
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

        $user->borrowerResidenceDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post borrower work details
     * @param Request $request
     **/
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

        $user->borrowerWorkDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post borrower business details
     * @param Request $request
     **/
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

        $user->borrowerWorkDetails()->save($details);

        return response()->json([

            'id' => $user->id,
        ], 200);

    }

    /**
     * post borrower referees details
     * @param Request $request
     **/
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
     * complete borrowers profile
     * @param Request $request
     **/
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
     * Borrower list view
     **/
    public function borrowerList(Builder $builder){

        if (request()->ajax()) {

            $model = User::withRole('borrower')->get();

            foreach ($model as $m){
                $m->registered_by = User::registeredBy($m->registered_by);
                $m->idNumber = User::find($m->id)->borrowerPersonalDetails()->first()->idNumber;
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
            'page' => 'borrower list'
        ];

        $html = $builder->columns([

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

        return view('teller.borrower.borrowerList')->with(compact('html'))->with($data);

    }

    /**
     * Borrower details view
     * @param Builder $builder
     * @param $id
     * @return $this
     */
    public function getBorrowerDetails(Builder $builder, $id){

        $personalDetails = User::findOrFail($id)->borrowerPersonalDetails;
        $personalDetails->email = User::findOrFail($id)->email;

        $nextOfKinDetails = User::findOrFail($id)->borrowerNextOfKin;
        $bankDetails = User::findOrFail($id)->borrowerBankDetails;

        if (request()->ajax()) {

            $loan = Loan::where('user_id', $id);


            return DataTables::of($loan)
                ->addColumn('action', function ($loan) {
                    return '<a href="/borrower/loan/'.$loan->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
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
            'page' => 'borrower details',
            'personalDetails' => $personalDetails,
            'nextOfKinDetails' => $nextOfKinDetails,
            'bankDetails' => $bankDetails,
        ];


        return view('teller.borrower.borrowerDetails')->with(compact('html'))->with($data);
    }
}
