<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'rating',
        'comment',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
