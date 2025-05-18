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
        $photo = Photo::create([
            'file' => $request->file->store('images', 'public')
        ]);

        $validatedData = $request->validated();

        $cat = Cat::create([
            ...$validatedData,
            'photo_id' => $photo->id,
        ]);

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

        return response()->json(['cat' => $cat])->setStatusCode(200);
    }
}
