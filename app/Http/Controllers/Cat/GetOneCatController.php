<?php

namespace App\Http\Controllers\Cat;

use App\Http\Controllers\Controller;
use App\Models\Cat;

class GetOneCatController extends Controller
{
    public function __invoke($id)
    {
        $cat = Cat::with(['breed'])->find($id);

        if (!$cat) {
            return response()->json([
                'message' => 'Кот не найден',
            ], 404);
        }

        $data = [
            'id' => $cat->id,
            'name' => $cat->name,
            'gender' => $cat->gender,
            'birth_date' => $cat->birth_date,
            'color' => $cat->color,
            'breed' => $cat->breed->name ?? null,
            'photo' => $cat->photo ? asset('/' . $cat->photo) : null,
            'status' => $cat->status,
            'mother' => $cat->mother->map(fn($item) => [...$item->toArray(), 'photo' => asset('/' . $item->photo)]),
            'father' => $cat->father->map(fn($item) => [...$item->toArray(), 'photo' => asset('/' . $item->photo)]),
        ];

        return response()->json($data);
    }
}
