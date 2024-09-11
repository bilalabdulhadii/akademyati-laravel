@extends('layouts.step')

@section('title', 'Publish Requirements')

@section('content')
    <!-- Topbar -->
    <div class="step-topbar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <img src="{{ asset('assets/step/images/logo.png') }}" alt="Logo">
                </div>
                <div class="col-auto">
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="container">
        <div class="step-content-container">
            <div class="mx-4">
                <h2 class="text-center mt-3 mb-5 requirement-h">Course Publishing Requirements</h2>

                <div class="requirement-section">
                    <h4>Course Essentials</h4>
                    <p>Ensure the following are filled in the Course Essentials tab:</p>
                    <ul>
                        <li><strong>Title:</strong> The name of the course.</li>
                        <li><strong>Subtitle:</strong> A brief description or tagline for the course.</li>
                        <li><strong>Description:</strong> At least 100 words detailed overview of what the course covers.</li>
                        <li><strong>Category:</strong> The category or subject area the course falls under.</li>
                        <li><strong>Level:</strong> The difficulty level of the course.</li>
                        <li><strong>Language:</strong> The language in which the course is taught.</li>
                    </ul>
                </div>

                <div class="requirement-section">
                    <h4>Audience & Goals</h4>
                    <p>Ensure the following are included in the Course Audience & Goals tab:</p>
                    <ul>
                        <li><strong>Objectives:</strong> At least 3 learning objectives. </li>
                        <li><strong>Audience:</strong> Describe the target audience. </li>
                    </ul>
                </div>

                <div class="requirement-section">
                    <h4>Promotional Content</h4>
                    <p>Ensure the following are included in the Course Promotional Content tab:</p>
                    <ul>
                        <li><strong>Thumbnail:</strong> A visual representation of the course.</li>
                        <li><strong>Promotional Video:</strong> An short video that promotes the course.</li>
                    </ul>
                </div>

                <div class="requirement-section">
                    <h4>Curriculum Design</h4>
                    <p>Ensure the following are included in the Course Curriculum Design tab:</p>
                    <ul>
                        <li><strong> Sections:</strong> At least 3 sections must be and each section should cover a distinct part of the course material.</li>
                        <li><strong> Lectures:</strong> In total more than 10 of lectures in various formats (articles, videos, etc.).</li>
                    </ul>
                </div>

                <div class="requirement-section">
                    <h4>Pricing</h4>
                    <p>Ensure the following are included in the Course Pricing tab:</p>
                    <ul>
                        <li><strong>Price:</strong> The cost of the course, if applicable.</li>
                    </ul>
                </div>
            </div>


        </div>
    </div>


    <div class="step-bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <a href="{{route('ins.courses')}}" class="btn btn-outline-dark">Exit</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('courses.edit.version', ['id' => $course_id]) }}" type="submit" class="btn btn-next">Edit Course</a>
                </div>
            </div>
        </div>
    </div>

@endsection

