<?php

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends DataController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    
    public function kocak()
    {
        echo"pitek";
    }
}
