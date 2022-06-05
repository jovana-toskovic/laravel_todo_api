<?php

namespace Database\State;

use App\Models\User;
use DateTimeZone;
use Illuminate\Support\Facades\DB;

class EnsureUsersArePresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        $users = [
            [
                "name" => "Test",
                "email" => "test@test.com",
                "password" => "password",
                "timezone" =>  DateTimeZone::listIdentifiers()[0]
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }

    private function present()
    {
        return DB::table('users')->count() > 0;
    }

}
