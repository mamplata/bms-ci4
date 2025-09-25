<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ResidentController extends BaseController
{
    public function dashboard()
    {
        $data = [
            'title' => 'Resident Dashboard',
            'name'  => session()->get('name')
        ];
        return view('resident/dashboard', $data);
    }
}
