<?php

use App\Chat;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 6)->create()->each(function ($u) {
            for ($i = 0; $i <= 4; $i++) {
                $u->messages()->save(factory(Chat::class)->make());
            }
        });
    }
}
