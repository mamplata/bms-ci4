<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StaffController extends BaseController
{
    public function manageResidents()
    {
        $data = [
            'title' => 'Manage Residents',
            'name'  => session()->get('name')
        ];
        return view('staff/manage_residents', $data);
    }
}
