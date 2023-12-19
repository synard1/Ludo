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
        $userlink2 = round(now()->timestamp/152);

        $adminUser = User::create([
            'name'              => 'Mhd Iqbal Syahputra',
            'email'             => 'synard1@gmail.com',
            // 'account_id'        => 'ID-'.Str::lower(Str::random(13)),
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => generateRandomString(6),
            'password'          => Hash::make('G00gl3!@'),
            'email_verified_at' => now(),
            'level_access'      => 'Super Admin',
            'subscription'      => 'Owner',
            'status'            => 'Active',
        ]);

        $demoUser1 = User::create([
            'name'              => $faker->name,
            'email'             => 'admin@demo.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => generateRandomString(6),
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Owner',
            'subscription'      => 'Free',
            'status'            => 'Active',
        ]);

        $demoUser2 = User::create([
            'name'              => $faker->name,
            'email'             => 'admin@demo2.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => generateRandomString(6),
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Owner',
            'subscription'      => 'Free',
            'status'            => 'Active',
        ]);

        $demoCompany1 = Company::create([
            'user_id'           => $demoUser1->id,
            'cid'               => $demoUser1->cid,
            'username'          => 'demo',
            'customlink'        => 'demo.ludo.my.id',
            'name'              => $faker->company,
            'address'           => $faker->address,
            'phone'             => $faker->phoneNumber,
            'email'             => 'company@demo.com',
            'website'           => 'www.demo.com',
            'status'            => 'Active',
            'subscription'      => 'Free',
            'communication'     => json_encode('Email'),
            'userlink'          => $userlink,
            'userlink2'         => 'c'.$userlink . config('onexolution.company.url'),
        ]);

        $demoCompany2 = Company::create([
            'user_id'           => $demoUser2->id,
            'cid'               => $demoUser2->cid,
            'username'          => 'demo2',
            'customlink'        => 'demo2.ludo.my.id',
            'name'              => $faker->company,
            'address'           => $faker->address,
            'phone'             => $faker->phoneNumber,
            'email'             => 'company@demo2.com',
            'website'           => 'www.demo2.com',
            'status'            => 'Active',
            'subscription'      => 'Free',
            'communication'     => json_encode('Email'),
            'userlink'          => $userlink2,
            'userlink2'         => 'c'.$userlink2 . config('onexolution.company.url'),
        ]);

        $demoUser11 = User::create([
            'name'              => $faker->name,
            'email'             => 'support@demo.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => $demoUser1->cid,
            'parent_id'         => $demoUser1->id,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Staff',
            'subscription'      => 'Free',
            'status'            => 'Active',
        ]);

        $demoUser12 = User::create([
            'name'              => $faker->name,
            'email'             => 'supervisor@demo.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => $demoUser1->cid,
            'parent_id'         => $demoUser1->id,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Supervisor',
            'subscription'      => 'Free',
            'status'            => 'Active',
        ]);

        $demoUser21 = User::create([
            'name'              => $faker->name,
            'email'             => 'support@demo2.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => $demoUser2->cid,
            'parent_id'         => $demoUser2->id,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Staff',
            'subscription'      => 'Free',
            'status'            => 'Active',
        ]);

        $demoUser22 = User::create([
            'name'              => $faker->name,
            'email'             => 'supervisor@demo2.com',
            'account_id'        => 'ID-'.generateRandomString(8),
            'cid'               => $demoUser2->cid,
            'parent_id'         => $demoUser2->id,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'level_access'      => 'Supervisor',
            'subscription'      => 'Free',
            'status'            => 'Active',
        ]);
    }
}
