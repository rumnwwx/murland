<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use App\Models\Photo;
use Illuminate\Http\Request;

class GetOrdersController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::all()->sortBy(function ($orders) {
            $statuses = [
                'pending' => 0,
                'approved' => 1,
                'canceled' => 2
            ];

            return $statuses[$orders->status];
        });


        return response()->json($orders)->setStatusCode(200);
    }

}
