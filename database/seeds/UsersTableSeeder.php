<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = Role::all();

    	$admin = User::create([
    		'name' => 'Glenn',
    		'email' => 'glenn@email.com',
    		'password' => bcrypt('123456'),
    		'activate' => true
    	])->roles()->attach($roles);

    	$normal = User::create([
    		'name' => 'Marry',
    		'email' => 'marry@email.com',
    		'password' => bcrypt('123456'),
    		'activate' => true
    	])->roles()->attach($roles->where('name', 'normal')->first());
    }
}
