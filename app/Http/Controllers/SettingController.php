<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanySla;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

use Modules\Notification\Services\TelegramService;
use Modules\Notification\Http\Controllers\TelegramController;

use Modules\Notification\Entities\CategoryNotif;
use Modules\Notification\Entities\PlatformNotif;
use Modules\Notification\Entities\UserNotif;

class SettingController extends Controller
{

    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if(auth()->user()->can('access setting management') && auth()->user()->can('read setting management')) {
        //         return $next($request);
        //     }

        //     abort(403, 'Unauthorized access.');
        // });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            addVendors(['datatables']);

            return view('pages.settings.indexAdmin');
        }

        addJavascriptFile('assets/js/custom/settings/company.js');

        $user = auth()->user(); // Get the authenticated user's ID
        $cid = $user->cid; // Assuming 'cid' is provided in the request
        $uid = $user->id; // Assuming 'cid' is provided in the request

    // Retrieve the company data based on user_id and cid
    $company = Company::where('user_id', $uid)
        ->where('cid', $cid)
        ->first(); // Use 'first' to get a single result or null if not found

    $companySla = CompanySla::where('user_id', $uid)
        ->where('user_cid', $cid)
        ->whereIn('name', ['mttr', 'art'])
        ->first(); // Assuming you're expecting a single result
    // return view('company.form', compact('company'));

        return view('pages.settings.index', compact(['companySla','company']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function getCompany(Company $company)
    {
        $company = Company::all();
        return $company->toJson();
    }

    public function saveCompany(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;
        $devStorage = config('onexolution.setting.dev_disk');
        $prodStorage = config('onexolution.setting.prod_disk');

        $checker = Company::where('user_id',$userId)->where('cid',$cid)->first();

        if($checker){
            if($checker->status = "Active"){

                $data = [
                    'name' => $request->input('company'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'website' => $request->input('website'),
                ];

                // Get the selected communication options
                $communicationOptions = $request->input('communication', []);
                // Save the array into the database
                $communicationString = json_encode($communicationOptions);
                // $data['communication'] = $communicationString;

                try {
                    if ($request->hasFile('logo')) {
                        $file = $request->file('logo');
                        $fileName = time() . '.' . $file->getClientOriginalExtension();
                        $oldFileName = $checker->logo;
            
                        // Determine storage disk based on environment
                        // $storageDisk = env('APP_ENV') === 'local' ? 'local' : 'contabo';
                        // $storagePath = $storageDisk === 'local' ? 'local/images/logo' : 'prod/images/logo';

                        // Determine storage path based on environment
                        $storageDisk = 'contabo';
                        $storagePath = env('APP_ENV') === 'local' ? 'local/images/logo' : 'prod/images/logo';

                        // Perform file operations
                        $path = Storage::disk('contabo')->put($storagePath, $file);

                        // Remove old image if exists
                        // $oldImagePath = "{$storageDisk}://{$storagePath}/{$oldFileName}";
                        $oldImagePath = "{$storagePath}/{$oldFileName}";
                        if (Storage::disk($storageDisk)->exists($oldImagePath)) {
                            Storage::disk($storageDisk)->delete($oldImagePath);
                        }else{
                             // Return message and image path (or null if error)
                            return [
                                'message' => 'not exist',
                                'image_path' => $oldImagePath,
                            ];
                        }

                        // Perform file operations
                        $path = Storage::disk($storageDisk)->put($storagePath, $file);
                        $url = Storage::disk($storageDisk)->url($path);
                        // Extract the file name from the path
                        $newFileName = basename($path);

                        // Prepare response
                        $message = 'Image uploaded successfully! ' . $url;
                        $imagePath = "{$storageDisk}://{$path}";
                        $data['logo'] = $newFileName;
                        $data['logo_url'] = $url;
                        $data['image_path'] = $imagePath;
            
                        // // Determine storage path based on environment
                        // $storagePath = env('APP_ENV') === 'local' ? 'local/images/logo' : 'prod/images/logo';
            
                        // // Store the image
                        // $path = Storage::disk($storageDisk)->put($storagePath, $file);
            
                        // // Get the full URL of the stored image
                        // $url = Storage::disk($storageDisk)->url($path);
            
                        // // Success message
                        // $message = 'Image uploaded successfully! ' . $url;
            
                        // // Use the image path
                        // $imagePath = "{$storageDisk}://{$path}";

                        // // Save to DB
                        // $data['logo'] = $url;

                    } else {
                        throw new \Exception('No image file uploaded.');
                    }
                } catch (\Exception $e) {
                    // Handle error
                    $message = 'Error uploading image: ' . $e->getMessage();
                    $imagePath = null;
                }
            
                // Return message and image path (or null if error)
                // return [
                //     'message' => $message,
                //     'image_path' => $imagePath,
                // ];

                $company = Company::updateOrCreate(
                    ['user_id' => $userId, 'cid' => $cid],
                    $data
                );

                // dd($upload);
                return response()->json(['message' => 'Company saved or updated successfully']);

            }elseif($checker->status = "Pending Review"){
                return response()->json(['message' => 'Please wait, your company profile under pending review']);
            }

        }else{

            $status = 'Pending Review';
            $userlink = round(now()->timestamp/151);

            $data = [
                'user_id' => $userId,
                'cid' => $cid,
                'name' => $request->input('company'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'communication' => $request->input('communication'),
                'subscription' => $user->subscription,
                'status' => $status,
                'userlink' => $userlink,
                'userlink2' => 'c'.$userlink . config('onexolution.company.url'),
            ];

            $company = Company::updateOrCreate(
                ['user_id' => $userId, 'cid' => $cid],
                $data
            );

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Company saved or updated successfully']);

        }


    }

    public function saveSla(Request $request)
    {
        $user = auth()->user();

        // Assuming your form data is passed as an array in the 'payload' field
        $payloadData = [
            'mttr' => $request->input('mttr'),
            'art' => $request->input('art'),
            // Add other fields as needed
        ];

        Company::where('cid',$user->cid)
                    ->update([
                        'payload' => $payloadData,
                    ]);

        return response()->json(['message' => 'SLA saved or updated successfully']);

        // try {

        //     if($request->input('sla_id')){
        //         // Update the ticket with the new status
        //         CompanySla::where('id', $request->input('sla_id'))
        //             ->where('user_cid',$user->cid)
        //             ->update([
        //                 // 'name' => $request->input('title'),
        //                 'description' => $request->input('description'),
        //                 'duration' => $request->input('duration'),
        //             ]);
        //     }else{
        //         $sla = CompanySla::create([
        //             'name' => $request->input('title'),
        //             'description' => $request->input('description'),
        //             'duration' => $request->input('duration'),
        //         ]);
        
        //     }
    
        //     // You can return a response, e.g., a success message
        //     return response()->json(['message' => 'SLA saved or updated successfully']);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['message' => 'Failed']);
        // }

    }

    

public function getCompanyData(Request $request)
{
    $userId = auth()->user()->id; // Get the authenticated user's ID
    $cid = $request->input('cid'); // Assuming 'cid' is provided in the request

    // Retrieve the company data based on user_id and cid
    $company = Company::where('user_id', $userId)
        ->where('cid', $cid)
        ->first(); // Use 'first' to get a single result or null if not found

    if ($company) {
        // Company data found
        return response()->json(['company' => $company]);
    } else {
        // Company not found
        return response()->json(['message' => 'Company not found'], 404);
    }
}

public function updateStatus(Request $request, $id)
{
    $status = $request->input('status');
    $userId = auth()->user()->id; // Get the authenticated user's ID

    try {
        $company = Company::updateOrCreate(
            ['id' => $id],
            ['status' => $status]
        );

        $users = User::where('cid', $company->cid)->update(['status' => $status]);

        //code...
        $comp = Company::where('id', $id)->first();
        $user = User::where('id', $comp->user_id)->first();

        // Assign default role "administrator" to the user
        $user->removeRole('Trial');
        $user->assignRole('Administrator');

        // Update the status in the database for the specified ID
        // You can use the Company model or your relevant model

        return response()->json(['message' => 'Status updated successfully']);
    } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['message' => 'Error']);
    }


}

public function clearCache($cacheType = 'all')
    {
        switch ($cacheType) {
            case 'config':
                Artisan::call('config:clear');
                break;

            case 'view':
                Artisan::call('view:clear');
                break;

            default:
                Artisan::call('cache:clear');
                break;
        }

        return "Cache ({$cacheType}) cleared.";
    }


    public function getLimit(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID
        $cid = $request->input('cid'); // Assuming 'cid' is provided in the request
        $source = config('onexolution.limit');

        // dd($user->subscription);
        // dd($source[$user->subscription]);

        // Extract the 'Free' section
        $data = $source[$user->subscription];

        // Count the total data
        $totalDataCount = count($data);

        // Prepare the result array
        $result = [
            'total' => "$totalDataCount",
            'data' => $data,
        ];

        // Print the result in JSON format
        echo json_encode($result, JSON_PRETTY_PRINT);
    }


    public function getVersion(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID
        $major = config('onexolution.version.major');
        $minor = config('onexolution.version.minor');
        $patch = config('onexolution.version.patch');

        // Prepare the result array
        $result = $major.'.'.$minor.'.'.$patch;

        // Print the result in JSON format
        return json_encode($result, JSON_PRETTY_PRINT);
    }

    public function domainCheck($client_id)
    {
        // Access the client_id wildcard here
        return "Client ID: $client_id";
    }

    public function showLogo($disk, $filename)
    {
        // Validate the disk to ensure it's a valid option
        $validDisks = ['contabo', 'local'];

        if (!in_array($disk, $validDisks)) {
            abort(404);
        }

        $path = 'prod/images/logo/' . $filename;

        // Check if the file exists in the specified storage disk
        if (Storage::disk($disk)->exists($path)) {
            // Return the image with the appropriate content type
            $file = Storage::disk($disk)->get($path);
            $type = Storage::disk($disk)->mimeType($path);

            return response($file, 200)->header('Content-Type', $type);
        }

        // If the file does not exist, return a 404 response
        abort(404);
    }

    public function getNotification(Request $request)
    {
        $user = auth()->user();
        // return response()->json(['message' => 'Error']);
        
        $data = UserNotif::where('user_cid',$user->cid)->get();

        if ($data->isNotEmpty()) {
            // Transform the incident data to include user names
            $formattedData = $data->map(function ($com) {
                return $com->platformCom->name.'_'.$com->module.'_'.$com->sub_module;
            });

            return response()->json(['notif' => $formattedData]);

        // return response()->json(['data' => $data]);
        // return response()->json(['message' => 'Notification saved or updated successfully']);

        } else {
            // Incident not found
            return response()->json(['']);
            // return response()->json(['message' => 'Incident not found'], 404);
        }
    }

    public function saveNotification(Request $request)
    {
        // Retrieve user data and form input
        $user = auth()->user();
        $formData = $request->all();
        $task = $request->input('task');
        $type = $request->input('type');
        $platform = $request->input('platform');

        if($task == 'SAVE'){
            // Check User Subscription
            if($user->subscription == 'Free'){
                $botToken = config('notification.bot.Telegram');
            }else{
                $botToken = $request->input('bot_token');
            }
          
            // Handle CONFIG type
            if ($type == 'CONFIG') {
                // Build payload data for update
                $payloadData = $this->buildPayloadData($request, $platform, $botToken);
                // Update company payload
                $this->updateCompanyPayload($user, $payloadData);

                return response()->json(['message' => 'Notification ' . ucfirst($type) . ' for ' . ucfirst($platform) . ' saved or updated successfully']);
            }
        } 
        // Handle TEST task for CONFIG type and telegram platform
        elseif ($task == 'TEST' && $type == 'CONFIG' && $platform == 'telegram') {
            // Send test telegram message
            $response = $this->sendTestTelegramMessage($request);
            return $response;
        }

        // Delete old user notifications
        $deleted = $this->deleteOldUserNotifications($user);

        // Insert new user notifications
        $this->insertNewUserNotifications($request->input('notif'), $user);

        return response()->json(['message' => 'Notification saved or updated successfully']);
    }

    // Build payload data for update
    private function buildPayloadData(Request $request, $platform, $botToken)
    {
        return [
            $platform => [
                'bot_token' => $botToken,
                'recipient' => $request->input('recipient'),
                'recipient_type' => 'GROUP', // GROUP OR PERSONAL
                'active' => $request->input('active'),
            ]
        ];
    }

    // Update company payload
    private function updateCompanyPayload($user, $payloadData)
    {
        Company::where('cid', $user->cid)->update([
            'payload' => $payloadData,
        ]);
    }

    // Send test telegram message
    private function sendTestTelegramMessage(Request $request)
    {
        $telegramService = app(TelegramService::class);
        $telegramController = new TelegramController($telegramService);
        return $telegramController->sendMessageToTelegram('Test Config');
    }

    // Delete old user notifications
    private function deleteOldUserNotifications($user)
    {
        return UserNotif::where('user_cid', $user->cid)->delete();
    }

    // Insert new user notifications
    private function insertNewUserNotifications($notifData, $user)
    {
        foreach ($notifData as $data) {
            $parts = explode("_", $data);
            $platform = $parts[0];
            $module = $parts[1];
            $submodule = $parts[2];

            $platform = PlatformNotif::where('name', $platform)->first();
            $category = CategoryNotif::where('module', $module)->where('sub_module', $submodule)->first();

            UserNotif::create([
                'platform_id' => $platform->id,
                'category_id' => $category->id,
                'module' => $module,
                'sub_module' => $submodule,
                'name' => $category->name,
                'description' => $category->description,
                'user_cid' => $user->cid,
            ]);
        }
    }


    // public function saveNotification(Request $request)
    // {
    //     $user = auth()->user();

    //     $formData = $request->all();

    //     $task = $request->input('task');
    //     $type = $request->input('type');
    //     $platform = $request->input('platform');

    //     if($task == 'SAVE'){
    //         // Check User Subscription
    //         if($user->subscription == 'Free'){
    //             $botToken = env('BOT_TELEGRAM');
    //         }else{
    //             $botToken = $request->input('bot_token');
    //         }

    //         if($type == 'CONFIG'){
    //             $payloadData = [
    //                 $platform => [
    //                     'bot_token' => $botToken,
    //                     'recipient' => $request->input('recipient'),
    //                     'recipient_type' => 'GROUP', // GROUP OR PERSONAL
    //                     'active' => $request->input('active'),
    //                 ]
    //             ];
        
    //             // dd($payloadData);

    //             Company::where('cid',$user->cid)
    //                         ->update([
    //                             'payload' => $payloadData,
    //                         ]);

    //             // dd($payloadData);

    //             return response()->json(['message' => 'Notification ' .$type . ' for '.Uc($platform).' saved or updated successfully']);
    //         }
    //     }elseif($task == 'TEST' && $type == 'CONFIG' && $platform == 'telegram'){
    //         $payloadData = [
    //             $platform => [
    //                 'bot_token' => $request->input('bot_token'),
    //                 'recipient' => $request->input('recipient'),
    //                 'recipient_type' => 'GROUP', // GROUP OR PERSONAL
    //                 'active' => $request->input('active'),
    //             ]
    //         ];

    //         // Call the sendMessageToTelegram method
    //         // $response = TelegramController::sendMessageToTelegram('Test Config');
    //         // // // Handle the response
    //         // return $response;

    //         // Create an instance of the TelegramService
    //         $telegramService = app(TelegramService::class);

    //         // Create an instance of the TelegramController and pass the TelegramService instance
    //         $telegramController = new TelegramController($telegramService);

    //         // Call the sendMessageToTelegram method on the instance
    //         $response = $telegramController->sendMessageToTelegram('Test Config');

    //         // Handle the response
    //         return $response;
    //     }
        
    //     // dd(count($request->input('notif')));

    //     // Delete old data before insert new data
    //     $deleted = UserNotif::where('user_cid',$user->cid)->delete();

    //     $count = count($request->input('notif'));

    //     foreach ($request->input('notif') as $data) {
    //         $parts = explode("_", $data);

    //         // $parts is now an array containing ["Telegram", "ITSM", "Logbook"]

    //         // Accessing individual parts
    //         $platform = $parts[0]; // "Telegram"
    //         $module = $parts[1]; // "ITSM"
    //         $submodule = $parts[2]; // "Logbook"

    //         $platform = PlatformNotif::where('name',$platform)->first();
    //         $category = CategoryNotif::where('module',$module)
    //             ->where('sub_module',$submodule)
    //             ->first();
    //         // print_r($platform .' '. $module .' '. $submodule );

    //         $userCom = UserNotif::create([
    //                         'platform_id' => $platform->id,
    //                         'category_id' => $category->id,
    //                         'module' => $module,
    //                         'sub_module' => $submodule,
    //                         'name' => $category->name,
    //                         'description' => $category->description,
    //                     ]);
    //     }

    //     // Assuming your form data is passed as an array in the 'payload' field
    //     // $payloadData = [
    //     //     'type' => $request->input('type'),
    //     //     'bot_token' => $request->input('bot_token'),
    //     //     'bot_recipient' => $request->input('bot_recipient'),
    //     //     'active' => $request->input('active'),
    //     //     // Add other fields as needed
    //     // ];

        

    //     // Company::where('cid',$user->cid)
    //     //             ->update([
    //     //                 'payload' => $payloadData,
    //     //             ]);

    //     return response()->json(['message' => 'Notification saved or updated successfully']);

    // }
}
