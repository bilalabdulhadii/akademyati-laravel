@extends('layouts.educator')

@section('title', 'Courses Overview')

@section('content')
    <div class="container">
        <div class="page-inner mx-5">
            <div class="container">
                <div class="overview-filter-bar-container mb-3">
                    <button class="arrow left hidden-arrows" id="overviewLeftArrow">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="overview-filter-bar">
                        @foreach(['all' => 'All', 'newest' => 'Newest', 'oldest' => 'Oldest' , 'draft' => 'Draft', 'underreview' => 'Under-Review', 'accepted' => 'Accepted', 'unpublished' => 'Unpublished', 'published' => 'Published', 'rejected' => 'Rejected'] as $filterValue => $filterLabel)
                            <div class="overview-filter-tab {{ request()->query('filter') === $filterValue || (!request()->query('filter') && $filterValue === 'all') ? 'active' : '' }}" data-filter="{{ $filterValue }}">
                                <a href="{{ url()->current() }}?filter={{ $filterValue }}" class="{{ request()->query('filter') === $filterValue || (!request()->query('filter') && $filterValue === 'all') ? 'active' : '' }}">{{ $filterLabel }}</a>
                            </div>
                        @endforeach
                    </div>
                    <button class="arrow right hidden-arrows" id="overviewRightArrow">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="d-flex flex-column flex-md-row align-items-md-center pb-4">
                    <!-- Search Input -->
                    <div class="flex-grow-1 me-md-3 mb-3 mb-md-0">
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <!-- Button Group -->
                    <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                        {{--<a href="#" class="btn btn-label-info flex-fill">Analysis</a>--}}
                        <a type="submit" id="createButton" class="btn btn-primary flex-fill">New Course</a>

                        <form id="createCourseForm" class="d-none" action="{{ route('courses.create.basic') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="create" id="create">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-5">
                        <h3 class="ms-2 mb-4"> First Version Drafts</h3>
                        <div class="card-body">
                            @if($courseVersions->count() > 0)
                                @foreach ($courseVersions as  $courseDraft)
                                    <div class="course-ins-card bg-white mb-3" data-status="{{  $courseDraft->status }}" data-timestamp="{{  $courseDraft->created_at }}">
                                        {{--<div class="status-badge">
                                            {{  $courseDraft->status }}
                                        </div>--}}
                                        <div class="card-img">
                                            @if($courseDraft->thumbnail)
                                                <img src="{{ Storage::url($courseDraft->thumbnail) }}" alt="Course image">
                                            @else
                                                <img src="{{ asset('dash/assets/img/course_default.jpg') }}" alt="Course image">
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title"> {{  $courseDraft->title }} </h5>
                                                <div class="course-options d-flex align-self-start">
                                                    <button type="button" class="btn btn-light btn-sm">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if($courseDraft->status === 'draft')
                                                            <li><a class="dropdown-item" href="{{ route('courses.edit.version', ['id' =>  $courseDraft->id]) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                            <li>
                                                                <form action="{{ route('courses.check2.draft') }}" method="post" id="check2Form{{  $courseDraft->id }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="course_id" value="{{  $courseDraft->id }}">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-external-link-alt me-2"></i>Send For Review
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @if($reviews[$courseDraft->id]['is_there'])
                                                                <li><a class="dropdown-item" href="{{ route('courses.track.review', ['id' => $courseDraft->id]) }}"><i class="fas fa-exclamation-circle me-2"></i>Old Feedbacks</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $courseDraft->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                        @elseif($courseDraft->status === 'pending')
                                                            <li><a class="dropdown-item" href="{{ route('courses.view.draft', ['id' =>  $courseDraft->id]) }}"><i class="fas fa-eye me-2"></i>View Content</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('courses.track.review', ['id' => $courseDraft->id]) }}"><i class="fas fa-exclamation-circle me-2"></i>Track Review</a></li>
                                                            <li><a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#cancelReviewModal{{  $courseDraft->id }}"><i class="fas fa-times me-2"></i>Cancel Review</a></li>
                                                        @elseif($courseDraft->status === 'rejected')
                                                            <li><a class="dropdown-item" href="{{ route('courses.reedit.version', ['id' =>  $courseDraft->id]) }}"><i class="fas fa-edit me-2"></i>Re-edit</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('courses.track.review', ['id' => $courseDraft->id]) }}"><i class="fas fa-exclamation-circle me-2"></i>View Feedback</a></li>
                                                            <li><a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $courseDraft->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                        @elseif($courseDraft->status === 'accepted')
                                                            <li><a class="dropdown-item" href="{{ route('courses.view.draft', ['id' =>  $courseDraft->id]) }}"><i class="fas fa-eye me-2"></i>View Content</a></li>
                                                            <li><a class="dropdown-item text-success" type="button" data-bs-toggle="modal" data-bs-target="#publishModal{{  $courseDraft->id }}"><i class="fas fa-external-link-alt me-2"></i>Publish</a></li>
                                                            <li><a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $courseDraft->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <p class="card-text mb-0"><small>Last updated: <b>{{  $courseDraft->updated_at->format('F j, Y \a\t H:i') }}</b> </small></p>
                                            @if($courseDraft->status === 'draft')
                                                <p class="card-text mb-0"><small class="status-badge-draft"> draft </small></p>
                                                {{--<div class="btn-group mt-3">
                                                    <a type="submit" href="{{ route('courses.edit.version', ['id' =>  $courseDraft->id]) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-edit me-1"></i>Edit</a>
                                                </div>--}}
                                                <!-- Modal delete Start -->
                                                <div class="modal fade" id="deleteModal{{  $courseDraft->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $courseDraft->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $courseDraft->id }}">Delete Your Version ?</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $courseDraft->id]) }}" class="btn btn-danger">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal delete End -->
                                            @elseif($courseDraft->status === 'pending')
                                                <p class="card-text mb-0"><small class="status-badge-pending"> under review </small></p>
                                                <!-- Modal cancelReview Start -->
                                                <div class="modal fade" id="cancelReviewModal{{  $courseDraft->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelReviewModalLabel{{  $courseDraft->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="cancelReviewModalLabel{{  $courseDraft->id }}">Cancel The Review ?</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to cancel the course review ? <br> Any changes made during the review will be lost.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Keep Review</a>
                                                                <a type="button" href="{{ route('courses.cancel.review', ['id' =>  $courseDraft->id]) }}" class="btn btn-danger">Cancel Review</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal cancelReview End -->
                                            @elseif($courseDraft->status === 'rejected')
                                                <p class="card-text mb-0"><small class="status-badge-rejected"> rejected </small></p>
                                                <!-- Modal delete Start -->
                                                <div class="modal fade" id="deleteModal{{  $courseDraft->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $courseDraft->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $courseDraft->id }}">Delete Your Version ?</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $courseDraft->id]) }}" class="btn btn-danger">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal delete End -->
                                            @elseif($courseDraft->status === 'accepted')
                                                <p class="card-text mb-0"><small class="status-badge-accepted"> accepted </small><small class="status-badge-unpublished ms-2"> unpublished </small></p>
                                                <!-- Modal publish Start -->
                                                <div class="modal fade" id="publishModal{{  $courseDraft->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="publishModalLabel{{  $courseDraft->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="publishModalLabel{{  $courseDraft->id }}">Confirm Publishing</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to publish this version? Once published, it will be visible to all users.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                <a type="button" href="{{ route('courses.publish.version', ['id' =>  $courseDraft->id]) }}" class="btn btn-success">Confirm</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal publish End -->
                                                <!-- Modal delete Start -->
                                                <div class="modal fade" id="deleteModal{{  $courseDraft->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $courseDraft->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $courseDraft->id }}">Delete Your Version ?</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this version? This is permanent and cannot be undone.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $courseDraft->id]) }}" class="btn btn-danger">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal delete End -->
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="bg-white p-5">
                                    <p class="text-center">No courses found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <h3 class="ms-2 mb-4"> Previously Published Courses</h3>
                        @if($courses->count() > 0)
                            @foreach ($courses as  $course)
                                <div class="course-ins-card bg-white mb-3" data-status="{{  $course->status }}" data-timestamp="{{  $course->created_at }}">
                                    <div class="card-img">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" alt="Course image">
                                        @else
                                            <img src="{{ asset('dash/assets/img/course_default.jpg') }}" alt="Course image">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title"> {{  $course->title }} </h5>
                                            <div class="course-options d-flex align-self-start">
                                                <button type="button" class="btn btn-light btn-sm">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if($course->status === 'published')
                                                        <li><a class="dropdown-item" href="{{ route('courses.view.published', ['id' =>  $course->id]) }}"><i class="fas fa-eye me-2"></i>View Content</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('ins.courses.history', ['id' =>  $course->id]) }}"><i class="fas fa-history me-2"></i>Version History</a></li>
                                                        @if(!$course->has_draft)
                                                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#newVersionModal{{  $course->id }}"><i class="fas fa-plus me-2"></i>New Version</a></li>
                                                        @endif
                                                        <li><a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#unpublishModal{{  $course->id }}"><i class="fas fa-times me-2"></i>Unpublish</a></li>
                                                    @elseif($course->status === 'unpublished')
                                                        <li><a class="dropdown-item" href="{{ route('courses.view.published', ['id' =>  $course->id]) }}"><i class="fas fa-eye me-2"></i>View Content</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('ins.courses.history', ['id' =>  $course->id]) }}"><i class="fas fa-history me-2"></i>Version History</a></li>
                                                        @if(!$course->has_draft)
                                                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#newVersionModal{{  $course->id }}"><i class="fas fa-plus me-2"></i>New Version</a></li>
                                                        @endif
                                                        <li><a class="dropdown-item text-success" type="button" data-bs-toggle="modal" data-bs-target="#republishCourseModal{{  $course->id }}"><i class="fas fa-external-link-alt me-2"></i>Republish</a></li>
                                                        <li><a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteCourseModal{{  $course->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text mb-0"><small>Last updated: <b>{{  $course->updated_at->format('F j, Y \a\t H:i') }}</b> </small></p>
                                        <p class="card-text mb-0"><small>Version number: {{  $course->version_number }}</small></p>
                                        @if( $course->status === 'published')
                                            <p class="card-text mb-0"><small class="status-badge-published"> published </small></p>
                                            <!-- Modal unpublish Start -->
                                            <div class="modal fade" id="unpublishModal{{  $course->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="unpublishModalLabel{{  $course->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="unpublishModalLabel{{  $course->id }}">Unpublish Your Course ?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                Are you sure you want to unpublish this course ? <br>
                                                                Unpublishing will make this course unavailable to students,
                                                                but you can republish it later. Please confirm if you wish to proceed.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                            <a type="button" href="{{ route('courses.unpublish.version', ['id' => $course->id]) }}" class="btn btn-danger">Unpublish</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal unpublish End -->
                                            <!-- Modal newVersion Start -->
                                            <div class="modal fade" id="newVersionModal{{  $course->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newVersionModalLabel{{  $course->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="newVersionModalLabel{{  $course->id }}">New version of this course ?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                Are you sure you want to create a new version of this course ? <br>
                                                                Creating a new version will allow you to make updates and changes
                                                                to the course while the current version remains live.
                                                                You can edit and refine the new version without affecting the existing course.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                            <form action="{{ route('courses.create.version', ['id' => $course->id]) }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="course_id" value="{{  $course->id }}">
                                                                <button type="submit" class="btn btn-primary">New Version</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal newVersion End -->
                                            @if($course->has_draft)
                                                <div class="my-auto">
                                                    <div class="new-version-accordion">
                                                        <div class="accordion accordion-flush" id="newVersionAccordion{{ $drafts[$course->id]['draft']->id }}">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{  $drafts[$course->id]['draft']->id }}" aria-expanded="false" aria-controls="collapse">
                                                                        <b>{{ $drafts[$course->id]['draft']->status }}</b>: {{ $drafts[$course->id]['draft']->title }}
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse{{  $drafts[$course->id]['draft']->id }}" class="accordion-collapse collapse" data-bs-parent="#newVersionAccordion{{ $drafts[$course->id]['draft']->id }}">
                                                                    <div class="accordion-body p-2">
                                                                        <div class="d-flex justify-content-start gap-2">
                                                                            @if($drafts[$course->id]['draft']->status === 'draft')
                                                                                <a type="submit" href="{{ route('courses.edit.version.new', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-edit me-2"></i>Edit</a>
                                                                                <form action="{{ route('courses.check2.draft') }}" method="post" id="check2Form{{  $drafts[$course->id]['draft']->id }}" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <input type="hidden" name="course_id" value="{{  $drafts[$course->id]['draft']->id }}">
                                                                                    <button type="submit" class="btn btn-sm btn-outline-dark">
                                                                                        <i class="fas fa-external-link-alt me-2"></i>Send For Review
                                                                                    </button>
                                                                                </form>
                                                                                @if($reviews[$drafts[$course->id]['draft']->id]['is_there'])
                                                                                    <a type="submit" href="{{ route('courses.track.review', ['id' => $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-exclamation-circle me-2"></i>Old Feedbacks</a>
                                                                                @endif
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                                                                <!-- Modal delete Start -->
                                                                                <div class="modal fade" id="deleteModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}">Delete This Version ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal delete End -->
                                                                            @elseif($drafts[$course->id]['draft']->status === 'pending')
                                                                                <a type="submit" href="{{ route('courses.view.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-eye me-2"></i>View Content</a>
                                                                                @if($reviews[$drafts[$course->id]['draft']->id]['is_there'])
                                                                                    <a type="submit" href="{{ route('courses.track.review', ['id' => $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-exclamation-circle me-2"></i>Track Review</a>
                                                                                @endif
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelReviewModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-times me-2"></i>Cancel Review</a>
                                                                                <!-- Modal cancelReview Start -->
                                                                                <div class="modal fade" id="cancelReviewModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelReviewModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="cancelReviewModalLabel{{  $drafts[$course->id]['draft']->id }}">Cancel The Review ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to cancel the version review ? <br> Any changes made during the review will be lost.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Keep Review</a>
                                                                                                <a type="button" href="{{ route('courses.cancel.review', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Cancel Review</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal cancelReview End -->
                                                                            @elseif($drafts[$course->id]['draft']->status === 'rejected')
                                                                                <a type="submit" href="{{ route('courses.reedit.version', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-edit  me-2"></i>Re-edit</a>
                                                                                @if($reviews[$drafts[$course->id]['draft']->id]['is_there'])
                                                                                    <a type="submit" href="{{ route('courses.track.review', ['id' => $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-exclamation-circle me-2"></i>View Feedback</a>
                                                                                @endif
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                                                                <!-- Modal delete Start -->
                                                                                <div class="modal fade" id="deleteModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}">Delete This Version ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal delete End -->
                                                                            @elseif($drafts[$course->id]['draft']->status === 'accepted')
                                                                                <a type="submit" href="{{ route('courses.view.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-eye me-2"></i>View Content</a>
                                                                                <a type="submit" class="btn btn-xs btn-outline-success" data-bs-toggle="modal" data-bs-target="#replaceVersionModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-external-link-alt me-2"></i>Replace Version</a>
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                                                                <!-- Modal delete Start -->
                                                                                <div class="modal fade" id="deleteModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}">Delete This Version ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal delete End -->
                                                                                <!-- Modal replaceVersion Start -->
                                                                                <div class="modal fade" id="replaceVersionModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="replaceVersionModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="replaceVersionModalLabel{{  $drafts[$course->id]['draft']->id }}">Confirm Replacement</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to replace the current live version with this draft version ? <br>
                                                                                                    This action will overwrite the live version with the draft content, and you may lose any
                                                                                                    changes made to the current live version. Please confirm to proceed.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.replace.version', ['id' => $course->id, 'version' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-info">Replace</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal replaceVersion End -->
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif( $course->status === 'unpublished')
                                            <p class="card-text mb-0"><small class="status-badge-unpublished"> unpublished </small></p>
                                            <!-- Modal newVersion Start -->
                                            <div class="modal fade" id="newVersionModal{{  $course->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newVersionModalLabel{{  $course->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="newVersionModalLabel{{  $course->id }}">New version of this course ?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                Are you sure you want to create a new version of this course ? <br>
                                                                Creating a new version will allow you to make updates and changes
                                                                to the course while the current version remains live.
                                                                You can edit and refine the new version without affecting the existing course.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                            <form action="{{ route('courses.create.version', ['id' => $course->id]) }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="course_id" value="{{  $course->id }}">
                                                                <button type="submit" class="btn btn-primary">New Version</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal newVersion End -->
                                            <!-- Modal RepublishCourse Start -->
                                            <div class="modal fade" id="republishCourseModal{{  $course->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="republishModalLabel{{  $course->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="republishModalLabel{{  $course->id }}">Republish this course ?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                Are you sure you want to republish this course ?<br>
                                                                This action will make the course available again.
                                                                Once published, it will be visible to all users.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                            <a  href="{{ route('courses.republish.version', ['id' => $course->id]) }}" type="submit" class="btn btn-success">Republish</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal RepublishCourse End -->
                                            <!-- Modal DeleteCourse Start -->
                                            <div class="modal fade" id="deleteCourseModal{{  $course->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteCourseModalLabel{{  $course->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="deleteCourseModalLabel{{  $course->id }}">Delete this course ?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                Are you sure you want to delete this course ? <br>
                                                                This is permanent and cannot be undone.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                            <a  href="{{ route('courses.delete.course', ['id' => $course->id]) }}" type="submit" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal DeleteCourse End -->
                                            @if($course->has_draft)
                                                <div class="mty-auto">
                                                    <div class="new-version-accordion">
                                                        <div class="accordion accordion-flush" id="newVersionAccordion{{ $drafts[$course->id]['draft']->id }}">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{  $drafts[$course->id]['draft']->id }}" aria-expanded="false" aria-controls="collapse">
                                                                        <b>{{ $drafts[$course->id]['draft']->status }}</b>: {{ $drafts[$course->id]['draft']->title }}
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse{{  $drafts[$course->id]['draft']->id }}" class="accordion-collapse collapse" data-bs-parent="#newVersionAccordion{{ $drafts[$course->id]['draft']->id }}">
                                                                    <div class="accordion-body p-2">
                                                                        <div class="d-flex justify-content-start gap-2">
                                                                            @if($drafts[$course->id]['draft']->status === 'draft')
                                                                                <a type="submit" href="{{ route('courses.edit.version.new', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-edit me-2"></i>Edit</a>
                                                                                <form action="{{ route('courses.check2.draft') }}" method="post" id="check2Form{{  $drafts[$course->id]['draft']->id }}" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <input type="hidden" name="course_id" value="{{  $drafts[$course->id]['draft']->id }}">
                                                                                    <button type="submit" class="btn btn-sm btn-outline-dark">
                                                                                        <i class="fas fa-external-link-alt me-2"></i>Send For Review
                                                                                    </button>
                                                                                </form>
                                                                                @if($reviews[$drafts[$course->id]['draft']->id]['is_there'])
                                                                                    <a type="submit" href="{{ route('courses.track.review', ['id' => $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-exclamation-circle me-2"></i>Old Feedbacks</a>
                                                                                @endif
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                                                                <!-- Modal delete Start -->
                                                                                <div class="modal fade" id="deleteModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}">Delete This Version ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal delete End -->
                                                                            @elseif($drafts[$course->id]['draft']->status === 'pending')
                                                                                <a type="submit" href="{{ route('courses.view.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-eye me-2"></i>View Content</a>
                                                                                @if($reviews[$drafts[$course->id]['draft']->id]['is_there'])
                                                                                    <a type="submit" href="{{ route('courses.track.review', ['id' => $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-exclamation-circle me-2"></i>Track Review</a>
                                                                                @endif
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelReviewModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-times me-2"></i>Cancel Review</a>
                                                                                <!-- Modal cancelReview Start -->
                                                                                <div class="modal fade" id="cancelReviewModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelReviewModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="cancelReviewModalLabel{{  $drafts[$course->id]['draft']->id }}">Cancel The Review ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to cancel the version review ? <br> Any changes made during the review will be lost.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Keep Review</a>
                                                                                                <a type="button" href="{{ route('courses.cancel.review', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Cancel Review</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal cancelReview End -->
                                                                            @elseif($drafts[$course->id]['draft']->status === 'rejected')
                                                                                <a type="submit" href="{{ route('courses.reedit.version', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-edit  me-2"></i>Re-edit</a>
                                                                                @if($reviews[$drafts[$course->id]['draft']->id]['is_there'])
                                                                                    <a type="submit" href="{{ route('courses.track.review', ['id' => $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-exclamation-circle me-2"></i>View Feedback</a>
                                                                                @endif
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                                                                <!-- Modal delete Start -->
                                                                                <div class="modal fade" id="deleteModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}">Delete This Version ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal delete End -->
                                                                            @elseif($drafts[$course->id]['draft']->status === 'accepted')
                                                                                <a type="submit" href="{{ route('courses.view.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-eye me-2"></i>View Content</a>
                                                                                <a type="submit" class="btn btn-xs btn-outline-success" data-bs-toggle="modal" data-bs-target="#replaceVersionModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-external-link-alt me-2"></i>Replace Version</a>
                                                                                <a type="submit" class="btn btn-xs btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{  $drafts[$course->id]['draft']->id }}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                                                                <!-- Modal delete Start -->
                                                                                <div class="modal fade" id="deleteModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{  $drafts[$course->id]['draft']->id }}">Delete This Version ?</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to delete this version ? <br> This is permanent and cannot be undone.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.delete.draft', ['id' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-danger">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal delete End -->
                                                                                <!-- Modal replaceVersion Start -->
                                                                                <div class="modal fade" id="replaceVersionModal{{  $drafts[$course->id]['draft']->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="replaceVersionModalLabel{{  $drafts[$course->id]['draft']->id }}" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="replaceVersionModalLabel{{  $drafts[$course->id]['draft']->id }}">Confirm Replacement</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Are you sure you want to replace the current live version with this draft version ? <br>
                                                                                                    This action will overwrite the live version with the draft content, and you may lose any
                                                                                                    changes made to the current live version. Please confirm to proceed.</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                                                                <a type="button" href="{{ route('courses.replace.version', ['id' => $course->id, 'version' =>  $drafts[$course->id]['draft']->id]) }}" class="btn btn-info">Replace</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Modal replaceVersion End -->
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-white p-5">
                                <p class="text-center">No courses found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const optionButtons = document.querySelectorAll('.course-options .btn');

            optionButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevent the event from bubbling up to the document
                    const dropdown = this.nextElementSibling;

                    // Hide all dropdowns
                    document.querySelectorAll('.course-options .dropdown-menu').forEach(menu => {
                        if (menu !== dropdown) {
                            menu.classList.remove('show');
                        }
                    });

                    // Toggle the clicked dropdown
                    dropdown.classList.toggle('show');
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.course-options')) {
                    document.querySelectorAll('.course-options .dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            submitFormIdBtnId('createButton', 'createCourseForm');
        });
    </script>
@endsection
