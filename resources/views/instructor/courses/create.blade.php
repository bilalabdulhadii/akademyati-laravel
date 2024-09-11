@extends('layouts.step')

@section('title', 'Instructor')

@section('content')
    <!-- Topbar -->
    <div class="step-topbar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <img src="{{ asset('assets/step/images/logo.png') }}" alt="Logo">
                </div>
                {{--<div class="col-auto">
                    <a href="{{ route('ins.courses') }}" class="btn btn-exit">Cancel</a>
                </div>--}}
            </div>
            <!-- Progress Container -->
            {{--<div class="step-progress-container">
                <div class="step-progress-bar" style="width: 50%;"></div>
            </div>--}}
        </div>
    </div>

    <style>
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            /*color: #fff;
            background-color: #696cff;*/
            color: #1f2122;
            background-color: #ededed;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .nav-pills .nav-link, .nav-pills .show>.nav-link {
            /*color: #fff;
            background-color: #696cff;*/
            /*background-color: lightgrey;*/
        }
        .nav-pills .nav-link:hover, .nav-pills .show>.nav-link {
            /*color: #fff;
            background-color: #696cff;*/
            color: #696cff;
        }

        .section-wrapper {
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }
        .lecture-wrapper {
            border: 1px solid #dee2e6;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #ffffff;
        }
        .content-wrapper {
            margin-top: 10px;
        }


        .hidden {
            display: none;
        }
        .button-box {
            margin-top: 10px;
        }
        .inputs {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .input-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .section-trash {
            font-size: 1.3rem;
        }

        .section-trash, .lecture-trash,
        .objective-trash, .prerequisite-trash {
            color: #1f2122;
            text-decoration: none;
            cursor: pointer;
        }

        .section-trash:hover , .lecture-trash:hover,
        .objective-trash:hover, .prerequisite-trash:hover {
            transform: scale(1.3);
            color: #dc3545;
        }

        .section-trash:hover i , .lecture-trash:hover i ,
        .objective-trash:hover i, .prerequisite-trash:hover i {
            color: #dc3545;
        }

        .add-more-objective, .add-more-prerequisite {
            cursor: pointer;
        }

        /*.accordion-button {
            pointer-events: none;
        }
        .accordion-button::after {
            pointer-events: all;
        }*/
    </style>

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
                <form id="courseForm" onsubmit="return false;" action="{{ route('save.draft') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="building-tips" role="tabpanel" aria-labelledby="building-tips-tab">
                            <!-- Building Tips form -->
                            <h3>Building Tips</h3>
                            <article class="mt-4 px-3">
                                <p></p>
                                <p>Welcome to the Course Creation Guide! <br> Creating a course on <b>Akademyati</b> is an exciting opportunity to share your expertise and make a positive impact on learners. To ensure your course is engaging and effective, follow these essential tips and requirements.</p>

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
                                <label for="course_title" class="mb-1">Course Title</label>
                                <input type="text" class="form-control" id="course_title" name="course_title" value="{{ $course->title ?? '' }}"  placeholder="Insert course title ..." required>
                                <p class="desc-item">Your title should be catchy, informative, and optimized for search engines.</p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_subtitle" class="mb-1">Course Subtitle</label>
                                <input type="text" class="form-control" id="course_subtitle" name="course_subtitle" value="{{ $course->subtitle ?? '' }}" placeholder="Insert course subtitle ...">
                                <p class="desc-item">Use 1 or 2 related keywords, and mention the most important areas that you've covered during your course.</p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_description" class="mb-1">Course Description</label>
                                <textarea class="form-control" id="course_description" name="course_description" rows="3" placeholder="Describe your course ..." required>{{ $course->description ?? '' }}</textarea>
                                <p class="desc-item">Description should have minimum 100 words.</p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_language" class="mb-1">Course Language</label>
                                <input type="text" class="form-control" id="course_language" name="course_language" value="{{ $course->language ?? '' }}" placeholder="Insert course language ..." required>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_level" class="mb-1">Course Level</label>
                                <select class="form-select" aria-label="select" id="course_level" name="course_level">
                                    <option value="" {{ is_null($course->level) ? 'selected' : '' }}>Select level</option>
                                    <option value="beginner" {{ $course->level === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ $course->level === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ $course->level === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="all" {{ $course->level === 'all' ? 'selected' : '' }}>All Levels</option>
                                </select>
                            </div>
                            <div class="form-group mt-4 pb-3">
                                <label for="course_category" class="mb-1">Course Category</label>
                                <select class="form-select" aria-label="select" id="course_category" name="course_category">
                                    <option value="" selected>Select category</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Business">Business</option>
                                    <option value="Arts">Arts</option>
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
                                <label for="targetAudience" class="pb-1">What will students learn in this course?</label>
                                <p class="desc-item">You must enter at least 3 learning objectives or
                                    outcomes that learners can expect to achieve after completing your course.</p>
                                <div class="objectives-container">
                                    <!-- Initial objective input -->
                                    {{--<div class="d-flex justify-content-between mt-2">
                                        <input type="text" class="form-control mb-2" id="course-objective-1" name="course_objective_1" placeholder="Enter objective 1">
                                        <a class="objective-trash d-flex mb-2 ms-3 align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <input type="text" class="form-control mb-2" id="course-objective-2" name="course_objective_2" placeholder="Enter objective 2">
                                        <a class="objective-trash d-flex mb-2 ms-3 align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <input type="text" class="form-control mb-2" id="course-objective-3" name="course_objective_3" placeholder="Enter objective 3">
                                        <a class="objective-trash d-flex mb-2 ms-3 align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>--}}
                                </div>
                                <a class="add-more-objective ms-2">Add more to your response</a>
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
                                    {{--<div class="d-flex justify-content-between mt-2">
                                        <input type="text" class="form-control mb-2" id="course-prerequisite-1" name="course_prerequisite_1" placeholder="Enter prerequisite 1">
                                        <a class="prerequisite-trash d-flex mb-2 ms-3 align-items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>--}}
                                </div>
                                <a class="add-more-prerequisite ms-2">Add more to your response</a>
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
                                <textarea class="form-control" id="course_benefit" name="course_benefit" rows="4"
                                          placeholder="Write a clear description" required></textarea>
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
                                <label for="course_thumbnail" class="form-label">Course Thumbnail</label>
                                <input class="form-control" type="file" id="course_thumbnail" name="course_thumbnail">
                                <p class="desc-item">Upload your course image here. </p>
                            </div>
                            <div class="form-group mt-4">
                                <label for="course_promotional_video" class="form-label">Promotional Video</label>
                                <input class="form-control" type="file" id="course_promotional_video" name="course_promotional_video">
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

                            <div class="container mt-4">
                                <div class="accordion" id="accordionPanelsStayOpenExample"></div>
                                <button id="add-section-btn" class="btn btn-outline-secondary add-section-btn">+ Section</button>

                                <template id="sectionTemplate">
                                    <div class="section-wrapper accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#replace-with-id"
                                                    aria-expanded="true" aria-controls="replace-with-id">
                                                Section #replace-with-number
                                            </button>
                                        </h2>
                                        <div id="replace-with-id" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="d-flex justify-content-between">
                                                    <input type="text" class="form-control mb-2 section-title" id="section-title-#replace-with-number" name="section_title_#replace-with-number" placeholder="Enter section title">
                                                    <a class="section-trash d-flex mb-2 ms-3 align-items-center ">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                <textarea class="form-control mb-4 section-description" id="section-description-#replace-with-number" name="section_description_#replace-with-number" placeholder="What does this section teach?"></textarea>
                                                <hr>
                                                <div class="lecture-container"></div>

                                                <button class="btn btn-outline-secondary btn-sm add-lecture-btn mt-2">+ Lecture</button>

                                                <div class="button-box hidden">
                                                    <div class="d-flex flex-wrap justify-content-start">
                                                        <button class="btn btn-outline-dark btn-sm lecture-article mt-3 mx-1">
                                                            <i class="fas fa-file-alt mx-1"></i> Article
                                                        </button>
                                                        <button class="btn btn-outline-dark btn-sm lecture-video mt-3 mx-1">
                                                            <i class="fas fa-file-video mx-1"></i> Video
                                                        </button>
                                                        <button class="btn btn-outline-dark btn-sm lecture-resource mt-3 mx-1">
                                                            <i class="fas fa-file-pdf mx-1"></i> Resource
                                                        </button>
                                                        <button class="btn btn-outline-dark btn-sm lecture-material mt-3 mx-1">
                                                            <i class="fas fa-file-download mx-1"></i> Material
                                                        </button>
                                                        <button class="btn btn-outline-dark btn-sm lecture-survey mt-3 mx-1">
                                                            <i class="fas fa-file-signature mx-1"></i> Survey
                                                        </button>
                                                        <button class="btn btn-outline-dark btn-sm lecture-assignment mt-3 mx-1">
                                                            <i class="fas fa-file-upload mx-1"></i> Assignment
                                                        </button>
                                                        <button class="btn btn-outline-dark btn-sm lecture-quiz mt-3 mx-1">
                                                            <i class="fas fa-clock mx-1"></i> Quiz
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template id="article_inputs">
                                    <div class="inputs lecture-wrapper">
                                        <input type="hidden" class="lecture-type" name="article" value="article">
                                        <div class="d-flex justify-content-between mb-1">
                                            <h6>Lecture <span class="lecture-number">1</span>:</h6>
                                            <a class="lecture-trash"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                        <input type="text" class="form-control mb-2" name="title" placeholder="Enter lecture title">
                                        <label>The Content</label>
                                        <textarea class="form-control mb-2" name="content" placeholder="Enter text content"></textarea>
                                    </div>
                                </template>

                                <template id="video_inputs">
                                    <div class="inputs lecture-wrapper">
                                        <input type="hidden" class="lecture-type" name="video" value="video">
                                        <div class="d-flex justify-content-between mb-1">
                                            <h6>Lecture <span class="lecture-number">1</span>:</h6>
                                            <a class="lecture-trash"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                        <input type="text" class="form-control mb-2" name="title" placeholder="Enter lecture title">
                                        <label>Lecture Video URL</label>
                                        <input type="text" class="form-control mb-2" name="video_url" placeholder="Enter video URL">
                                        <label>Lecture Description</label>
                                        <input type="text" class="form-control mb-2" name="description" placeholder="Enter video URL">
                                    </div>
                                </template>
                            </div>
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
                                <label for="course_price" class="pb-1">Course Price</label>
                                <select class="form-select" aria-label="select" id="course_price" name="course_price" required>
                                    <option value="0.00" {{ $course->price == 0.00 ? 'selected' : '' }}>Select the course price</option>
                                    <option value="0.00" {{ $course->price == 0.00 ? 'selected' : '' }}>Free</option>
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
                                <input type="text" class="form-control" id="course_coupon" name="course_coupon" placeholder="Enter coupon code">
                            </div>
                            <div class="form-group pt-4">
                                <label for="discount_amount" class="pb-1">Discount Amount (%)</label>
                                <input type="number" class="form-control" id="discount_amount" name="discount_amount" placeholder="Enter discount percentage">
                            </div>
                            <div class="form-group pt-4">
                                <label for="coupon_start_date" class="pb-1">Coupon Start Date</label>
                                <input type="date" class="form-control" id="coupon_start_date" name="coupon_start_date">
                            </div>
                            <div class="form-group pt-4">
                                <label for="coupon_end_date" class="pb-1">Coupon End Date</label>
                                <input type="date" class="form-control" id="coupon_end_date" name="coupon_end_date">
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
                                <textarea class="form-control" id="welcome_message" name="welcome_message" rows="4" placeholder="Insert welcome message ..."></textarea>
                            </div>
                            <div class="form-group pt-4">
                                <label for="congratulations_message" class="pb-1">Congratulations Message</label>
                                <textarea class="form-control" id="congratulations_message" name="congratulations_message" rows="4" placeholder="Insert congratulations message ..."></textarea>
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
                    <button class="btn btn-back">Save</button>
                </div>
                <div class="col-auto">
                    <button class="btn btn-next">Publish</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nextButton = document.querySelector('.btn-back');
            const additionalInfoForm = document.getElementById('courseForm');

            nextButton.addEventListener('click', function () {
                additionalInfoForm.submit();
            });
        });
    </script>
@endsection

