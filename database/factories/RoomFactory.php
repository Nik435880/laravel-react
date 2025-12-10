<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
   
    
    protected $model = Room::class;
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
        ];
    }
}
