<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      Role::truncate();

      Role::create(['name' => 'ライター', 'authority' => 0]);
      Role::create(['name' => '編集者', 'authority' => 1]);
      Role::create(['name' => '管理者', 'authority' => 9]);
    }
}
