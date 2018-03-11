<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Super Administrador',
            'cpfcnpj' => '111.111.111-11',
            'email' => 'sadmin@teste.com',
            'password' => bcrypt('123456'),
        ]);
        $user->assignRole('sadmin');

        $user = User::create([
            'name' => 'Usuário Teste',
            'cpfcnpj' => '222.222.222-22',
            'email' => 'teste@teste.com',
            'password' => bcrypt('123456'),
        ]);

        $faker = Faker\Factory::create();
        for($i = 0; $i < 500; $i++) {
            $random = str_random(11);

            App\Models\User::create([
                'name' => $faker->name,
                'cpfcnpj' => $random,
                'email' => $random."@teste.com",
                'password' => bcrypt('123456')
            ]);
        }
    }
}
