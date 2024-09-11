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
                <div class="col-auto">
                    <span>Step 1 of 2</span>
                </div>
                <div class="col-auto">
                    <a href="{{ route('ins.courses') }}" class="btn btn-exit">Exit</a>
                </div>
            </div>
            <!-- Progress Container -->
            <div class="step-progress-container">
                <div class="step-progress-bar" style="width: 50%;"></div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="container">
        <div class="step-content-container step-content-container-style2 text-center">

            <form id="createCourse" action="{{ route('courses.create.complete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-5 mx-5">
                    <h3 class="pb-2">What do you think of a working title?</h3>
                    <p class="desc-item fs-6"> If you’re unsure, You can update it later.</p>
                    <input type="text" class="form-control mt-3 course-title" name="course_title"
                           id="course_title" value="{{ $title ?? '' }}" placeholder="e.g. Introduction to Programming">
                </div>

                <div class="form-group mx-5 mb-5" style="margin-top: 7rem">
                    <h3 class="pb-2">Which category best represents the content you'll provide?</h3>
                    <p class="desc-item fs-6"> If you're not sure about the right category,
                        you can change it later.</p>
                    <select class="form-select" aria-label="select" id="course_category" name="course_category">
                        <option value="" {{ $category_id == '' ? 'selected' : ''}}>Select Category</option>
                        @if($categories->count() > 0)
                            @foreach($categories as $category)
                                @if($category->level == 1)
                                    <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : ''}}>{{ $category->title }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </form>

        </div>
    </div>

    <div class="step-bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    {{--<button class="btn btn-back">Back</button>--}}
                </div>
                <div class="col-auto">
                    <button class="btn btn-next" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupInputToggle('.course-title', '.btn-next', 'text');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nextButton = document.querySelector('.btn-next');
            const additionalInfoForm = document.getElementById('createCourse');

            nextButton.addEventListener('click', function () {
                additionalInfoForm.submit();
            });
        });
    </script>
@endsection

