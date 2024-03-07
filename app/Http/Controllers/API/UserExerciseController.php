<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseResource;
use App\Http\Controllers\API\AppBaseController;

class UserExerciseController extends AppBaseController
{

     public function getAll(){

        $exercises = Exercise::all();

        return $this->json_custom_response([
            "exercises" => ExerciseResource::collection($exercises),
        ]);

     }


         public function store(Request $request)
        {
            $request->validate([
                'exercise_ids' => 'required|array',
                'exercise_ids.*' => 'exists:exercises,id',
            ]);

            $user = auth()->user();
            $date = now()->toDateString();

            $user->exercises()->detach();

            $user->exercises()->syncWithoutDetaching(
                collect($request->input('exercise_ids'))->mapWithKeys(function ($id) use ($date) {
                    return [$id => ['date' => $date]];
                })->toArray()
            );

           // return response()->json(['message' => 'Exercises added successfully']);
           $userExercises = $user->exercises;

            return response()->json(['exercises' => ExerciseResource::collection($userExercises)]);
        }

        public function index()
        {
            $user = auth()->user();
            $today = Carbon::now()->toDateString();

            $userExercisesToday = $user->exercises()
                ->whereDate('date', $today)
                ->get();
            return response()->json(['userExercisesToday' => ExerciseResource::collection($userExercisesToday)]);
        }
}
