<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ArticleLecture;
use App\Models\ArticleLectureVersion;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseAttribute;
use App\Models\CourseAttributeVersion;
use App\Models\CourseVersion;
use App\Models\Instructor;
use App\Models\Lecture;
use App\Models\LectureVersion;
use App\Models\ReviewVersion;
use App\Models\Section;
use App\Models\SectionVersion;
use App\Models\VideoLecture;
use App\Models\VideoLectureVersion;
use Google\Service\Exception;
use Google\Service\YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google\Client;
use Illuminate\Support\Facades\Storage;

class CourseManageController extends Controller
{
    public function index(Request $request)
    {
        $courseVersions = CourseVersion::query();
        $coursesQuery = Course::query();

        $filter = $request->query('filter');
        if ($filter) {
            switch ($filter) {
                case 'draft':
                    $courseVersions->where('status', 'draft')
                        ->where('version_number', 1);
                    $coursesQuery->whereHas('versions', function ($query) {
                        $query->where('status', 'draft');
                    });
                    break;
                case 'underreview':
                    $courseVersions->where('status', 'pending')
                        ->where('version_number', 1);
                    $coursesQuery->whereHas('versions', function ($query) {
                        $query->where('status', 'pending');
                    });
                    break;
                case 'accepted':
                    $courseVersions->where('status', 'accepted')
                        ->where('version_number', 1);
                    $coursesQuery->whereHas('versions', function ($query) {
                        $query->where('status', 'accepted');
                    });
                    break;
                case 'rejected':
                    $courseVersions->where('status', 'rejected')
                        ->where('version_number', 1);
                    $coursesQuery->whereHas('versions', function ($query) {
                        $query->where('status', 'rejected');
                    });
                    break;
                case 'published':
                    $courseVersions->whereRaw('1 = 0');
                    /*$courseVersions->where('status', 'active')
                        ->where('version_number', 1);*/
                    $coursesQuery->where('status', 'published');
                    break;
                case 'unpublished':
                    $courseVersions->where('status', '<>', 'active')
                        ->where('version_number', 1);
                    $coursesQuery->where('status', 'unpublished');
                    break;
                case 'newest':
                    $courseVersions->orderBy('created_at', 'desc')
                        ->where('version_number', 1);
                    $coursesQuery->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $courseVersions->orderBy('created_at', 'asc')
                        ->where('version_number', 1);
                    $coursesQuery->orderBy('created_at', 'asc');
                    break;
            }
        }

        $courses = $coursesQuery->orderBy('updated_at', 'desc')->get();
        $drafts = [];
        $reviews = [];
        foreach ($courses as $course) {
            if ($course->has_draft) {
                $draft = CourseVersion::where('course_id', $course->id)
                    ->where('version_number', $course->version_number + 1)->first();
                $drafts[$course->id] = [
                    'draft' => $draft,
                ];

                $reviewCount = ReviewVersion::where('course_id', $draft->id)
                    ->whereNot('status', 'cancelled')
                    ->count();
                $is_there = false;
                if ($reviewCount > 0 && ($draft->status === 'draft'
                        || $draft->status === 'pending'
                        || $draft->status === 'rejected')) {
                    $is_there = true;
                }
                $reviews[$draft->id] = [
                    'is_there' => $is_there,
                ];

            } else {
                $drafts[$course->id] = [
                    'draft' => "",
                ];
            }
        }

        $courseVersions = $courseVersions->where('version_number', 1)
            ->where('status', '!=', 'active')
            ->where('status', '!=', 'old')
            ->orderBy('updated_at', 'desc')
            ->get();


        foreach ($courseVersions as $courseVersion) {
            $reviewCount = ReviewVersion::where('course_id', $courseVersion->id)
                ->whereNot('status', 'cancelled')
                ->count();
            $is_there = false;
            if ($reviewCount > 0 && ($courseVersion->status === 'draft'
                    || $courseVersion->status === 'pending'
                    || $courseVersion->status === 'rejected')) {
                $is_there = true;
            }
            $reviews[$courseVersion->id] = [
                'is_there' => $is_there,
            ];
        }

        return view('instructor.overview', [
            'courseVersions' => $courseVersions,
            'courses' => $courses,
            'drafts' => $drafts,
            'reviews' => $reviews,
        ]);
    }

    public function course_history($id)
    {
        $course = Course::find($id);
        if ($course) {
            $versions = CourseVersion::where('course_id', $id)
                ->orderBy('version_number', 'desc')
                ->get();
            return view('instructor.courses.history', [
                'versions' => $versions,
                'course' => $course,
            ]);
        }
        return redirect()->route('ins.courses');
    }

    public function create_basic(Request $request)
    {
        $title = '';
        $category_id = '';
        $categories = Category::all();
        return view('instructor.courses.create-basic', [
            'title' => $title,
            'category_id' => $category_id,
            'categories' => $categories,
        ]);
    }

    public function create_complete(Request $request)
    {
        $request->validate([
            'course_title' => 'required|string'
        ]);
        $request->session()->put('course_title_cat', $request->all());
        return view('instructor.courses.create-complete');
    }

    public function create_back(Request $request)
    {
        $data = $request->session()->get('course_title_cat');
        $title =  $data['course_title'];
        $category_id = $data['course_category'];
        $categories = Category::all();
        return view('instructor.courses.create-basic', [
            'title' => $title,
            'category_id' => $category_id,
            'categories' => $categories,

        ]);
    }

    public function create(Request $request)
    {
        $instructor = Instructor::where('user_id', Auth::id())->first();
        $data = $request->session()->get('course_title_cat');
        $course = new CourseVersion();
        $course->version_number = 1;
        $course->instructor_id = $instructor->id;
        $course->title = $data['course_title'];
        $course->category_id = $data['course_category'];
        $course->save();
        $courseId = $course->id;

        $request->session()->forget('course_title_cat');
        return redirect()->route('courses.edit.version', ['id' => $courseId]);
    }

    public function edit_draft($id)
    {
        $course = CourseVersion::find($id);
        if (!$course) {
            return redirect()->route('ins.courses');
        }

        if ($course->status !== 'draft') {
            return redirect()->route('ins.courses');
        }

        // Fetch course attributes and categories
        $attributes = CourseAttributeVersion::where('course_id', $id)->get();
        $categories = Category::all();

        // Fetch sections
        $sections = SectionVersion::where('course_id', $id)
            ->orderBy('order')
            ->get();

        // Initialize arrays for lectures
        $articleLectures = [];
        $videoLectures = [];
        $lectures = [];

        // Iterate through sections and fetch lectures
        foreach ($sections as $section) {
            // Fetch all lectures for the current section
            $sectionLectures = LectureVersion::where('section_id', $section->id)
                ->orderBy('order')
                ->get();

            $lectures[$section->id] = $sectionLectures; // Store lectures in the array

            foreach ($sectionLectures as $lecture) {
                // Handle article lectures
                if ($lecture->type === 'article') {
                    $articleLecture = ArticleLectureVersion::where('lecture_id', $lecture->id)->first();
                    if ($articleLecture) {
                        $articleLectures[$lecture->id] = [
                            'title' => $articleLecture->title,
                            'content' => $articleLecture->content,
                            'order' => $articleLecture->order,
                            'section_order' => $articleLecture->section_order,
                        ];
                    }
                }
                // Handle video lectures
                elseif ($lecture->type === 'video') {
                    $videoLecture = VideoLectureVersion::where('lecture_id', $lecture->id)->first();
                    if ($videoLecture) {
                        $videoLectures[$lecture->id] = [
                            'title' => $videoLecture->title,
                            'url' => $videoLecture->video_url,
                            'description' => $videoLecture->description,
                            'order' => $videoLecture->order,
                            'section_order' => $videoLecture->section_order,
                        ];
                    }
                }
            }
        }


        $formatedDurationsLectures = [];
        $formatedDurationsSections = [];
        foreach ($sections as $section) {
            $formatedDurationsSections[$section->id] = $this->formatDuration($section->duration);
            foreach ($lectures[$section->id] as $lecture) {
                if ($lecture->duration > 0) {
                    $formatedDurationsLectures[$lecture->id] = $this->formatDuration($lecture->duration);
                }
            }
        }

        return view('instructor.courses.edit', [
            'course' => $course,
            'attributes' => $attributes,
            'sections' => $sections,
            'lectures' => $lectures,
            'articleLectures' => $articleLectures,
            'videoLectures' => $videoLectures,
            'categories' => $categories,
            'formatedDurations' => $formatedDurationsLectures,
        ]);
    }
    public function edit_draft_new($id)
    {
        $course = CourseVersion::find($id);
        if (!$course) {
            return redirect()->route('ins.courses');
        }

        if ($course->status !== 'draft') {
            return redirect()->route('ins.courses');
        }

        // Fetch course attributes and categories
        $attributes = CourseAttributeVersion::where('course_id', $id)->get();
        $categories = Category::all();

        // Fetch sections
        $sections = SectionVersion::where('course_id', $id)
            ->orderBy('order')
            ->get();

        // Initialize arrays for lectures
        $articleLectures = [];
        $videoLectures = [];
        $lectures = [];

        // Iterate through sections and fetch lectures
        foreach ($sections as $section) {
            // Fetch all lectures for the current section
            $sectionLectures = LectureVersion::where('section_id', $section->id)
                ->orderBy('order')
                ->get();

            $lectures[$section->id] = $sectionLectures; // Store lectures in the array

            foreach ($sectionLectures as $lecture) {
                // Handle article lectures
                if ($lecture->type === 'article') {
                    $articleLecture = ArticleLectureVersion::where('lecture_id', $lecture->id)->first();
                    if ($articleLecture) {
                        $articleLectures[$lecture->id] = [
                            'title' => $articleLecture->title,
                            'content' => $articleLecture->content,
                            'order' => $articleLecture->order,
                            'section_order' => $articleLecture->section_order,
                        ];
                    }
                }
                // Handle video lectures
                elseif ($lecture->type === 'video') {
                    $videoLecture = VideoLectureVersion::where('lecture_id', $lecture->id)->first();
                    if ($videoLecture) {
                        $videoLectures[$lecture->id] = [
                            'title' => $videoLecture->title,
                            'url' => $videoLecture->video_url,
                            'description' => $videoLecture->description,
                            'order' => $videoLecture->order,
                            'section_order' => $videoLecture->section_order,
                        ];
                    }
                }
            }
        }


        $formatedDurationsLectures = [];
        $formatedDurationsSections = [];
        foreach ($sections as $section) {
            $formatedDurationsSections[$section->id] = $this->formatDuration($section->duration);
            foreach ($lectures[$section->id] as $lecture) {
                if ($lecture->duration > 0) {
                    $formatedDurationsLectures[$lecture->id] = $this->formatDuration($lecture->duration);
                }
            }
        }

        return view('instructor.courses.edit_version', [
            'course' => $course,
            'attributes' => $attributes,
            'sections' => $sections,
            'lectures' => $lectures,
            'articleLectures' => $articleLectures,
            'videoLectures' => $videoLectures,
            'categories' => $categories,
            'formatedDurations' => $formatedDurationsLectures,
        ]);
    }

    function formatDuration($seconds)
    {
        // Calculate hours, minutes, and seconds
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Format the string
        $formattedDuration = '';

        if ($hours > 0) {
            $formattedDuration .= str_pad($hours, 2, '0', STR_PAD_LEFT) . ':';
        }
        $formattedDuration .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);

        return $formattedDuration;
    }

    public function reedit_draft($id)
    {
        $course = CourseVersion::find($id);
        if ($course->status === 'rejected') {
            $course->status = 'draft';
            $course->save();
            return redirect()->route('courses.edit.version', [
                'id' => $course->id,
            ]);
        }
        return redirect()->route('ins.courses');
    }

    public function save_draft(Request $request)
    {
        // Get all form data
        $data = $request->all();
        $courseId = $data['course_id'];

        $course = CourseVersion::find($courseId);
        $course->title = $data['course_title'];
        $course->subtitle = $data['course_subtitle'];
        $course->description = $data['course_description'];
        $course->level = $data['course_level'];
        $course->language = $data['course_language'];
        $course->price = $data['course_price'];
        $course->category_id = $data['course_category'];
        $course->subcategory_id = $data['course_subcategory'];
        $course->subsubcategory_id = $data['course_subsubcategory'];
        $course->save();

        if ($request->hasFile('course_thumbnail')) {
            $file = $request->file('course_thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = 'thumbnail_' . time() . '.' . $extension;
            $filePath = $file->storeAs('versions/'.$courseId.'/thumbnails', $filename, 'public');
            $course->thumbnail = $filePath;
            $course->save();
        }

        if ($request->hasFile('course_promotional_video')) {
            $file = $request->file('course_promotional_video');
            $extension = $file->getClientOriginalExtension();
            $filename = 'promotional_video_' . time() . '.' . $extension;
            $filePath = $file->storeAs('versions/'.$courseId.'/promotional_videos', $filename, 'public');
            $course->promotional_video = $filePath;
            $course->save();
        }
        $course->save();

        $this->saveBasicsDraft($data);
        $this->saveCurriculumDraft($data, $courseId);

        return redirect()->route('ins.courses');
    }

    public function saveBasicsDraft($data)
    {
        $courseId = $data['course_id'];

        // Handle the Objectives
        CourseAttributeVersion::where('course_id', $courseId)
            ->where('type', 'objective')
            ->delete();
        $objectives = [];
        foreach ($data as $key => $value) {
            if (preg_match('/^course_objective_(\d+)$/', $key, $matches)) {
                $objectiveNumber = $matches[1];
                $objectives[$objectiveNumber] = $value;
            }
        }
        foreach ($objectives as $order => $content) {
            if (!empty($content)) {
                $courseAttribute = new CourseAttributeVersion();
                $courseAttribute->course_id = $courseId;
                $courseAttribute->type = 'objective';
                $courseAttribute->content = $content;
                $courseAttribute->order = $order;
                $courseAttribute->save();
            }
        }

        // Handle the Prerequisites
        CourseAttributeVersion::where('course_id', $courseId)
            ->where('type', 'prerequisite')
            ->delete();
        $prerequisites = [];
        foreach ($data as $key => $value) {
            if (preg_match('/^course_prerequisite_(\d+)$/', $key, $matches)) {
                $prerequisiteNumber = $matches[1];
                $prerequisites[$prerequisiteNumber] = $value;
            }
        }
        foreach ($prerequisites as $order => $content) {
            if (!empty($content)) {
                $courseAttribute = new CourseAttributeVersion();
                $courseAttribute->course_id = $courseId;
                $courseAttribute->type = 'prerequisite';
                $courseAttribute->content = $content;
                $courseAttribute->order = $order;
                $courseAttribute->save();
            }
        }

        // Add or Update the Benefit
        if (!empty($data['course_benefit'])) {
            // Use updateOrCreate to either update an existing record or create a new one
            CourseAttributeVersion::updateOrCreate(
                [
                    'course_id' => $courseId,
                    'type' => 'benefit',
                ],
                [
                    'content' => $data['course_benefit'],
                ]
            );
        }

        // Add or Update the Welcome Message
        if (!empty($data['welcome_message'])) {
            CourseAttributeVersion::updateOrCreate(
                [
                    'course_id' => $courseId,
                    'type' => 'welcome_message',
                ],
                [
                    'content' => $data['welcome_message'],
                ]
            );
        }

        if (!empty($data['congratulations_message'])) {
            CourseAttributeVersion::updateOrCreate(
                [
                    'course_id' => $courseId,
                    'type' => 'congratulations_message',
                ],
                [
                    'content' => $data['congratulations_message'],
                ]
            );
        }
    }

    public function saveCurriculumDraft($data, $courseId)
    {
        $sections = [];
        $existingSections = SectionVersion::where('course_id', $courseId)->get();

        // Extract and organize data
        foreach ($data as $key => $value) {
            if (strpos($key, 'section_title_') === 0) {
                $sectionNumber = str_replace('section_title_', '', $key);
                if (!isset($sections[$sectionNumber])) {
                    $sections[$sectionNumber] = [
                        'section_number' => $sectionNumber,
                        'lectures_count' => 0,
                        'title' => $value,
                        'description' => $data['section_description_' . $sectionNumber] ?? '',
                        'articleLectures' => [],
                        'videoLectures' => [],
                        'resourceLectures' => [],
                        'materialLectures' => [],
                        'surveyLectures' => [],
                        'assignmentLectures' => [],
                        'quizLectures' => [],
                    ];
                }
            }

            if (strpos($key, 'section_') === 0 && strpos($key, '_lecture_') !== false) {
                preg_match('/section_(\d+)_lecture_(\d+)_(\w+)/', $key, $matches);
                if (count($matches) === 4) {
                    list(, $sectionNumber, $lectureNumber, $type) = $matches;
                    if (!isset($sections[$sectionNumber][$type . 'Lectures'][$lectureNumber])) {
                        $sections[$sectionNumber][$type . 'Lectures'][$lectureNumber] = [
                            'section_number' => $sectionNumber,
                            'lecture_number' => $lectureNumber,
                            'title' => $data['section_' . $sectionNumber . '_lecture_' . $lectureNumber . '_title'] ?? '',
                            'type' => $type,
                        ];
                    }

                    switch ($type) {
                        case 'article':
                            $sections[$sectionNumber][$type . 'Lectures'][$lectureNumber]['content'] = $data['section_' . $sectionNumber . '_lecture_' . $lectureNumber . '_content'] ?? '';
                            break;
                        case 'video':
                            $sections[$sectionNumber][$type . 'Lectures'][$lectureNumber]['url'] = $data['section_' . $sectionNumber . '_lecture_' . $lectureNumber . '_url'] ?? '';
                            $sections[$sectionNumber][$type . 'Lectures'][$lectureNumber]['description'] = $data['section_' . $sectionNumber . '_lecture_' . $lectureNumber . '_description'] ?? '';
                            break;
                    }

                    $sections[$sectionNumber]['lectures_count'] = max(
                        $sections[$sectionNumber]['lectures_count'],
                        $lectureNumber
                    );
                }
            }
        }

        $existingSectionIds = $existingSections->pluck('id')->toArray();
        $newSectionIds = [];

        foreach ($sections as $section) {
            $sectionRecord = SectionVersion::updateOrCreate(
                ['course_id' => $courseId, 'order' => $section['section_number']],
                [
                    'lectures_count' => $section['lectures_count'],
                    'title' => $section['title'],
                    'description' => $section['description'],
                    'order' => $section['section_number'],
                ]
            );
            $sectionId = $sectionRecord->id;
            $newSectionIds[] = $sectionId;

            // Save lectures for the section
            $this->saveLectures($sectionId, $section);

            /*$totalDuration = LectureVersion::where('section_id', $sectionId)->sum('duration');
            $sectionRecord->update(['duration' => $totalDuration]);*/
        }

        $sectionsToDelete = array_diff($existingSectionIds, $newSectionIds);
        if (!empty($sectionsToDelete)) {
            // Delete lectures for these sections first
            LectureVersion::whereIn('section_id', $sectionsToDelete)->delete();
            // Then delete the sections
            SectionVersion::whereIn('id', $sectionsToDelete)->delete();
        }

        $course = CourseVersion::find($courseId);
        $newSections = SectionVersion::where('course_id', $courseId)->get();
        $counter = 0;
        $course->lectures_count = 0;
        $course->duration = 0;
        $course->save();
        foreach ($newSections as $newSection) {
            $newSection->duration = LectureVersion::where('section_id', $newSection->id)->sum('duration');
            $newSection->save();

            $counter++;
            $course->lectures_count += $newSection->lectures_count;
            $course->duration += $newSection->duration;
            $course->save();
        }
        $course->sections_count = $counter;
        $course->save();
    }

    protected function saveLectures($sectionId, $section)
    {
        // Delete old lectures for the section before saving new ones
        LectureVersion::where('section_id', $sectionId)->delete();

        // Save article lectures
        foreach ($section['articleLectures'] as $lectureNumber => $lecture) {
            $mainLecture = new LectureVersion();
            $mainLecture->section_id = $sectionId;
            $mainLecture->title = $lecture['title'];
            $mainLecture->type = $lecture['type'];
            $mainLecture->section_order = $section['section_number'];
            $mainLecture->order = $lectureNumber;
            $mainLecture->save();
            $mainLectureId = $mainLecture->id;

            $articleLecture = new ArticleLectureVersion();
            $articleLecture->lecture_id = $mainLectureId;
            $articleLecture->section_order = $section['section_number'];
            $articleLecture->order = $lectureNumber;
            $articleLecture->title = $lecture['title'];
            $articleLecture->content = $lecture['content'];
            $articleLecture->save();

            if ($articleLecture->content) {
                $duration = $this->getArticleLectureDuration($articleLecture->content);
                if ($duration) {
                    $articleLecture->duration = $duration;
                    $articleLecture->save();

                    $mainLecture->duration = $duration;
                    $mainLecture->save();
                }
            }
        }

        // Save video lectures
        foreach ($section['videoLectures'] as $lectureNumber => $lecture) {
            $mainLecture = new LectureVersion();
            $mainLecture->section_id = $sectionId;
            $mainLecture->title = $lecture['title'];
            $mainLecture->type = $lecture['type'];
            $mainLecture->section_order = $section['section_number'];
            $mainLecture->order = $lectureNumber;
            $mainLecture->save();
            $mainLectureId = $mainLecture->id;

            $videoLecture = new VideoLectureVersion();
            $videoLecture->lecture_id = $mainLectureId;
            $videoLecture->section_order = $section['section_number'];
            $videoLecture->order = $lectureNumber;
            $videoLecture->title = $lecture['title'];
            $videoLecture->video_url = $lecture['url'];
            $videoLecture->description = $lecture['description'];
            $videoLecture->save();

            if ($videoLecture->video_url) {
                $videoId = $this->getYouTubeVideoID($videoLecture->video_url);
                $duration = $this->getYouTubeVideoDuration($videoId);
                if ($duration) {
                    $videoLecture->duration = $duration;
                    $videoLecture->save();

                    $mainLecture->duration = $duration;
                    $mainLecture->save();
                }
            }
        }
    }

    public function getArticleLectureDuration($content)
    {
        $textContent = strip_tags($content);
        $wordCount = str_word_count($textContent);
        $readingSpeed = 250; // Average words per minute
        $estimatedMinutes = $wordCount / $readingSpeed;
        return $estimatedMinutes * 60;
    }

    public function getYouTubeVideoID($url) {
        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]+)(?:\?|$)/',
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)(?:&|$)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)(?:\?|$)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return false;
    }

    public function getYouTubeVideoDuration($videoId) {
        $apiKey = env('YOUTUBE_API_KEY'); // Ensure your API key is correctly set in your .env file
        $client = new Client();
        $client->setDeveloperKey($apiKey);
        $service = new YouTube($client);

        try {
            $response = $service->videos->listVideos('contentDetails', ['id' => $videoId]);
            $items = $response->getItems();

            if (!empty($items)) {
                $duration = $items[0]->getContentDetails()->getDuration();
                return $this->convertISO8601Duration($duration);
            } else {
                return null; // Handle cases where no video is found
            }
        } catch (\Exception $e) {
            // Log or handle the error appropriately
            return null;
        }
    }

    public function convertISO8601Duration($duration) {
        // Example duration: PT10M1S
        $interval = new \DateInterval($duration);
        $seconds = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
        return $seconds;
    }

    public function check_draft(Request $request)
    {
        $data = $request->all();
        $courseId = $data['course_id'];

        $course = CourseVersion::find($courseId);
        $course->title = $data['course_title'];
        $course->subtitle = $data['course_subtitle'];
        $course->description = $data['course_description'];
        $course->level = $data['course_level'];
        $course->language = $data['course_language'];
        $course->price = $data['course_price'];
        $course->category_id = $data['course_category'];
        $course->subcategory_id = $data['course_subcategory'];
        $course->subsubcategory_id = $data['course_subsubcategory'];

        if ($request->hasFile('course_thumbnail')) {
            $file = $request->file('course_thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = 'thumbnail_' . time() . '.' . $extension;
            $filePath = $file->storeAs('versions/'.$courseId.'/thumbnails', $filename, 'public');
            $course->thumbnail = $filePath;
            $course->save();
        }

        if ($request->hasFile('course_promotional_video')) {
            $file = $request->file('course_promotional_video');
            $extension = $file->getClientOriginalExtension();
            $filename = 'promotional_video_' . time() . '.' . $extension;
            $filePath = $file->storeAs('versions/'.$courseId.'/promotional_videos', $filename, 'public');
            $course->promotional_video = $filePath;
            $course->save();
        }
        $course->save();

        $this->saveBasicsDraft($data);
        $this->saveCurriculumDraft($data, $courseId);


        // 1. Check if required fields are filled in course_versions
        $course = CourseVersion::find($courseId);
        if (!$course || !$course->language) {
            return view('instructor.courses.requirement', [
                'course_id' => $courseId,
            ]);
        }

        // 2. Check if there are at least three sections
        $sections = SectionVersion::where('course_id', $courseId)->get();
        if ($sections->count() < 1) {
            return view('instructor.courses.requirement', [
                'course_id' => $courseId,
            ]);
        }

        // 3. Check if there are at least ten lectures
        $totalLectures = $sections->sum('lectures_count');
        if ($totalLectures < 1) {
            return view('instructor.courses.requirement', [
                'course_id' => $courseId,
            ]);
        }

        // 4. Show confirmation view
        return view('instructor.courses.confirm', [
            'course_id' => $courseId,
        ]);
    }

    public function check_draft_2(Request $request)
    {
        $courseId = $request->course_id;

        // 1. Check if required fields are filled in course_versions
        $course = CourseVersion::find($courseId);
        if (!$course || !$course->language) {
            return view('instructor.courses.requirement', [
                'course_id' => $courseId,
            ]);
        }

        // 2. Check if there are at least three sections
        $sections = SectionVersion::where('course_id', $courseId)->get();
        if ($sections->count() < 1) {
            return view('instructor.courses.requirement', [
                'course_id' => $courseId,
            ]);
        }

        // 3. Check if there are at least ten lectures
        $totalLectures = $sections->sum('lectures_count');
        if ($totalLectures < 1) {
            return view('instructor.courses.requirement', [
                'course_id' => $courseId,
            ]);
        }

        // 4. Show confirmation view
        return view('instructor.courses.confirm', [
            'course_id' => $courseId,
        ]);
    }

    public function track_review($id)
    {
        $course = CourseVersion::find($id);
        if ($course && ($course->status === 'draft' || $course->status === 'pending' || $course->status === 'rejected')) {
            $reviews = ReviewVersion::where('course_id', $course->id)
                ->orderBy('order', 'desc')
                ->get();

            if ($reviews->count() > 0) {
                $last = ReviewVersion::where('course_id', $course->id)
                    ->orderBy('order', 'desc')
                    ->first();
                $last_review = false;
                if ($last->status === 'pending' || $last->status === 'started') {
                    $last_review = true;
                }
                return view('instructor.courses.track-review', [
                    'course' => $course,
                    'reviews' => $reviews,
                    'last_review' => $last_review,
                ]);
            }
        }
        return redirect()->route('ins.courses');
    }

    public function confirm_draft(Request $request)
    {
        $courseId = $request->input('course_id');

        // Update course status
        $course = CourseVersion::find($courseId);
        if ($course) {
            $course->status = 'pending';
            $course->save();

            $lastFeedback = ReviewVersion::where('course_id', $course->id)
                ->orderBy('order', 'desc')
                ->first();

            $newOrder = $lastFeedback ? $lastFeedback->order + 1 : 1;

            $reviewVersion = new ReviewVersion();
            $reviewVersion->course_id = $courseId;
            $reviewVersion->order = $newOrder;
            $reviewVersion->save();

        }

        return redirect()->route('ins.courses');
    }

    public function cancel_review($id)
    {
        $course = CourseVersion::find($id);
        if ($course) {
            $course->status = 'draft';
            $course->save();

            $reviewVersion = ReviewVersion::where('course_id', $course->id)
                ->orderBy('order', 'desc')
                ->first();

            if ($reviewVersion && ($reviewVersion->status === 'pending' || $reviewVersion->status === 'started')) {
                $reviewVersion->status = 'cancelled';
                $reviewVersion->save();
            }
        }


        return redirect()->route('ins.courses');
    }

    public function view_draft_content($id)
    {
        $course = CourseVersion::find($id);

        if ($course->status === 'pending' || $course->status === 'accepted' || $course->status === 'active') {
            // Fetch course attributes and categories
            $attributes = CourseAttributeVersion::where('course_id', $id)->get();

            // Fetch sections
            $sections = SectionVersion::where('course_id', $id)
                ->orderBy('order')
                ->get();

            // Initialize arrays for lectures
            $articleLectures = [];
            $videoLectures = [];
            $lectures = [];

            // Iterate through sections and fetch lectures
            foreach ($sections as $section) {
                // Fetch all lectures for the current section
                $sectionLectures = LectureVersion::where('section_id', $section->id)
                    ->orderBy('order')
                    ->get();

                $lectures[$section->id] = $sectionLectures; // Store lectures in the array

                foreach ($sectionLectures as $lecture) {
                    // Handle article lectures
                    if ($lecture->type === 'article') {
                        $articleLecture = ArticleLectureVersion::where('lecture_id', $lecture->id)->first();
                        if ($articleLecture) {
                            $articleLectures[$lecture->id] = [
                                'title' => $articleLecture->title,
                                'content' => $articleLecture->content,
                                'order' => $articleLecture->order,
                                'section_order' => $articleLecture->section_order,
                            ];
                        }
                    }
                    // Handle video lectures
                    elseif ($lecture->type === 'video') {
                        $videoLecture = VideoLectureVersion::where('lecture_id', $lecture->id)->first();
                        if ($videoLecture) {
                            $videoLectures[$lecture->id] = [
                                'title' => $videoLecture->title,
                                'url' => $videoLecture->video_url,
                                'description' => $videoLecture->description,
                                'order' => $videoLecture->order,
                                'section_order' => $videoLecture->section_order,
                            ];
                        }
                    }
                }
            }


            $formatedDurationsLectures = [];
            $formatedDurationsSections = [];
            foreach ($sections as $section) {
                $formatedDurationsSections[$section->id] = $this->formatDuration($section->duration);
                foreach ($lectures[$section->id] as $lecture) {
                    if ($lecture->duration > 0) {
                        $formatedDurationsLectures[$lecture->id] = $this->formatDuration($lecture->duration);
                    }
                }
            }

            return view('instructor.courses.view-content', [
                'course' => $course,
                'attributes' => $attributes,
                'sections' => $sections,
                'lectures' => $lectures,
                'articleLectures' => $articleLectures,
                'videoLectures' => $videoLectures,
                'formatedDurations' => $formatedDurationsLectures,
            ]);
        }

        return redirect()->route('ins.courses');
    }

    public function view_published_content($id)
    {
        $course = Course::find($id);

        if ($course->status === 'published' || $course->status === 'unpublished') {
            // Fetch course attributes and categories
            $attributes = CourseAttribute::where('course_id', $id)->get();

            // Fetch sections
            $sections = Section::where('course_id', $id)
                ->orderBy('order')
                ->get();

            // Initialize arrays for lectures
            $articleLectures = [];
            $videoLectures = [];
            $lectures = [];

            // Iterate through sections and fetch lectures
            foreach ($sections as $section) {
                // Fetch all lectures for the current section
                $sectionLectures = Lecture::where('section_id', $section->id)
                    ->orderBy('order')
                    ->get();

                $lectures[$section->id] = $sectionLectures; // Store lectures in the array

                foreach ($sectionLectures as $lecture) {
                    // Handle article lectures
                    if ($lecture->type === 'article') {
                        $articleLecture = ArticleLecture::where('lecture_id', $lecture->id)->first();
                        if ($articleLecture) {
                            $articleLectures[$lecture->id] = [
                                'title' => $articleLecture->title,
                                'content' => $articleLecture->content,
                                'order' => $articleLecture->order,
                                'section_order' => $articleLecture->section_order,
                            ];
                        }
                    }
                    // Handle video lectures
                    elseif ($lecture->type === 'video') {
                        $videoLecture = VideoLecture::where('lecture_id', $lecture->id)->first();
                        if ($videoLecture) {
                            $videoLectures[$lecture->id] = [
                                'title' => $videoLecture->title,
                                'url' => $videoLecture->video_url,
                                'description' => $videoLecture->description,
                                'order' => $videoLecture->order,
                                'section_order' => $videoLecture->section_order,
                            ];
                        }
                    }
                }
            }


            $formatedDurationsLectures = [];
            $formatedDurationsSections = [];
            foreach ($sections as $section) {
                $formatedDurationsSections[$section->id] = $this->formatDuration($section->duration);
                foreach ($lectures[$section->id] as $lecture) {
                    if ($lecture->duration > 0) {
                        $formatedDurationsLectures[$lecture->id] = $this->formatDuration($lecture->duration);
                    }
                }
            }


            return view('instructor.courses.view-content', [
                'course' => $course,
                'attributes' => $attributes,
                'sections' => $sections,
                'lectures' => $lectures,
                'articleLectures' => $articleLectures,
                'videoLectures' => $videoLectures,
                'formatedDurations' => $formatedDurationsLectures,
            ]);
        }
        return redirect()->route('ins.courses');
    }

    public function publish_First_version($id)
    {
        $course = CourseVersion::find($id);
        if ($course->status === 'accepted') {
            $this->publishFirstVersion($id);
        }
        return redirect()->route('ins.courses');
    }

    public function publishFirstVersion($id)
    {
        $courseVersion = CourseVersion::find($id);
        $sectionVersions = SectionVersion::where('course_id', $id)->get();
        $courseAttributeVersions = CourseAttributeVersion::where('course_id', $id)->get();

        // Create  the course
        $course = new Course();
        $course->version_number = $courseVersion->version_number;
        $course->title = $courseVersion->title;
        $course->subtitle = $courseVersion->subtitle;
        $course->description = $courseVersion->description;
        $course->category_id = $courseVersion->category_id;
        $course->subcategory_id = $courseVersion->subcategory_id;
        $course->subsubcategory_id = $courseVersion->subsubcategory_id;
        $course->level = $courseVersion->level;
        $course->language = $courseVersion->language;
        $course->instructor_id = $courseVersion->instructor_id;
        $course->price = $courseVersion->price;
        $course->sections_count = $courseVersion->sections_count;
        $course->lectures_count = $courseVersion->lectures_count;
        $course->duration = $courseVersion->duration;
        $course->save();
        $newCourseId = $course->id;

        if ($courseVersion->thumbnail) {
            $oldFilePath = $courseVersion->thumbnail;
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $filename = 'thumbnail_' . time() . '.' . $extension;
            $newFilePath = 'courses/' . $newCourseId . '/thumbnails/' . $filename;
            // Copy the file to the new location
            Storage::copy($oldFilePath, $newFilePath);
            // Update the course record with the new file path
            $course->thumbnail = $newFilePath;
            $course->save();
        }

        if ($courseVersion->promotional_video) {
            $oldFilePath = $courseVersion->promotional_video;
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $filename = 'promotional_video_' . time() . '.' . $extension;
            $newFilePath = 'courses/' . $newCourseId . '/promotional_videos/' . $filename;
            // Copy the file to the new location
            Storage::copy($oldFilePath, $newFilePath);
            // Update the course record with the new file path
            $course->promotional_video = $newFilePath;
            $course->save();
        }

        foreach ($courseAttributeVersions as $courseAttributeVersion) {
            $courseAttribute = new CourseAttribute();
            $courseAttribute->course_id = $newCourseId;
            $courseAttribute->type = $courseAttributeVersion->type;
            $courseAttribute->content = $courseAttributeVersion->content;
            $courseAttribute->order = $courseAttributeVersion->order;
            $courseAttribute->save();
        }

        // save the new data
        foreach ($sectionVersions as $sectionVersion) {
            // Create new section record
            $section = new Section();
            $section->course_id = $newCourseId;
            $section->lectures_count = $sectionVersion->lectures_count;
            $section->title = $sectionVersion->title;
            $section->description = $sectionVersion->description;
            $section->order = $sectionVersion->order;
            $section->duration = $sectionVersion->duration;
            $section->save();
            $sectionId = $section->id;

            // Retrieve lectures for this section
            $lectureVersions = LectureVersion::where('section_id', $sectionVersion->id)
                ->orderBy('order')
                ->get();

            // Move course lectures
            foreach ($lectureVersions as $lectureVersion) {
                // Create new lecture record
                $lecture = new Lecture();
                $lecture->section_id = $sectionId;
                $lecture->title = $lectureVersion->title;
                $lecture->type = $lectureVersion->type; // 'article' or 'video'
                $lecture->section_order = $lectureVersion->section_order;
                $lecture->order = $lectureVersion->order;
                $lecture->duration = $lectureVersion->duration;
                $lecture->save();
                $lectureId = $lecture->id;

                // Move course article lectures
                if ($lectureVersion->type === 'article') {
                    $articleLectureVersions = ArticleLectureVersion::where('lecture_id', $lectureVersion->id)->get();
                    foreach ($articleLectureVersions as $articleLectureVersion) {
                        $articleLecture = new ArticleLecture();
                        $articleLecture->lecture_id = $lectureId;
                        $articleLecture->section_order = $articleLectureVersion->section_order;
                        $articleLecture->order = $articleLectureVersion->order;
                        $articleLecture->title = $articleLectureVersion->title;
                        $articleLecture->content = $articleLectureVersion->content;
                        $articleLecture->duration = $articleLectureVersion->duration;
                        $articleLecture->save();
                    }
                }

                // Move course video lectures
                if ($lectureVersion->type === 'video') {
                    $videoLectureVersions = VideoLectureVersion::where('lecture_id', $lectureVersion->id)->get();
                    foreach ($videoLectureVersions as $videoLectureVersion) {
                        $videoLecture = new VideoLecture();
                        $videoLecture->lecture_id = $lectureId;
                        $videoLecture->section_order = $videoLectureVersion->section_order;
                        $videoLecture->order = $videoLectureVersion->order;
                        $videoLecture->title = $videoLectureVersion->title;
                        $videoLecture->video_url = $videoLectureVersion->video_url;
                        $videoLecture->description = $videoLectureVersion->description;
                        $videoLecture->duration = $videoLectureVersion->duration;
                        $videoLecture->save();
                    }
                }
            }
        }

        $courseVersion->course_id = $newCourseId;
        $courseVersion->published_at = now();
        $courseVersion->status = 'active';
        $courseVersion->save();

        $course->published_at = now();
        $course->save();
    }

    public function unpublish_version($id)
    {
        $course = Course::find($id);
        $course->status = 'unpublished';
        $course->save();
        return redirect()->route('ins.courses');
    }

    public function republish_version($id)
    {
        $course = Course::find($id);
        $course->status = 'published';
        $course->published_at = now();
        $course->save();
        return redirect()->route('ins.courses');
    }

    public function check_delete($id)
    {
        $courseVersion = CourseVersion::find($id);
        if ($courseVersion) {
            if ($courseVersion->course_id) {
                $course = Course::find($courseVersion->course_id);
                $course->has_draft = false;
                $course->save();
            }

            // Determine the folder path based on the version ID
            $versionFolderPath = 'versions/'.$courseVersion->id.'/';

            // Delete all files in the version folder
            Storage::deleteDirectory($versionFolderPath);

            /*if ($courseVersion->thumbnail) {
                Storage::delete($courseVersion->thumbnail);
            }
            if ($courseVersion->promotional_video) {
                Storage::delete($courseVersion->promotional_video);
            }*/

            $courseVersion->delete();
        }
        return redirect()->route('ins.courses');
    }

    public function delete_course($id)
    {
        $course = Course::find($id);
        if ($course) {
            $versions = CourseVersion::where('course_id', $course->id)->get();
            foreach ($versions as $version) {
                $versionFolderPath = 'versions/'.$version->id.'/';
                Storage::deleteDirectory($versionFolderPath);
            }

            $courseFolderPath = 'courses/'.$course->id.'/';
            Storage::deleteDirectory($courseFolderPath);
            $course->delete();
        }
        return redirect()->route('ins.courses');
    }

    public function create_version(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course->has_draft) {
            $version_id = $this->createCourseVersion($id);
            $course->has_draft = true;
            $course->save();

            return redirect()->route('courses.edit.version.new', ['id' => $version_id]);
        }
        return redirect()->route('ins.courses');
    }

    public function createCourseVersion($id):int
    {
        // Find the course to create a version from
        $course = Course::find($id);
        $instructor = Instructor::where('user_id', Auth::id())->first();

        // Create a new version record for the course
        $courseVersion = new CourseVersion();
        $courseVersion->version_number = $course->version_number + 1;
        $courseVersion->course_id = $id;
        $courseVersion->title = $course->title;
        $courseVersion->subtitle = $course->subtitle;
        $courseVersion->description = $course->description;
        $courseVersion->category_id = $course->category_id;
        $courseVersion->subcategory_id = $course->subcategory_id;
        $courseVersion->subsubcategory_id = $course->subsubcategory_id;
        $courseVersion->level = $course->level;
        $courseVersion->language = $course->language;
        $courseVersion->instructor_id = $instructor->id;
        $courseVersion->sections_count = $course->sections_count;
        $courseVersion->lectures_count = $course->lectures_count;
        $courseVersion->duration = $course->duration;
        $courseVersion->price = $course->price;
        $courseVersion->save();
        $newCourseVersionId = $courseVersion->id;

        if ($course->thumbnail) {
            $oldFilePath = $course->thumbnail;
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $filename = 'thumbnail_' . time() . '.' . $extension;
            $newFilePath = 'versions/' . $newCourseVersionId . '/thumbnails/' . $filename;
            // Copy the file to the new location
            Storage::copy($oldFilePath, $newFilePath);
            // Update the course record with the new file path
            $courseVersion->thumbnail = $newFilePath;
            $courseVersion->save();
        }

        if ($course->promotional_video) {
            $oldFilePath = $course->promotional_video;
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $filename = 'promotional_video_' . time() . '.' . $extension;
            $newFilePath = 'versions/' . $newCourseVersionId . '/promotional_videos/' . $filename;
            // Copy the file to the new location
            Storage::copy($oldFilePath, $newFilePath);
            // Update the course record with the new file path
            $courseVersion->promotional_video = $newFilePath;
            $courseVersion->save();
        }

        // Copy course attributes to the new version
        $courseAttributes = CourseAttribute::where('course_id', $id)->get();
        foreach ($courseAttributes as $courseAttribute) {
            $courseAttributeVersion = new CourseAttributeVersion();
            $courseAttributeVersion->course_id = $newCourseVersionId;
            $courseAttributeVersion->type = $courseAttribute->type;
            $courseAttributeVersion->content = $courseAttribute->content;
            $courseAttributeVersion->order = $courseAttribute->order;
            $courseAttributeVersion->save();
        }

        // Copy sections and their lectures to the new version
        $sections = Section::where('course_id', $id)->get();
        foreach ($sections as $section) {
            // Create a new section record in the version table
            $sectionVersion = new SectionVersion();
            $sectionVersion->course_id = $newCourseVersionId;
            $sectionVersion->lectures_count = $section->lectures_count;
            $sectionVersion->title = $section->title;
            $sectionVersion->description = $section->description;
            $sectionVersion->order = $section->order;
            $sectionVersion->duration = $section->duration;
            $sectionVersion->save();
            $newSectionVersionId = $sectionVersion->id;

            // Retrieve and copy lectures for this section
            $lectures = Lecture::where('section_id', $section->id)->orderBy('order')->get();
            foreach ($lectures as $lecture) {
                // Create a new lecture record in the version table
                $lectureVersion = new LectureVersion();
                $lectureVersion->section_id = $newSectionVersionId;
                $lectureVersion->title = $lecture->title;
                $lectureVersion->type = $lecture->type; // 'article' or 'video'
                $lectureVersion->section_order = $lecture->section_order;
                $lectureVersion->order = $lecture->order;
                $lectureVersion->duration = $lecture->duration;
                $lectureVersion->save();
                $newLectureVersionId = $lectureVersion->id;

                // Copy article lectures if applicable
                if ($lecture->type === 'article') {
                    $articleLectures = ArticleLecture::where('lecture_id', $lecture->id)->get();
                    foreach ($articleLectures as $articleLecture) {
                        $articleLectureVersion = new ArticleLectureVersion();
                        $articleLectureVersion->lecture_id = $newLectureVersionId;
                        $articleLectureVersion->section_order = $articleLecture->section_order;
                        $articleLectureVersion->order = $articleLecture->order;
                        $articleLectureVersion->title = $articleLecture->title;
                        $articleLectureVersion->content = $articleLecture->content;
                        $articleLectureVersion->duration = $articleLecture->duration;
                        $articleLectureVersion->save();
                    }
                }

                // Copy video lectures if applicable
                if ($lecture->type === 'video') {
                    $videoLectures = VideoLecture::where('lecture_id', $lecture->id)->get();
                    foreach ($videoLectures as $videoLecture) {
                        $videoLectureVersion = new VideoLectureVersion();
                        $videoLectureVersion->lecture_id = $newLectureVersionId;
                        $videoLectureVersion->section_order = $videoLecture->section_order;
                        $videoLectureVersion->order = $videoLecture->order;
                        $videoLectureVersion->title = $videoLecture->title;
                        $videoLectureVersion->video_url = $videoLecture->video_url;
                        $videoLectureVersion->description = $videoLecture->description;
                        $videoLectureVersion->duration = $videoLecture->duration;
                        $videoLectureVersion->save();
                    }
                }
            }
        }
        return $newCourseVersionId;
    }

    public function replace_version($id, $version)
    {
        $this->replaceLiveWithDraft($id, $version);
        return redirect()->route('ins.courses');
    }

    public function replaceLiveWithDraft($courseId, $draftVersionId)
    {
        $draftVersion = CourseVersion::find($draftVersionId);
        $liveCourse = Course::where('id', $courseId)->first();
        if (!$draftVersion || !$liveCourse) {
            return redirect()->route('ins.courses');
        }

        // Update the live course with draft version data
        $liveCourse->version_number = $draftVersion->version_number;
        $liveCourse->title = $draftVersion->title;
        $liveCourse->subtitle = $draftVersion->subtitle;
        $liveCourse->description = $draftVersion->description;
        $liveCourse->category_id = $draftVersion->category_id;
        $liveCourse->subcategory_id = $draftVersion->subcategory_id;
        $liveCourse->subsubcategory_id = $draftVersion->subsubcategory_id;
        $liveCourse->level = $draftVersion->level;
        $liveCourse->language = $draftVersion->language;
        $liveCourse->instructor_id = $draftVersion->instructor_id;
        $liveCourse->price = $draftVersion->price;
        $liveCourse->sections_count = $draftVersion->sections_count;
        $liveCourse->lectures_count = $draftVersion->lectures_count;
        $liveCourse->duration = $draftVersion->duration;
        $liveCourse->save();

        Storage::delete($liveCourse->thumbnail);
        Storage::delete($liveCourse->promotional_video);
        $liveCourse->thumbnail = '';
        $liveCourse->promotional_video = '';
        $liveCourse->save();

        if ($draftVersion->thumbnail) {
            $oldFilePath = $draftVersion->thumbnail;
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $filename = 'thumbnail_' . time() . '.' . $extension;
            $newFilePath = 'courses/' . $courseId . '/thumbnails/' . $filename;
            // Copy the file to the new location
            Storage::copy($oldFilePath, $newFilePath);
            // Update the course record with the new file path
            $liveCourse->thumbnail = $newFilePath;
            $liveCourse->save();
        }

        if ($draftVersion->promotional_video) {
            $oldFilePath = $draftVersion->promotional_video;
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $filename = 'promotional_video_' . time() . '.' . $extension;
            $newFilePath = 'courses/' . $courseId . '/promotional_videos/' . $filename;
            // Copy the file to the new location
            Storage::copy($oldFilePath, $newFilePath);
            // Update the course record with the new file path
            $liveCourse->promotional_video = $newFilePath;
            $liveCourse->save();
        }

        CourseAttribute::where('course_id', $courseId)->delete();

        // Fetch and copy new course attributes from draft
        $draftAttributes = CourseAttributeVersion::where('course_id', $draftVersionId)->get();
        foreach ($draftAttributes as $draftAttribute) {
            $courseAttribute = new CourseAttribute();
            $courseAttribute->course_id = $courseId;
            $courseAttribute->type = $draftAttribute->type;
            $courseAttribute->content = $draftAttribute->content;
            $courseAttribute->order = $draftAttribute->order;
            $courseAttribute->save();
        }

        Section::where('course_id', $courseId)->delete();

        $draftSections = SectionVersion::where('course_id', $draftVersionId)->get();
        foreach ($draftSections as $draftSection) {
            $section = new Section();
            $section->course_id = $courseId;
            $section->lectures_count = $draftSection->lectures_count;
            $section->title = $draftSection->title;
            $section->description = $draftSection->description;
            $section->order = $draftSection->order;
            $section->duration = $draftSection->duration;
            $section->save();
            $sectionId = $section->id;

            // Copy lectures for the section
            $draftLectures = LectureVersion::where('section_id', $draftSection->id)
                ->orderBy('order')
                ->get();
            foreach ($draftLectures as $draftLecture) {
                $lecture = new Lecture();
                $lecture->section_id = $sectionId;
                $lecture->title = $draftLecture->title;
                $lecture->type = $draftLecture->type;
                $lecture->section_order = $draftLecture->section_order;
                $lecture->order = $draftLecture->order;
                $lecture->duration = $draftLecture->duration;
                $lecture->save();
                $lectureId = $lecture->id;

                // Copy article lectures
                if ($draftLecture->type === 'article') {
                    $articleLectures = ArticleLectureVersion::where('lecture_id', $draftLecture->id)->get();
                    foreach ($articleLectures as $articleLecture) {
                        $newArticleLecture = new ArticleLecture();
                        $newArticleLecture->lecture_id = $lectureId;
                        $newArticleLecture->section_order = $articleLecture->section_order;
                        $newArticleLecture->order = $articleLecture->order;
                        $newArticleLecture->title = $articleLecture->title;
                        $newArticleLecture->content = $articleLecture->content;
                        $newArticleLecture->duration = $articleLecture->duration;
                        $newArticleLecture->save();
                    }
                }

                // Copy video lectures
                if ($draftLecture->type === 'video') {
                    $videoLectures = VideoLectureVersion::where('lecture_id', $draftLecture->id)->get();
                    foreach ($videoLectures as $videoLecture) {
                        $newVideoLecture = new VideoLecture();
                        $newVideoLecture->lecture_id = $lectureId;
                        $newVideoLecture->section_order = $videoLecture->section_order;
                        $newVideoLecture->order = $videoLecture->order;
                        $newVideoLecture->title = $videoLecture->title;
                        $newVideoLecture->video_url = $videoLecture->video_url;
                        $newVideoLecture->description = $videoLecture->description;
                        $newVideoLecture->duration = $videoLecture->duration;
                        $newVideoLecture->save();
                    }
                }
            }
        }

        $previousVersion = CourseVersion::where('course_id', $courseId)
            ->where('version_number', '<', $draftVersion->version_number) // Ensure it's a previous version
            ->orderBy('version_number', 'desc') // Order by version number to get the closest previous
            ->first();
        $previousVersion->status = 'old';
        $previousVersion->save();

        $draftVersion->published_at = now();
        $draftVersion->status = 'active';
        $draftVersion->save();

        $liveCourse->has_draft = false;
        $liveCourse->version_number = $draftVersion->version_number;
        $liveCourse->save();
    }
}
