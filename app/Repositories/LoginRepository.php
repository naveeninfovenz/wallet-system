<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginRepository{

    public function getUser($email){

        try{
            return User::where('email',$email)->first();
        }
        catch(\Exception $e){
            Log::info([
                'finction'=>'getUser',
                'line'=>$e->getLine(),
                'message'=>$e->getMessage()
            ]);
        }
    }
}