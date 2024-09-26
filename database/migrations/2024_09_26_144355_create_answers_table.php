<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('option_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_correct');
            $table->integer('attempt_number')->default(1); // Add this line
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
