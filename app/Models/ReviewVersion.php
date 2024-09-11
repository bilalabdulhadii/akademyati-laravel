<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewVersion extends Model
{
    use HasFactory;

    public function courseVersion()
    {
        return $this->belongsTo(CourseVersion::class, 'course_id');
    }
}
