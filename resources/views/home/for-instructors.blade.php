
@extends('layouts.app')

@section('title', 'For Instructors')

@section('content')

    <style>

    </style>
    <div class="special-container">
        <div class="home-header">
            <div class="instructor-banner">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="header-text mt-5 pt-5">
                            <h6>Welcome To AKADEMYATI</h6>
                            <h4 class="mb-0"><em>Your Expertise, </em> Their Future</h4>
                            <h6 class="text-secondary">Join a community of passionate educators shaping the future together.</h6>
                            <div class="main-button">
                                <a href="{{ route('register') }}" class="main-button-swap">Join Us <span>Join → </span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="for-ins-container-why">
            <div class="row">
                <h2 class="text-dark">Why Teach with Us</h2>
                <div class="col-lg-4">
                    <div class="ins-section-item m-lg-4 d-flex flex-column justify-content-between align-items-center">
                        <img src="{{ asset('assets/home/images/global.png') }}" alt="global">
                        <h5 class="mb-3 text-primary">Global Classroom</h5>
                        <p>Expand your impact by reaching and inspiring students from every corner of the globe, all from the comfort of your own space.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ins-section-item m-lg-4 d-flex flex-column justify-content-between align-items-center">
                        <img src="{{ asset('assets/home/images/expertise.png') }}" alt="expertise">
                        <h5 class="mb-3 text-primary">Your Expertise, Your Way</h5>
                        <p>Shape your teaching journey with full control over your courses, schedule, and content, empowering you to share your expertise on your own terms.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ins-section-item m-lg-4 d-flex flex-column justify-content-between align-items-center">
                        <img src="{{ asset('assets/home/images/passion.png') }}" alt="passion">
                        <h5 class="mb-3 text-primary">Empower Your Passion</h5>
                        <p>Transform your passion into a powerful educational experience, earning income while making a lasting difference in the lives of learners.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-light">
        <div class="container">
            <div class="for-ins-container-community p-3">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="{{ asset('assets/home/images/features.png') }}" alt="features">
                    </div>
                    <div class="col-lg-6 community-details">
                        <h4>Join the Community</h4>
                        <p>
                            Join our vibrant community of passionate instructors and educators,
                            where collaboration and knowledge-sharing thrive. Connect with
                            fellow professionals, access a wealth of exclusive resources,
                            participate in live workshops, and engage in meaningful discussions.
                            Our platform offers opportunities to network with industry leaders,
                            exchange innovative teaching strategies, and elevate your skills.
                            Be a part of a supportive community that values growth, creativity,
                            and the power of education. Together, we can shape the future of learning.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container for-ins-container-how">
        <h2 class="text-dark timeline-top-header text-center">How It Works</h2>
        <div class="timeline">
            <div class="timeline-row">
                <div class="timeline-time">
                    Launchpad
                </div>
                <div class="timeline-content">
                    <i class="fas fa-check"></i>
                    <h4>Sign Up and Create Your Profile</h4>
                    <p>Register easily with your credentials, and set up a professional profile that showcases your expertise and teaching style. Let students know who you are and what they can expect.</p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-time">
                    Blueprint
                </div>
                <div class="timeline-content">
                    <i class="far fa-file-alt"></i>
                    <h4>Design Your Course</h4>
                    <p>
                        Use our intuitive course builder to design engaging lessons, videos, and assessments. Whether it’s a single lecture or a full curriculum, you’re in control of how you teach.
                    </p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-time">
                    Elevate
                </div>
                <div class="timeline-content">
                    <i class="fas fa-rocket"></i>
                    <h4>Publish and Reach Students</h4>
                    <p>Once your course is ready, publish it to our platform and start reaching students worldwide. Promote your course and watch your teaching community grow as learners enroll.</p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-time">
                    Influence
                </div>
                <div class="timeline-content">
                    <i class="far fa-gem"></i>
                    <h4>Engage and Earn</h4>
                    <p>Interact with students through Q&A sessions, feedback, and assignments. As your course gains traction, earn revenue from enrollments and impact lives with your knowledge.</p>
                </div>
            </div>
        </div>
    </div>

@endsection
