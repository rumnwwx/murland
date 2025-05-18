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

        $cats = Cat::all()->sortBy(function ($cat) {
            $statuses = [
                'доступен' => 0,
                'забронирован' => 1,
                'усыновлен' => 2
            ];

            return $statuses[$cat->status];
        });


        return response()->json($cats)->setStatusCode(200);
    }
}
