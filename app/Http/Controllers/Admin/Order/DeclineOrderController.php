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
    public function __invoke($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'canceled';
        $order->save();

        foreach ($order->cats as $cat) {
            $cat->status = 'доступен';
            $cat->save();
        }

        return response()->json(['message' => 'Заявка отклонена']);
    }
}
