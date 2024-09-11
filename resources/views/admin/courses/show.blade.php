@extends('layouts.admin')

@section('title', $course->title)

@section('content')
    <style>
        .course-content-tabs input:disabled, .course-content-tabs select:disabled, .course-content-tabs textarea:disabled {
            background: white !important;
            opacity: 1 !important;
        }
    </style>
        <div class="page-inner" style="min-height: 87vh; margin-top: 120px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">{{ $course->title }} <span>({{ ucfirst($course->status) }})</span></h4>
                                    <a href="{{ route('admin.courses.preview.redirect', ['id' => $course->id]) }}" target="_blank" class="btn btn-primary rounded-2">Preview</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="essentials-tab" data-bs-toggle="pill" href="#essentials" role="tab" aria-controls="pills-essentials" aria-selected="true">Essentials</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="audience-tab" data-bs-toggle="pill" href="#audience" role="tab" aria-controls="pills-audience" aria-selected="false">Audience</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="promotional-tab" data-bs-toggle="pill" href="#promotional" role="tab" aria-controls="pills-promotional" aria-selected="false">Promotional</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="curriculum-tab" data-bs-toggle="pill" href="#curriculum" role="tab" aria-controls="pills-curriculum" aria-selected="false">Curriculum</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pricing-tab" data-bs-toggle="pill" href="#pricing" role="tab" aria-controls="pills-pricing" aria-selected="false">Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="promotion-tab" data-bs-toggle="pill" href="#promotion" role="tab" aria-controls="pills-promotion" aria-selected="false">Promotion</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="messages-tab" data-bs-toggle="pill" href="#messages" role="tab" aria-controls="pills-messages" aria-selected="false">Messages</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3 course-content-tabs mb-3" id="line-tabContent">
                                    <div class="tab-pane fade show active" id="essentials" role="tabpanel" aria-labelledby="essentials-tab">
                                        <div class="form-group mt-4">
                                            <label for="course_title" class="mb-1">Course Title</label>
                                            <input type="text" class="form-control" id="course_title" name="course_title" value="{{ $course->title ?? '' }}"  disabled>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="course_subtitle" class="mb-1">Course Subtitle</label>
                                            <input type="text" class="form-control" id="course_subtitle" name="course_subtitle" value="{{ $course->subtitle ?? '' }}" disabled>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="course_description" class="mb-1">Course Description</label>
                                            <textarea class="form-control" id="course_description" name="course_description" rows="8" disabled>{{ $course->description ?? '' }}</textarea>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label for="course_language" class="mb-1">Course Language</label>
                                            <input type="text" class="form-control" id="course_language" name="course_language" value="{{ $course->language ?? '' }}" disabled>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="course_level" class="mb-1">Course Level</label>
                                            <input type="text" class="form-control" id="course_level" value="{{ $course->level ?? '' }}" disabled>
                                        </div>
                                        <div class="form-group mt-4 pb-3">
                                            <label for="course_category" class="mb-1">Course Category</label>
                                            <input type="text" class="form-control" id="course_category" value="Technology" disabled>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="audience" role="tabpanel" aria-labelledby="audience-tab">
                                        <h4 class="mt-5 mb-4">Course Objectives</h4>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach($attributes as $attribute)
                                            @if($attribute['type'] === 'objective' && $attribute['order'] == $counter)
                                                <label>Course objective {{ $counter }}</label>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <input type="text" class="form-control mb-2" id="course-objective-{{ $counter }}"
                                                           name="course_objective_{{ $counter }}" value="{{ $attribute->content }}" disabled>
                                                </div>
                                                @php $counter++; @endphp
                                            @endif
                                        @endforeach

                                        <h4 class="mt-5 mb-4">Course Prerequisites</h4>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach($attributes as $attribute)
                                            @if($attribute['type'] === 'prerequisite' && $attribute['order'] == $counter)
                                                <label>Course prerequisite {{ $counter }}</label>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <input type="text" class="form-control mb-2" id="course-prerequisite-{{ $counter }}"
                                                           name="course_prerequisite_{{ $counter }}" value="{{ $attribute->content }}" disabled>
                                                </div>
                                                @php $counter++; @endphp
                                            @endif
                                        @endforeach

                                        <h4 class="mt-5 mb-4">Course Benefits</h4>
                                        @php
                                            $content = "";
                                                foreach ($attributes as $attribute) {
                                                    if ($attribute['type'] === 'benefit') {
                                                        $content = $attribute['content'];
                                                        break;
                                                    }
                                                }
                                        @endphp
                                        <textarea class="form-control" id="course_benefit" name="course_benefit" rows="7" disabled>{{ $content }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="promotional" role="tabpanel" aria-labelledby="promotional-tab">
                                        <div class="form-group mt-5">
                                            <label for="course_thumbnail" class="form-label">Course Thumbnail</label>
                                            <input class="form-control" type="file" id="course_thumbnail" name="course_thumbnail" disabled>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="course_promotional_video" class="form-label">Promotional Video</label>
                                            <input class="form-control" type="file" id="course_promotional_video" name="course_promotional_video" disabled>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
                                        <div class="accordion mt-5">
                                            @if(!empty($data['sections']))
                                                @foreach($data['sections'] as $sectionNumber => $section)
                                                    @php
                                                        $lecturesCount = $section['lectures_count'] ?? 0;
                                                        $lectureCount = 1;
                                                    @endphp
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed bg-primary-subtle mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-section-{{ $sectionNumber }}"
                                                                    aria-expanded="true" aria-controls="accordion-section-{{ $sectionNumber }}">
                                                                Section {{ $sectionNumber }}: {{ $section['title'] ?? '' }}
                                                            </button>
                                                        </h2>
                                                        <div id="accordion-section-{{ $sectionNumber }}" class="accordion-collapse collapse">
                                                            <div class="accordion-body">
                                                                <label class="my-2">Section Description</label>
                                                                <textarea class="form-control mb-4 section-description" id="section-description-{{ $sectionNumber }}" name="section_description_{{ $sectionNumber }}" disabled>{{ $section['description'] ?? '' }}</textarea>
                                                                <hr>
                                                                @php
                                                                    $combinedLectures = [];
                                                                    foreach (['articleLectures', 'videoLectures'] as $type) {
                                                                        if (!empty($data[$type])) {
                                                                            // Iterate over sections
                                                                            foreach ($data[$type] as $section => $lectures) {
                                                                                // Check if the current section number matches the target section number
                                                                                if ($section == $sectionNumber) {
                                                                                    // Iterate over lectures in the section
                                                                                    foreach ($lectures as $order => $lecture) {
                                                                                        // Ensure that the 'section_number' exists and matches the target section number
                                                                                        if (isset($lecture['section_number']) && $lecture['section_number'] == $sectionNumber) {
                                                                                            // Add lecture to combined lectures array
                                                                                            $combinedLectures[] = [
                                                                                                'section' => $section,
                                                                                                'order' => $lecture['lecture_number'],
                                                                                                'type' => $lecture['type'],
                                                                                                'data' => $lecture,
                                                                                            ];
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp

                                                                <div class="lecture-container">
                                                                    <div class="accordion">
                                                                        @while($lecturesCount >= $lectureCount)
                                                                            @foreach($combinedLectures as $index => $lecture)
                                                                                @if($lecture['order'] == $lectureCount)
                                                                                    @switch($lecture['type'])
                                                                                        @case('article')

                                                                                            <div class="accordion-item">
                                                                                                <h2 class="accordion-header">
                                                                                                    <button class="accordion-button collapsed bg-primary-subtle mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-article-{{ $lectureCount }}"
                                                                                                            aria-expanded="true" aria-controls=accordion-article-{{ $lectureCount }}">
                                                                                                        Lecture {{ $lectureCount }} (Article): {{ $lecture['data']['title'] ?? '' }}
                                                                                                    </button>
                                                                                                </h2>
                                                                                                <div id="accordion-article-{{ $lectureCount }}" class="accordion-collapse collapse" aria-labelledby="accordion-article-{{ $lectureCount }}">
                                                                                                    <div class="accordion-body">
                                                                                                        <label class="my-2">The Content</label>
                                                                                                        <div class="form-control mb-2 fr-view p-3" style="max-height: 400px; overflow-y: auto">
                                                                                                            {!! $lecture['data']['content'] ?? '' !!}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            @break
                                                                                        @case('video')
                                                                                            <div class="accordion-item">
                                                                                                <h2 class="accordion-header">
                                                                                                    <button class="accordion-button collapsed bg-primary-subtle mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-video-{{ $lectureCount }}"
                                                                                                            aria-expanded="true" aria-controls=accordion-video-{{ $lectureCount }}">
                                                                                                        Lecture {{ $lectureCount }} (Video): {{ $lecture['data']['title'] ?? '' }}
                                                                                                    </button>
                                                                                                </h2>
                                                                                                <div id="accordion-video-{{ $lectureCount }}" class="accordion-collapse collapse" aria-labelledby="accordion-video-{{ $lectureCount }}">
                                                                                                    <div class="accordion-body">
                                                                                                        <label class="my-2">Lecture Video URL</label>
                                                                                                        <input type="text" class="form-control mb-2" name="section_{{ $sectionNumber }}_video_{{ $lectureCount }}_url" value="{{ $lecture['data']['url'] ?? '' }}" disabled>
                                                                                                        <label class="my-2">Lecture Description</label>
                                                                                                        <div class="form-control mb-2 fr-view p-3" style="max-height: 350px; overflow-y: auto">
                                                                                                            {!! $lecture['data']['description'] ?? '' !!}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            @break
                                                                                    @endswitch
                                                                                    @php
                                                                                        $lectureCount++;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                        @endwhile
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                                        <div class="form-group pt-4">
                                            <label for="course_price" class="pb-1">Course Price</label>
                                            <input type="text" class="form-control" id="course_price" value="{{ number_format($course->price, 2) ?? '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="promotion" role="tabpanel" aria-labelledby="promotion-tab">
                                        <h3>Promotion</h3>
                                        <div class="form-group pt-4">
                                            <label for="course_coupon" class="pb-1">Coupon Code</label>
                                            <input type="text" class="form-control" id="course_coupon" name="course_coupon" disabled>
                                        </div>
                                        <div class="form-group pt-4">
                                            <label for="discount_amount" class="pb-1">Discount Amount (%)</label>
                                            <input type="number" class="form-control" id="discount_amount" name="discount_amount" disabled>
                                        </div>
                                        <div class="form-group pt-4">
                                            <label for="coupon_start_date" class="pb-1">Coupon Start Date</label>
                                            <input type="date" class="form-control" id="coupon_start_date" name="coupon_start_date" disabled>
                                        </div>
                                        <div class="form-group pt-4">
                                            <label for="coupon_end_date" class="pb-1">Coupon End Date</label>
                                            <input type="date" class="form-control" id="coupon_end_date" name="coupon_end_date" disabled>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                                        <div class="form-group pt-4">
                                            <label for="welcome_message" class="pb-1">Welcome Message</label>
                                            @php
                                                $content = "";
                                                    foreach ($attributes as $attribute) {
                                                        if ($attribute['type'] === 'welcome_message') {
                                                            $content = $attribute['content'];
                                                            break;
                                                        }
                                                    }
                                            @endphp
                                            <div class="form-control mb-2 fr-view p-3" id="welcome_message" style="max-height: 400px; overflow-y: auto">
                                                {!! $content ?? '' !!}
                                            </div>
                                        </div>
                                        <div class="form-group pt-4">
                                            <label for="congratulations_message" class="pb-1">Congratulations Message</label>
                                            @php
                                                $content = "";
                                                    foreach ($attributes as $attribute) {
                                                        if ($attribute['type'] === 'congratulations_message') {
                                                            $content = $attribute['content'];
                                                            break;
                                                        }
                                                    }
                                            @endphp
                                            <div class="form-control mb-2 fr-view p-3" id="congratulations_message" style="max-height: 400px; overflow-y: auto">
                                                {!! $content ?? '' !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
