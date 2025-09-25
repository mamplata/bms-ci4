<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class ResidentController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Resident Dashboard
     */
    public function dashboard()
    {
        $data = [
            'title' => 'Resident Dashboard',
            'name'  => session()->get('name'),
        ];

        return view('resident/dashboard', $data);
    }

    /**
     * View and update own profile
     */
    public function profile()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/')->with('error', 'User not found.');
        }

        // Handle profile update
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name'  => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];

            // Optional: update password if provided
            $password = $this->request->getPost('password') ?? '';
            if ($password) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->userModel->update($userId, $data);

            // Update session name
            session()->set('name', $data['name']);

            return redirect()->back()->with('message', 'Profile updated successfully.');
        }

        return view('resident/profile', ['user' => $user, 'title' => 'My Profile']);
    }
}
