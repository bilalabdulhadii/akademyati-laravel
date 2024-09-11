@extends('layouts.step')

@section('title', 'Additional Info')

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
            </div>
            <!-- Progress Container -->
            <div class="step-progress-container">
                <div class="step-progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
    <div class="container">
        <div class="step-content-container p-4 shadow-lg">
            <form action="{{ route('store.additional.info') }}" method="POST" id="infoForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea id="bio" name="bio" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="birth" class="form-label">Date of Birth</label>
                    <input type="date" id="birth" name="birth" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" id="nationality" name="nationality" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="education_level" class="form-label">Education Level</label>
                    {{-- <input type="text" id="education_level" name="education_level" class="form-control"> --}}
                    <select id="education_level" name="education_level" class="form-select form-control">
                        <option value="">Select education level</option>
                        <option value="High School Diploma">High School Diploma</option>
                        <option value="Associate Degree">Associate Degree</option>
                        <option value="Bachelors Degree">Bachelor's Degree</option>
                        <option value="Masters Degree">Master's Degree</option>
                        <option value="Doctoral Degree">Doctoral Degree</option>
                        <option value="Professional Degree">Professional Degree</option>
                        <option value="Postdoctoral Fellowship">Postdoctoral Fellowship</option>
                        <option value="Certificate or Diploma Program">Certificate or Diploma Program</option>
                        <option value="Vocational or Technical Degree">Vocational or Technical Degree</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="major" class="form-label">Major</label>
                    <input type="text" id="major" name="major" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="interests" class="form-label">Interests</label>
                    <textarea id="interests" name="interests" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="language" class="form-label">Language</label>
                    <input type="text" id="language" name="language" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="profile" class="form-label">Profile image</label>
                    <input type="file" id="profile" name="profile" class="form-control">
                </div>
            </form>
        </div>
    </div>

    <div class="step-bottombar">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <form action="{{ route('skip-additional-info') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-back">skip</button>
                    </form>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-next">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nextButton = document.querySelector('.btn-next');
            const additionalInfoForm = document.getElementById('infoForm');

            nextButton.addEventListener('click', function () {
                additionalInfoForm.submit();
            });
        });
    </script>
@endsection

