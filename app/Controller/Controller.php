<?php
namespace App\Controller;

use App\Request\Request;
use App\Exception\MethodNotAllowedException;

class Controller
{
    /**
     * welcome画面表示
     */
    public function welcomeView()
    {
        return view('welcome');
    }
}
