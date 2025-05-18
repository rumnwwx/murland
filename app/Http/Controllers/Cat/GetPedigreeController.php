<?php

namespace App\Http\Controllers\Cat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Order;
use App\Models\OrderCat;
use App\Models\Photo;
use Illuminate\Http\Request;

class GetPedigreeController extends Controller
{
    public function __invoke(Request $request)
    {
        // Получаем всех котов, которые являются родителями (имеют детей)
        $parents = Cat::whereHas('children')
            // И при этом не являются чьими-то детьми (не имеют родителей)
            ->whereDoesntHave('mother')
            ->whereDoesntHave('father')
            ->with(['breed', 'photo'])
            ->get();

        // Форматируем результат
        $data = $parents->map(function ($parent) {
            return [
                'id' => $parent->id,
                'name' => $parent->name,
                'gender' => $parent->gender,
                'birth_date' => $parent->birth_date,
                'color' => $parent->color,
                'breed' => $parent->breed->name ?? null,
                'photo_id' => $parent->photo->file ?? null,
                'status' => $parent->status,
                'children_count' => $parent->children->count()
            ];
        });

        return response()->json([
            'parents' => $data,
            'count' => $parents->count()
        ]);
    }
}
