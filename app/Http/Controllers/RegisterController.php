<?php

namespace App\Http\Controllers;

use App\Services\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $registerService;
    public function __construct() {
        $this->registerService = new RegisterService();
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
       $data = $this->registerService->newUser($request);
       if($data){
        return redirect()->route('index')->with('status-success','User Register Successfully');
       }
       else{
        return redirect()->back()->with('status-failed','User Register Failed');
       }
    }
}
