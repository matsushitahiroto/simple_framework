<?php
namespace App\Controller;

use App\Request\Request;
use App\Exception\MethodNotAllowedException;

class Controller
{
    public function __call($method,$args){
        throw new MethodNotAllowedException();
    }

    public function welcomeView()
    {
        return view('welcome');
    }
}
