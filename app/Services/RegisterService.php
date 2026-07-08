<?php
namespace App\Services;

use App\Interfaces\RegisterInterface;
use App\Repositories\RegisterRepository;

class RegisterService implements RegisterInterface{
    protected $registerRepsitory;

    public function __construct() {
        $this->registerRepsitory = new RegisterRepository();
    }

    public function newUser($request) : int{
        return $this->registerRepsitory->registerNewUser($request);
    }
}