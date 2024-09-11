@extends('layouts.educator')

@section('title', 'Inbox')

@section('content')
    <div class="container">
        <div class="page-inner" style="margin-top: 120px">
            <div class="container">
                <div class="inbox-container">
                    <div class="col inbox-content {{ $active_sidebar ? 'expand' : '' }}">
                        <!-- Main Content -->
                        <div class="add-contact-box">
                            <a class="add-contact-btn" type="button" id="addUserMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-plus"></i></a>
                            <ul id="add-new-user-menu" class="add-new-user-menu dropdown-menu dropdown-menu-end p-0" aria-labelledby="addUserMenu">
                                <li class="search-new-user-input-item"><input type="text" name="search_new_user_input" class="search-new-user-input"  id="search-new-user-input" placeholder="search ..."></li>
                                @foreach($users as $index => $user)
                                    @if($user->id != Auth::id())
                                        <li class="add-new-user-item {{ $index === 0 ? 'add-new-user-item-1' : '' }}">
                                            <div class="dropdown-item d-flex justify-content-between">
                                                <small class="d-flex flex-grow-1 flex-column justify-content-between">
                                                    <small>{{ $user->first_name }} {{ $user->last_name }}</small>
                                                    <small>{{ ucfirst($user->role) }}</small>
                                                </small>
                                                @if($user->contact_status === 'new')
                                                    <form class="d-flex align-items-center justify-content-center" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="new_contact">
                                                        <input type="hidden" name="contact_id" value="{{ $user->id }}">
                                                        <button type="submit" class="p-2 add-new-user-item-icon bg-transparent border border-0"><i class="fas fa-user-plus"></i></button>
                                                    </form>
                                                @elseif($user->contact_status === 'archived')
                                                    <form class="d-flex align-items-center justify-content-center" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="unarchive_2">
                                                        <input type="hidden" name="contact_id" value="{{ $user->contact_id }}">
                                                        <button type="submit" class="p-2 add-new-user-item-bg text-white rounded-2 border border-0">Unarchive</button>
                                                    </form>
                                                @elseif($user->contact_status === 'removed')
                                                    <form class="d-flex align-items-center justify-content-center" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="add_removed_contact">
                                                        <input type="hidden" name="contact_id" value="{{ $user->contact_id }}">
                                                        <button type="submit" class="p-2 add-new-user-item-bg text-white rounded-2 border border-0">Re-Add</button>
                                                    </form>
                                                @elseif($user->contact_status === 'active')
                                                    <a class="p-2 d-flex align-items-center add-new-user-item-icon  justify-content-center"><i class="fas fa-user-check"></i></a>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="bg-white h-100">
                            <div class="contacts-list-header dropend">
                                <a class="contacts-list-options" type="button" id="contactOptionMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                <ul class="contacts-list-options-menu dropdown-menu p-0" aria-labelledby="contactOptionMenu">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#archivedContactsModal">Archived Contacts</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#removedContactsModal">Removed Contacts</a></li>
                                </ul>

                                <!-- Archived Contacts Modal Start -->
                                <div class="modal fade" id="archivedContactsModal" tabindex="-1" aria-labelledby="archivedContactsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="archivedContactsModalLabel">Archived Contacts</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="archived-contacts-list">
                                                    @php $counter = 0; @endphp
                                                    @foreach($contacts as $contact)
                                                        @if($contact->status === 'archived')
                                                            <li>
                                                                <div class="d-flex flex-column flex-grow-1 ">
                                                                    <span class="d-flex">{{ $contact->contact->first_name }} {{ $contact->contact->last_name }}</span>
                                                                    <span class="d-flex">{{ ucfirst($contact->contact->role) }}</span>
                                                                </div>
                                                                <form action="{{ route('inbox.update') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="unarchive_3">
                                                                    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                                    <button type="submit">Unarchive</button>
                                                                </form>
                                                            </li>
                                                            @php $counter++; @endphp
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                @if($counter == 0)
                                                    <h6 class="my-5 text-secondary">No Archived Contact</h6>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Archived Contacts Modal End -->

                                <!-- Removed Contacts Modal Start -->
                                <div class="modal fade" id="removedContactsModal" tabindex="-1" aria-labelledby="removedContactsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="removedContactsModalLabel">Removed Contacts</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="archived-contacts-list">
                                                    @php $counter = 0; @endphp
                                                    @foreach($contacts as $contact)
                                                        @if($contact->status === 'removed')
                                                            <li>
                                                                <div class="d-flex flex-column flex-grow-1 ">
                                                                    <span class="d-flex">{{ $contact->contact->first_name }} {{ $contact->contact->last_name }}</span>
                                                                    <span class="d-flex">{{ ucfirst($contact->contact->role) }}</span>
                                                                </div>
                                                                <form action="{{ route('inbox.update') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="add_removed_contact_2">
                                                                    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                                    <button type="submit">Re-Add</button>
                                                                </form>
                                                            </li>
                                                            @php $counter++; @endphp
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                @if($counter == 0)
                                                    <h6 class="my-5 text-secondary">No Removed Contact</h6>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Removed Contacts Modal End -->

                                <div class="contacts-search-box">
                                    <input type="text" name="contacts_search_input" class="contacts-search-input" id="contacts-search-input" placeholder="search ...">
                                    <a><i class="fas fa-search"></i></a>
                                </div>
                            </div>

                            @if($contacts->count() > 0)
                                <ul class="contacts-list" id="contacts-list">
                                    @foreach($contacts as $contact)
                                        @if($contact->status === 'active')
                                            <li class="contact-item">
                                                @if($contact->has_message)
                                                    <a class="">
                                                        <form action="{{ route('inbox.update') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="read_message">
                                                            <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                            <button type="submit" class="contact-submit-btn">
                                                                @if($contact->contact->profile)
                                                                    <img class="contact-prof-img" src="{{ Storage::url($contact->contact->profile) }}" alt="profile">
                                                                @else
                                                                    <span class="contact-prof-chars">{{ substr($contact->contact->first_name, 0, 1) }}{{ substr($contact->contact->last_name, 0, 1) }}</span>
                                                                @endif
                                                                <span class="contact-item-details d-flex flex-column justify-content-between flex-grow-1">
                                                                    <span class="contact-item-name">{{ $contact->contact->first_name }} {{ $contact->contact->last_name }}</span>
                                                                    <span class="contact-item-subject">{{ ucfirst($contact->contact->role) }}</span>
                                                                </span>
                                                                <small class="contact-item-time">
                                                                    <small class="">{{ $contact->latestMessage->formated_time ?? 'NEW' }}</small>
                                                                    <small>
                                                                        <i class="{{ $contact->is_muted ? 'far fa-bell-slash' : '' }}"></i>
                                                                        @if($contact->new_messages > 0)
                                                                            <i class="contact-new-messages-count">{{ $contact->new_messages ? $contact->new_messages : '' }}</i>
                                                                        @endif
                                                                    </small>
                                                                </small>
                                                            </button>
                                                        </form>
                                                    </a>
                                                @else
                                                    <a class="contact-data-btn {{ $contact->id == $is_active ? 'selected-item' : '' }}" data-toggle="{{ $contact->id }}">
                                                        @if($contact->contact->profile)
                                                            <img class="contact-prof-img" src="{{ Storage::url($contact->contact->profile) }}" alt="profile">
                                                        @else
                                                            <span class="contact-prof-chars">{{ substr($contact->contact->first_name, 0, 1) }}{{ substr($contact->contact->last_name, 0, 1) }}</span>
                                                        @endif
                                                        <span class="contact-item-details d-flex flex-column justify-content-between  flex-grow-1">
                                                            <span class="contact-item-name">{{ $contact->contact->first_name }} {{ $contact->contact->last_name }}</span>
                                                            <span class="contact-item-subject">{{ ucfirst($contact->contact->role) }}</span>
                                                        </span>
                                                        <small class="contact-item-time">
                                                            <small class="">{{ $contact->latestMessage->formated_time ?? 'NEW' }}</small>
                                                            <small>
                                                                <i class="{{ $contact->is_muted ? 'far fa-bell-slash' : '' }}"></i>
                                                                {{-- <i class="contact-new-messages-count">{{ $contact->new_messages ? $contact->new_messages : '' }}</i> --}}
                                                            </small>
                                                        </small>
                                                    </a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <p class="w-100 text-center mt-5">Find for new people</p>
                            @endif
                        </div>
                    </div>
                    <div class="col contacts-sidebar {{ $active_sidebar ? 'show-sidebar' : '' }}" id="contacts-sidebar">
                        <div class="content-container">
                            <button class="btn message-back-btn" id="toggleSidebar2"><i class="fa fa-angle-left"></i></button>
                            @foreach($contacts as $contact)
                                <div class="content-data-changer {{ $contact->id == $is_active ? 'active' : '' }}" data-content="{{ $contact->id }}">
                                    <div class="inbox-content-header">
                                        @if($contact->contact->role === 'instructor')
                                            <a target="_blank" href="{{ route('ins.profile', ['username' => $contact->contact->username]) }}" class="text-decoration-none text-dark">
                                                @if($contact->contact->profile)
                                                    <img class="contact-prof-img" src="{{ Storage::url($contact->contact->profile) }}" alt="profile">
                                                @else
                                                    <span class="contact-prof-chars">{{ substr($contact->contact->first_name, 0, 1) }}{{ substr($contact->contact->last_name, 0, 1) }}</span>
                                                @endif
                                            </a>
                                        @elseif($contact->contact->role === 'student')
                                            <a target="_blank" href="{{ route('std.profile', ['username' => $contact->contact->username]) }}" class="text-decoration-none text-dark">
                                                @if($contact->contact->profile)
                                                    <img class="contact-prof-img" src="{{ Storage::url($contact->contact->profile) }}" alt="profile">
                                                @else
                                                    <span class="contact-prof-chars">{{ substr($contact->contact->first_name, 0, 1) }}{{ substr($contact->contact->last_name, 0, 1) }}</span>
                                                @endif
                                            </a>
                                        @else
                                            <a class="text-decoration-none text-dark">
                                                @if($contact->contact->profile)
                                                    <img class="contact-prof-img" src="{{ Storage::url($contact->contact->profile) }}" alt="profile">
                                                @else
                                                    <span class="contact-prof-chars">{{ substr($contact->contact->first_name, 0, 1) }}{{ substr($contact->contact->last_name, 0, 1) }}</span>
                                                @endif
                                            </a>
                                        @endif
                                        <span class="contact-item-details d-flex flex-column justify-content-between flex-grow-1">
                                            <span class="contact-item-name">{{ $contact->contact->first_name }} {{ $contact->contact->last_name }}</span>
                                            <span class="contact-item-subject">{{ ucfirst($contact->contact->role) }}</span>
                                        </span>
                                        <div class="dropdown">
                                            <button href="#" class="message-options-action" type="button" id="optionMenu_{{ $contact->id }}" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end p-0 shadow-sm" aria-labelledby="optionMenu_{{ $contact->id }}">
                                                <li>
                                                    <form class="h-100 w-100" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="{{ $contact->is_muted ? 'unmute' : 'mute' }}">
                                                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                        <button type="submit" class="dropdown-item message-input-send"><i class="{{ $contact->is_muted ? 'far fa-bell' : 'far fa-bell-slash' }} me-2"></i>{{ $contact->is_muted ? 'Unmute' : 'Mute' }}</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form class="h-100 w-100" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="clear">
                                                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                        <button type="submit" class="dropdown-item message-input-send"><i class="fas fa-times me-2"></i>Clear chat</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form class="h-100 w-100" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="{{ $contact->is_favorite ? 'unfavorite' : 'favorite' }}">
                                                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                        <button type="submit" class="dropdown-item message-input-send"><i class="{{ $contact->is_favorite ? 'fas fa-star text-warning' : 'far fa-star' }} me-2"></i>{{ $contact->is_favorite ? 'Unfavorite' : 'Favorite' }}</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form class="h-100 w-100" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="{{ $contact->status === 'archived' ? 'unarchive' : 'archive' }}">
                                                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                        <button type="submit" class="dropdown-item message-input-send"><i class="{{ $contact->status === 'archived' ? 'far fa-folder-open' : 'far fa-folder' }} me-2"></i>{{ $contact->status === 'archived' ? 'Unarchive' : 'Archive' }}</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form class="h-100 w-100" action="{{ route('inbox.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="remove">
                                                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                        <button type="submit" class="dropdown-item message-input-send"><i class="far fa-trash-alt me-2"></i>Remove</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <div class="inbox-content-second-header">
                                        <a href="#" class="message-delete-action"><i class="far fa-trash-alt"></i></a>
                                        <a href="#" class="message-star-action"><i class="far fa-star"></i></a>
                                        <div class="d-flex flex-column justify-content-between flex-grow-1"></div>
                                        <a href="#" class="message-options-action"><i class="fas fa-ellipsis-v"></i></a>
                                    </div> --}}
                                    <div class="messages-body">
                                        @foreach($messages[$contact->id] as $message)
                                            @if($message->receiver_id == Auth::id())
                                                @if($message->status === 'sent' || $message->status === 'read')
                                                    <div class="message-content-came">
                                                        @if($message->sender->profile)
                                                            <img class="contact-came-img" src="{{ Storage::url($message->sender->profile) }}" alt="profile">
                                                        @else
                                                            <span class="contact-came-chars">{{ substr($message->sender->first_name, 0, 1) }}{{ substr($message->sender->last_name, 0, 1) }}</span>
                                                        @endif
                                                        <div class="message-came-details">
                                                            <div class="message-came-text">
                                                                {{ $message->content }}
                                                            </div>
                                                            <small class="message-came-time d-flex align-items-center">{{ $message->formated_created_at }}</small>
                                                        </div>
                                                        {{-- <div class="message-came-remove">
                                                            <form action="{{ route('inbox.update') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="remove_message">
                                                                <input type="hidden" name="message_id" value="{{ $message->id }}">
                                                                <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                                <button type="submit"><i class="far fa-trash-alt"></i></button>
                                                            </form>
                                                        </div> --}}
                                                    </div>
                                                @elseif($message->status === 'removed')
                                                    <div class="message-content-came">
                                                        @if($message->sender->profile)
                                                            <img class="contact-came-img" src="{{ Storage::url($message->sender->profile) }}" alt="profile">
                                                        @else
                                                            <span class="contact-came-chars">{{ substr($message->sender->first_name, 0, 1) }}{{ substr($message->sender->last_name, 0, 1) }}</span>
                                                        @endif
                                                        <div class="message-came-details">
                                                            <div class="message-came-text">
                                                                <i class="fas fa-ban me-2"></i>This message has been deleted
                                                            </div>
                                                            <small class="message-came-time d-flex align-items-center">{{ $message->formated_created_at }}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                @if($message->status === 'sent' || $message->status === 'read')
                                                    <div class="message-content-sent">
                                                        <div class="message-sent-remove">
                                                            <form action="{{ route('inbox.update') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="remove_message">
                                                                <input type="hidden" name="message_id" value="{{ $message->id }}">
                                                                <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                                <button type="submit"><i class="far fa-trash-alt"></i></button>
                                                            </form>
                                                        </div>
                                                        <div class="message-sent-details">
                                                            <div class="message-sent-text">
                                                                {{ $message->content }}
                                                            </div>
                                                            <small class="message-sent-time d-flex align-items-center">{{ $message->formated_created_at }}
                                                                @if($message->status === 'sent')
                                                                    <i class="fas fa-check text-muted ms-2"></i>
                                                                @else
                                                                    <i class="fas fa-check-double text-primary fs-6 ms-2"></i>
                                                                @endif
                                                            </small>
                                                        </div>
                                                        @if($message->sender->profile)
                                                            <img class="contact-sent-img" src="{{ Storage::url($message->sender->profile) }}" alt="profile">
                                                        @else
                                                            <span class="contact-sent-chars">{{ substr($message->sender->first_name, 0, 1) }}{{ substr($message->sender->last_name, 0, 1) }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach

                                        <div class="message-send-box">
                                            <div class="message-input-box">
                                                <form class="h-100 w-100" action="{{ route('inbox.update') }}" method="POST" id="formSendNewMessage">
                                                    @csrf
                                                    <input type="hidden" name="status" value="new_message">
                                                    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                    <textarea rows="3" id="newMessageContent" name="message_content" placeholder="type your message here ..."></textarea>
                                                    <button type="submit" class="message-input-send"><i class="far fa-paper-plane"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-data-changer-empty">
                                    <h3>No Content Available</h3>
                                    <p>Select a contact to view messages.</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize filter for each search input, list, and item class
            filterItems('search-new-user-input', 'add-new-user-menu', 'add-new-user-item');
            filterItems('contacts-search-input', 'contacts-list', 'contact-item');
        });
    </script>
@endsection
