<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expanding Textarea</title>
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh; /* Adjust as needed */
        }

        .chat-contents {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        .chat-contents-inputs {
            margin-top: auto;
        }

        .chat-message-text-input {
            position: relative;
        }

        textarea {
            width: calc(100% - 60px); /* Adjust for padding or margin */
            min-height: 36px; /* Minimum height for one line */
            max-height: 144px; /* Maximum height for four lines */
            border-radius: 5px;
            padding: 8px 12px; /* Adjust padding as needed */
            border: none;
            resize: none;
            line-height: 1.5; /* Adjust this to your line height */
            font-size: 1rem;
            overflow-y: auto; /* Show scrollbar if needed */
            box-sizing: border-box; /* Include padding in height calculation */
        }
    </style>
</head>
<body>
<div class="chat-container">
    <div class="chat-contents">
        <!-- Other chat contents here -->
    </div>
    <div class="chat-contents-inputs">
        <div class="chat-message-text-input">
            <textarea id="messageText" name="message_text" rows="1" placeholder="Type your message here ..."></textarea>
        </div>
    </div>
</div>

<script>
    function adjustTextareaHeight(textarea) {
        textarea.style.height = 'auto'; // Reset the height
        const computedStyle = getComputedStyle(textarea);
        const lineHeight = parseFloat(computedStyle.lineHeight);
        const minHeight = parseFloat(computedStyle.minHeight);
        const maxHeight = parseFloat(computedStyle.maxHeight);

        // Set height based on scrollHeight, but limit it to max-height
        textarea.style.height = Math.min(textarea.scrollHeight, maxHeight) + 'px';

        // Ensure the height is at least the minimum height
        if (textarea.style.height < minHeight) {
            textarea.style.height = minHeight + 'px';
        }
    }

    const textarea = document.getElementById('messageText');

    textarea.addEventListener('input', function() {
        adjustTextareaHeight(this);
    });

    // Initialize textarea height
    adjustTextareaHeight(textarea);
</script>
</body>
</html>





{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Chat System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .chat-sidebar {
            height: 100vh;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            background: white;
            position: relative;
            z-index: 100;
        }
        .chat-sidebar.full-width {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .chat-sidebar.open {
            transform: translateX(0);
        }
        .chat-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .chat-message {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            border-left: 1px solid #ddd;
        }
        .chat-input {
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .message-bubble {
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .message-bubble.sent {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }
        .message-bubble.received {
            background-color: #e9ecef;
            color: black;
            align-self: flex-start;
        }
        .contact-list .contact-item {
            cursor: pointer;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .contact-list .contact-item:hover {
            background-color: #f1f1f1;
        }
        @media (max-width: 767px) {
            .chat-sidebar {
                display: none;
            }
            .chat-sidebar.full-width {
                display: block;
                width: 100%;
            }
            .chat-container.open .chat-sidebar {
                display: block;
                transform: translateX(0);
            }
            .chat-container.open .chat-message {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row chat-container">
        <!-- Sidebar for large screens -->
        <nav class="col-md-3 col-lg-2 chat-sidebar d-none d-md-block">
            <h4>Contacts</h4>
            <ul class="list-unstyled contact-list">
                <li class="contact-item" data-contact="alice">Alice</li>
                <li class="contact-item" data-contact="bob">Bob</li>
                <li class="contact-item" data-contact="charlie">Charlie</li>
            </ul>
        </nav>

        <!-- Chat container -->
        <main class="col-md-9 col-lg-10">
            <!-- Toggle button for small screens -->
            <button class="btn btn-primary d-md-none" id="sidebar-toggle">☰</button>
            <div class="chat-sidebar d-md-none">
                <h4>Contacts</h4>
                <ul class="list-unstyled contact-list">
                    <li class="contact-item" data-contact="alice">Alice</li>
                    <li class="contact-item" data-contact="bob">Bob</li>
                    <li class="contact-item" data-contact="charlie">Charlie</li>
                </ul>
            </div>
            <div class="chat-header d-flex justify-content-between align-items-center p-3">
                <h4 id="chat-title">Select a contact</h4>
            </div>
            <div class="chat-message" id="chat-messages">
                <!-- Chat messages will be dynamically updated here -->
            </div>
            <div class="chat-input" id="chat-input" style="display: none;">
                <form id="chat-form">
                    <input type="text" class="form-control" placeholder="Type a message..." id="message-input">
                    <button type="submit" class="btn btn-primary mt-2">Send</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    let activeContact = null;

    // Toggle sidebar visibility
    document.getElementById('sidebar-toggle').addEventListener('click', function() {
        const sidebar = document.querySelector('.chat-sidebar');
        const container = document.querySelector('.chat-container');
        sidebar.classList.toggle('open');
        container.classList.toggle('open');
    });

    // JavaScript to handle contact switching
    document.querySelectorAll('.contact-item').forEach(item => {
        item.addEventListener('click', function() {
            const contact = this.getAttribute('data-contact');

            if (activeContact === contact) {
                // If the same contact is clicked again, close the chat
                document.getElementById('chat-title').textContent = 'Select a contact';
                document.getElementById('chat-messages').innerHTML = '';
                document.getElementById('chat-input').style.display = 'none';
                activeContact = null;
                if (window.innerWidth < 768) {
                    // Simulate click on sidebar toggle button to close sidebar
                    document.getElementById('sidebar-toggle').click();
                }
            } else {
                // Load and display chat for the new contact
                document.getElementById('chat-title').textContent = `Chat with ${contact.charAt(0).toUpperCase() + contact.slice(1)}`;
                document.getElementById('chat-messages').innerHTML = generateSampleMessages(contact);
                document.getElementById('chat-input').style.display = 'block';
                activeContact = contact;
                if (window.innerWidth < 768) {
                    // Simulate click on sidebar toggle button to open sidebar
                    document.getElementById('sidebar-toggle').click();
                }
            }
        });
    });

    // Function to generate sample messages based on contact
    function generateSampleMessages(contact) {
        const messages = {
            alice: [
                { type: 'received', text: 'Hi, how are you?' },
                { type: 'sent', text: "I'm good, thanks! How about you?" },
                { type: 'received', text: "I'm great! Thanks for asking." }
            ],
            bob: [
                { type: 'received', text: 'Hey! What’s up?' },
                { type: 'sent', text: 'Not much, just working on a project.' },
                { type: 'received', text: 'Cool! Let me know if you need help.' }
            ],
            charlie: [
                { type: 'received', text: 'Hi there!' },
                { type: 'sent', text: 'Hello! How’s it going?' },
                { type: 'received', text: 'Pretty good, just relaxing.' }
            ]
        };

        return messages[contact].map(msg => `
                <div class="message-bubble ${msg.type}">
                    ${msg.text}
                </div>
            `).join('');
    }

    // JavaScript to handle form submission
    document.getElementById('chat-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();
        if (message && activeContact) {
            const messageBubble = document.createElement('div');
            messageBubble.className = 'message-bubble sent';
            messageBubble.textContent = message;
            document.getElementById('chat-messages').appendChild(messageBubble);
            messageInput.value = '';
            document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
        }
    });

    // Handle window resize to ensure correct sidebar behavior
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            document.querySelector('.chat-sidebar').classList.remove('full-width');
            document.querySelector('.chat-container').classList.remove('open');
        }
    });
</script>
</body>
</html> --}}
