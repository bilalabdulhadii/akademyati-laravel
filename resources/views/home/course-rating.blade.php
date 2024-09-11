
@extends('layouts.app')

@section('title', 'Course Details')

@section('content')

    <div class="page-wrapper single-course-container" style="min-height: 90vh">
        <div class="course-basic-details-1">
            <div class="container">
                <!-- Main Info Section -->
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <div class="d-flex me-4">
                                    <a class="d-flex align-items-center justify-content-center text-white border-white border rounded-2 text-decoration-none fs-4 p-3"
                                       href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <p class="category-title">
                                        {{ $course->category_id ? $course->category->title : '' }}
                                        @if($course->subcategory_id)
                                            > {{ $course->subcategory->title }}
                                        @endif
                                        @if($course->subsubcategory_id)
                                            > {{ $course->subsubcategory->title}}
                                        @endif
                                    </p>
                                    <p class="course-title">{{ $course->title }}</p>
                                    <p class="course-subtitle">{{ $course->subtitle }}</p>
                                    <p class="created-by"><em>Created By: </em>
                                        <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="instructor-name">
                                            Dr. {{ $course->instructor->first_name }} {{ $course->instructor->last_name }},
                                            {{ $course->instructor->professional_title }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container course-rating-container">
            @if($enrollment)
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        @if(!$enrollment->has_rate)
                            <div class="course-rating-input">
                                <form action="{{ route('course.index.rating.store', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" method="post">
                                    @csrf
                                    <h4>Share your rating and inspire others!</h4>
                                    <label class="mt-4 form-label">Rating</label>
                                    <div class="rating">
                                        <input type="number" name="rating_value" hidden required>
                                        <div class="rating-stars">
                                            <i class='far fa-star star' style="--i: 0;"></i>
                                            <i class='far fa-star star' style="--i: 1;"></i>
                                            <i class='far fa-star star' style="--i: 2;"></i>
                                            <i class='far fa-star star' style="--i: 3;"></i>
                                            <i class='far fa-star star' style="--i: 4;"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="rating_comment" class="form-label">Comment</label>
                                        <textarea name="rating_comment" class="form-control" rows="4" placeholder="Type your comment here ..."></textarea>
                                    </div>
                                    <button type="submit">Rate</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="course-rating-header">
                        <div>
                            <span class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($course->rating))
                                        <i class="fas fa-star"></i>
                                    @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </span>{{ number_format($course->rating, 1) }}
                        </div>
                        <span>{{ $ratings->count() ?? 0 }} Ratings</span>
                        <span>{{ $course->enrollments->count() > 0 ? $course->enrollments->count().' Students Enroll' : 'No Enrolls' }}</span>
                    </div>
                    <div class="course-rating-body">
                        @if($enrollment)
                            @if($enrollment->has_rate)
                                <div class="course-rating-update">
                                    <div>
                                    <span class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $student_rate->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>{{ $student_rate->rating }}
                                    </div>
                                    <p>{{ $student_rate->student->first_name }} {{ $student_rate->student->last_name }} - {{ $student_rate->updated_at->format('d M Y') }}</p>
                                    @if($student_rate->comment)
                                        <p>{{ $student_rate->comment }}</p>
                                    @endif
                                    <a class="course-rating-edit-btn" data-bs-toggle="modal" data-bs-target="#ratingEditModal"><i class="far fa-edit"></i></a>
                                    <!-- Edit Modal Start -->
                                    <div class="modal fade" id="ratingEditModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ratingEditModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="d-flex justify-content-between p-3">
                                                    <h1 class="modal-title fs-5" id="ratingEditModalLabel"></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="px-4">
                                                        <div class="course-rating-input mt-0">
                                                            <form action="{{ route('course.index.rating.store', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" method="post">
                                                                @csrf
                                                                <h4>Share your rating and inspire others!</h4>
                                                                <label class="mt-4 form-label">Rating</label>
                                                                <div class="rating">
                                                                    <input type="number" name="rating_value" hidden required>
                                                                    <div class="rating-stars">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <= $student_rate->rating)
                                                                                    <i class='fas fa-star star active' style="--i: 0;"></i>
                                                                                @else
                                                                                    <i class='far fa-star star' style="--i: 0;"></i>
                                                                                @endif
                                                                            @endfor
                                                                        @endfor
                                                                        {{-- <i class='far fa-star star' style="--i: 0;"></i>
                                                                        <i class='far fa-star star' style="--i: 1;"></i>
                                                                        <i class='far fa-star star' style="--i: 2;"></i>
                                                                        <i class='far fa-star star' style="--i: 3;"></i>
                                                                        <i class='far fa-star star' style="--i: 4;"></i> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="rating_comment" class="form-label">Comment</label>
                                                                    <textarea name="rating_comment" class="form-control" rows="4" placeholder="Type your comment here ...">{{ $student_rate->comment ?? ''}}</textarea>
                                                                </div>
                                                                <button type="submit">Rate</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Modal End -->
                                </div>
                            @endif
                        @endif
                        @if($ratings->count() > 0)
                            @foreach($ratings as $index => $rate)
                                <div class="course-rating-item">
                                    <div>
                                        <span class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rate->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </span>{{ $rate->rating }}
                                    </div>
                                    <p>{{ substr($rate->student->first_name, 0, 1) }}**** {{ substr($rate->student->last_name, 0, 1) }}**** - {{ $rate->updated_at->format('d M Y') }}</p>
                                    @if($rate->comment)
                                        <p>{{ $rate->comment }}</p>
                                    @endif
                                    @if($index != ($ratings->count() - 1))
                                        <hr>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        const allStar = document.querySelectorAll('.rating .star');
        const ratingValue = document.querySelector('.rating input');

        allStar.forEach((item, idx) => {
            item.addEventListener('click', function () {
                let click = 0;
                ratingValue.value = idx + 1;

                allStar.forEach(i => {
                    i.classList.replace('fas', 'far');
                    i.classList.remove('active');
                });
                for (let i = 0; i < allStar.length; i++) {
                    if (i <= idx) {
                        allStar[i].classList.replace('far', 'fas');
                        allStar[i].classList.add('active');
                    } else {
                        allStar[i].style.setProperty('--i', click);
                        click++;
                    }
                }
            });
        });
    </script> --}}
    {{-- <div class="row d-flex justify-content-center">
            <div class="col-lg-3">
                <div class="course-rating-container">
                    <form action="{{ route('rate') }}" method="post">
                        @csrf
                        <div class="rating">
                            <input type="number" name="rating" hidden>
                            <i class='far fa-star star' style="--i: 0;"></i>
                            <i class='far fa-star star' style="--i: 1;"></i>
                            <i class='far fa-star star' style="--i: 2;"></i>
                            <i class='far fa-star star' style="--i: 3;"></i>
                            <i class='far fa-star star' style="--i: 4;"></i>
                        </div>
                        <button type="submit" class="btn btn-outline-dark">Rate</button>
                    </form>
                </div>
            </div>
        </div> --}}
@endsection
