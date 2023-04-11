<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles
        $admin = Role::create(['name' => 'Administrador']);
        $author = Role::create(['name' => 'Author']);

        //Permisos
        Permission::create(['name' => 'admin.index','description'=>'Ver Dashboard'])->syncRoles([$admin,$author]);
        //Categorias
        Permission::create(['name' => 'categories.index','description'=>'Ver Categorias'])->syncRoles([$admin,$author]);
        Permission::create(['name' => 'categories.create','description'=>'Crear Categorias'])->assignRole($admin);
        Permission::create(['name' => 'categories.edit','description'=>'Editar Categorias'])->assignRole($admin);
        Permission::create(['name' => 'categories.destroy','description'=>'Eliminar Categorias'])->assignRole($admin);
        //Articulos
        Permission::create(['name' => 'articles.index','description'=>'Ver Articulos'])->syncRoles([$admin,$author]);
        Permission::create(['name' => 'articles.create','description'=>'Crear Articulos'])->syncRoles([$admin,$author]);
        Permission::create(['name' => 'articles.edit','description'=>'Editar Articulos'])->syncRoles([$admin,$author]);
        Permission::create(['name' => 'articles.destroy','description'=>'Eliminar Articulos'])->syncRoles([$admin,$author]);
        //Comentarios
        Permission::create(['name' => 'comments.index','description'=>'Ver Comentarios'])->syncRoles([$admin,$author]);
        Permission::create(['name' => 'comments.destroy','description'=>'Eliminar Comentarios'])->syncRoles([$admin,$author]);
        //Usuarios
         Permission::create(['name' => 'users.index','description'=>'Ver Usuarios'])->assignRole([$admin]);
         Permission::create(['name' => 'users.edit','description'=>'Editar Usuarios'])->assignRole([$admin]);
         Permission::create(['name' => 'users.destroy','description'=>'Eliminar Usuarios'])->assignRole([$admin]);
        //Roles
        Permission::create(['name' => 'roles.index','description'=>'Ver Roles'])->assignRole([$admin]);
        Permission::create(['name' => 'roles.create','description'=>'Crear Roles'])->assignRole([$admin]);
        Permission::create(['name' => 'roles.edit','description'=>'Editar Roles'])->assignRole([$admin]);
        Permission::create(['name' => 'roles.destroy','description'=>'Eliminar Roles'])->assignRole([$admin]);


    }
}
