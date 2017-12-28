<?php

namespace App\Http\Controllers\Borrower;

use App\BorrowerBankDetails;
use App\BorrowerNextOfKin;
use App\BorrowerPersonalDetails;
use App\BorrowerResidenceDetails;
use App\BorrowerWorkDetails;
use App\RefereesDetails;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Borrower\PersonalDetails;
use Illuminate\Support\Facades\Auth;
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
     *post next of kin details
     * @param Request $request
     */
    public function nextOfKin(Request $request){

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
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required',
        ]);

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
    **/
    public function getBorrowerDetails($id){

        $data = [
            'page' => 'borrower details',
            'personalDetails' => User::findOrFail($id)->borrowerPersonalDetails
        ];


        return view('teller.borrower.borrowerDetails')->with($data);
    }

}
