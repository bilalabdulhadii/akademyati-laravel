@extends('layouts.step')

@section('title', $course->title )

@section('content')
    <style>
        #courseViewForm input:disabled, #courseViewForm textarea:disabled, #courseViewForm select:disabled {
            background-color: #fff
        }
    </style>
    <!-- Topbar -->
    <div class="step-topbar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <img src="{{ asset('assets/step/images/logo.png') }}" alt="Logo">
                </div>
                <div class="col-auto">
                    {{--<a href="{{ route('ins.courses') }}" class="btn btn-exit">Exit</a>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="step-content-wrapper">
            <button class="collapse-button d-lg-none" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
                <span class="icon"><i class="fas fa-bars"></i></span>
            </button>
            <div class="step-sidebar collapse fast-collapse d-lg-block" id="sidebarMenu">
                <!-- Sidebar content goes here -->
                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <li>
                        <h6 class="px-2"> Course Plan </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="course-building-tab" data-toggle="pill" href="#building-tips" role="tab" aria-controls="building-tips" aria-selected="true">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Building Tips
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="course-essentials-tab" data-toggle="pill" href="#course-essentials" role="tab" aria-controls="course-essentials" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Course Essentials
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="audience-tab" data-toggle="pill" href="#audience" role="tab" aria-controls="audience" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Audience & Goals
                        </a>
                    </li>
                    <li>
                        <h6 class="px-1 pt-3"> Content Development </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="promotional-tab" data-toggle="pill" href="#promotional" role="tab" aria-controls="promotional" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Promotional Content
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="curriculum-tab" data-toggle="pill" href="#curriculum" role="tab" aria-controls="curriculum" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Curriculum & Outline
                        </a>
                    </li>
                    <li>
                        <h6 class="px-1 pt-3"> Course Launch </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pricing-tab" data-toggle="pill" href="#pricing" role="tab" aria-controls="pricing" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Pricing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="promotion-tab" data-toggle="pill" href="#promotion" role="tab" aria-controls="promotion" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Promotion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="messages-tab" data-toggle="pill" href="#messages" role="tab" aria-controls="messages" aria-selected="false">
                            <span class="icon"><i class="fa-regular fa-square"></i></span> Course Messages
                        </a>
                    </li>
                </ul>
            </div>
            <div class="step-content-container-style1">
                <!-- Main content goes here -->
                <form id="courseViewForm" action="" method="POST" {{--autocomplete="off"--}} enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="building-tips" role="tabpanel" aria-labelledby="building-tips-tab">
                            <!-- Building Tips form -->
                            <h3>Building Tips</h3>
                            <article class="mt-4 px-3">
                                <p></p>
                                <p>Welcome to the Course Creation Guide! <br> Creating a course on <a target=”_blank” href="{{ route('home') }}"><b> Akademyati </b></a> is an exciting opportunity to share your expertise and make a positive impact on learners. To ensure your course is engaging and effective, follow these essential tips and requirements.</p>

                                <h2 class="mt-5 mb-2">Tips for Creating a Great Course</h2>
                                <ol class="mb-5">
                                    <li class="mb-2"><strong>Know Your Audience:</strong> Understand who your learners are and what they need. Tailor your content to address their goals and challenges.</li>
                                    <li class="mb-2"><strong>Define Clear Objectives:</strong> Outline specific learning outcomes you want to achieve. This will help structure your course and measure its success.</li>
                                    <li class="mb-2"><strong>Organize Your Content:</strong> Break your course into manageable sections and lectures. Use a logical flow to guide learners through the material.</li>
                                    <li class="mb-2"><strong>Engage Your Learners:</strong> Include interactive elements like quizzes, assignments, and discussions to keep learners engaged and reinforce their understanding.</li>
                                    <li class="mb-2"><strong>Use Multimedia:</strong> Enhance your content with videos, images, and infographics. Diverse media can make learning more enjoyable and effective.</li>
                                    <li class="mb-2"><strong>Provide Clear Instructions:</strong> Ensure that all activities and assignments have clear instructions and expectations. This helps learners understand what is required.</li>
                                    <li class="mb-2"><strong>Test Your Content:</strong> Before publishing, review and test your course materials. Get feedback from others to identify any areas for improvement.</li>
                                </ol>

                                <h2 class="mt-5 mb-2">Requirements for Creating a Course</h2>
                                <ol class="mb-5">
                                    <li class="mb-2"><strong>Course Outline:</strong> Develop a comprehensive outline that includes sections, lectures, and key topics. This will serve as the foundation for your course.</li>
                                    <li class="mb-2"><strong>Content Quality:</strong> Ensure all content is accurate, up-to-date, and relevant. High-quality materials contribute to a better learning experience.</li>
                                    <li class="mb-2"><strong>Technical Requirements:</strong> Verify that your course materials are compatible with Akademyati's platform. This includes file formats, multimedia, and interactive elements.</li>
                                    <li class="mb-2"><strong>Assessment Methods:</strong> Design assessments that align with your learning objectives. This includes quizzes, assignments, and other evaluation tools.</li>
                                    <li class="mb-2"><strong>Accessibility:</strong> Ensure your course is accessible to all learners, including those with disabilities. Follow best practices for accessibility to create an inclusive learning environment.</li>
                                </ol>

                                <p class="mt-4">By following these tips and meeting the requirements, you'll be well on your way to creating a successful and impactful course on Akademyati. Happy teaching!</p>
                            </article>
                        </div>
                        <div class="tab-pane fade" id="course-essentials" role="tabpanel" aria-labelledby="course-essentials-tab">
                            <!-- Course Essentials form -->
                            <h3>Course Essentials</h3>
                            <p class="desc-paragraph pb-4">Creating a strong course landing page is key to success on <a target=”_blank” href="{{ route('home') }}"><b> Akademyati </b></a> and can
                                boost visibility on Google. Focus on crafting a compelling page that
                                convinces potential students to enroll by showcasing your course's value.
                            </p>
                            <div class="form-group mt-4">
                                <label for="course_title" class="mb-1">Course Title <small class="text-danger">(required)</small></label>
                                <input type="text" class="form-control" id="course_title" name="course_title" value="{{ $course->title ?? '' }}"  placeholder="Insert course title ..." disabled>
                                <p class="desc-item">Your title should be catchy, informative, and optimized for search engines.</p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_subtitle" class="mb-1">Course Subtitle <small class="text-danger">(required)</small></label>
                                <input type="text" class="form-control" id="course_subtitle" name="course_subtitle" value="{{ $course->subtitle ?? '' }}" placeholder="Insert course subtitle ..." disabled>
                                <p class="desc-item">Use 1 or 2 related keywords, and mention the most important areas that you've covered during your course.</p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_description" class="mb-1">Course Description <small class="text-danger">(required)</small></label>
                                <textarea class="form-control" id="course_description" name="course_description" rows="3" placeholder="Describe your course ..." disabled>{{ $course->description ?? '' }}</textarea>
                                <p class="desc-item">Description should have minimum 100 words.</p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_language" class="mb-1">Course Language <small class="text-danger">(required)</small></label>
                                <input type="text" class="form-control" id="course_language" name="course_language" value="{{ $course->language ?? '' }}" placeholder="Insert course language ..." disabled>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_level" class="mb-1">Course Level <small class="text-danger">(required)</small></label>
                                <select class="form-select" aria-label="select" id="course_level" name="course_level" disabled>
                                    <option value="" {{ is_null($course->level) ? 'selected' : '' }}>Select level</option>
                                    <option value="Beginner" {{ $course->level === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="Intermediate" {{ $course->level === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="Advanced" {{ $course->level === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="All Levels" {{ $course->level === 'All Levels' ? 'selected' : '' }}>All Levels</option>
                                </select>
                            </div>
                            <div class="form-group mt-4 pb-3">
                                <label for="course_category" class="mb-1">Course Main Category <small class="text-danger">(required)</small></label>
                                <select class="form-select" aria-label="select" id="course_category" name="course_category" disabled>
                                    <option value="" selected>{{ $course->category_id ? $course->category->title : '' }}</option>
                                </select>
                                <p class="desc-item mb-0">Choose at least one category level so your course can be easily navigated and discovered.</p>
                            </div>
                            <div class="form-group pb-3">
                                <label for="course_subcategory" class="mb-1">Course SubCategory</label>
                                <select class="form-select" aria-label="select" id="course_subcategory" name="course_subcategory" disabled>
                                    <option value="" selected>{{ $course->subcategory_id ? $course->subcategory->title : '' }}</option>
                                </select>
                            </div>
                            <div class="form-group pb-3">
                                <label for="course_subsubcategory" class="mb-1">Course Sub-SubCategory</label>
                                <select class="form-select" aria-label="select" id="course_subsubcategory" name="course_subsubcategory" disabled>
                                    <option value="" selected>{{ $course->subsubcategory_id ? $course->subsubcategory->title : '' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="audience" role="tabpanel" aria-labelledby="audience-tab">
                            <h3>Audience & Goals</h3>
                            <!-- Audience & Goals form -->
                            <p class="desc-paragraph pb-4">These descriptions will be publicly visible on your
                                Course Landing Page and directly affect your course performance.
                                Those descriptions will help learners determine if your course suits their needs.
                            </p>
                            <div class="form-group pt-3">
                                <label for="targetAudience" class="pb-1">What will students learn in this course? <small class="text-danger">(3 objectives required)</small></label>
                                <p class="desc-item">You must enter at least 3 learning objectives or
                                    outcomes that learners can expect to achieve after completing your course.</p>
                                <div class="objectives-container">
                                    <!-- Initial objective input -->
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach($attributes as $attribute)
                                        @if($attribute['type'] === 'objective' && $attribute['order'] == $counter)
                                            <div class="d-flex justify-content-between mt-2">
                                                <input type="text" class="form-control mb-2" id="course-objective-{{ $counter }}"
                                                       name="course_objective_{{ $counter }}" placeholder="Enter objective {{ $counter }}" value="{{ $attribute->content }}" disabled>
                                            </div>
                                            @php $counter++; @endphp
                                        @endif
                                    @endforeach
                                </div>
                                {{--<a class="add-more-objective ms-2">Add more to your response</a>--}}
                                <template id="objective-template">
                                    <div class="d-flex justify-content-between mt-2">
                                        <input type="text" class="form-control mb-2" name="course_objective" placeholder="Enter objective">
                                        <a class="objective-trash d-flex mb-2 ms-3 align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </template>
                            </div>

                            <div class="form-group mt-5 pb-0">
                                <label for="studentPrerequisites" class="pb-2">What are the requirements or prerequisites for taking this course?</label>
                                <p class="desc-item">If there are no requirements you can leave it blank.</p>
                                <div class="prerequisites-container">
                                    <!-- Initial prerequisite input -->

                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach($attributes as $attribute)
                                        @if($attribute['type'] === 'prerequisite' && $attribute['order'] == $counter)
                                            <div class="d-flex justify-content-between mt-2">
                                                <input type="text" class="form-control mb-2" id="course-prerequisite-{{ $counter }}"
                                                       name="course_prerequisite_{{ $counter }}" placeholder="Enter prerequisite {{ $counter }}" value="{{ $attribute->content }}" disabled>
                                            </div>
                                            @php $counter++; @endphp
                                        @endif
                                    @endforeach
                                </div>
                                {{--<a class="add-more-prerequisite ms-2">Add more to your response</a>--}}
                                <template id="prerequisite-template">
                                    <div class="d-flex justify-content-between mt-2">
                                        <input type="text" class="form-control mb-2" name="course_prerequisite" placeholder="Enter prerequisite">
                                        <a class="prerequisite-trash d-flex mb-2 ms-3 align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </template>
                            </div>
                            <div class="form-group pt-4">
                                <label for="course_benefit" class="pb-1">Who is this course for?</label>
                                <p class="desc-item">Describe the target audience for your course who will find your course valuable and relevant to their needs.</p>
                                @php
                                    $content = "";
                                        foreach ($attributes as $attribute) {
                                            if ($attribute['type'] === 'benefit') {
                                                $content = $attribute['content'];
                                                break;
                                            }
                                        }
                                @endphp
                                <textarea class="form-control" id="course_benefit" name="course_benefit" rows="4"
                                          placeholder="Write a clear description" disabled>{{ $content }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="promotional" role="tabpanel" aria-labelledby="promotional-tab">
                            <!-- Promotional form -->
                            <h3>Promotional Content</h3>
                            <p class="desc-paragraph pb-4">
                                These elements will help attract and engage potential learners by providing
                                a visual preview of your course and highlighting its key features.
                            </p>
                            <div class="form-group mt-5">
                                <label for="course_thumbnail" class="form-label">Course Thumbnail <small class="text-danger">(required)</small></label>
                                <input class="form-control" type="file" id="course_thumbnail" name="course_thumbnail" disabled>
                                <p class="desc-item">Upload your course image here. </p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_promotional_video" class="form-label">Promotional Video <small class="text-danger">(required)</small></label>
                                <input class="form-control" type="file" id="course_promotional_video" name="course_promotional_video" disabled>
                                <p class="desc-item">Your promo video is a quick and compelling way for students to preview what they’ll learn in your course.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
                            <!-- Curriculum Design form -->
                            <h3>Curriculum Design</h3>
                            <p class="desc-paragraph pb-4">
                                Begin organizing your course content by outlining sections, lectures,
                                and interactive components such as quizzes and assignments.
                                Use your course outline to effectively structure your content,
                                ensuring clear labeling for each section and lecture.
                            </p>

                            {{-- Extract Curriculum Start --}}
                            <div class="container mt-4">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    @if(!empty($sections))
                                        @foreach($sections as $section)
                                            <div class="section-wrapper accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-section-{{ $section->order }}"
                                                            aria-expanded="true" aria-controls="accordion-section-{{ $section->order }}">
                                                        <span class="section-number">Section: {{ $section->order }}</span>
                                                        <small class="lectures-count ms-auto text-primary" style="font-size: 0.9rem">({{ $section->lectures_count }} lectures)</small>
                                                    </button>
                                                </h2>
                                                <div id="accordion-section-{{ $section->order }}" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        <div class="d-flex justify-content-start">
                                                            <input type="text" class="form-control mb-2 section-title" id="section-title-{{ $section->order }}" name="section_title_{{ $section->order }}" value="{{ $section->title ?? '' }}" placeholder="Enter section title" disabled>
                                                        </div>
                                                        <textarea class="form-control mb-4 section-description" id="section-description-{{ $section->order }}" name="section_description_{{ $section->order }}" placeholder="What does this section teach?" disabled>{{ $section->description ?? '' }}</textarea>
                                                        <hr>

                                                        <div class="lecture-container">
                                                            @if($section->lectures_count > 0)
                                                                @php
                                                                    $lectureCounter = 1;
                                                                @endphp
                                                                @foreach($lectures[$section->id] as $lecture)
                                                                    @if($lecture->order == $lectureCounter)
                                                                        @switch($lecture->type)
                                                                            @case('article')
                                                                                <div class="inputs lecture-wrapper">
                                                                                    <input type="hidden" class="lecture-type" name="section_{{ $section->order }}_lecture_{{ $lectureCounter }}_article" value="article">
                                                                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                                                                        <h5>Lecture <span class="lecture-number">{{ $lectureCounter }}</span>:
                                                                                            <span class="fs-5 fw-bold ls-wide text-primary">{{ $formatedDurations[$lecture->id] ?? '00:00' }}
                                                                                                <i class="icon-information text-secondary fw-bold fs-6 ms-1"></i>
                                                                                            </span>
                                                                                        </h5>
                                                                                    </div>
                                                                                    <input type="text" class="form-control mb-2" name="section_{{ $section->order }}_lecture_{{ $lectureCounter }}_title" value="{{ $articleLectures[$lecture->id]['title'] ?? '' }}" placeholder="Enter lecture title" disabled>
                                                                                    <label>The Content</label>
                                                                                    <div class="form-control mb-2 fr-view p-3">
                                                                                        {!! $articleLectures[$lecture->id]['content'] ?? '' !!}
                                                                                    </div>
                                                                                </div>
                                                                                @break
                                                                            @case('video')
                                                                                <div class="inputs lecture-wrapper">
                                                                                    <input type="hidden" class="lecture-type" name="section_{{ $section->order }}_lecture_{{ $lectureCounter }}_video" value="video">
                                                                                    <div class="d-flex justify-content-start mb-1">
                                                                                        <h5>Lecture <span class="lecture-number">{{ $lectureCounter }}</span>:
                                                                                            <span class="fs-5 fw-bold ls-wide text-primary">{{ $formatedDurations[$lecture->id] ?? '00:00' }}
                                                                                                <i class="icon-information text-secondary fw-bold fs-6 ms-1"></i>
                                                                                            </span>
                                                                                        </h5>
                                                                                    </div>
                                                                                    <input type="text" class="form-control mb-2" name="section_{{ $section->order }}_lecture_{{ $lectureCounter }}_title" value="{{ $videoLectures[$lecture->id]['title'] ?? '' }}" placeholder="Enter lecture title" disabled>
                                                                                    <label>Lecture Video URL</label>
                                                                                    <input type="text" class="form-control mb-2" name="section_{{ $section->order }}_lecture_{{ $lectureCounter }}_url" value="{{ $videoLectures[$lecture->id]['url'] ?? '' }}" placeholder="Enter video URL" disabled>
                                                                                    <label>Lecture Description</label>
                                                                                    <div class="form-control mb-2 fr-view p-3">
                                                                                        {!! $videoLectures[$lecture->id]['content'] ?? '' !!}
                                                                                    </div>
                                                                                </div>
                                                                                @break
                                                                        @endswitch
                                                                    @endif

                                                                    @php
                                                                        $lectureCounter++;
                                                                    @endphp
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            {{-- Extract Curriculum End --}}
                        </div>
                        <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                            <!-- Pricing form -->
                            <h3>Pricing</h3>
                            <p class="desc-paragraph pb-4">
                                Select a pricing tier that reflects the value of your course and resonates
                                with your target audience. Remember, offering your course for free can
                                help attract more students, but you may want to consider a paid option
                                to reflect the depth and quality of your content. Choose wisely to balance
                                accessibility and value.
                            </p>
                            <div class="form-group pt-4">
                                <label for="course_price" class="pb-1">Course Price <small class="text-danger">(required)</small></label>
                                <select class="form-select" aria-label="select" id="course_price" name="course_price" disabled>
                                    <option value="-1" {{ $course->price == -1.0 ? 'selected' : '' }}>Select the course price</option>
                                    <option value="0" {{ $course->price == 0.0 ? 'selected' : '' }}>Free</option>
                                    <option value="9.99" {{ $course->price == 9.99 ? 'selected' : '' }}>$9.99</option>
                                    <option value="19.99" {{ $course->price == 19.99 ? 'selected' : '' }}>$19.99</option>
                                    <option value="29.99" {{ $course->price == 29.99 ? 'selected' : '' }}>$29.99</option>
                                    <option value="39.99" {{ $course->price == 39.99 ? 'selected' : '' }}>$39.99</option>
                                    <option value="49.99" {{ $course->price == 49.99 ? 'selected' : '' }}>$49.99</option>
                                    <option value="59.99" {{ $course->price == 59.99 ? 'selected' : '' }}>$59.99</option>
                                    <option value="69.99" {{ $course->price == 69.99 ? 'selected' : '' }}>$69.99</option>
                                    <option value="79.99" {{ $course->price == 79.99 ? 'selected' : '' }}>$79.99</option>
                                    <option value="89.99" {{ $course->price == 89.99 ? 'selected' : '' }}>$89.99</option>
                                    <option value="99.99" {{ $course->price == 99.99 ? 'selected' : '' }}>$99.99</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="promotion" role="tabpanel" aria-labelledby="promotion-tab">
                            <!-- Promotion form -->
                            <h3>Promotion</h3>
                            <p class="desc-paragraph pb-4">
                                You cannot create coupons for a free course.
                            </p>
                            <div class="form-group pt-4">
                                <label for="course_coupon" class="pb-1">Coupon Code</label>
                                <input type="text" class="form-control" id="course_coupon" name="course_coupon" placeholder="Enter coupon code" disabled>
                            </div>
                            <div class="form-group pt-4">
                                <label for="discount_amount" class="pb-1">Discount Amount (%)</label>
                                <input type="number" class="form-control" id="discount_amount" name="discount_amount" placeholder="Enter discount percentage" disabled>
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
                            <!-- Course Messages form -->
                            <h3>Course Messages</h3>
                            <p class="desc-paragraph pb-4">
                                Write messages to your students (optional) that will be sent automatically
                                when they join or complete your course to encourage students to engage with
                                course content. If you do not wish to send a welcome or congratulations message,
                                leave the text box blank.
                            </p>
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
                                {{--<textarea class="form-control" id="welcome_message" name="welcome_message"
                                          rows="4" placeholder="Insert welcome message" disabled>{{ $content }}</textarea>--}}
                                <div class="form-control mb-2 fr-view p-3" id="welcome_message" style="max-height: 250px; overflow-y: auto">
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
                                {{--<textarea class="form-control" id="congratulations_message" name="congratulations_message"
                                          rows="4" placeholder="Insert congratulations message" disabled>{{ $content }}</textarea>--}}
                                <div class="form-control mb-2 fr-view p-3" id="congratulations_message" style="max-height: 250px; overflow-y: auto">
                                    {!! $content ?? '' !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="step-bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <a type="submit" href="{{ route('ins.courses') }}" class="btn btn-none btn-outline-dark">Exit</a>
                </div>
                <div class="col-auto">
                    {{--<a type="submit" class="btn btn-next">Cancel Review</a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

