<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        
        for($i=0;$i<15;$i++){
            $data = [
                'name'      => $faker->name(),
                'email'     => $faker->email(),
                'image'     => 'default.png',
                'password'  => '12345',
                'role_id'   => $faker->numberBetween(1,2),
                'is_active' => $faker->numberBetween(0,1),
                'created_at'=> $faker->dateTimeBetween('2025-01-01', '2025-02-24')->format('Y-m-d H:i:s'),
                'updated_at'=> Time::now('Asia/Jakarta')
            ];

            $this->db->table('user')->insert($data);
        }
    }
}
