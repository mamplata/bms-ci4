<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'name'  => session()->get('name')
        ];
        return view('admin/dashboard', $data);
    }

    /**
     * Manage Staff (list page with DataTables)
     */
    public function manageStaff()
    {
        return view('admin/manage_staff/index', [
            'title' => 'Manage Staff',
        ]);
    }

    public function staffData()
    {
        return $this->datatableResponse(
            $this->userModel,
            ['name', 'email', 'created_at'], // sortable columns
            ['name', 'email'],               // searchable columns
            ['created_at' => 'DESC'],        // default order
            ['role_id' => '2']                 // base filter
        );
    }

    /**
     * Create Staff
     */
    public function createStaff()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name'     => 'required|min_length[3]|max_length[100]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/manage_staff/create_staff', [
                    'validation' => $this->validator
                ]);
            }

            $password = $this->request->getPost('password') ?? '';
            $data = [
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role_id'  => '2', // Staff
            ];

            $this->userModel->insert($data);

            $this->logAction(session()->get('user_id'), "Created staff: {$data['email']}");

            return redirect()->to('/admin/manage-staff')->with('message', 'Staff created successfully.');
        }

        return view('admin/manage_staff/create_staff', ['title' => 'Create Staff']);
    }

    /**
     * Edit Staff
     */
    public function editStaff($id)
    {
        $staff = $this->userModel->find($id);

        if (!$staff || $staff['role_id'] !== '2') {
            return redirect()->to('/admin/manage-staff')->with('error', 'Staff not found.');
        }

        if ($this->request->getMethod() === 'PUT') {
            $rules = [
                'name'  => 'required|min_length[3]|max_length[100]',
                'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            ];

            if (!$this->validate($rules)) {
                return view('admin/manage_staff/edit_staff', [
                    'validation' => $this->validator,
                    'staff'      => $staff
                ]);
            }

            $updateData = [
                'id'    => $id,
                'name'  => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];

            $password = $this->request->getPost('password') ?? '';
            if ($this->request->getPost('password')) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->userModel->save($updateData);

            $this->logAction(session()->get('user_id'), "Edited staff: {$updateData['email']}");

            return redirect()->back()->with('message', 'Staff updated successfully.');
        }

        return view('admin/manage_staff/edit_staff', [
            'title' => 'Edit Staff',
            'staff' => $staff
        ]);
    }

    /**
     * Delete Staff
     */
    public function deleteStaff($id)
    {
        $staff = $this->userModel->find($id);

        if ($staff && $staff['role_id'] === '2') {
            $this->userModel->delete($id);

            $this->logAction(session()->get('user_id'), "Deleted staff: {$staff['email']}");

            return redirect()->to('/admin/manage-staff')->with('message', 'Staff deleted successfully.');
        }

        return redirect()->to('/admin/manage-staff')->with('error', 'Unable to delete staff.');
    }

    /**
     * System Logs (last 100 entries)
     */
    public function systemLogs()
    {
        $logs = $this->auditModel->orderBy('created_at', 'DESC')->findAll(100);

        return view('admin/system_logs', [
            'title' => 'System Logs',
            'logs'  => $logs
        ]);
    }
}
