<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:agent');
    }

    /**
     * Returns Dashboard
     * @param Builder $builder
     * @return $this
     */
    public function index(Builder $builder){

        $data = [
            'page' => 'dashboard'
        ];

        $users =  User::where('registered_by', Auth::user()->id)->withRole('customer')->get();

        foreach ($users as $user){

            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
            $user->account = $user->borrowerPersonalDetails()->first()->account;
        }

        if (request()->ajax()) {

            return Datatables::of($users)
                ->addColumn('action', function ($model) {
                    return '<a href="/customer/details/'.$model->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
                })
                ->make(true);
        }

        $html = $builder->columns([
            [
                'name' => 'account',
                'title' => 'Account No.',
                'data' => 'account'
            ],
            [
                'name' => 'name',
                'title' => 'Name',
                'data' => 'name'
            ],
            [
                'name' => 'mobile',
                'title' => 'Mobile No.',
                'data' => 'mobile'
            ],
            [
                'name' => 'approved',
                'title' => 'Approved',
                'data' => 'approved',
                'render' => 'function(){
                                return data == null ? \'Not Approved \' : \'Approved\'
                            }'
            ],
            [
                'name' => 'status',
                'title' => 'Status',
                'data' => 'status'
            ],
            [
                'name' => 'created_at',
                'title' => 'Registered On',
                'data' => 'created_at'
            ],
            [
                'name' => 'action',
                'title' => 'Action',
                'data' => 'action'
            ],
        ]);

        return view('agent.index', compact('html'))->with($data);
    }

    /**
     * agent profile
    **/

    public function profile(){

        $data = [
            'page' => 'profile'
        ];

        return view('agent.profile')->with($data);
    }

}
