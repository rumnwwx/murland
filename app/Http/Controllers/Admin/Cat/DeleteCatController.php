<?php

namespace App\Http\Controllers\Admin\Cat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Photo;
use Illuminate\Http\Request;

class DeleteCatController extends Controller
{
    public function __invoke($id)
    {
        $cat = Cat::findOrFail($id);
        $cat->delete($id);

        return response()->json(['message' => 'Кот успешно удален'])->setStatusCode(200);
    }
}
