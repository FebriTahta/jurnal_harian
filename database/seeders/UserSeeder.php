<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usr = [
            [
                'anggota_id' => "8",
                'bidang_id' => "4",
                'username' => "9",
                'role' => "anggota",
                'password'   => bcrypt("adm"),
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            // [
            //     'anggota_id' => "2",
            //     'bidang_id' => "1",
            //     'username' => "2",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],
            // [
            //     'anggota_id' => "3",
            //     'bidang_id' => "1",
            //     'username' => "3",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],
            // [
            //     'anggota_id' => "4",
            //     'bidang_id' => "1",
            //     'username' => "4",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],
            // [
            //     'anggota_id' => "5",
            //     'bidang_id' => "3",
            //     'username' => "5",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],
            // [
            //     'anggota_id' => "6",
            //     'bidang_id' => "3",
            //     'username' => "6",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],
            // [
            //     'anggota_id' => "7",
            //     'bidang_id' => "2",
            //     'username' => "7",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],
            // [
            //     'anggota_id' => "8",
            //     'bidang_id' => "2",
            //     'username' => "8",
            //     'role' => "anggota",
            //     'password'   => bcrypt("adm"),
            //     'created_at' => new \DateTime,
            //     'updated_at' => null,
            // ],

        ];
        \DB::table('users')->insert($usr);
    }
}
