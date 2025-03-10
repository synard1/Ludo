<?php

namespace App\Helpers;

use Nwidart\Modules\Facades\Module;

class ModuleHelper
{
    public static function isModuleActive($moduleName)
    {

        if(Module::has($moduleName)){
          return Module::isEnabled($moduleName);
        }else{
        
          return false;
        }
    }
}