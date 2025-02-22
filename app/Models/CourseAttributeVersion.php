<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttributeVersion extends Model
{
    protected $fillable = [
        'course_id',
        'type',
        'content',
        'order',
    ];

    use HasFactory;
}
