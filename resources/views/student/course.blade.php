@extends('layouts.course')

@section('title', 'Course')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12 content-above-buttons">
                    <div class="card card-round">
                        {{--<div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <h4 class="card-title">Users Geolocation</h4>
                            </div>
                            <p class="card-category">
                                Map of the distribution of users around the world
                            </p>
                        </div>--}}
                        <div class="card-body" style="padding: 0">
                            <div class="video-container" style="border-radius: 10px 10px 0 0">
                                <iframe width="100%" height="100%"
                                        src="https://www.youtube.com/embed/iKWIBL4qD0c?si=ZGEq2nDC9TdWUJKO"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>

                                </iframe>
                            </div>
                            <div class="p-4">

                                <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="line-home-tab" data-bs-toggle="pill"
                                           href="#line-overviews" role="tab" aria-controls="pills-home"
                                           aria-selected="true">Overviews</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill"
                                           href="#line-announcements" role="tab" aria-controls="pills-profile"
                                           aria-selected="false">Announcements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill"
                                           href="#line-reviews" role="tab" aria-controls="pills-contact"
                                           aria-selected="false">Reviews</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill"
                                           href="#line-community" role="tab" aria-controls="pills-contact"
                                           aria-selected="false">Community</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3 mb-3" id="line-tabContent">
                                    <div class="tab-pane fade show active" id="line-overviews" role="tabpanel" aria-labelledby="line-home-tab">
                                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                                            <div>
                                                <h3 class="fw-bold mb-3">CS-GO: Legendary Tactics and Strategies</h3>
                                                <h6 class="op-7 mb-2">Bob Brown</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="line-announcements" role="tabpanel" aria-labelledby="line-profile-tab">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                            ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                            mollit anim id est laborum.</p>
                                    </div>
                                    <div class="tab-pane fade" id="line-reviews" role="tabpanel" aria-labelledby="line-contact-tab">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                            ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                            mollit anim id est laborum.</p>
                                    </div>
                                    <div class="tab-pane fade" id="line-community" role="tabpanel" aria-labelledby="line-contact-tab">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                            ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                            mollit anim id est laborum.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="button-container">
                        <a class="btn btn-info">Next</a>
                        <a class="btn btn-info">Prev</a>
                    </div>
                </div>
            </div>
        </div>
        <style>

        </style>
    </div>
@endsection

