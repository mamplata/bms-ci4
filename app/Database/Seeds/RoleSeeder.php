<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Resident'],
            ['id' => 2, 'name' => 'Staff'],
            ['id' => 3, 'name' => 'Admin'],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
