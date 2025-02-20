@extends('layouts.app')

@section('title', 'Akademyati')

@section('content')
    <!-- ***** Preloader Start ***** -->
     <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <div class="special-container">
        <div class="home-header">
            <div class="main-banner">
                <div class="row h-100 d-flex justify-content-start">
                    <div class="col-lg-6">
                        <div class="header-text mt-5 pt-5">
                            <h6>Welcome To AKADEMYATI - Let's Try</h6>
                            <h4><em>Empowering</em> Your Future <br> with Knowledge</h4>
                            <div class="main-button">
                                <a href="{{ route('courses.index') }}" class="main-button-swap">Browse Now <span>Browse → </span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="upcoming-section">
        <div class="upcoming-events">
            <div class="event">
                <div class="event-info">
                    <h3>Upcoming Our <b>Future of AI in Education</b> Course!</h3>
                    <p>Designed for educators looking to integrate technology into their teaching methods.</p>
                </div>
                <div class="event-timer user-select-none" id="timer1">
                </div>
            </div>
        </div>
    </div>

    <!-- Start New Arrival Certificates Area -->
    <div class="new-arrival-container mt-5">
        <div class="new-arrival py-5">
            <div class="heading-section">
                <h4><em>New Arrival </em> Certificates</h4>
            </div>
            <div class="cards-container">
                <div class="new-arrival-card">
                    {{-- <img src="{{ asset('assets/home/images/web-dev.png') }}" alt="Course 1 Image"> --}}
                    <div class="new-arrival-card-content">
                        <h3>Advanced Web Development</h3>
                        <p>Master the latest technologies in web development.</p>
                    </div>
                </div>
                <div class="new-arrival-card">
                    {{-- <img src="{{ asset('assets/home/images/machine-learning.png') }}" alt="Course 3 Image"> --}}
                    <div class="new-arrival-card-content">
                        <h3>Machine Learning Fundamentals</h3>
                        <p>Explore the basics of machine learning algorithms.</p>
                    </div>
                </div>
                {{-- <div class="new-arrival-card">
                     --}}{{-- <img src="{{ asset('assets/home/images/mobile-dev.png') }}" alt="Course 2 Image"> --}}{{--
                    <div class="new-arrival-card-content">
                        <h3>Mobile App Development</h3>
                        <p>Build native apps for iOS and Android platforms.</p>
                    </div>
                </div>
                 <div class="new-arrival-card">
                     --}}{{-- <img src="{{ asset('assets/home/images/data-science.png') }}" alt="Course 4 Image"> --}}{{--
                    <div class="new-arrival-card-content">
                        <h3>Data Science with Python</h3>
                        <p>Explore data analysis and machine learning with Python.</p>
                    </div>
                </div> --}}
            </div>
            {{-- <a href="{{ route('home') }}" class="view-all-button">View All <span>→</span></a> --}}
        </div>
    </div>
    <!-- /End New Arrival Certificates Area -->


    <!-- Start Featured Courses Area -->
    <div class="special-container">
        <section class="main-courses-slider">
            <div class="heading-section d-flex justify-content-between">
                <h4><em>Featured </em> Courses</h4>
                <a href="{{ route('courses.index') }}">view all <span>→</span></a>
            </div>
            <div class="cat-inner">
                <div class="col-12 p-0">
                    <div class="category1-slider">
                        @if($courses->count() > 0)
                            @foreach($courses as $course)
                                <div class="single-cat">
                                    <div class="card">
                                        <div class="image-container">
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top" alt="Course Image">
                                            @else
                                                <img src="{{ asset('assets/home/images/course_1.png') }}" class="card-img-top" alt="Course Image">
                                            @endif
                                            @if(Auth::check() && Auth::user()->hasRole('student'))
                                                <form action="{{ route('course.bookmark') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    @if($course->isBookmarked($course->id))
                                                        <div class="add-to-favorite-icon-filled">
                                                            <button type="submit"><i class="fa fa-bookmark"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="add-to-favorite-icon-empty">
                                                            <button type="submit"><i class="fa fa-bookmark-o"></i></button>
                                                        </div>
                                                    @endif
                                                </form>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="course-title">
                                                <a href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" class="card-title">{{ $course->title }}</a>
                                            </div>
                                            <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}"  class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                            <div class="rating">
                                                <span class="me-2">{{ number_format($course->rating, 1) }}</span>
                                                <a class="text-decoration-none" href="{{ route('course.index.rating', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($course->rating))
                                                            <i class="fas fa-star"></i>
                                                        @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </a>
                                                <span class="ms-2">({{ $course->enrollments->count() > 0 ? $course->enrollments->count().' Students' : '' }})</span>
                                            </div>
                                            @if($course->price > 0)
                                                <div class="price">${{ $course->price }}</div>
                                            @else
                                                <div class="price">Free</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /End Featured Courses Area -->

    <!-- Start Top-Rated Courses Area -->
    <div class="special-container">
        <section class="main-courses-slider">
            <div class="heading-section d-flex justify-content-between">
                <h4><em>Top-Rated </em> Courses</h4>
                <a href="{{ route('courses.index') }}">view all <span>→</span></a>
            </div>
            <div class="cat-inner">
                <div class="col-12 p-0">
                    <div class="category2-slider">
                        @if($courses->count() > 0)
                            @foreach($courses->reverse() as $course)
                                <div class="single-cat">
                                    <div class="card">
                                        <div class="image-container">
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top" alt="Course Image">
                                            @else
                                                <img src="{{ asset('assets/home/images/course_1.png') }}" class="card-img-top" alt="Course Image">
                                            @endif
                                            @if(Auth::check() && Auth::user()->hasRole('student'))
                                                <form action="{{ route('course.bookmark') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    @if($course->isBookmarked($course->id))
                                                        <div class="add-to-favorite-icon-filled">
                                                            <button type="submit"><i class="fa fa-bookmark"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="add-to-favorite-icon-empty">
                                                            <button type="submit"><i class="fa fa-bookmark-o"></i></button>
                                                        </div>
                                                    @endif
                                                </form>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="course-title">
                                                <a href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" class="card-title">{{ $course->title }}</a>
                                            </div>
                                            <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}"  class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                            <div class="rating">
                                                <span class="me-2">{{ number_format($course->rating, 1) }}</span>
                                                <a class="text-decoration-none" href="{{ route('course.index.rating', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($course->rating))
                                                            <i class="fas fa-star"></i>
                                                        @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </a>
                                                <span class="ms-2">({{ $course->enrollments->count() > 0 ? $course->enrollments->count().' Students' : '' }})</span>
                                            </div>
                                            @if($course->price > 0)
                                                <div class="price">${{ $course->price }}</div>
                                            @else
                                                <div class="price">Free</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /End Top-Rated Courses Area -->

    <!-- Start trending-topics Area -->
    <div class="trending-topics-container">
        <div class="trending-topics">
            <div class="heading-section">
                <h4><em>Trending Topics</em> Topics</h4>
            </div>
            <div class="categories-container">
                <div class="category-box">
                    <h3>Artificial Intelligence</h3>
                    <div class="subcategories">
                        <span>Machine Learning</span>, <span>Deep Learning</span>, <span>Neural Networks</span>
                    </div>
                </div>
                <div class="category-box">
                    <h3>Web Development</h3>
                    <div class="subcategories">
                        <span>HTML</span>, <span>CSS</span>, <span>JavaScript</span>
                    </div>
                </div>
                <div class="category-box">
                    <h3>Data Science</h3>
                    <div class="subcategories">
                        <span>Data Analysis</span>, <span>Machine Learning</span>, <span>Data Visualization</span>
                    </div>
                </div>
                <div class="category-box">
                    <h3>Graphic Design</h3>
                    <div class="subcategories">
                        <span>Adobe Photoshop</span>, <span>Illustrator</span>, <span>UI/UX Design</span>
                    </div>
                </div>
                <div class="category-box">
                    <h3>Business & Finance</h3>
                    <div class="subcategories">
                        <span>Marketing</span>, <span>Accounting</span>, <span>Entrepreneurship</span>
                    </div>
                </div>
                <div class="category-box">
                    <h3>Languages</h3>
                    <div class="subcategories">
                        <span>English</span>, <span>Spanish</span>, <span>Mandarin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start trending-topics Area -->

    <!-- Main Banner Upcoming Countdown start -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function countdown(eventId, eventDate) {
                const timerElement = document.getElementById(eventId);
                const countDownDate = new Date(eventDate).getTime();

                const interval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    /*const seconds = Math.floor((distance % (1000 * 60)) / 1000);*/

                    /*timerElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;*/
                    timerElement.innerHTML = `${days}d ${hours}h ${minutes}m`;

                    if (distance < 0) {
                        clearInterval(interval);
                        timerElement.innerHTML = "EXPIRED";
                    }
                }, 1000);
            }

            countdown("timer1", "2024-09-10T00:00:00");
        });
    </script>
    <!-- Main Banner Upcoming Countdown end -->
@endsection
