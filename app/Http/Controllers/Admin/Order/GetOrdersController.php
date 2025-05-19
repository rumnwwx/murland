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
        $orders = Order::with('cats')->get();

        $statuses = [
            'pending' => 0,
            'approved' => 1,
            'canceled' => 2
        ];

        $sortedOrders = $orders->sortBy(function ($order) use ($statuses) {
            return $statuses[$order->status] ?? 99;
        });

        $formattedOrders = $sortedOrders->map(function ($order) {
            return [
                'id' => $order->id,
                'name' => $order->name,
                'phone' => $order->phone,
                'status' => $order->status,
                'cat_ids' => $order->cats->map(function ($cat) {
                    return [
                        'id' => $cat->id,
                        'name' => $cat->name,
                        'gender' => $cat->gender,
                        'birth_date' => $cat->birth_date,
                        'color' => $cat->color,
                        'breed_id' => $cat->breed_id,
                        'status' => $cat->status,
                        'photo' => $cat->photo ? asset('/' . $cat->photo) : null,
                    ];
                }),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        })->values();

        return response()->json($formattedOrders, 200);
    }

}
