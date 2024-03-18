<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrdersController extends Controller
{
    use traitapi\apitrait;

    public function index()
    {
        $orders = Order::all();
        if ($orders->isEmpty()) {
            return "No orders available!";
        } else {
            return $this->apiresponse($orders, "ok", 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_details' => 'required',
            'service_center_id' => 'required',
            'order_date' => 'required',
            'order_state' => 'required',
            'phone' => 'required',
            'car_model' => 'required',
            'services' => 'array|required', 
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $order = Order::create([
            'user_id' => $request->user_id,
            'order_details' => $request->order_details,
            'service_center_id' => $request->service_center_id,
            'order_date' => $request->order_date,
            'phone' => $request->phone,
            'car_model' => $request->car_model,
            'order_state' => $request->order_state,
        ]);

        $order->services()->attach($request->input('services'));

        return $this->apiresponse($order, "Order created successfully", 201);
    }

    public function show(Order $order)
    {
        return $this->apiresponse($order, "ok", 200);
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_details' => 'required',
            'service_center_id' => 'required',
            'order_date' => 'required',
            'phone' => 'required',
            'car_model' => 'required',
            'services' => 'array|required', 
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $order->update($request->all());

        // Sync the selected services with the order
        $order->services()->sync($request->input('services'));

        return $this->apiresponse($order, "Order updated successfully", 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return $this->apiresponse([], "Order deleted successfully", 200);
    }




    public function getOrdersByServiceCenterId($service_center_id)
    {
        $orders = Order::where('service_center_id', $service_center_id)->get();

        if ($orders->isEmpty()) {
            return $this->apiresponse([], "No orders found for the specified service center ID", 404);
        }

        return $this->apiresponse($orders, "Orders found for the specified service center ID", 200);
    }
}
