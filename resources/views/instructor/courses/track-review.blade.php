@php use Carbon\Carbon; @endphp

@extends('layouts.step')

@section('title', 'Reviews')

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
                <div class="text-center">
                    <h2 class="mt-3 mb-5 requirement-h">{{ $course->title }}</h2>
                </div>
                @if($reviews)
                    @php
                        $seenAt = Carbon::parse($reviews->first()->seen_at);
                        $finishedAt = Carbon::parse($reviews->first()->finished_at);
                    @endphp
                @endif
                <table class="table table-bordered mb-5">
                    <tbody>
                        <tr>
                            <th scope="row">Instructor:</th>
                            <td>{{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</td>
                        </tr>
                        @foreach($reviews as $review)
                            <tr>
                                <th scope="row">Created At:</th>
                                <td>{{ $course->created_at->format('F j, Y \a\t H:i') }}</td>
                            </tr>
                            @if($review->status === 'started')
                                <tr>
                                    <th scope="row">Review Started At:</th>
                                    <td>{{ $seenAt->format('F j, Y \a\t H:i') }}</td>
                                </tr>
                            @elseif($review->status === 'rejected')
                                <tr>
                                    <th scope="row">Review Started At:</th>
                                    <td>{{ $seenAt->format('F j, Y \a\t H:i') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Review Finished At:</th>
                                    <td>{{ $finishedAt->format('F j, Y \a\t H:i') }}</td>
                                </tr>
                            @endif
                            @break
                        @endforeach
                    </tbody>
                </table>
                @foreach($reviews as $review)
                    @if($review->status === 'pending')
                        <div class="requirement-section">
                            <h4>Awaiting Review</h4>
                            <p class="mt-3">Your submission is currently in the queue and has not yet been reviewed.
                                We're excited to dive into it soon, so stay tuned for updates!</p>
                        </div>
                    @endif
                    @if($review->status === 'started')
                        <div class="requirement-section">
                            <h4>Under Evaluation</h4>
                            <p class="mt-3">
                                Great news! Your submission is now under active review.
                                Our team is carefully evaluating it to ensure everything is in top shape.
                                We’ll reach out with feedback as soon as possible.
                            </p>
                        </div>
                    @endif
                    @if($review->status === 'rejected')
                        <div class="requirement-section">
                            <h4>Submission Rejected</h4>
                            <p class="mt-3">
                                We’ve completed our review of your submission,
                                and unfortunately, it has been rejected. Please review the provided
                                feedback to understand the reasons and necessary steps for improvement.
                                We’re here to help you refine and resubmit.
                            </p>
                        </div>

                        <h4>Provided Feedback</h4>
                        <div class="form-control mb-2 fr-view p-3" id="feedback">
                            {!! $review->feedback ?? '' !!}
                        </div>
                    @endif
                    @break
                @endforeach

                <hr class="my-5">
                @if($reviews->count() > 1)
                    <div class="requirement-section mt-5">
                        <h4 class="mb-4">Old Feedbacks</h4>
                        @php $counter = $reviews->count() - 1; @endphp
                        @foreach($reviews->skip(1) as  $review)
                            <h6><b>Feedback {{ $counter }}:</b></h6>
                            <div class="form-control mb-5 fr-view p-3" id="feedback">
                                {!! $review->feedback ?? '' !!}
                            </div>
                            @php $counter--; @endphp
                        @endforeach
                    </div>
                @endif

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
                </div>
            </div>
        </div>
    </div>

@endsection

