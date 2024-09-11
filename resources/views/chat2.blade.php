<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responsive Layout with Bootstrap</title>
    <!-- Bootstrap Core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .chat-container {
            width: 75%;
            background-color: #fff;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 1050;
            transition: transform 0.3s ease;
            border-left: 1px solid #ccc;
            display: block;
        }

        .contacts-section {
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            height: 100%;
            background-color: #fff;
            width: 25%;
        }

        .contacts-section .contacts-header {
            background-color: #fff;
            position: relative;
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
        }

        .contacts-section .contacts-header .contacts-options {
            height: 100%;
            width: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-weight: 600;
        }

        .contacts-section .contacts-header .contacts-search {
            width: calc(100% - 50px);
            height: calc(100% - 26px);
            margin: 13px;
            position: relative;
            border-radius: 50px;
        }

        .contacts-section .contacts-header .contacts-search .contacts-search-icon {
            width: 30px;
            height: calc(100% - 4px);
            border-top-right-radius: 25px;
            border-bottom-right-radius: 25px;
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
        }

        .contacts-section .contacts-header .contacts-search input {
            width: calc(100% - 60px);
            height: 100%;
            padding: 0 40px 0 20px;
            margin: 0;
            border-radius: 50px;
            border: 1px solid #ddd;
            transition: all 0.2s ease;
        }

        .contacts-section .contacts-header .contacts-search input:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .contacts-section .contacts-header .contacts-search input:focus {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            outline: none;
            border-color: #aaa;
        }

        .contacts-section .contacts-header .contacts-search input::placeholder {
            color: #bbb;
        }

        .contacts-section ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .contacts-section ul li {
            padding: 12px 0;
            transition: all 0.3s ease;
            user-select: none;
            -webkit-user-select: none;
            cursor: pointer;
            background-color: transparent;
            border-bottom: 1px solid #ddd;
        }

        .contacts-section ul li:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .contacts-section ul li.selected-item {
            background-color: #7b7efd;
            color: white;
        }

        .overlay {
            background-color: transparent;
        }

        @media (max-width: 992px) {
            .chat-container {
                position: fixed;
                width: 100%;
                height: 100%;
                transform: translateX(100%);
                z-index: 1050;
                top: 0;
                right: 0;
                display: none;
                border: none;
            }

            .chat-container.active {
                transform: translateX(0);
                display: block;
            }

            .contacts-section {
                margin-right: 0;
                width: 100%;
            }

            .contacts-header {
                width: 100%;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: transparent;
                z-index: 1040;
                display: none;
            }

            .overlay.active {
                display: block;
            }

            .contacts-back-btn {
                z-index: 1060;
            }

            #right-menu-back.contacts-back-btn {
                display: block;
            }

            .chat-container .chat-content-header .chat-header-details .chat-header-img {
                margin-left: 50px !important;
            }
        }

        @media (min-width: 991.98px) {
            #right-menu-back.contacts-back-btn {
                display: none;
            }
        }
        .chat-contacts-list {
            overflow-y: auto;
            overflow-x: hidden;
        }
        .chat-contacts-list .chats-list-header {
            margin: 0;
            padding: 15px 20px;
            font-size: 1.5rem;
            color: #696cff;
            font-weight: 300;
            letter-spacing: 0.1rem;
            user-select: none;
            -webkit-user-select: none;
            border-bottom: 1px solid #ddd;
        }

        .chat-contacts-list .contact-item-details {
            width: 100%;
            height: 38%;
            display: flex;
            background-color: transparent;
        }

        .chat-contacts-list .contact-item-details p, .chat-contacts-list .contact-item-details span {
            margin: 0;
            padding: 0;
        }

        .chat-contacts-list .contact-item-details .contact-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ccc;
            margin: 0 10px;

        }

        .chat-contacts-list .contact-item-details .contact-text-details {
            width: calc(100% - 93px);
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            margin: 0 26px 0 10px;
            justify-content: space-between;
        }

        .chat-contacts-list .contact-item-details .contact-text-details .contact-message-preview {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 15px;
        }

        .chat-contacts-list .contact-item-details .contact-text-details .contact-name-time {
            display: flex;
            justify-content: space-between;
        }

        .chat-contacts-list .contact-item-details .contact-text-details .contact-name-time .contact-name {
            width: calc(100% - 76px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
            font-size: 18px;
        }

        .chat-contacts-list .contact-item-details .contact-text-details .contact-name-time .contact-time {
            width: 75px;
            text-align: end;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
        }


        .chat-container .chat-content-header {
            height: 60px;
            width: 100%;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .chat-container .chat-content-header .chat-header-details {
            padding: 10px 0;
            width: 100%;
            height: calc(100% - 20px);
            display: flex;
            justify-content: start;
        }

        #right-menu-back.contacts-back-btn {
            position: fixed;
            height: 40px;
            width: 40px;
            border: none;
            background-color: transparent;
            font-size: 1.5rem;
            font-weight: 800;
            top: 5px;
            left: 0;
        }

        .chat-container .chat-content-header .chat-header-details .chat-header-img {
            width: 40px;
            height: 40px;
            margin: 0 20px 0 20px;
            border-radius: 50%;
            background-color: #ccc;
        }

        .chat-header-details .chat-text-details {
            display: flex;
            height: 100%;
            width: calc(100% - 110px);
        }

        .chat-header-details .chat-text-details  .chat-options {
            display: flex;
            align-items: center;
            justify-content: end;
            font-size: 1.2rem;
            height: 100%;
            margin: 0 20px 0 5px;
            /*width: 60px;*/
            padding: 0;
            user-select: none;
            -webkit-user-select: none;
            cursor: pointer;
        }

        .chat-header-details .chat-text-details .chat-name-state {
            height: 100%;
            width: calc(100% - 100px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .chat-header-details .chat-text-details .chat-name-state .chat-name,
        .chat-header-details .chat-text-details .chat-name-state .chat-message-state {
            margin: 0;
            padding: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-container .chat-contents {
            background-color: #f7f8f8;
            padding: 0;
            height: calc(100% - 60px);
            display: flex;
            flex-direction: column;
            justify-content: start;
            position: relative;
        }

        .chat-container .chat-contents .chat-messages {
            height: 100%;
            width: calc(100% - 60px);
            padding: 30px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            overflow-y: auto;
        }

        .chat-container .chat-contents .chat-contents-inputs {
            /*background-color: grey;*/
            display: flex;
            align-items: flex-end;
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input {
            width: calc(100% - 40px);
            height: calc(100% - 30px);
            margin: 10px 20px 30px;
            border-radius: 5px;
            background-color: transparent;
            display: flex;
            align-items: flex-end;
            position: relative;
        }


        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input .chat-message-send {
            position: absolute;
            top: 2px;
            bottom: 2px;
            right: 2px;
            background: transparent;
            color: #1f2122;
            border-radius: 5px;
            width: 48px;
            display: flex;
            justify-content: start;
            padding-bottom: 10px;
            align-items: end;
            user-select: none;
            -webkit-user-select: none;
            font-size: 1.2rem;
            font-weight: 400;
            cursor: pointer;

        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea {
            width: calc(100% - 60px);
            height: calc(100% - 20px);
            background-color: #fff;
            max-height: 120px;
            border-radius: 5px;
            padding: 10px 50px 10px 10px;
            margin-bottom: 0;
            border: 1px solid #ddd;
            resize: none;
            line-height: 1.5;
            font-size: 1rem;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea::-webkit-scrollbar {
            width: 0;
            border-radius: 5px;
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea::selection {
            background: #7b7efd;
            color: #fff;
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea:focus {
            outline: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .chat-container .chat-contents .chat-contents-inputs .chat-message-text-input textarea {

        }

        .chat-subcontainer, .chat-empty-subcontainer {
            width: 100%;
            height: 100%;
        }

        .chat-subcontainer {
            display: none;
        }

        .chat-empty-subcontainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .chat-empty-subcontainer h3 {
            margin: 0 0 10px;
        }

        .chat-empty-subcontainer p {
            margin: 0;
        }

    </style>
</head>

<body>

<div id="wrapper">
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
        <div class="contacts-header">
            <div class="contacts-options"><i>☰</i></div>
            <div class="contacts-search">
                <span class="contacts-search-icon"></span>
                <input type="text" name="contacts_search" placeholder="Search ...">
            </div>
        </div>
        <div class="container-fluid chat-contacts-list">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="chats-list-header">Chats</h3>
                    <ul class="list-unstyled">
                        <li class="list-group-item" data-subcontainer="1" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 1</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="2" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 2</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="3" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 3</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="4" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 4</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" data-subcontainer="5" onclick="toggleRightSidebarContent(this)">
                            <div class="contact-item-details">
                                <p class="contact-img"></p>
                                <div class="contact-text-details">
                                    <div class="contact-name-time">
                                        <p class="contact-name">Emma Meruem 5</p>
                                        <span class="contact-time">25 Minutes</span>
                                    </div>
                                    <p class="contact-message-preview">Message example text, only try it</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- Menu Toggle Script -->

<script>
    function adjustTextareaHeight(textarea) {
        textarea.style.height = 'auto'; // Reset the height
        const computedStyle = getComputedStyle(textarea);
        const maxHeight = parseFloat(computedStyle.maxHeight);

        // Set height based on scrollHeight, but limit it to max-height
        const newHeight = Math.min(textarea.scrollHeight, maxHeight);
        textarea.style.height = newHeight - 20 + 'px'; // Adjust height
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
            if (window.innerWidth >= 992) {
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
            if (window.innerWidth >= 992) {
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
        if (window.innerWidth >= 992) {
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
        if (window.innerWidth < 992) {
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


{{-- <script>
    let currentActiveItem = null;
    let wasSidebarActive = false; // Track if the sidebar was active before resizing
    let activeSubcontainerId = null; // Track the active subcontainer ID

    // Cache DOM elements
    const rightSidebar = document.getElementById('chat-container-wrapper');
    const overlay = document.getElementById('overlay');
    const chatSubcontainers = document.querySelectorAll('.chat-subcontainer');
    const chatEmptySubcontainer = document.querySelector('.chat-empty-subcontainer');

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

        if (currentActiveItem === item) {
            // Deselect the item and reset the sidebar
            item.classList.remove('selected-item');
            hideAllSubcontainers();
            if (window.innerWidth >= 992) {
                chatEmptySubcontainer.style.display = 'flex';
            } else {
                rightSidebar.classList.remove('active');
                chatEmptySubcontainer.style.display = 'flex';
                overlay.classList.remove('active');
            }
            currentActiveItem = null;
            wasSidebarActive = false;
        } else {
            // Remove selected class from the previously selected item
            if (currentActiveItem) {
                currentActiveItem.classList.remove('selected-item');
            }

            // Show the relevant chat subcontainer
            hideAllSubcontainers();
            showSubcontainer(subcontainerId);

            // Handle sidebar and empty subcontainer visibility
            if (window.innerWidth >= 992) {
                rightSidebar.classList.remove('active');
                chatEmptySubcontainer.style.display = 'none';
            } else {
                rightSidebar.classList.add('active');
                overlay.classList.add('active');
            }

            // Set the new active item
            item.classList.add('selected-item');
            currentActiveItem = item;
            wasSidebarActive = true;
            activeSubcontainerId = subcontainerId; // Track the active subcontainer ID
        }
    }

    document.getElementById('right-menu-back').addEventListener('click', function () {
        hideAllSubcontainers();
        if (window.innerWidth >= 992) {
            chatEmptySubcontainer.style.display = 'flex';
        } else {
            rightSidebar.classList.remove('active');
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

    // Handle screen resizing
    window.addEventListener('resize', function () {
        if (window.innerWidth < 992) {
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
</script> --}}
</body>
</html>
