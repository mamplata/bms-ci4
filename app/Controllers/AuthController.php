<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Register new Resident (role_id = 1)
     */
    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name'     => 'required|min_length[3]|max_length[100]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
            ];

            if (!$this->validate($rules)) {
                // Validation failed, return with errors
                return view('auth/register', [
                    'validation' => $this->validator
                ]);
            }

            $password = $this->request->getPost('password') ?? '';
            $data = [
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role_id'  => 1, // default = Resident
            ];

            $this->userModel->insert($data);

            return redirect()->to('/')->with('message', 'Registration successful.');
        }

        return view('auth/register');
    }

    /**
     * Login existing user
     */
    public function login()
    {

        if ($this->request->getMethod() === 'POST') {

            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password') ?? '';

            $user = $this->userModel->where('email', $email)->first();


            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'user_id'    => $user['id'],
                    'role_id'    => $user['role_id'],
                    'name'       => $user['name'],
                    'isLoggedIn' => true,
                ]);


                $this->logAction($user['id'], "Login");

                // Role-based redirect
                switch ($user['role_id']) {
                    case 1: // Resident
                        return redirect()->to('/resident/dashboard');
                    case 2: // Staff
                        return redirect()->to('/staff/manage-residents');
                    case 3: // Admin
                        return redirect()->to('/admin/dashboard');
                    default:
                        return redirect()->to('/');
                }
            }

            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        return view('auth/login');
    }


    /**
     * Logout
     */
    public function logout()
    {
        $userId = session()->get('user_id');
        $this->logAction($userId, "Logout");

        session()->destroy();
        return redirect()->to('/');
    }

    /**
     * Forgot Password (send reset link)
     */
    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $user  = $this->userModel->where('email', $email)->first();

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $this->userModel->update($user['id'], [
                    'reset_token'   => $token,
                    'reset_expires' => $expires
                ]);

                // Send email (you can configure Email in CI4)
                $resetLink = base_url("reset-password/{$token}");

                // Placeholder email logic (replace with CI4 Email service)
                log_message('info', "Password reset link: {$resetLink}");

                return redirect()->back()->with('message', 'Reset link sent to your email.');
            }

            return redirect()->back()->with('error', 'Email not found.');
        }

        return view('auth/forgot_password');
    }

    /**
     * Reset Password with token
     */
    public function resetPassword($token = null)
    {
        if ($this->request->getMethod() === 'POST') {
            $token = $this->request->getPost('token');
            $password = $this->request->getPost('password') ?? '';

            $user = $this->userModel->where('reset_token', $token)
                ->where('reset_expires >=', date('Y-m-d H:i:s'))
                ->first();

            if ($user) {
                $this->userModel->update($user['id'], [
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'reset_token'   => null,
                    'reset_expires' => null
                ]);

                $this->logAction($user['id'], "Password Reset");

                return redirect()->to('/')->with('message', 'Password updated successfully.');
            }

            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired token.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    /**
     * Unauthorized Page
     */
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
