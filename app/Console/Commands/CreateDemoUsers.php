<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class CreateDemoUsers extends Command
{
    protected $signature = 'wallet:create-users';

    protected $description = 'Create demo users with wallet balances';

    public function handle()
    {
        $users = [
            ['name'=>'Naveen','email'=>'naveen@gmail.com','password'=>'123456','balance'=>10000],
            ['name'=>'Arun','email'=>'arun@gmail.com','password'=>'123456','balance'=>5000],
            ['name'=>'Kumar','email'=>'kumar@gmail.com','password'=>'123456','balance'=>7000],
            ['name'=>'Rahul','email'=>'rahul@gmail.com','password'=>'123456','balance'=>12000],
            ['name'=>'Vijay','email'=>'vijay@gmail.com','password'=>'123456','balance'=>8000],
            ['name'=>'Ajith','email'=>'ajith@gmail.com','password'=>'123456','balance'=>9500],
            ['name'=>'Suresh','email'=>'suresh@gmail.com','password'=>'123456','balance'=>11000],
            ['name'=>'Praveen','email'=>'praveen@gmail.com','password'=>'123456','balance'=>15000],
            ['name'=>'Ramesh','email'=>'ramesh@gmail.com','password'=>'123456','balance'=>3000],
            ['name'=>'Ganesh','email'=>'ganesh@gmail.com','password'=>'123456','balance'=>4000],
            ['name'=>'Hari','email'=>'hari@gmail.com','password'=>'123456','balance'=>6000],
            ['name'=>'Karthik','email'=>'karthik@gmail.com','password'=>'123456','balance'=>9000],
            ['name'=>'Manoj','email'=>'manoj@gmail.com','password'=>'123456','balance'=>2000],
            ['name'=>'Saravanan','email'=>'saravanan@gmail.com','password'=>'123456','balance'=>13000],
            ['name'=>'Dinesh','email'=>'dinesh@gmail.com','password'=>'123456','balance'=>17000],
            ['name'=>'Lokesh','email'=>'lokesh@gmail.com','password'=>'123456','balance'=>25000],
            ['name'=>'Sathish','email'=>'sathish@gmail.com','password'=>'123456','balance'=>14000],
            ['name'=>'Vinoth','email'=>'vinoth@gmail.com','password'=>'123456','balance'=>7500],
            ['name'=>'Bala','email'=>'bala@gmail.com','password'=>'123456','balance'=>5500],
            ['name'=>'Senthil','email'=>'senthil@gmail.com','password'=>'123456','balance'=>18000],

        ];

        foreach ($users as $data) {

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            Wallet::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'balance' => $data['balance'],
                    'version' => 1
                ]
            );

            $this->info("✔ {$user->name} created with Wallet Balance ₹{$data['balance']}");
        }
        $this->info('--------------------------------');
        $this->info('All Demo Users Created Successfully');
    }
}