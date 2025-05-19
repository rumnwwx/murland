<?php

namespace App\Http\Controllers\Cat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use App\Models\Photo;
use Illuminate\Http\Request;

class GetAvailableCatsController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Cat::query()
            ->where('status', 'доступен')
            ->with(['breed']);

        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('breed')) {
            $query->whereHas('breed', function ($q) use ($request) {
                $q->where('name', $request->breed);
            });
        }

        $cats = $query->orderBy('name')
            ->get()
            ->map(function ($cat) {
                $catArray = $cat->toArray();

                return [
                    ...$catArray,
                    'breed' => $cat->breed->name,
                    'photo' => $cat->photo ? asset('/' . $cat->photo) : null,
                ];
            });

        return response()->json($cats);
    }
}
