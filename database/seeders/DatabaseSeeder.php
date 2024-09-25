<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $topic = Topic::create(['name' => 'Science']);
        $quiz = Quiz::create(['title' => 'Basic Physics', 'description' => 'Test your knowledge of physics.','quize_type'=>'multiple_attempts','time_limit' => 15, 'topic_id' => $topic->id, 'created_by' => 1]);

        $question1 = Question::create(['quiz_id' => $quiz->id, 'question_text' => 'What is the speed of light?', 'question_type' => 'multiple_choice']);
        Option::create(['question_id' => $question1->id, 'option_text' => '300,000 km/s', 'is_correct' => true]);
        Option::create(['question_id' => $question1->id, 'option_text' => '150,000 km/s', 'is_correct' => false]);

// Repeat this for more questions and options.

    }
}
