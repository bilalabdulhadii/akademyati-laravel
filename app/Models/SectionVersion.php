<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionVersion extends Model
{
    use HasFactory;

    protected $table = 'section_versions';
    protected $fillable = [
        'course_id',        // Add this line
        'lectures_count',
        'title',
        'description',
        'order',
    ];
}
