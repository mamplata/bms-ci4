<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'name'  => session()->get('name')
        ];
        return view('admin/dashboard', $data);
    }
}
