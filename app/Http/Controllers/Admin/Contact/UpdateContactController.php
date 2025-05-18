<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Order\CreateOrderRequest;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderCat;
use App\Models\Photo;
use Illuminate\Http\Request;

class UpdateContactController extends Controller
{
    public function __invoke(Request $request)
    {

        $validated = $request->validate([
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'work_hours' => 'nullable|string|max:255',
        ]);

        $map = [
            'phone' => 'phone',
            'email' => 'email',
            'address' => 'address',
            'work_hours' => 'time',
        ];

        foreach ($map as $field => $type) {
            if (!is_null($validated[$field])) {
                Contact::updateOrCreate(
                    ['type' => $type],
                    ['value' => $validated[$field]]
                );
            }
        }

        return response()->json([
            'message' => 'Контактные данные успешно обновлены.',
            'data' => $validated,
        ]);
    }
}
