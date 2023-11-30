<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $userlink = round(now()->timestamp/151);

        $demoUser = User::create([
            'name'              => 'Mhd Iqbal Syahputra',
            'email'             => 'synard1@gmail.com',
            // 'account_id'        => 'ID-'.Str::lower(Str::random(13)),
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => generateRandomString(6),
            'password'          => Hash::make('G00gl3!@'),
            'email_verified_at' => now(),
            'level_access'      => 'Super Admin',
            'subscription'      => 'Owner',
        ]);

        $demoUser2 = User::create([
            'name'              => $faker->name,
            'email'             => 'admin@demo.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => generateRandomString(6),
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Owner',
            'subscription'      => 'Free',
        ]);

        $demoCompany = Company::create([
            'user_id'           => $demoUser2->id,
            'cid'               => $demoUser2->cid,
            'username'          => 'demo',
            'customlink'        => 'demo.ludo.my.id',
            'name'              => $faker->company,
            'address'           => $faker->address,
            'phone'             => $faker->phoneNumber,
            'email'             => 'company@demo.com',
            'website'           => 'www.demo.com',
            'status'            => 'Active',
            'subscription'      => 'Free',
            'communication'     => 'Email',
            'userlink'          => $userlink,
            'userlink2'         => 'c'.$userlink . config('onexolution.company.url'),
        ]);

        $demoUser3 = User::create([
            'name'              => $faker->name,
            'email'             => 'support@demo.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => $demoUser2->cid,
            'parent_id'         => $demoUser2->id,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Staff',
            'subscription'      => 'Free',
        ]);

        $demoUser4 = User::create([
            'name'              => $faker->name,
            'email'             => 'supervisor@demo.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => $demoUser2->cid,
            'parent_id'         => $demoUser2->id,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Supervisor',
            'subscription'      => 'Free',
        ]);
    }
}
