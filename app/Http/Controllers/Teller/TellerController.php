<?php

namespace App\Http\Controllers\Teller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\Entrust;

class TellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:agent');
    }

    /**
    * Returns Dashboard
    **/
    public function index(){



        $data = [
            'page' => ''
        ];
        return view('agent.index',$data);
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
