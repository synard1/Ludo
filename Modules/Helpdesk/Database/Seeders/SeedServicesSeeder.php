<?php

namespace Modules\Helpdesk\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Helpdesk\Entities\Service;
use Ramsey\Uuid\Uuid;

class SeedServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'admin@demo.com')->first();

        $services = [
            ['name' => 'IT Support', 'description' => 'Provides technical support for IT-related issues'],
            ['name' => 'Software Development', 'description' => 'Develops custom software solutions'],
            ['name' => 'Network Maintenance', 'description' => 'Manages and maintains the organization\'s network'],
            ['name' => 'Hardware Troubleshooting', 'description' => 'Diagnoses and resolves hardware-related issues'],
            ['name' => 'Software Troubleshooting', 'description' => 'Diagnoses and resolves software-related issues'],
            ['name' => 'User Account Management', 'description' => 'Manages user accounts and access permissions'],
            ['name' => 'Email Configuration and Support', 'description' => 'Configures and provides support for email services'],
            ['name' => 'Security and Antivirus Management', 'description' => 'Ensures security measures and manages antivirus software'],
            ['name' => 'Network Design and Planning', 'description' => 'Designs and plans the organization\'s network infrastructure'],
            ['name' => 'Network Security', 'description' => 'Implements and maintains network security protocols'],
            ['name' => 'Wireless Network Setup', 'description' => 'Configures and supports wireless network setups'],
            ['name' => 'VPN Setup and Support', 'description' => 'Sets up and provides support for Virtual Private Networks'],
            ['name' => 'Network Performance Optimization', 'description' => 'Optimizes network performance and resolves connectivity issues'],
            ['name' => 'Server Configuration and Maintenance', 'description' => 'Configures and maintains organization servers'],
            ['name' => 'Backup and Recovery', 'description' => 'Implements and manages data backup and recovery systems'],
            ['name' => 'System Monitoring and Alerts', 'description' => 'Monitors system performance and sets up alerts'],
            ['name' => 'Database Administration', 'description' => 'Manages and administers organization databases'],
            ['name' => 'IT Policy and Compliance', 'description' => 'Develops and enforces IT policies and ensures compliance'],
        ];

        foreach ($services as $service) {
            $model = new Service([
                'id' => Uuid::uuid4()->toString(), // Generate and assign UUID
                'name' => $service['name'],
                'description' => $service['description'],
                'user_id' => $user1->id,
                'user_cid' => $user1->cid,
                'created_by' => $user1->name,
                'created_by_level' => $user1->level_access,
            ]);
            $model->save();
        }

    }
}
