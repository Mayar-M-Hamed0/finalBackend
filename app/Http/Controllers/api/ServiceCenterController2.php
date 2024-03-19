<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCenter;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ServiceCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceCenter = ServiceCenter::all();
        return $serviceCenter;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'location' => 'required|string',
            'services' => 'required|array',
            'cars' => 'required|array',

        ]);
        $ServiceCenter->services()->attach($request->input('services'));

        return response()->json(['message' => 'Order created successfully', 'data' => $order],201);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->messages()], 422);
        }

        $ServiceCenter = ServiceCenter::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCenter $serviceCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCenter $serviceCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCenter $serviceCenter)
    {
        //
    }
}
