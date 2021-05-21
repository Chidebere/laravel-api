<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'work@tvzcorp.com',
            'password' => '$2y$10$kyxpzj804Edef7tA2ScZne6iKXf8KKeLFkIWF0No9Vl1JsF3rY9DW', // pAs!sw@rd@#61g
        ]);
    }
}
