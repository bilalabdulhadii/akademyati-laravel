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
            </div>
            <!-- Progress Container -->
            <div class="step-progress-container">
                <div class="step-progress-bar" style="width: 50%;"></div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="container">
        <div class="step-content-container">
            <h3>How Do You Want to Change the World Today ?</h3>

            <div class="card-container step-card-container row mt-4">
                <!-- Student Card -->
                <div class="col-md-6 col-6 mb-4">
                    <div class="card step-card" data-role="student">
                        <img src="{{ asset('assets/step/images/student-profile.png') }}" class="card-img-top step-card-img-top"
                             alt="Student Image">
                        <div class="card-body step-card-body">
                            <h5 class="card-title">Student</h5>
                            <p class="card-text">Explore new knowledge and build your future.</p>
                        </div>
                    </div>
                </div>

                <!-- Instructor Card -->
                <div class="col-md-6 col-6 mb-4">
                    <div class="card step-card" data-role="instructor">
                        <img src="{{ asset('assets/step/images/instructor-profile.png') }}" class="card-img-top step-card-img-top"
                             alt="Instructor Image">
                        <div class="card-body step-card-body">
                            <h5 class="card-title">Instructor</h5>
                            <p class="card-text">Share your expertise and inspire the next generation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottombar -->
    {{--<div class="bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    --}}{{--<button class="btn btn-back">Back</button>--}}{{--
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-next">Next</button>
                </div>
            </div>
        </div>
    </div>--}}

    <div class="step-bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    {{--<button class="btn btn-back">Back</button>--}}
                </div>
                <div class="col-auto">
                    <form action="{{ route('store-basic-info') }}" method="post" id="roleForm"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="role" id="selectedRole">
                        <button type="submit" class="btn btn-next" disabled>Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.card');
            const nextButton = document.querySelector('.btn-next');
            const selectedRoleInput = document.getElementById('selectedRole');

            cards.forEach(card => {
                card.addEventListener('click', function () {
                    // Toggle the selected class
                    this.classList.toggle('selected');

                    // Ensure only one card is selected at a time
                    let selectedRole = null;
                    cards.forEach(otherCard => {
                        if (otherCard !== this) {
                            otherCard.classList.remove('selected');
                        } else if (this.classList.contains('selected')) {
                            selectedRole = this.getAttribute('data-role');
                        }
                    });

                    // Enable or disable the next button based on selection
                    if (selectedRole) {
                        nextButton.disabled = false;
                        // Set the selected role in the hidden input field
                        selectedRoleInput.value = this.getAttribute('data-role');
                    } else {
                        nextButton.disabled = true;
                    }
                });
            });

            /*nextButton.addEventListener('click', function() {
                const selectedCard = document.querySelector('.card.selected');
                if (selectedCard) {
                    const selectedRole = selectedCard.getAttribute('data-role');
                    if (selectedRole === 'student') {
                        window.location.href = ';
                    } else if (selectedRole === 'instructor') {
                        window.location.href = '';
                    }
                }
            });*/
            // Initially disable the next button
            nextButton.disabled = true;
        });
    </script>

@endsection

