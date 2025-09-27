<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('users');

        // Create default admin if not exists
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

        // =========================
        // Create 20 dummy staff users
        // =========================
        $faker = Factory::create();
        $staffData = [];

        for ($i = 1; $i <= 20; $i++) {
            $staffData[] = [
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role_id'  => 2, // Staff
            ];
        }

        $builder->insertBatch($staffData);

        echo "✅ 20 Staff accounts created (role_id=2). Default password: password123\n";
    }
}
