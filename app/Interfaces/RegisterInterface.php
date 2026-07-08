<?php
namespace App\Interfaces;

interface RegisterInterface{
    public function newUser($request):int;
}