<?php

namespace Modules\ITAM\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ITAM\Entities\AssetCategory;
use Modules\ITAM\Entities\AssetType;
use App\Models\User;

class AssetCategoryAndTypeSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Define your asset categories and types
         $categoriesAndTypes = [
            'Hardware' => [
                'Laptop',
                'Desktop',
                'Workstation',
                'Server',
                'Thin Client',
                'Router',
                'Switch',
                'Firewall',
                'Modem',
                'Access Point',
                'HDD',
                'SSD',
                'NAS',
                'SAN',
                'Monitor',
                'Printer',
                'Scanner',
                'Keyboard',
                'Mouse',
                'Projector',
                'Speaker',
                'Microphone',
                'CCTV'
                // Add more hardware types as needed
            ],
            'Software' => [
                'Operating System',
                'Productivity Software',
                'Design Software',
                'Security Software',
                'Database Software',
                'Web Browser',
                'Email Client',
                // Add more software types
            ],
            'Network' => [
                'Router',
                'Switch',
                'Firewall',
                'Load Balancer',
                'VPN Gateway',
                'Network Interface Card (NIC)',
                // Add more network types
            ],
            'License' => [
                'Software License',
                'Cloud Subscription',
                'Support License',
                // Add more license types
            ],
            'Consumable' => [
                'Ink Cartridge',
                'Toner Cartridge',
                'Paper',
                'Cable',
                // Add more consumable types
            ],
            'Other' => [
                'Documentation',
                'Contract',
                'Training Material',
                'Digital Asset (Image)',
                'Digital Asset (Video)',
                // Add more other types
            ],
            // Add more categories as needed
        ];
        $user = User::where('email', 'synard1@gmail.com')->first();


        foreach ($categoriesAndTypes as $categoryName => $types) {
            // Generate category prefix (First 3 letters, uppercase)
            $categoryPrefix = strtoupper(substr($categoryName, 0, 3));

            // Create category with prefix
            $category = AssetCategory::firstOrCreate([
                'name' => $categoryName,
                'prefix' => $categoryPrefix, // New prefix field
                'created_by' => $user->id
            ]);

            // Ensure unique type prefixes within each category
            $counter = 1;

            foreach ($types as $typeName) {
                $typePrefix = "{$categoryPrefix}-" . str_pad($counter, 3, '0', STR_PAD_LEFT);
                $typePrefix2 = strtoupper(substr($typeName, 0, 3));

                
                AssetType::firstOrCreate([
                    'category_id' => $category->id,
                    'name' => $typeName,
                    'prefix' => $typePrefix2, // New prefix field
                    'long_prefix' => $typePrefix.'-'.$typePrefix2, // New prefix field
                    'created_by' => $user->id,
                ]);

                $counter++;
            }
            // $category = AssetCategory::firstOrCreate(['name' => $categoryName,'created_by' => $user->id]);

            // foreach ($types as $typeName) {
            //     AssetType::firstOrCreate([
            //         'category_id' => $category->id,
            //         'name' => $typeName,
            //         'created_by' => $user->id,
            //     ]);
            // }
        }
    
    }
}
