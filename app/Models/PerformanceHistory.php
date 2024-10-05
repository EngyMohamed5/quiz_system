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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Adjust if your foreign key is named differently
    }

}
