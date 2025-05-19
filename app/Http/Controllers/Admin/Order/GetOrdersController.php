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
    public function __invoke()
    {
        $orders = Order::with('cats')->latest()->get();

        return response()->json([
            'orders' => $orders,
        ]);
    }

}
