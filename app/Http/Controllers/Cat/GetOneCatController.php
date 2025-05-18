<?php

namespace App\Http\Controllers\Cat;

use App\Http\Controllers\Controller;
use App\Models\Cat;

class GetOneCatController extends Controller
{
    public function __invoke($id)
    {
        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json([
                'message' => 'Пост не найден',
            ], 404);
        }

        return response()->json($cat)->setStatusCode(200);
    }
}
