<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Breed;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Photo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
             'login' => 'munr',
             'password' => Hash::make('QWEasd123!'),
         ]);

         Breed::create([
             'name' => 'Бурма'
         ]);
         Breed::create([
             'name' => 'Абиссинская'
         ]);

        $imageDirectory = public_path('images');

        $files = File::files($imageDirectory);

        foreach ($files as $file) {
            Photo::create([
                'file' => 'images/' . $file->getFilename(),
            ]);
        }

        Cat::factory()->count(20)->create();
    }
}
