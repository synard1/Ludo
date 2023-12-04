<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\StatusHistory;

if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}


if (!function_exists('getName')) {
    /**
     * Get product name
     *
     * @return void
     */
    function getName()
    {
        return config('settings.KT_THEME');
    }
}


if (!function_exists('addHtmlAttribute')) {
    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value)
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes)
    {
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value)
    {
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope)
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true)
    {
        return theme()->printHtmlClasses($scope, $full);
    }
}


if (!function_exists('getSvgIcon')) {
    /**
     * Get SVG icon content
     *
     * @param $path
     * @param $classNames
     * @param $folder
     *
     * @return string
     */
    function getSvgIcon($path, $classNames = 'svg-icon', $folder = 'assets/media/icons/')
    {
        return theme()->getSvgIcon($path, $classNames, $folder);
    }
}


if (!function_exists('setModeSwitch')) {
    /**
     * Set dark mode enabled status
     *
     * @param $flag
     *
     * @return void
     */
    function setModeSwitch($flag)
    {
        theme()->setModeSwitch($flag);
    }
}


if (!function_exists('isModeSwitchEnabled')) {
    /**
     * Check dark mode status
     *
     * @return void
     */
    function isModeSwitchEnabled()
    {
        return theme()->isModeSwitchEnabled();
    }
}


if (!function_exists('setModeDefault')) {
    /**
     * Set the mode to dark or light
     *
     * @param $mode
     *
     * @return void
     */
    function setModeDefault($mode)
    {
        theme()->setModeDefault($mode);
    }
}


if (!function_exists('getModeDefault')) {
    /**
     * Get current mode
     *
     * @return void
     */
    function getModeDefault()
    {
        return theme()->getModeDefault();
    }
}


if (!function_exists('setDirection')) {
    /**
     * Set style direction
     *
     * @param $direction
     *
     * @return void
     */
    function setDirection($direction)
    {
        theme()->setDirection($direction);
    }
}


if (!function_exists('getDirection')) {
    /**
     * Get style direction
     *
     * @return void
     */
    function getDirection()
    {
        return theme()->getDirection();
    }
}


if (!function_exists('isRtlDirection')) {
    /**
     * Check if style direction is RTL
     *
     * @return void
     */
    function isRtlDirection()
    {
        return theme()->isRtlDirection();
    }
}


if (!function_exists('extendCssFilename')) {
    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param $path
     *
     * @return void
     */
    function extendCssFilename($path)
    {
        return theme()->extendCssFilename($path);
    }
}


if (!function_exists('includeFavicon')) {
    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon()
    {
        return theme()->includeFavicon();
    }
}


if (!function_exists('includeFonts')) {
    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts()
    {
        return theme()->includeFonts();
    }
}


if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js')
    {
        return theme()->getGlobalAssets($type);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors)
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor)
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type)
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute)
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}


if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}


if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path)
    {
        return asset('assets/media/'.$path);
    }
}


if (!function_exists('getIcon')) {
    /**
     * Get icon
     *
     * @param $path
     *
     * @return string
     */
    function getIcon($name, $class = '', $type = '')
    {
        return theme()->getIcon($name, $class, $type);
    }
}

function shouldEnableDebugbar()
{
    // Check if the user is authenticated and has the "Super Admin" role
    if (auth()->check() && auth()->user()->hasRole('Super Admin')) {
        return true;
    }

    return false;
}

// if (!function_exists('checkDebugBarEnabled')) {

//     /**
//      * Checks if the debug bar is enabled for the current user.
//      *
//      * This function checks if the user has the Super Admin role or if their IP address is in the whitelist.
//      * If either condition is true, the debug bar is enabled; otherwise, it is disabled.
//      *
//      * @return void
//      */
//     function checkDebugBarEnabled()
//     {
//         $user = auth()->user();

//         // Check if the user has the "Super Admin" role
//         if ($user && $user->hasRole('Super Admin')) {
//             return true;
//         }

//         // Check if the current IP address is whitelisted
//         $whitelistedIPs = config('onexolution.whitelisted_ips', []);
//         if (in_array(request()->ip(), $whitelistedIPs)) {
//             return true;
//         }

//         return false;
//     }
// }

// if (!function_exists('is_super_admin_or_whitelisted_ip')) {
//     function is_super_admin_or_whitelisted_ip()
//     {
//         // Check if the user has Super Admin role
//         if (auth()->check() && auth()->user()->hasRole('Super Admin')) {
//             return true;
//         }

//         // Get the list of whitelisted IP addresses from the configuration
//         $whitelistedIPs = config('onexolution.whitelisted_ips');

//         // Check if the current user's IP address is in the whitelist
//         $userIP = request()->ip();
//         if (in_array($userIP, $whitelistedIPs)) {
//             return true;
//         }

//         return false;
//     }
// }

if (! function_exists('checkMacAddress')) {
    function checkMacAddress($mac)
    {
        $endpoint = Config::get('onexolution.hotspot.endpoint_maclookup');
        $api_key = Config::get('onexolution.hotspot.api_maclookup');

        $responses = Http::withUrlParameters([
            'endpoint' => $endpoint,
            'page' => 'macs',
            'version' => 'v2',
            'mac' => $mac,
            'apiKey' => $api_key,
        ])->get('{+endpoint}/{version}/{page}/{mac}?apiKey={apiKey}');

        return $responses;
    }
}

if (!function_exists('generateRandomString')) {
    /**
     * Generate random string Uppercase Alphanumeric
     *
     * @param $char
     *
     * @return random string
     */
    function generateRandomString($length)
    {
        // return Str::random($char, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $result;
    }
}

if (!function_exists('Uc')) {
    /**
     * Return Uppercase First Letter Each Words
     *
     * @string
     *
     * @return String
     */
    function Uc($string)
    {
        return ucwords($string);
    }
}

if (!function_exists('formatArray')) {
    function formatArray($array)
    {
        // Your logic to format the array
        return json_encode($array);
    }
}

if (!function_exists('statusHistory')) {
    /**
     * Save status history
     *
     * @param $id
     * @param $name
     * @param $data
     * @param $type
     *
     * @return string
     */
    function statusHistory($id, $class = '', $type = '')
    {
        return theme()->getIcon($id, $class, $type);
    }
}

if (!function_exists('isMobileBrowser')) {
    function isMobileBrowser()
    {
        $userAgent = request()->header('User-Agent');

        // Check if the user agent contains keywords commonly found in mobile browsers
        return preg_match('/(iPhone|iPod|Android|webOS|BlackBerry|Windows Phone)/i', $userAgent);
    }
}
