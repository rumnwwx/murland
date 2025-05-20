<?php

namespace App\Http\Controllers\Admin\Cat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Photo;
use Illuminate\Http\Request;

class GetCatsController extends Controller
{
    public function __invoke()
    {
        $cats = Cat::with('breed')
        ->get()
            ->sortBy(function ($cat) {
                $statuses = [
                    'доступен' => 0,
                    'забронирован' => 1,
                    'усыновлен' => 2
                ];

                return $statuses[$cat->status];
            })
            ->sortBy('name')
            ->values()
            ->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'breed' => $cat->breed->name ?? null,
                    'photo' => $cat->photo ? asset('/' . $cat->photo) : null,
                ];
            });

        return response()->json($cats);
    }
}
