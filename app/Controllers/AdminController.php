<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $auditModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->auditModel = new AuditLogModel();
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
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';
        $order  = $request->getPost('order'); // contains column index & direction
        $columns = $request->getPost('columns'); // contains column data names

        $builder = $this->userModel->where('role_id', 2);

        // 🔍 Filtering
        if (!empty($search)) {
            $builder->groupStart()
                ->like('name', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        $recordsTotal    = $this->userModel->where('role_id', 2)->countAllResults(false);
        $recordsFiltered = $builder->countAllResults(false);

        // 🔀 Sorting
        if (!empty($order)) {
            foreach ($order as $o) {
                $colIndex = intval($o['column']);
                $dir      = $o['dir'] === 'asc' ? 'ASC' : 'DESC';
                $colName  = $columns[$colIndex]['data'];

                // only allow sorting on actual DB columns
                if (in_array($colName, ['name', 'email', 'created_at'])) {
                    $builder->orderBy($colName, $dir);
                }
            }
        } else {
            $builder->orderBy('created_at', 'DESC'); // default
        }

        // 🔢 Pagination
        $data = $builder->findAll($length, $start);

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'csrf'            => [
                'token' => csrf_token(),
                'hash'  => csrf_hash()
            ]
        ]);
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

        if ($this->request->getMethod() === 'POST') {
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

            return redirect()->to('/admin/manage-staff')->with('message', 'Staff updated successfully.');
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

    /**
     * Helper: log admin actions
     */
    protected function logAction($userId, $action)
    {
        if ($userId) {
            $this->auditModel->insert([
                'user_id'    => $userId,
                'action'     => $action,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
            ]);
        }
    }
}
