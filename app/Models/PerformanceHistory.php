<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceHistory extends Model
{
    use HasFactory;
    protected $table = 'performance_histories'; 
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'attempt_number', 
    ];
     // Define relationship with User
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
 
     // Define relationship with Quiz
     public function quiz()
     {
         return $this->belongsTo(Quiz::class, 'quiz_id');
     }
}
