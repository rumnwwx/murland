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
        // Получаем заказы с нужными отношениями
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->get();

        // Формируем данные для ответа
        $data = [
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'user' => $order->user->name,
                    'total' => $order->total,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    'items' => $order->orderItems->map(function ($item) {
                        return [
                            'product' => $item->product->name,
                            'quantity' => $item->quantity,
                            'price' => $item->price
                        ];
                    })
                ];
            })
        ];

        // Возвращаем ответ
        return response()->json($data);
    }

}
