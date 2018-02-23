<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // acesso aos modulos
        Permission::create(['name' => 'acesso_mod_administracao', 'description' => 'Administração - Acesso ao Módulo Administração']);

        //acesso aos menus
        Permission::create(['name' => 'acesso_cad_usuario', 'description' => 'Administração - Acesso ao Cadastro de Usuário']);

        //permissão usuários
        Permission::create(['name' => 'inserir_usuario', 'description' => 'Administração - Inserir Usuários']);
        Permission::create(['name' => 'alterar_usuario', 'description' => 'Administração - Alterar Usuário']);
        Permission::create(['name' => 'deletar_usuario', 'description' => 'Administração - Deletar Usuário']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'sadmin', 'description' => 'Super Administrador']);
        $role->givePermissionTo('acesso_mod_administracao');
        $role->givePermissionTo('acesso_cad_usuario');
        $role->givePermissionTo('inserir_usuario');
        $role->givePermissionTo('alterar_usuario');
        $role->givePermissionTo('deletar_usuario');
    }
}
