<?php

namespace App\Http\Controllers\Admin\Cat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Cat;
use App\Models\Pedigree;
use App\Models\Photo;
use Illuminate\Http\Request;

class CreateCatController extends Controller
{
    public function __invoke(CreateCatRequest $request)
    {
        $validatedData = $request->validated();

        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'доступен';
        }

        if (!empty($validatedData['mother_id'])) {
            $mother = Cat::find($validatedData['mother_id']);

            if (!$mother || $mother->gender !== 'кошка') {
                return response()->json(['message' => 'mother_id должен ссылаться на кошку.'], 422);
            }

            if ($mother->birth_date > $validatedData['birth_date']) {
                return response()->json(['message' => 'Мать не может быть моложе котенка.'], 422);
            }
        }

        if (!empty($validatedData['father_id'])) {
            $father = Cat::find($validatedData['father_id']);

            if (!$father || $father->gender !== 'кот') {
                return response()->json(['message' => 'father_id должен ссылаться на кота.'], 422);
            }

            if ($father->birth_date > $validatedData['birth_date']) {
                return response()->json(['message' => 'Отец не может быть моложе котенка.'], 422);
            }
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('cats', 'public');
            $validatedData['photo'] = 'storage/'.$photoPath;

        }

        $cat = Cat::create([...$validatedData]);

        if (!empty($validatedData['mother_id'])) {
            Pedigree::create([
                'parent_id' => $validatedData['mother_id'],
                'cat_id' => $cat->id,
                'relation_type' => 'mother',
            ]);
        }

        if (!empty($validatedData['father_id'])) {
            Pedigree::create([
                'parent_id' => $validatedData['father_id'],
                'cat_id' => $cat->id,
                'relation_type' => 'father',
            ]);
        }

        $cat->load(['breed']);

        $response = [
            'cat' => [
                'id' => $cat->id,
                'name' => $cat->name,
                'gender' => $cat->gender,
                'birth_date' => $cat->birth_date,
                'color' => $cat->color,
                'breed' => $cat->breed->name ?? null,
                'status' => $cat->status,
                'photo' => $cat->photo ? asset('/' . $cat->photo) : null,
                'created_at' => $cat->created_at,
                'updated_at' => $cat->updated_at,
            ],
            'message' => 'Кот успешно создан'
        ];

        return response()->json($response, 201);
    }
}
