<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // Members

        $avatarPath = Storage::disk('public')->putFileAs('avatar', new File(public_path('assets/avatar/profile.jpeg')), 'profile.jpeg');


        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'username' => "Member $i",
                'email' => "member$i@example.com",
                'password' => Hash::make('password'),
                'role_id' => 2,
                'avatar' => $avatarPath
            ]);

            Member::create([
                'user_id' => $user->id_user,
                'phone_number'   => "08123$i$i$i$i$i",
            ]);
        }
    }
}
