<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'topic_id',
        'created_by',
        "image",
        "quiz_type"
    ];


    public function topic()
    {
        return $this->belongsTo(Topic::class,"topic_id","id");
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by',"id");
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'performance_histories');
    }
    public function performances()
    {
        return $this->hasMany(PerformanceHistory::class,"quiz_id","id");
    }

}
