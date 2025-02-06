<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Notification\Entities\CategoryNotif;
use Modules\Notification\Entities\PlatformNotif;

use Ramsey\Uuid\Uuid;

class NotificationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('parent_id', null)->where('level_access', 'Super Admin')->get();

        $categories = [
            ['module' => 'ITSM', 'sub_module' => null, 'name' => 'ITSM Daily Report', 'description' => 'Issues related to network connectivity', 'status' => '0'],
            ['module' => 'ITSM', 'sub_module' => 'Incident', 'name' => 'ITSM Incident', 'description' => 'Including new incident, edit, resolved, cancelled', 'status' => '1'],
            ['module' => 'ITSM', 'sub_module' => 'Services', 'name' => 'ITSM Incident', 'description' => 'Including new incident, edit, resolved, cancelled', 'status' => '1'],
            ['module' => 'ITSM', 'sub_module' => 'WorkOrder', 'name' => 'ITSM Incident', 'description' => 'Including new incident, edit, resolved, cancelled', 'status' => '1'],
            ['module' => 'ITSM', 'sub_module' => 'Logbook', 'name' => 'ITSM Logbook Review', 'description' => 'Notification to report new logbook need a review from supervisor', 'status' => '0'],
            // Add more categories as needed
        ];

        $platforms = [
            ['name' => 'Email', 'description' => 'Send notification via email group or personal', 'status' => '0'],
            ['name' => 'WhatsApp', 'description' => 'Planning', 'status' => '0'],
            ['name' => 'Telegram', 'description' => 'Send notification via telegram bot to personal chat or group chat', 'status' => '1'],
        ];

        foreach ($users as $user) {
            foreach ($categories as $category) {
                $model = new CategoryNotif([
                    'id' => Uuid::uuid4()->toString(), // Generate and assign UUID
                    'module' => $category['module'],
                    'sub_module' => $category['sub_module'],
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'status' => $category['status'],
                    'user_id' => $user->id,
                    'user_cid' => $user->cid,
                    'created_by' => $user->name,
                    'created_by_level' => $user->level_access,
                ]);
                $model->save();
            }

            foreach ($platforms as $platform) {
                $model = new PlatformNotif([
                    'id' => Uuid::uuid4()->toString(), // Generate and assign UUID
                    'name' => $platform['name'],
                    'description' => $platform['description'],
                    'status' => $platform['status'],
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
