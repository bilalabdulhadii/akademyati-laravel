<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function articleLecture()
    {
        return $this->hasOne(ArticleLecture::class);
    }

    public function videoLecture()
    {
        return $this->hasOne(VideoLecture::class);
    }

    public function lectureProgress()
    {
        return $this->hasOne(LectureProgress::class);
    }

}
