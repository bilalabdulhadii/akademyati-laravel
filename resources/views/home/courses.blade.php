@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <style>

    </style>
    <div class="page-wrapper explore-page-container">
        <div class="container-fluid">
            <div class="row d-flex flex-nowrap">
                <div class="filter-menu filter-menu-sticky d-none d-lg-block">
                    <h5 class="mb-2">Explore by Category</h5>
                    <hr>
                    @if($categories->count() > 0)
                        <ul class="filter-categories-list">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug, 'rate' => request()->query('rate')]) }}"
                                       class="filter-categories-item {{ request()->query('category') === $category->slug ? 'active' : '' }}">
                                        {{ $category->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <h5 class="mb-2 mt-5">Best Rated Courses</h5>
                    <hr>
                    <ul class="filter-categories-list">
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['rate' => 'top', 'category' => request()->query('category')]) }}"
                               class="filter-categories-item {{ request()->query('rate') === 'top' ? 'active' : '' }}">
                                4.5 Stars & Up
                            </a>
                        </li>
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['rate' => 'high', 'category' => request()->query('category')]) }}"
                               class="filter-categories-item {{ request()->query('rate') === 'high' ? 'active' : '' }}">
                                4 Stars & Above
                            </a>
                        </li>
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['rate' => 'well', 'category' => request()->query('category')]) }}"
                               class="filter-categories-item {{ request()->query('rate') === 'well' ? 'active' : '' }}">
                                3 Stars & Higher
                            </a>
                        </li>
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['rate' => 'good', 'category' => request()->query('category')]) }}"
                               class="filter-categories-item {{ request()->query('rate') === 'good' ? 'active' : '' }}">
                                2 Stars & Better
                            </a>
                        </li>
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['rate' => 'all', 'category' => request()->query('category')]) }}"
                               class="filter-categories-item {{ request()->query('rate') === 'all' ? 'active' : '' }}">
                                1 Star & Above
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="main-content">
                    <!-- Filter Menu (Collapsible on small screens) -->
                    <div class="filter-menu-collapsible d-lg-none">
                        <button class="btn btn-block text-white" style="background-color: #696cff" type="button" data-toggle="collapse" data-target="#filterMenu" aria-expanded="false" aria-controls="filterMenu">
                            Filters
                        </button>
                        <div class="collapse" id="filterMenu">
                            <div class="filter-menu">
                                <h5 class="mb-2">Explore by Category</h5>
                                <hr>
                                @if($categories->count() > 0)
                                    <ul class="filter-categories-list">
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug, 'rate' => request()->query('rate')]) }}"
                                                   class="filter-categories-item {{ request()->query('category') === $category->slug ? 'active' : '' }}">
                                                    {{ $category->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                <h5 class="mb-2 mt-5">Best Rated Courses</h5>
                                <hr>
                                <ul class="filter-categories-list">
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['rate' => 'top', 'category' => request()->query('category')]) }}"
                                           class="filter-categories-item {{ request()->query('rate') === 'top' ? 'active' : '' }}">
                                            4.5 Stars & Up
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['rate' => 'high', 'category' => request()->query('category')]) }}"
                                           class="filter-categories-item {{ request()->query('rate') === 'high' ? 'active' : '' }}">
                                            4 Stars & Above
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['rate' => 'well', 'category' => request()->query('category')]) }}"
                                           class="filter-categories-item {{ request()->query('rate') === 'well' ? 'active' : '' }}">
                                            3 Stars & Higher
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['rate' => 'good', 'category' => request()->query('category')]) }}"
                                           class="filter-categories-item {{ request()->query('rate') === 'good' ? 'active' : '' }}">
                                            2 Stars & Better
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['rate' => 'all', 'category' => request()->query('category')]) }}"
                                           class="filter-categories-item {{ request()->query('rate') === 'all' ? 'active' : '' }}">
                                            1 Star & Above
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Cards Container -->
                    <div class="card-container main-courses">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <h6 class="ms-2 text-dark">{{ $courses->count() ?? 0 }} results listed</h6>
                            </div>
                        </div>
                        <div class="row d-flex flex-wrap justify-content-start m-0">
                            @if($courses->count() > 0)
                                @foreach($courses as $course)
                                    <div class="card-xxxl-style col-xl-3 col-lg-4 col-md-6 col-sm-12 px-0">
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
                                                    <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                                    <div class="rating">
                                                        <span class="me-2">{{ number_format($course->rating, 1) }}</span>
                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= floor($course->rating))
                                                                    <i class="fas fa-star"></i>
                                                                @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    {{-- <small class="text-secondary">{{ $course->enrollments->count() > 0 ? '('.$course->enrollments->count().' Students)' : '' }}</small> --}}
                                                @if($course->price > 0)
                                                        <div class="price">${{ $course->price }}</div>
                                                    @else
                                                        <div class="price">Free</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if($courses->count() > 0)
                                @foreach($courses as $course)
                                    <div class="card-xxxl-style col-xl-3 col-lg-4 col-md-6 col-sm-12 px-0">
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
                                                    <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                                    <div class="rating">
                                                        <span class="me-2">{{ number_format($course->rating, 1) }}</span>
                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= floor($course->rating))
                                                                    <i class="fas fa-star"></i>
                                                                @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    {{-- <small class="text-secondary">{{ $course->enrollments->count() > 0 ? '('.$course->enrollments->count().' Students)' : '' }}</small> --}}
                                                @if($course->price > 0)
                                                        <div class="price">${{ $course->price }}</div>
                                                    @else
                                                        <div class="price">Free</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if($courses->count() > 0)
                                @foreach($courses as $course)
                                    <div class="card-xxxl-style col-xl-3 col-lg-4 col-md-6 col-sm-12 px-0">
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
                                                    <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                                    <div class="rating">
                                                        <span class="me-2">{{ number_format($course->rating, 1) }}</span>
                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= floor($course->rating))
                                                                    <i class="fas fa-star"></i>
                                                                @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    {{-- <small class="text-secondary">{{ $course->enrollments->count() > 0 ? '('.$course->enrollments->count().' Students)' : '' }}</small> --}}
                                                @if($course->price > 0)
                                                        <div class="price">${{ $course->price }}</div>
                                                    @else
                                                        <div class="price">Free</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- <div class="col-lg-3 d-none  d-lg-block pe-0">
    <!-- Filter Menu (Visible on large screens) -->
    <div class="filter-menu filter-menu-sticky">
        <h4>Filters</h4>
        <!-- Accordion for Category -->
        <div class="accordion" id="categoryAccordionDesktop">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCategoryDesktop">
                    <button class="accordion-button bg-light p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategoryDesktop" aria-expanded="true" aria-controls="collapseCategoryDesktop">
                        Category
                    </button>
                </h2>
                <div id="collapseCategoryDesktop" class="accordion-collapse collapse show" aria-labelledby="headingCategoryDesktop" data-bs-parent="#categoryAccordionDesktop">
                    <div class="accordion-body">
                        @if($categories->count() > 0)
                            <ul class="filter-categories-list">
                                @foreach($categories as $category)
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" name="{{ $category->id }}" type="checkbox" id="{{ $category->id }}">
                                            <label class="form-check-label" for="{{ $category->id }}">
                                                {{ $category->title }}
                                            </label>
                                        </div>
                                        @if($category->children->count() > 0)
                                            <ul class="filter-subcategories-list">
                                                @foreach($category->children as $subCategory)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="{{ $subCategory->id }}" type="checkbox" id="{{ $subCategory->id }}">
                                                            <label class="form-check-label" for="{{ $subCategory->id }}">
                                                                {{ $subCategory->title }}
                                                            </label>
                                                        </div>
                                                        @if($subCategory->children->count() > 0)
                                                            <ul class="filter-subsubcategories-list">
                                                                @foreach($subCategory->children as $subSubCategory)
                                                                    <li>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" name="{{ $subSubCategory->id }}" type="checkbox" id="{{ $subSubCategory->id }}">
                                                                            <label class="form-check-label" for="{{ $subSubCategory->id }}">
                                                                                {{ $subSubCategory->title }}
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                         --}}{{-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="category2">
                            <label class="form-check-label" for="category2">
                                Category 2
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="category3">
                            <label class="form-check-label" for="category3">
                                Category 3
                            </label>
                        </div> --}}{{--
                        <!-- Add more checkboxes as needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion for Price Range -->
        <div class="accordion mt-3" id="priceAccordionDesktop">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPriceDesktop">
                    <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePriceDesktop" aria-expanded="false" aria-controls="collapsePriceDesktop">
                        Price Range
                    </button>
                </h2>
                <div id="collapsePriceDesktop" class="accordion-collapse collapse" aria-labelledby="headingPriceDesktop" data-bs-parent="#priceAccordionDesktop">
                    <div class="accordion-body">
                        <input type="text" class="form-control" id="price" placeholder="e.g., $10 - $50">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-9">
    <div class="main-content">
        <!-- Filter Menu (Collapsible on small screens) -->
        <div class="filter-menu-collapsible d-lg-none">
            <button class="btn btn-block text-white" style="background-color: #696cff" type="button" data-toggle="collapse" data-target="#filterMenu" aria-expanded="false" aria-controls="filterMenu">
                Filters
            </button>
            <div class="collapse" id="filterMenu">
                <div class="filter-menu">
                    <div class="accordion" id="categoryAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingCategory">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                                    Category
                                </button>
                            </h2>
                            <div id="collapseCategory" class="accordion-collapse collapse show" aria-labelledby="headingCategory" data-bs-parent="#categoryAccordion">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="category1">
                                        <label class="form-check-label" for="category1">
                                            Category 1
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="category2">
                                        <label class="form-check-label" for="category2">
                                            Category 2
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="category3">
                                        <label class="form-check-label" for="category3">
                                            Category 3
                                        </label>
                                    </div>
                                    <!-- Add more checkboxes as needed -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion mt-3" id="priceAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPrice">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
                                    Price Range
                                </button>
                            </h2>
                            <div id="collapsePrice" class="accordion-collapse collapse" aria-labelledby="headingPrice" data-bs-parent="#priceAccordion">
                                <div class="accordion-body">
                                    <input type="text" class="form-control" id="price" placeholder="e.g., $10 - $50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cards Container -->
        <div class="card-container main-courses">
            <div class="row">
                @if($courses->count() > 0)
                    @foreach($courses as $course)
                        <div class="card-xxxl-style col-xl-3 col-lg-4 col-md-6 col-sm-12 px-0">
                            <div class="single-cat">
                                <div class="card">
                                    <div class="image-container">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top" alt="Course Image">
                                        @else
                                            <img src="{{ asset('assets/home/images/course_1.png') }}" class="card-img-top" alt="Course Image">
                                        @endif
                                        <div class="add-to-favorite-icon-style1">
                                            <i class="fa fa-bookmark-o"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="course-title">
                                            <a href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" class="card-title">{{ $course->title }}</a>
                                        </div>
                                        <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                        <div class="rating">
                                            <span class="me-2">4.8</span>
                                            <div>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half"></i>
                                            </div>
                                            <span class="ms-2">(2.3M)</span>
                                        </div>
                                        @if($course->price > 0)
                                            <div class="price">${{ $course->price }}</div>
                                        @else
                                            <div class="price">Free</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if($courses->count() > 0)
                    @foreach($courses as $course)
                        <div class="card-xxxl-style col-xl-3 col-lg-4 col-md-6 col-sm-12 px-0">
                            <div class="single-cat">
                                <div class="card">
                                    <div class="image-container">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top" alt="Course Image">
                                        @else
                                            <img src="{{ asset('assets/home/images/course_1.png') }}" class="card-img-top" alt="Course Image">
                                        @endif
                                        <div class="add-to-favorite-icon-style1">
                                            <i class="fa fa-bookmark-o"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="course-title">
                                            <a href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" class="card-title">{{ $course->title }}</a>
                                        </div>
                                        <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                        <div class="rating">
                                            <span class="me-2">4.8</span>
                                            <div>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half"></i>
                                            </div>
                                            <span class="ms-2">(2.3M)</span>
                                        </div>
                                        @if($course->price > 0)
                                            <div class="price">${{ $course->price }}</div>
                                        @else
                                            <div class="price">Free</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if($courses->count() > 0)
                    @foreach($courses as $course)
                        <div class="card-xxxl-style col-xl-3 col-lg-4 col-md-6 col-sm-12 px-0">
                            <div class="single-cat">
                                <div class="card">
                                    <div class="image-container">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top" alt="Course Image">
                                        @else
                                            <img src="{{ asset('assets/home/images/course_1.png') }}" class="card-img-top" alt="Course Image">
                                        @endif
                                        <div class="add-to-favorite-icon-style1">
                                            <i class="fa fa-bookmark-o"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="course-title">
                                            <a href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" class="card-title">{{ $course->title }}</a>
                                        </div>
                                        <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="card-subtitle mb-2 text-muted">{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</a>
                                        <div class="rating">
                                            <span class="me-2">4.8</span>
                                            <div>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half"></i>
                                            </div>
                                            <span class="ms-2">(2.3M)</span>
                                        </div>
                                        @if($course->price > 0)
                                            <div class="price">${{ $course->price }}</div>
                                        @else
                                            <div class="price">Free</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div> --}}
