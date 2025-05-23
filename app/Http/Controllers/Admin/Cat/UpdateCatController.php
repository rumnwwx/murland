<?php

namespace App\Http\Controllers\Admin\Cat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Http\Requests\Admin\UpdateCatRequest;
use App\Models\Cat;
use Illuminate\Http\Request;

class UpdateCatController extends Controller
{
    public function __invoke(UpdateCatRequest $request, $id)
    {
        $validated = $request->validated();
        $cat = Cat::findOrFail($id);

        $updateData = array_filter($validated, function($value) {
            return $value !== null;
        });

        $cat->update($updateData);

        return response()->json([
            'message' => 'Кот успешно обновлен',
            'data' => $cat
        ]);
    }
}
