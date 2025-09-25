<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        $builder = $this->db->table('users');

        // Check if admin already exists
        $admin = $builder->where('email', 'admin@example.com')->get()->getRow();

        if (!$admin) {
            $data = [
                'name'     => 'System Administrator',
                'email'    => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id'  => 3, // Admin
            ];

            $builder->insert($data);

            echo "✅ Admin account created: admin@example.com / admin123\n";
        } else {
            echo "ℹ️ Admin account already exists, skipping...\n";
        }
    }
}
