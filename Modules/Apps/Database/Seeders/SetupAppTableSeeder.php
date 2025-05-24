<?php

namespace Modules\Apps\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Donations\Entities\DonationStatus;
use Modules\Area\Database\Seeders\SeedAreaModule;
use Modules\Authorization\Database\Seeders\RoleSeederTableSeeder;
use Modules\Authorization\Database\Seeders\PermissionsSeederTableSeeder;

class SetupAppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        Model::unguard();
        (new PermissionsSeederTableSeeder())->run();
        (new RoleSeederTableSeeder())->run();
        (new SeedAreaModule())->run();
        $this->insertUserRole($this->insertUser());
        DB::commit();
    }

    private function insertUser()
    {
        return User::create([
            'name' => 'admin',
            'mobile' => '94971095',
            'email' => 'admin@tocaan.com',
            'password' => bcrypt("12345678"),
        ]);
    }

    private function insertUserRole($user)
    {
        $user->assignRole(['super-admin']);
    }
}
