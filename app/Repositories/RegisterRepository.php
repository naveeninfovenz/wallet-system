<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
class RegisterRepository{

    public function registerNewUser($request){
        try{

            DB::beginTransaction();
           $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'created_at' => now(),
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 3000.00,
            'version' => 1,
        ]);
        DB::commit();
          return true;

        }
        catch(\Exception $e){
            Log::info([
                'function'=>'registerNewUser',
                'line'=>$e->getLine(),
                'message'=>$e->getMessage()
            ]);
        }
    }
}