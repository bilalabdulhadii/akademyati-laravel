<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /*public function section()
    {
        return $this->belongsTo(Section::class);
    }*/

    /*public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }*/

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
