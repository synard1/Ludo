<?php

namespace App\Helpers;

use Nwidart\Modules\Facades\Module;

class ModuleHelper
{
    public static function isModuleActive($moduleName)
    {
        return Module::isEnabled($moduleName);
    }
}