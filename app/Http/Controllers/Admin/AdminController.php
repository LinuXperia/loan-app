<?php

namespace App\Http\Controllers\Admin;

use App\AgentDetails;
use App\Mail\SendAgentAccountDetails;
use App\Role;
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
    **/
    public function index(){

        $data = [
            'page' => 'dashboard'
        ];

        return view('admin.index')->with($data);
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
     * @param Builder $builder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activeAgents(Builder $builder){

        $agents = User::withRole('agent')->where('status', 'active')->get();

        foreach ($agents as $agent){
            $agent->registered_by_name = User::getNameFromId($agent->registered_by);
        }

       if (request()->ajax()) {

           return DataTables::of($agents)
               ->addColumn('action', function ($agents) {
                   return '<a href="/admin/agent/'.$agents->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
               })
               ->editColumn('id', 'ID: {{$id}}')
               ->toJson();
       }

       $data = [
           'page' => 'Active Agents'
       ];

       $html = $builder->columns([
               ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
               ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
               ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
               ['data' => 'registered_by_name', 'name' => 'registered_by_name', 'title' => 'Registered By'],
               ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created On'],
           ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
            ]);

        return view('admin.agent.active', compact('html'))->with($data);
   }

    /**
     * inactive agents
     * @param Builder $builder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inActiveAgents(Builder $builder){

        $agents = User::withRole('agent')->where('status', 'inactive')->get();

        foreach ($agents as $agent){
            $agent->registered_by_name = User::getNameFromId($agent->registered_by);


        }

        if (request()->ajax()) {

            return DataTables::of($agents)
                ->addColumn('action', function ($agents) {
                    return '<a href="/admin/agent/'.$agents->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $data = [
            'page' => 'Inactive Agents'
        ];

        $html = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'registered_by_name', 'name' => 'registered_by_name', 'title' => 'Registered By'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Deactivated On'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
        ]);

        return view('admin.agent.inactive', compact('html'))->with($data);
    }

    /**
     * all agents
     * @param Builder $builder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allAgents(Builder $builder){

        $agents = User::withRole('agent')->get();

        foreach ($agents as $agent){
            $agent->registered_by_name = User::getNameFromId($agent->registered_by);


        }

        if (request()->ajax()) {

            return DataTables::of($agents)
                ->addColumn('action', function ($agents) {
                    return '<a href="/admin/agent/'.$agents->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->toJson();
        }

        $data = [
            'page' => 'All Agents'
        ];

        $html = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'registered_by_name', 'name' => 'registered_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created On'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
        ]);

        return view('admin.agent.all', compact('html'))->with($data);
    }

    /**
     * @param $id
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
