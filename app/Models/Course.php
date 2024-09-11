<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory;

    /*public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }*/

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function instructorInfo()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function getFullName()
    {
        return $this->instructor ? $this->instructor->user->first_name . ' ' . $this->instructor->user->last_name : 'N/A';
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function lectures()
    {
        return $this->hasManyThrough(Lecture::class, Section::class, 'course_id', 'section_id');
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function versions()
    {
        return $this->hasMany(CourseVersion::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function subsubcategory()
    {
        return $this->belongsTo(Category::class, 'subsubcategory_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(CourseBookmark::class, 'course_id');
    }

    public function isBookmarked()
    {
        return $this->bookmarks()
            ->where('user_id', Auth::id())
            ->exists();
    }

    /*public function bookmarkedByStudents() {
        return $this->belongsToMany(Student::class, 'course_bookmarks', 'course_id', 'student_id')->withTimestamps();
    }*/

}
