<?php

namespace Modules\ITAM\Services;

use Illuminate\Support\Str;
use Modules\ITAM\Entities\Asset;

class AssetTagGenerator
{
    /**
     * Generate an asset tag based on the selected criteria.
     *
     * @param int $assetTagType
     * @param \App\Models\Asset|null $asset
     * @return string
     */
    public function generate(int $assetTagType, ?Asset $asset = null): string
    {
        switch ($assetTagType) {
            case 1:
                return $this->generateUniversalCode();
            case 2:
                return $this->generateCategoryCodePrefix($asset);
            case 3:
                return $this->generateTypeCodePrefix($asset);
            case 4:
                return $this->generateCategoryNumberTypeCount($asset);
            case 5:
                return $this->generateUniversalCodeAlphabetic();
            case 6:
                return $this->generateUniversalCodeAlphanumeric();
            default:
                return $this->generateUniversalCode(); // Default to universal code
        }
    }

    /**
     * Generate a universal asset tag (IT-00001).
     *
     * @return string
     */
    protected function generateUniversalCode(): string
    {
        $count = Asset::count() + 1;
        return 'IT-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Generate an asset tag with category code prefix (HARD-0001).
     *
     * @param \App\Models\Asset|null $asset
     * @return string
     */
    protected function generateCategoryCodePrefix(?Asset $asset): string
    {
        if (!$asset || !$asset->category) {
            return 'CAT-ERR'; // Or handle error appropriately
        }

        $categoryCode = strtoupper(Str::limit($asset->category->name, 4, '')); // Example: HARD
        $count = Asset::where('category_id', $asset->category_id)->count() + 1;
        return $categoryCode . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate an asset tag with type code prefix (INK-0001).
     *
     * @param \App\Models\Asset|null $asset
     * @return string
     */
    protected function generateTypeCodePrefix(?Asset $asset): string
    {
        if (!$asset || !$asset->type) {
            return 'TYPE-ERR'; // Or handle error appropriately
        }

        $typeCode = strtoupper(Str::limit($asset->type->name, 4, '')); // Example: INK
        $count = Asset::where('type_id', $asset->type_id)->count() + 1;
        return $typeCode . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate an asset tag with category-number-type-count (CON-001-INK-000x).
     *
     * @param \App\Models\Asset|null $asset
     * @return string
     */
    protected function generateCategoryNumberTypeCount(?Asset $asset): string
    {
        if (!$asset || !$asset->category || !$asset->type) {
            return 'CAT-TYPE-ERR'; // Or handle error appropriately
        }

        $categoryCode = strtoupper(Str::limit($asset->category->name, 3, ''));
        $typeCode = strtoupper(Str::limit($asset->type->name, 3, ''));
        $categoryCount = Asset::where('category_id', $asset->category_id)->count() + 1;
        $typeCount = Asset::where('type_id', $asset->type_id)->count() + 1;

        return $categoryCode . '-' . str_pad($categoryCount, 3, '0', STR_PAD_LEFT) . '-' . $typeCode . '-' . str_pad($typeCount, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a universal asset tag (IT-ABCDE).
     *
     * @return string
     */
    protected function generateUniversalCodeAlphabetic(): string
    {
        $count = Asset::count() + 1;
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $tag = 'IT-';
        for ($i = 0; $i < 5; $i++) {
            $tag .= $alphabet[$count % 26];
            $count = (int)($count / 26);
        }
        return $tag;
    }

    /**
     * Generate a universal asset tag (IT-0AB96Y).
     *
     * @return string
     */
    protected function generateUniversalCodeAlphanumeric(): string
    {
        $characters = $this->generateRandomCode();
        $tag = 'IT-';
        $tag .= $characters;
        // $count = Asset::count() + 1;
        // for ($i = 0; $i < 6; $i++) {
        //     $tag .= $characters[$count % 36];
        //     $count = (int)($count / 36);
        // }
        return $tag;
    }

    function generateRandomCode($length = 6) {
        return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }
}
