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
        $parents = Cat::whereHas('children')
            ->whereDoesntHave('mother')
            ->whereDoesntHave('father')
            ->with(['breed'])
            ->get();

        $data = $parents->map(function ($parent) {
            return [
                'id' => $parent->id,
                'name' => $parent->name,
                'gender' => $parent->gender,
                'birth_date' => $parent->birth_date,
                'color' => $parent->color,
                'breed' => $parent->breed->name ?? null,
                'photo' => $parent->photo ? asset('/' . $parent->photo) : null,
                'status' => $parent->status,
                'children_count' => $parent->children->count()
            ];
        });

        return response()->json([
            'parents' => $data
        ]);
    }
}
