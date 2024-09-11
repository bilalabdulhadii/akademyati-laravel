@extends('layouts.admin')

@section('title', 'Inbox')

@section('content')
   {{-- <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="col-md-12 p-0">
                        <div class="card">
                            --}}{{-- <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">Inbox</h4>
                            </div> --}}{{--
                            <div class="card-body p-0">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

    <div class="h-100 mx-5" style="margin-top: 150px; max-height: 85vh">
        <div class="chat-container-wrapper">
            <!-- Chat Content -->
            <div id="chat-container-wrapper" class="chat-container">
                <button class="contacts-back-btn" id="right-menu-back"><span>←</span></button>

                <div id="chat-subcontainer-1" class="chat-subcontainer">
                    <div class="chat-content-header">
                        <div class="chat-header-details">
                            {{-- <button class="back-btn contacts-back-btn" id="back-btn-1"><span>←</span></button> --}}
                            <p class="chat-header-img"></p>
                            <div class="chat-text-details">
                                <div class="chat-name-state">
                                    <p class="chat-name">Emma Meruem 1</p>
                                    <small class="chat-message-state">Message example text, only try it</small>
                                </div>
                                <div class="chat-options">
                                    <a><i class="icon-phone"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chat-contents">
                        <div class="chat-messages" id="chat-messages-content">

                        </div>

                        <div class="chat-contents-inputs">
                            <div class="chat-message-text-input">
                                <textarea id="messageText" oninput="adjustTextareaHeight(this)" name="message_text"  rows="1"  placeholder="Type your message here ..."></textarea>
                                <div class="chat-message-send">
                                    <i class="far fa-paper-plane"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chat-subcontainer-2" class="chat-subcontainer">
                    <div class="chat-content-header">
                        <div class="chat-header-details">
                            {{-- <button class="back-btn contacts-back-btn" id="back-btn-2"><span>←</span></button> --}}
                            <p class="chat-header-img"></p>
                            <div class="chat-text-details">
                                <div class="chat-name-state">
                                    <p class="chat-name">Emma Meruem 2</p>
                                    <p class="chat-message-state">Message example text, only try it</p>
                                </div>
                                <i class="chat-options">Call</i>
                            </div>
                        </div>
                    </div>

                    <div class="chat-contents">
                        <div class="chat-messages" id="chat-messages-content">

                        </div>

                        <div class="chat-contents-inputs">
                            <div class="chat-message-text-input">
                                <textarea id="messageText" oninput="adjustTextareaHeight(this)" name="message_text"  rows="1"  placeholder="Type your message here ..."></textarea>
                                <div class="chat-message-send">
                                    <i>Send</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chat-subcontainer-3" class="chat-subcontainer">
                    <div class="chat-content-header">
                        <div class="chat-header-details">
                            {{-- <button class="back-btn contacts-back-btn" id="back-btn-3"><span>←</span></button> --}}
                            <p class="chat-header-img"></p>
                            <div class="chat-text-details">
                                <div class="chat-name-state">
                                    <p class="chat-name">Emma Meruem 3</p>
                                    <p class="chat-message-state">Message example text, only try it</p>
                                </div>
                                <i class="chat-options">Call</i>
                            </div>
                        </div>
                    </div>

                    <div class="chat-contents">
                        <div class="chat-messages" id="chat-messages-content">

                        </div>

                        <div class="chat-contents-inputs">
                            <div class="chat-message-text-input">
                                <textarea id="messageText" oninput="adjustTextareaHeight(this)" name="message_text"  rows="1"  placeholder="Type your message here ..."></textarea>
                                <div class="chat-message-send">
                                    <i>Send</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chat-subcontainer-4" class="chat-subcontainer">
                    <div class="chat-content-header">
                        <div class="chat-header-details">
                            {{-- <button class="back-btn contacts-back-btn" id="back-btn-4"><span>←</span></button> --}}
                            <p class="chat-header-img"></p>
                            <div class="chat-text-details">
                                <div class="chat-name-state">
                                    <p class="chat-name">Emma Meruem 4</p>
                                    <p class="chat-message-state">Message example text, only try it</p>
                                </div>
                                <i class="chat-options">Call</i>
                            </div>
                        </div>
                    </div>

                    <div class="chat-contents">
                        <div class="chat-messages" id="chat-messages-content">

                        </div>

                        <div class="chat-contents-inputs">
                            <div class="chat-message-text-input">
                                <textarea id="messageText" oninput="adjustTextareaHeight(this)" name="message_text" rows="1" placeholder="Type your message here ..."></textarea>
                                <div class="chat-message-send">
                                    <i>Send</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chat-subcontainer-5" class="chat-subcontainer">
                    <div class="chat-content-header">
                        <div class="chat-header-details">
                            {{-- <button class="back-btn contacts-back-btn" id="back-btn-5"><span>←</span></button> --}}
                            <p class="chat-header-img"></p>
                            <div class="chat-text-details">
                                <div class="chat-name-state">
                                    <p class="chat-name">Emma Meruem 5</p>
                                    <p class="chat-message-state">Message example text, only try it</p>
                                </div>
                                <i class="chat-options">Call</i>
                            </div>
                        </div>
                    </div>

                    <div class="chat-contents">
                        <div class="chat-messages" id="chat-messages-content">

                        </div>

                        <div class="chat-contents-inputs">
                            <div class="chat-message-text-input">
                                <textarea id="messageText" oninput="adjustTextareaHeight(this)" name="message_text" rows="1" placeholder="Type your message here ..."></textarea>
                                <div class="chat-message-send">
                                    <i>Send</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chat-empty-subcontainer">
                    <h3>No Content Available</h3>
                    <p>Select a contact to view content.</p>
                </div>
            </div>

            <!-- Overlay -->
            <div class="overlay" id="overlay"></div>
            <!-- Page Content -->
            <div class="contacts-section page-content">
                <div class="contacts-header-container">
                    <div class="contacts-header">
                        <div class="contacts-options"><i class="fas fa-bars"></i></div>
                        <div class="contacts-search">
                            <span class="contacts-search-icon"><i class="fa fa-search"></i></span>
                            <input type="text" name="contacts_search" placeholder="Search ...">
                        </div>
                    </div>
                </div>
                <div class="chat-contacts-list">
                    <div>
                        <div>
                            <h3 class="chats-list-header">Chats</h3>
                            <ul class="list-unstyled">
                                <li data-subcontainer="1" onclick="toggleRightSidebarContent(this)">
                                    <div class="contact-item-details">
                                        <p class="contact-img"></p>
                                        <div class="contact-text-details">
                                            <div class="contact-name-time">
                                                <h6 class="contact-name">Emma Meruem 1</h6>
                                                <small class="contact-time">25 Minutes</small>
                                            </div>
                                            <small class="contact-message-preview">Message example text, only try it</small>
                                        </div>
                                    </div>
                                </li>
                                <li data-subcontainer="1" onclick="toggleRightSidebarContent(this)">
                                    <div class="contact-item-details">
                                        <p class="contact-img"></p>
                                        <div class="contact-text-details">
                                            <div class="contact-name-time">
                                                <h6 class="contact-name">Emma Meruem 1</h6>
                                                <small class="contact-time">25 Minutes</small>
                                            </div>
                                            <small class="contact-message-preview">Message example text, only try it</small>
                                        </div>
                                    </div>
                                </li>
                                <li data-subcontainer="1" onclick="toggleRightSidebarContent(this)">
                                    <div class="contact-item-details">
                                        <p class="contact-img"></p>
                                        <div class="contact-text-details">
                                            <div class="contact-name-time">
                                                <h6 class="contact-name">Emma Meruem 1</h6>
                                                <small class="contact-time">25 Minutes</small>
                                            </div>
                                            <small class="contact-message-preview">Message example text, only try it</small>
                                        </div>
                                    </div>
                                </li>
                                <li data-subcontainer="1" onclick="toggleRightSidebarContent(this)">
                                    <div class="contact-item-details">
                                        <p class="contact-img"></p>
                                        <div class="contact-text-details">
                                            <div class="contact-name-time">
                                                <h6 class="contact-name">Emma Meruem 1</h6>
                                                <small class="contact-time">25 Minutes</small>
                                            </div>
                                            <small class="contact-message-preview">Message example text, only try it</small>
                                        </div>
                                    </div>
                                </li>
                                <li data-subcontainer="1" onclick="toggleRightSidebarContent(this)">
                                    <div class="contact-item-details">
                                        <p class="contact-img"></p>
                                        <div class="contact-text-details">
                                            <div class="contact-name-time">
                                                <h6 class="contact-name">Emma Meruem 1</h6>
                                                <small class="contact-time">25 Minutes</small>
                                            </div>
                                            <small class="contact-message-preview">Message example text, only try it</small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function adjustTextareaHeight(textarea) {
            textarea.style.height = 'auto'; // Reset the height
            const computedStyle = getComputedStyle(textarea);
            const maxHeight = parseFloat(computedStyle.maxHeight);

            // Set height based on scrollHeight, but limit it to max-height
            const newHeight = Math.min(textarea.scrollHeight, maxHeight);
            textarea.style.height = newHeight + 'px'; // Adjust height
        }

        // Initialize textarea height
        const textarea = document.getElementById('messageText');

        // Call the function to set initial height
        adjustTextareaHeight(textarea);
    </script>

    <script>
        let currentActiveItem = null;
        let wasSidebarActive = false; // Track if the sidebar was active before resizing
        let activeSubcontainerId = null; // Track the active subcontainer ID

        // Cache DOM elements
        const rightSidebar = document.getElementById('chat-container-wrapper');
        const overlay = document.getElementById('overlay');
        const chatSubcontainers = document.querySelectorAll('.chat-subcontainer');
        const chatEmptySubcontainer = document.querySelector('.chat-empty-subcontainer');
        const backButton = document.getElementById('right-menu-back');

        function hideAllSubcontainers() {
            chatSubcontainers.forEach(subcontainer => {
                subcontainer.style.display = 'none';
            });
        }

        function showSubcontainer(id) {
            const subcontainer = document.getElementById(`chat-subcontainer-${id}`);
            if (subcontainer) {
                subcontainer.style.display = 'block';
                chatEmptySubcontainer.style.display = 'none';
            } else {
                console.warn(`Subcontainer with ID "chat-subcontainer-${id}" not found.`);
            }
        }

        function toggleRightSidebarContent(item) {
            const subcontainerId = item.getAttribute('data-subcontainer');

            // Hide all chat subcontainers
            hideAllSubcontainers();

            if (currentActiveItem === item) {
                // Deselect the item and reset the sidebar
                item.classList.remove('selected-item');
                if (window.innerWidth >= 1200) {
                    chatEmptySubcontainer.style.display = 'flex';
                    activeSubcontainerId = null;
                } else {
                    rightSidebar.classList.remove('active');
                    chatEmptySubcontainer.style.display = 'flex';
                    overlay.classList.remove('active');
                    activeSubcontainerId = null;
                }
                currentActiveItem = null;
                wasSidebarActive = false;
            } else {
                // Remove selected class from the previously selected item
                if (currentActiveItem) {
                    currentActiveItem.classList.remove('selected-item');
                }

                // Show the relevant chat subcontainer
                showSubcontainer(subcontainerId);
                activeSubcontainerId = subcontainerId; // Track the active subcontainer ID

                // Handle sidebar and empty subcontainer visibility
                if (window.innerWidth >= 1200) {
                    rightSidebar.classList.remove('active');
                    overlay.classList.remove('active');
                } else {
                    rightSidebar.classList.add('active');
                    overlay.classList.add('active');
                }

                // Set the new active item
                item.classList.add('selected-item');
                currentActiveItem = item;
                wasSidebarActive = true;
            }
        }

        backButton.addEventListener('click', function () {
            // Reset visibility based on screen size
            if (window.innerWidth >= 1200) {
                chatEmptySubcontainer.style.display = 'flex';
                hideAllSubcontainers();
                rightSidebar.classList.remove('active');
                overlay.classList.remove('active');
            } else {
                rightSidebar.classList.remove('active');
                hideAllSubcontainers();
                chatEmptySubcontainer.style.display = 'flex';
                overlay.classList.remove('active');
            }

            if (currentActiveItem) {
                currentActiveItem.classList.remove('selected-item');
            }
            currentActiveItem = null;
            wasSidebarActive = false;
            activeSubcontainerId = null;
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth < 1200) {
                // Small screen adjustments
                if (wasSidebarActive) {
                    rightSidebar.classList.add('active');
                    overlay.classList.add('active');
                    if (activeSubcontainerId) {
                        showSubcontainer(activeSubcontainerId);
                    } else {
                        chatEmptySubcontainer.style.display = 'flex';
                    }
                } else {
                    rightSidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    chatEmptySubcontainer.style.display = 'flex';
                }
            } else {
                // Large screen adjustments
                chatEmptySubcontainer.style.display = 'flex';
                hideAllSubcontainers();
                if (wasSidebarActive) {
                    rightSidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    if (activeSubcontainerId) {
                        showSubcontainer(activeSubcontainerId);
                    }
                }
            }
        });
    </script>
@endsection
