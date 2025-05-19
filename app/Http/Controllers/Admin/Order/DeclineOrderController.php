<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DeclineOrderController extends Controller
{
    public function __invoke($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Заказ не найден'], 404);
        }

        $order->status = 'canceled';
        $order->save();

        foreach ($order->cats as $cat) {
            $cat->status = 'доступен';
            $cat->save();
        }

        return response()->json(['message' => 'Заказ успешно отклонен']);
    }
}
