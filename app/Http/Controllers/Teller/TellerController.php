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
        //
    }

    /**
    * Returns Dashboard
    **/
    public function index(){



        $data = [
            'page' => ''
        ];
        return view('teller.index',$data);
    }

    /**
     * Teller profile
    **/

    public function profile(){

        $data = [
            'page' => 'profile'
        ];

        return view('teller.profile')->with($data);
    }



}
