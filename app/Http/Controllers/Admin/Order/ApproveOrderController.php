<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use Illuminate\Http\Request;

class ApproveOrderController extends Controller
{
    public function __invoke($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Заказ не найден'], 404);
        }

        $order->status = 'approved';
        $order->save();

        foreach ($order->cats as $cat) {
            $cat->status = 'усыновлен';
            $cat->save();
        }

        return response()->json(['message' => 'Заказ успешно одобрен']);
    }
}
