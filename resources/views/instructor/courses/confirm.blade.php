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

    <style>
        .requirement-h {
            color: #696cff;
        }
        .requirement-section {
            margin-bottom: 40px;
        }
        .requirement-section h4 {
            background-color: #f4f4f4;
            padding: 10px;
            border-left: 5px solid #007bff;
            margin: 0;
        }
        .requirement-section p {
            margin: 5px 0 20px;
        }
        .requirement-section ul {
            font-size: 18px;
            line-height: 1.5;
        }
    </style>

    <!-- Content Container -->
    <div class="container">
        <div class="step-content-container">
            <div class="mx-4">
                <h2 class="text-center mt-3 mb-5 requirement-h">Course Review Confirmation</h2>

                <div class="requirement-section">
                    <h4>All Requirements Met</h4>
                    <p>Congratulations! You have met all the requirements for publishing your course.
                        Your course is now ready for submission.</p>

                    <h4>Review Period</h4>
                    <p>By proceeding, your course will be submitted for review. The review process ensures that all content is accurate and meets our quality standards. Please note the following:</p>
                    <ul>
                        <li>Your course will be placed in a review queue, and you will be notified of the status once the review is complete.</li>
                        <li>While your course is under review, you can not make any edits.</li>
                    </ul>

                    <h4>Review and Approval</h4>
                    <p>Make sure you understand the following for the Review and Approval:</p>
                    <ul>
                        <li>Your course will be reviewed by our team.</li>
                        <li>If any additional information or modifications are required, you will be notified.</li>
                    </ul>

                    <p>If you are ready to submit your course for review, click the button below:</p>
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
                    <a type="submit" class="btn btn-next" id="submitReview">Submit For Review</a>
                    <form action="{{ route('courses.confirm.draft') }}" method="post" id="reviewForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('submitReview').addEventListener('click', function() {
                document.getElementById('reviewForm').submit();
            });
        });
    </script>

@endsection

