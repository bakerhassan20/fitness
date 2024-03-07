<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExercisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       // Exercise::truncate();

         $exercisesData = [
            ['name' => 'Hey, it`s time for lunch'],
            ['name' => 'Do your lowerody workout'],
            ['name' => 'Hey, Did You finish all your meditation for this week'],
            ['name' => 'You have finished all your workouts today'],
            ['name' => 'Hey,it`s time for lunch'],
            ['name' => 'Don`t forget your water intake'],
            ['name' => 'Add some meals for todays intake'],
            ['name' => 'its not about being the best its about your better than you were yesterday'],


        ];


        Exercise::insert($exercisesData);
    }
}
