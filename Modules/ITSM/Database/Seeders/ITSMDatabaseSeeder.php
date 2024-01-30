<?php

namespace Modules\ITSM\Database\Seeders;

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use Modules\ITSM\Entities\IncidentCategory;
use Modules\ITSM\Entities\ServiceCategory;

class ITSMDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('parent_id', null)->where('level_access','Owner')->get();
        // $user1 = User::where('email', 'admin@demo.com')->first();

        $categories = [
            ['name' => 'Network', 'description' => 'Issues related to network connectivity'],
            ['name' => 'System Outage', 'description' => 'Complete unavailability of a system'],
            ['name' => 'Hardware', 'description' => 'Failures or issues with hardware components'],
            ['name' => 'Email', 'description' => 'Issues affecting email communication'],
            ['name' => 'Security', 'description' => 'Security-related incidents'],
            ['name' => 'Software', 'description' => 'Issues with software applications'],
            ['name' => 'Database', 'description' => 'Issues related to database operations'],
            ['name' => 'Telecommunication', 'description' => 'Issues with telecommunication systems'],
            ['name' => 'Server', 'description' => 'Issues with server operations'],
            ['name' => 'Application Integration', 'description' => 'Issues related to application integration'],
            ['name' => 'User Account', 'description' => 'Issues with user accounts and access'],
            ['name' => 'Mobile Device', 'description' => 'Issues with mobile devices'],
            ['name' => 'Internet Connectivity', 'description' => 'Issues with internet connectivity'],
            ['name' => 'Printer', 'description' => 'Issues with printers and printing'],
            ['name' => 'Data Backup', 'description' => 'Issues related to data backup'],
            ['name' => 'Environmental', 'description' => 'Environmental issues affecting IT infrastructure'],
            ['name' => 'Power Outage', 'description' => 'Issues related to power outages'],
            ['name' => 'Compliance Violation', 'description' => 'Violations of IT compliance policies'],
            ['name' => 'Access Control', 'description' => 'Issues with access control systems'],
            ['name' => 'VoIP Issues', 'description' => 'Issues with Voice over IP (VoIP) systems'],
            ['name' => 'Network Security', 'description' => 'Security issues related to the network'],
            ['name' => 'Wireless Network Setup', 'description' => 'Issues with wireless network setups'],
            ['name' => 'VPN Setup and Support', 'description' => 'Issues with VPN setups and support'],
            ['name' => 'Network Performance Optimization', 'description' => 'Optimizing network performance'],
            ['name' => 'Server Configuration and Maintenance', 'description' => 'Configuring and maintaining servers'],
            ['name' => 'Backup and Recovery', 'description' => 'Managing data backup and recovery systems'],
            ['name' => 'System Monitoring and Alerts', 'description' => 'Monitoring system performance and setting up alerts'],
            ['name' => 'Database Administration', 'description' => 'Administering databases'],
            ['name' => 'IT Policy and Compliance', 'description' => 'Developing and enforcing IT policies'],
            // Add more categories as needed
        ];

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
            ['name' => 'Network Infrastructure Upgrade', 'description' => 'Plans and executes upgrades to the network infrastructure'],
            ['name' => 'Endpoint Security Management', 'description' => 'Ensures security on endpoint devices, such as computers and laptops'],
            ['name' => 'Cloud Services Administration', 'description' => 'Manages and administers cloud-based services and solutions'],
            ['name' => 'IT Training and Knowledge Sharing', 'description' => 'Provides training sessions and shares IT knowledge within the organization'],
            ['name' => 'IT Asset Management', 'description' => 'Tracks and manages the organization\'s IT assets'],
            ['name' => 'Disaster Recovery Planning', 'description' => 'Develops and implements plans for disaster recovery and business continuity'],
            ['name' => 'IT Governance', 'description' => 'Establishes and oversees IT governance practices'],
            ['name' => 'Health Information System Administration', 'description' => 'Administers and maintains the organization\'s health information system (e.g., SIMRS)'],
        ];


        foreach ($users as $user) {
            foreach ($categories as $category) {
                $model = new IncidentCategory([
                    'id' => Uuid::uuid4()->toString(), // Generate and assign UUID
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'user_id' => $user->id,
                    'user_cid' => $user->cid,
                    'created_by' => $user->name,
                    'created_by_level' => $user->level_access,
                ]);
                $model->save();
            }

            foreach ($services as $service) {
                $model = new ServiceCategory([
                    'id' => Uuid::uuid4()->toString(), // Generate and assign UUID
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'user_id' => $user->id,
                    'user_cid' => $user->cid,
                    'created_by' => $user->name,
                    'created_by_level' => $user->level_access,
                ]);
                $model->save();
            }
        }

    }
}
