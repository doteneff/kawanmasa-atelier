<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userCount = $this->db->table("users")->countAll();
        
        if ($userCount == 0) {
            $data = [   
                'name' => 'admin',
                'email'=> 'admin@gmail.com',
                'password'=> password_hash('P@ssw0rd', PASSWORD_DEFAULT),
            ];

            $this->db->table('users')->insert($data);

            echo "Successfully seed users data!";
        }
    }
}
