<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use App\Models\Photo;
use Illuminate\Http\Request;

class CreateOrderController extends Controller
{
    public function __invoke(CreateOrderRequest $request)
    {
        $validatedData =$request->validated();

        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'pending';
        }

        $order = Order::query()->create($validatedData);

        return response()->json(['order' => $order], 200);
    }
}
