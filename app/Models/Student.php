<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courseRate()
    {
        return $this->hasOne(CourseRating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
