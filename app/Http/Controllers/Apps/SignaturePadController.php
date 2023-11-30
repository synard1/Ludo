<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\SignaturePad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SignaturePadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.apps.core.signaturePad');
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
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        DB::beginTransaction();

        try {

            $sign = SignaturePad::updateOrCreate(
                ['model_id' => $request->input('workorder_id'), 'user_cid' => $cid],
                ['signature' => $request->input('signature'),
                'module' => $request->input('module'),
                'model' => $request->input('model'),
                ]
            );

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Signature saved or updated successfully']);
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();

            // You can log the error or return an error response
            return response()->json(['error' => 'Error saving Work Order Response'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SignaturePad $signaturePad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SignaturePad $signaturePad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SignaturePad $signaturePad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SignaturePad $signaturePad)
    {
        //
    }
}
