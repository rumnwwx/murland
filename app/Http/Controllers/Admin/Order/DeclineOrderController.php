<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use App\Models\Photo;
use Illuminate\Http\Request;

class DeclineOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::get();

        foreach ($orders as $order) {

            if(OrderCat::where('id', $order->id)->count()){
                $cat = Cat::where('id', OrderCat::where('id', $order->id)->first()->cat_id)->first();
                $data[] = array(
                    'id' => $order->id,
                    'name' => $order->name,
                    'phone' => $order->phone,
                    'status' => $order->status,
                    'cat' => $cat
                );
            }
            else{
                $data[] = array(
                    'id' => $order->id,
                    'name' => $order->name,
                    'phone' => $order->phone,
                    'status' => $order->status,
                );
            }
        }

        return $data;
    }
}
