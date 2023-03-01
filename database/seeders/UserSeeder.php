<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = config('users.users');

        foreach ($users as $user) {
            $new_user = new User();
            $new_user->name = $user['name'];
            $new_user->surname = $user['surname'];
            $new_user->date_of_birth = $user['date_of_birth'];
            $new_user->email = $user['email'];
            $new_user->password = $user['password'];
            $new_user->created_at = $user['created_at'];
            $new_user->updated_at = $user['updated_at'];
            $new_user->save();
        }
    }
}
