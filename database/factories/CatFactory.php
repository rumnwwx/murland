<?php

namespace Database\Factories;

use App\Models\Cat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cat>
 */
class CatFactory extends Factory
{
    protected $model = Cat::class;

    public function definition(): array
    {
        $genders = ['кот', 'кошка'];
        $colors = ['чёрный', 'белый', 'серый', 'рыжий', 'пятнистый'];
        $namesMale = ['Барсик', 'Мурзик', 'Василий', 'Кисяня', 'Леопольд'];
        $namesFemale = ['Муня', 'Соня', 'Матрёшка', 'Киса', 'Белка'];

        $gender = $this->faker->randomElement($genders);
        $name = $gender === 'кот'
            ? $this->faker->randomElement($namesMale)
            : $this->faker->randomElement($namesFemale);

        $imageFiles = glob(public_path('images') . '/*.*');
        $photo = $imageFiles ? basename($this->faker->randomElement($imageFiles)) : null;

        return [
            'name' => $name,
            'gender' => $gender,
            'birth_date' => $this->faker->date('Y-m-d', $this->faker->dateTimeBetween('-10 years', '-2 months')),
            'color' => $this->faker->randomElement($colors),
            'breed_id' => $this->faker->numberBetween(1, 2),
            'status' => 'доступен',
            'photo' => $photo ? 'images/' . $photo : null,
        ];
    }
}
