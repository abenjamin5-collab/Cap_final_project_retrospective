<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLesson extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function coach() {
        return $this->belongsTo(User::class, 'coach_id');
     }
     
     public function student() {
        return $this->belongsTo(User::class, 'student_id');
     }
}
