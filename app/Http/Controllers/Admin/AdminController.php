<?php

namespace App\Http\Controllers\Admin;

use App\AgentDetails;
use App\DataTables\Agents\ActiveDataTable;
use App\DataTables\Agents\AllDataTable;
use App\DataTables\Agents\DeactivatedDataTable;
use App\Loan;
use App\Mail\SendAgentAccountDetails;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * return dashboard
     * @param Builder $builder
     * @return $this
     */
    public function index(Builder $builder){

        $data = [
            'page' => 'dashboard'
        ];

        $loans = Loan::where('approved',null)->limit(5);

        if (request()->ajax()) {

            return Datatables::of($loans)
                ->addColumn('action', function ($model) {
                    return '<a href="/customer/' . $model->user_id .'/loan/'.$model->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
                })
                ->make(true);
        }

        $html = $builder->columns([
            ['data' => 'reference_no', 'name' => 'reference_no', 'title' => 'Reference No.'],
            [
                'data' => 'amount_borrowed',
                'name' => 'amount_borrowed',
                'title' => 'Amount',
                'render' => 'function(){
                    return "ksh." + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }'
            ],
            [
                'data' => 'amount_to_pay',
                'name' => 'amount_to_pay',
                'title' => 'Total Amount',

            ],
            ['data' => 'status', 'name' => 'status', 'title' => 'Loan Status'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Applied On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
            ]);

        return view('admin.index', compact('html'))->with($data);
   }

    /**
     * @return $this
     */
    public function profile(){

       $data = [
           'page' => 'Admin Profile'
       ];

        return view('admin.profile')->with($data);
   }

    /**
     *return new agent view
     */
    public function newAgent(){

        $data = [
            'page' => 'new agent'
        ];

        return view('admin.agent.new')->with($data);
   }

   public function createNewAgent(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|min:10|numeric'
        ]);

        $password = mt_rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'registered_by' => Auth::user()->id
        ]);

        //post user details
        $agentDetails = new  AgentDetails();

        $agentDetails->phone =  $request->phone;
        $agentDetails->address =  $request->address ? $request->address : '';
        $agentDetails->country =  $request->country ? $request->country : 'kenya';
        $agentDetails->comment =  $request->comment ? $request->comment : '';

        $user->agentDetails()->save($agentDetails);

        //assign agent role
       $user->attachRole(2);

        //sender email to agent
       Mail::to($user)->send(new SendAgentAccountDetails($user,$password));

       return back()->withSuccess("Agent Account Created Successfully. Account Details sent to their -- ". $request->email."  -- address.");
   }

    /**
     * active agents
     * @param ActiveDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activeAgents(ActiveDataTable $dataTable){

        $data = [
            'page' => 'Active Agent Accounts'
        ];

        return $dataTable->render('admin.agent.active', $data);

   }

    /**
     * inactive agents
     * @param DeactivatedDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inActiveAgents(DeactivatedDataTable $dataTable){

        $data = [
            'page' => 'Deactivated Agent Accounts'
        ];

        return $dataTable->render('admin.agent.inactive', $data);
    }

    /**
     * all agents
     * @param AllDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allAgents(AllDataTable $dataTable){

        $data = [
            'page' => 'Agent Accounts List'
        ];

        return $dataTable->render('admin.agent.all', $data);
    }

    /**
     * agent details
     * @param $id
     * @return $this
     */
    public function agentsDetails($id){

        $user = User::findOrFail($id);

        $user->registered_by_name = User::getNameFromId($user->registered_by);

        if(!$user){

            return back()->withError('This Agent does not exist');
        }

        $user->details = AgentDetails::where('user_id', $user->id)->first();

        $data = [
            'page' => 'Agent Details',
            'agentDetails' => $user
        ];

        return view('admin.agent.details')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request){

        $user = User::findOrFail($request->id);

        if(!$user){
            return response()->json([
                'errors' => [
                    'status' => ['Agent not found. Reload Page']
                ]
            ]);
        }

        $user->status = $request->status !==   $user->status ? $request->status : $user->status;
        $user->save();

        return response()->json([
            'message' => 'Status Updated Successfully.'
        ], 200);
    }
}
