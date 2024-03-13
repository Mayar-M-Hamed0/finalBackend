<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ordersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order=order::all();
        return $order;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=validator::make($request->all(),
       [ 'user_id'=>"required",
            // 'user_id'=>auth::user(),
            'order_details'=>'required',
            'service_center_id'=>'required',
            'order_date'=>"required"
       ]


    );
        if ($validator->fails()){
            return response($validator->errors()->all());
        }
        $order=order::create([
            'user_id'=>$request['user_id'],
            // 'user_id'=>auth::user(),
            'order_details'=>$request['order_details'],
            'service_center_id'=>$request['service_center_id'],
            'order_date'=>$request['order_date'],
            'order_state'=>"appended"


        ]);
        return $order;
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
       $order->update($request->all());
       return "done";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
       $order->delete();
    }

    public function archeive(){
        $order =Order::onlyTrashed()->get();
        return $order;
    }
    public function restore($id){
        order::withTrashed()
        ->where('id', 1)
        ->restore();
    }
    public function forcedelete($id){
        order::withTrashed()
        ->where('id', 1)
        ->forceDelete();
    }
}
