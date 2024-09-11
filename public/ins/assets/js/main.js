

/* Overview filter bar start */

document.addEventListener('DOMContentLoaded', function () {
    const filterBar = document.querySelector('.overview-filter-bar');
    const filterBarContainer = document.querySelector('.overview-filter-bar-container');
    const leftArrow = document.getElementById('overviewLeftArrow');
    const rightArrow = document.getElementById('overviewRightArrow');
    const scrollAmount = 200; // Amount to scroll on each arrow click

    function updateArrowVisibility() {
        const containerWidth = filterBarContainer.offsetWidth;
        const barWidth = filterBar.scrollWidth;

        // Show or hide arrows based on content overflow
        leftArrow.style.display = filterBar.scrollLeft > 0 ? 'block' : 'none';
        rightArrow.style.display = filterBar.scrollLeft < barWidth - containerWidth ? 'block' : 'none';
    }

    // Remove hidden-arrows class to show arrows
    leftArrow.classList.remove('hidden-arrows');
    rightArrow.classList.remove('hidden-arrows');

    // Add event listeners for arrows
    leftArrow.addEventListener('click', function () {
        filterBar.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });

    rightArrow.addEventListener('click', function () {
        filterBar.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });

    // Update arrow visibility on scroll and resize
    updateArrowVisibility();
    filterBar.addEventListener('scroll', updateArrowVisibility);
    window.addEventListener('resize', updateArrowVisibility);

    // Add click event listener to tabs
    filterBar.addEventListener('click', function (event) {
        const target = event.target;
        if (target.classList.contains('overview-filter-tab')) {
            // Remove active class from all tabs
            document.querySelectorAll('.overview-filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            // Add active class to the clicked tab
            target.classList.add('active');
        }
    });
});


/*document.addEventListener('DOMContentLoaded', function () {
    const filterBar = document.querySelector('.overview-filter-bar');
    const filterBarContainer = document.querySelector('.overview-filter-bar-container');
    const leftArrow = document.getElementById('overviewLeftArrow');
    const rightArrow = document.getElementById('overviewRightArrow');
    const scrollAmount = 200; // Amount to scroll on each arrow click

    function updateArrowVisibility() {
        const containerWidth = filterBarContainer.offsetWidth;
        const barWidth = filterBar.scrollWidth;

        // Show or hide arrows based on content overflow
        leftArrow.style.display = filterBar.scrollLeft > 0 ? 'block' : 'none';
        rightArrow.style.display = filterBar.scrollLeft < barWidth - containerWidth ? 'block' : 'none';
    }

    // Add event listeners for arrows
    leftArrow.addEventListener('click', function () {
        filterBar.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });

    rightArrow.addEventListener('click', function () {
        filterBar.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });

    // Update arrow visibility on scroll and resize
    updateArrowVisibility();
    filterBar.addEventListener('scroll', updateArrowVisibility);
    window.addEventListener('resize', updateArrowVisibility);

    // Add click event listener to tabs
    filterBar.addEventListener('click', function (event) {
        const target = event.target;
        if (target.classList.contains('overview-filter-tab')) {
            // Remove active class from all tabs
            document.querySelectorAll('.overview-filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            // Add active class to the clicked tab
            target.classList.add('active');
        }
    });
});*/

/* Overview filter bar end */


/* Submit form with form-id and button-id start */
/*document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createButton').addEventListener('click', function() {
        document.getElementById('createCourseForm').submit();
    });
    document.getElementById('checkPublishBtn').addEventListener('click', function() {
        document.getElementById('check2Form').submit();
    });
});*/

function submitFormIdBtnId(buttonId, formId) {
    const button = document.getElementById(buttonId);
    const form = document.getElementById(formId);

    if (button && form) {
        button.addEventListener('click', function() {
            form.submit();
        });
    }
}
/* Submit form with form-id and button-id end */

// scripts.js

// scripts.js

function copyUrlToClipboard() {
    const pageUrl = window.location.href;
    navigator.clipboard.writeText(pageUrl).then(function() {
        // Show the message
        const messageElement = document.getElementById('copyMessage');
        messageElement.style.display = 'block';

        // Hide the message after 3 seconds
        setTimeout(function() {
            messageElement.style.display = 'none';
        }, 3000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
    });
}



