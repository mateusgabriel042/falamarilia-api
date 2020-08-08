<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create()->each(function ($user) {
            $user->profile()->save(factory(Profile::class)->make());
            $user->createToken('Laravel Password Grant Client');
        });
    }
}
