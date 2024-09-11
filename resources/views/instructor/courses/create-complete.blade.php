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
                    <span>Step 2 of 2</span>
                </div>
                <div class="col-auto">
                    <a href="{{ route('ins.courses') }}" class="btn btn-exit">Exit</a>
                </div>
            </div>
            <!-- Progress Container -->
            <div class="step-progress-container">
                <div class="step-progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="container">
        <div class="step-content-container step-content-container-style2">

            <form id="createCourse" action="{{ route('courses.create') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="margin: 7rem 1.5rem">
                    <h3 class="pb-2 text-center">How many hours per week can you dedicate to creating your course?</h3>
                    <p class="desc-item fs-6 text-center"> There are no right or wrong answers here.
                        We’ll work with whatever time you can offer to help you achieve your goals.</p>

                    <div class="form-check mt-5">
                        <input type="radio" class="form-check-input" id="radio1" name="time_per_week" value="0-2">
                        <label class="form-check-label" for="radio1">I'm very busy right now (0-2 hours)</label>
                    </div>

                    <div class="form-check mt-2">
                        <input type="radio" class="form-check-input" id="radio2" name="time_per_week" value="2-4">
                        <label class="form-check-label" for="radio2">I'll work on this on the side (2-4 hours)</label>
                    </div>

                    <div class="form-check mt-2">
                        <input type="radio" class="form-check-input" id="radio3" name="time_per_week" value="5+">
                        <label class="form-check-label" for="radio3">I have lots of flexibility (5+ hours)</label>
                    </div>

                    <div class="form-check mt-2">
                        <input type="radio" class="form-check-input" id="radio4" name="time_per_week" value="not_decided">
                        <label class="form-check-label" for="radio4">I haven't yet decided if I have time</label>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="step-bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <form action="{{ route('courses.create.back') }}" method="post" id="roleForm"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="back" id="back">
                        <button type="submit" class="btn btn-back">Back</button>
                    </form>
                </div>
                <div class="col-auto">
                    <button class="btn btn-next">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupInputToggle('input[name="time_per_week"]', '.btn-next', 'radio');
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

