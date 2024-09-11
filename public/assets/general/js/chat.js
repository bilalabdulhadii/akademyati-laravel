
/* Chat Contacts Search Start */
function filterItems(searchInputId, listId, itemClass) {
    const searchInput = document.getElementById(searchInputId);
    const itemList = document.getElementById(listId);

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        const items = itemList.getElementsByClassName(itemClass);

        Array.from(items).forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}
/* Chat Contacts Search End */

/* Chat Operations Start */
document.addEventListener('DOMContentLoaded', function() {
    let currentButtonData = null;

    const toggleButtons = document.querySelectorAll('[data-toggle]');
    const sidebar = document.getElementById('contacts-sidebar');
    const mainContent = document.querySelector('.inbox-content');
    const emptyContent = document.querySelector('.content-data-changer-empty');
    const allContactButtons = document.querySelectorAll('.contact-data-btn, .contact-submit-btn');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const buttonData = this.getAttribute('data-toggle');

            // Remove 'selected-item' class from all buttons
            removeSelectedClassFromButtons();

            if (currentButtonData === buttonData) {
                // If the same button is clicked again
                if (sidebar.classList.contains('show-sidebar')) {
                    toggleSidebar();
                }
                currentButtonData = null;
                updateSidebarContent(null);
            } else {
                currentButtonData = buttonData;
                updateSidebarContent(buttonData);

                // Add 'selected-item' class to the clicked button
                const clickedButton = this;
                clickedButton.classList.add('selected-item');


                if (!sidebar.classList.contains('show-sidebar') || !mainContent.classList.contains('expand')) {
                    toggleSidebar();
                }
            }
        });
    });

    document.getElementById('toggleSidebar2').addEventListener('click', function() {
        updateSidebarContent(null);
        toggleSidebar();

        // Remove 'selected-item' class from all buttons
        removeSelectedClassFromButtons();
    });

    function toggleSidebar() {
        sidebar.classList.toggle('show-sidebar');
        mainContent.classList.toggle('expand');
    }

    function updateSidebarContent(buttonData) {
        const sidebarDataItems = document.querySelectorAll('.content-data-changer');

        sidebarDataItems.forEach(item => {
            item.classList.remove('active');
        });

        if (buttonData) {
            const dataToShow = document.querySelector(`.content-data-changer[data-content="${buttonData}"]`);
            if (dataToShow) {
                dataToShow.classList.add('active');
            }
            emptyContent.classList.remove('active');
        } else {
            emptyContent.classList.add('active');
        }
    }

    function removeSelectedClassFromButtons() {
        allContactButtons.forEach(button => {
            button.classList.remove('selected-item');
        });
    }

    // Initial check on page load
    const anyContentActive = document.querySelector('.content-data-changer.active');
    if (!anyContentActive) {
        emptyContent.classList.add('active');
    } else {
        emptyContent.classList.remove('active');
    }

    document.getElementById('formSendNewMessage').addEventListener('submit', function(event) {
        const messageInput = document.getElementById('newMessageContent');

        // Trim whitespace and check if the textarea is empty
        if (messageInput.value.trim() === '') {
            // Prevent form submission
            event.preventDefault();

            // Optionally, you can display a custom message to the user
            /*alert('Please enter a message before sending.');*/
        }
    });
});
/* Chat Operations End */
