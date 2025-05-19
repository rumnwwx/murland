<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use Illuminate\Http\Request;

class CreateOrderController extends Controller
{
    public function __invoke(CreateOrderRequest $request)
    {
        $validatedData = $request->validated();

        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'pending';
        }

        $order = Order::query()->create($validatedData);

        if (isset($validatedData['cat_ids']) && is_array($validatedData['cat_ids'])) {
            $order->cats()->sync($validatedData['cat_ids']);
        }

        $response = [
            'order' => [
                'id' => $order->id,
                'name' => $order->name,
                'phone' => $order->phone,
                'status' => $order->status,
                'cat_ids' => $order->cats,
            ],
            'message' => 'Заказ успешно создан'
        ];

        return response()->json($response, 200);
    }
}


