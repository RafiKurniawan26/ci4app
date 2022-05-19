<?php

namespace App\Database\Seeds;



use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class OrangSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        // $data = [
        //     [
        //         'nama' => 'Rafi',
        //         'alamat'    => 'Tanjung Selatan',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now()
        //     ],
        //     [
        //         'nama' => 'Kurniawan',
        //         'alamat'    => 'Tanjung Pinang',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now()
        //     ],
        //     [
        //         'nama' => 'Rafa',
        //         'alamat'    => 'Tanjung Barat',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now()
        //     ],
        // ];

        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama' => $faker->name,
                'alamat'    => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::now()
            ];
            $this->db->table('orang')->insert($data);
        }



        // Simple Queries
        // $this->db->query("INSERT INTO Orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)", $data);

        // Using Query Builder
        // $this->db->table('orang')->insert($data);
    }
}
