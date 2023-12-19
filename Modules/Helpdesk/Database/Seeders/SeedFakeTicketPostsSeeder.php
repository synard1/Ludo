<?php

namespace Modules\Helpdesk\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Modules\Helpdesk\Entities\Ticket;

class SeedFakeTicketPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker)
    {
        $user1= User::where('email', 'supervisor@demo.com')->first();
        $user2= User::where('email', 'supervisor@demo2.com')->first();

        // Sample Tickets (adjust details and add more as needed)
        $tickets = [
            [
                'subject' => 'Printer Not Working',
                'description' => 'The printer in the marketing department is not working. It displays an error message.',
                'origin_unit' => "Purchasing", // Replace with appropriate ID
                'reporter_name' => $faker->name, // Replace with appropriate ID
                'issue_category' => ["Hardware"],
                'source_report' => 'Phone Call',
                'report_time' => now()->subHours(2),
                'response_time' => now()->subHours(2)->subMinutes(5),
                'status' => 'Open',
                'user_id' => $user1->id,
                'user_cid' => $user1->cid,
                'created_by' => $user1->name,
                'created_by_level' => $user1->level_access,
            ],
            [
                'subject' => 'Slow Internet Speed',
                'description' => 'The internet connection in the development team is very slow.',
                'origin_unit' => "Cashier", // Replace with appropriate ID
                'reporter_name' => $faker->name, // Replace with appropriate ID
                'issue_category' => ["Network"],
                'source_report' => 'Email',
                'report_time' => now()->subDay(),
                'response_time' => now()->subDay()->subMinutes(5),
                'status' => 'Open',
                'user_id' => $user1->id,
                'user_cid' => $user1->cid,
                'created_by' => $user1->name,
                'created_by_level' => $user1->level_access,
            ],
            [
                'subject' => 'Software Crashing',
                'description' => 'The accounting software keeps crashing unexpectedly, causing data loss and delays in work.',
                'origin_unit' => "Accounting", // Replace with appropriate ID
                'reporter_name' => $faker->name, // Replace with appropriate ID
                'issue_category' => ["Software"],
                'source_report' => 'Walk-in',
                'report_time' => now()->subDays(2),
                'response_time' => now()->subHours(2), // No response yet
                'status' => 'Open',
                'user_id' => $user1->id,
                'user_cid' => $user1->cid,
                'created_by' => $user1->name,
                'created_by_level' => $user1->level_access,
            ],
            [
                'subject' => 'Access Denied',
                'description' => 'I am unable to access my project files on the server. I received an "Access Denied" error message.',
                'origin_unit' => "IT", // Replace with appropriate ID
                'reporter_name' => $faker->name, // Replace with appropriate ID
                'issue_category' => ["User"],
                'source_report' => 'Online Chat',
                'report_time' => now()->subHours(3),
                'response_time' => now()->subHours(2), // Responded within an hour
                'status' => 'Open',
                'user_id' => $user2->id,
                'user_cid' => $user2->cid,
                'created_by' => $user2->name,
                'created_by_level' => $user2->level_access,
            ],
            [
                'subject' => 'Urgent: Phone Lines Down',
                'description' => 'All phone lines in the office are down, preventing us from making or receiving calls.',
                'origin_unit' => "Sales", // Replace with appropriate ID
                'reporter_name' => $faker->name, // Replace with appropriate ID
                'issue_category' =>["Network"],
                'source_report' => 'Phone Call',
                'report_time' => now()->subMinutes(15),
                'response_time' => now()->subHours(1), // Awaiting immediate response
                'status' => 'Open',
                'user_id' => $user2->id,
                'user_cid' => $user2->cid,
                'created_by' => $user2->name,
                'created_by_level' => $user2->level_access,
            ],
            [
                'subject' => 'Missing Supplies',
                'description' => 'We are running low on toner cartridges and printer paper, causing delays in printing important documents.',
                'origin_unit' => "Human Resources", // Replace with appropriate ID
                'reporter_name' => $faker->name, // Replace with appropriate ID
                'issue_category' => ["Supplies"],
                'source_report' => 'Internal Ticket',
                'report_time' => now()->subHours(1),
                'response_time' => now()->subHours(1), // Resolved within an hour
                'status' => 'Open',
                'user_id' => $user2->id,
                'user_cid' => $user2->cid,
                'created_by' => $user2->name,
                'created_by_level' => $user2->level_access,
            ],
            // ... Add more tickets
        ];

        foreach ($tickets as $ticket) {
            $model = new Ticket([
                'id' => Uuid::uuid4()->toString(), // Generate and assign UUID
                'subject' => $ticket['subject'],
                'description' => $ticket['description'],
                'origin_unit' => $ticket['origin_unit'],
                'reporter_name' => $ticket['reporter_name'],
                'issue_category' => $ticket['issue_category'],
                'source_report' => $ticket['source_report'],
                'report_time' => $ticket['report_time'],
                'response_time' => $ticket['response_time'],
                'status' => $ticket['status'],
                'user_id' => $ticket['user_id'],
                'user_cid' => $ticket['user_cid'],
                'created_by' => $ticket['created_by'],
                'created_by_level' => $ticket['created_by_level'],
            ]);
            $model->save();
        }

        // foreach ($tickets as $ticket) {
        //     DB::table('tickets')->insert($ticket);
        // }
    }
}
