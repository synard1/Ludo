<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

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

    // return view('company.form', compact('company'));

        return view('pages.settings.index', compact('company'));
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

        $checker = Company::where('user_id',$userId)->where('cid',$cid)->first();

        if($checker){
            if($checker->status = "Pending Review"){
                return response()->json(['message' => 'Please wait, your company profile under pending review']);
            }

        }else{

            $status = 'Pending Review';
            $data = [
                'user_id' => $userId,
                'cid' => $cid,
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'communication' => $request->input('communication'),
                'status' => $status
            ];

            $company = Company::updateOrCreate(
                ['user_id' => $userId, 'cid' => $cid],
                $data
            );

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Company saved or updated successfully']);

        }


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

        //code...
        $comp = Company::where('id', $id)->first();
        $user = User::where('id', $comp->user_id)->first();

        // Assign default role "administrator" to the user
        $user->removeRole('trial');
        $user->assignRole('administrator');

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
}
