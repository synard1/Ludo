<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', function (Request $request) {
    // Your authentication logic here (e.g., check credentials)

    // Example (replace with your actual authentication)
    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        $token = $user->createToken('api-token')->plainTextToken; // Create Sanctum token

        return response()->json(['access_token' => $token], 200);
    } else {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->get('/test-auth', function (Request $request) {
    return response()->json(['message' => 'Authenticated!'], 200);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
