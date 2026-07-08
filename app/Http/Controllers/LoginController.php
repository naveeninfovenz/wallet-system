<?php

namespace App\Http\Controllers;
use App\AppConst;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $loginService;
    public function __construct() {
        $this->loginService = new LoginService();
    }

    public function index(){
        return view('auth.auth');
    }

    public function login(Request $request){
        $data = $this->loginService->loginUser($request);
        $result = $data->getData(true);
        if($result['status']== AppConst::SUCCESS_STATUS_CODE){
            return redirect()->route('dashboard')->with('status-success','User Login Successfully.');
          }
          else if($result['status']== AppConst::UNAUTHORIZED){
            return redirect()->route('index')->with('status-error','User Details Not Matched.');
          }
          else{
            return redirect()->route('index')->with('status-error','User Details Not Found Please Sign');
          }
    }

    public function logout(){
        Auth::logout();
           return redirect()->route('index')->with('status-success','User Logout Successfully.');
           
    }

}
