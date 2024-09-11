
/* submit forms start */
function sendForm(formId, action) {
    let form = document.getElementById(formId);
    form.action = action;
    form.submit();
}
/* submit forms end */


/*function setupInputToggle(inputSelector, buttonSelector) {
    const textInput = document.querySelector(inputSelector);
    const submitButton = document.querySelector(buttonSelector);

    function toggleButton() {
        if (textInput.value.trim() !== '') {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    textInput.addEventListener('input', toggleButton);
    toggleButton();
}*/


function setupInputToggle(inputSelector, buttonSelector, type = 'text') {
    const inputElement = document.querySelector(inputSelector);
    const submitButton = document.querySelector(buttonSelector);

    function toggleButton() {
        if (type === 'text') {
            submitButton.disabled = inputElement.value.trim() === '';
        } else if (type === 'radio') {
            submitButton.disabled = !document.querySelector(`${inputSelector}:checked`);
        } else if (type === 'select') {
            submitButton.disabled = inputElement.value === '';
        }
    }

    if (type === 'radio') {
        document.querySelectorAll(inputSelector).forEach(radio => {
            radio.addEventListener('change', toggleButton);
        });
    } else {
        inputElement.addEventListener('input', toggleButton);
    }
    toggleButton();
}


/* course content start */
document.getElementById('add-section-btn').addEventListener('click', function() {
    addSection();
});

function addSection() {
    const template = document.getElementById('sectionTemplate');
    const clone = template.content.cloneNode(true);

    const sectionWrappers = document.querySelectorAll('#accordionPanelsStayOpenExample .section-wrapper');
    const existingSections = sectionWrappers.length;

    // Generate unique IDs and names for each section
    const sectionNumber = existingSections + 1;
    const newId = `accordion-section-${sectionNumber}`;
    const titleId = `section-title-${sectionNumber}`;
    const descriptionId = `section-description-${sectionNumber}`;
    const titleName = `section_title_${sectionNumber}`;
    const descriptionName = `section_description_${sectionNumber}`;

    const button = clone.querySelector('.accordion-button');
    const collapse = clone.querySelector('.accordion-collapse');
    const titleInput = clone.querySelector('.section-title');
    const descriptionInput = clone.querySelector('.section-description');

    button.setAttribute('data-bs-target', `#${newId}`);
    button.setAttribute('aria-controls', newId);
    collapse.setAttribute('id', newId);
    /*button.innerText = `Section ${sectionNumber}`;*/
    const sectionNumberSpan = button.querySelector('.section-number');
    if (sectionNumberSpan) {
        sectionNumberSpan.textContent = `Section: ${sectionNumber}`;
    }

    titleInput.setAttribute('id', titleId);
    titleInput.setAttribute('name', titleName);

    descriptionInput.setAttribute('id', descriptionId);
    descriptionInput.setAttribute('name', descriptionName);

    document.getElementById('accordionPanelsStayOpenExample').appendChild(clone);
    document.getElementById('accordionPanelsStayOpenExample').appendChild(document.getElementById('add-section-btn'));
}

document.getElementById('accordionPanelsStayOpenExample').addEventListener('click', function(event) {
    if (event.target.classList.contains('add-lecture-btn')) {
        showLectureOptions(event.target);
    } else if (event.target.classList.contains('lecture-article')) {
        addLectureInputs(event.target, 'article_inputs');
    } else if (event.target.classList.contains('lecture-video')) {
        addLectureInputs(event.target, 'video_inputs');
    } else if (event.target.classList.contains('lecture-resource')) {
    } else if (event.target.classList.contains('lecture-material')) {
    } else if (event.target.classList.contains('lecture-survey')) {
    } else if (event.target.classList.contains('lecture-assignment')) {
    } else if (event.target.classList.contains('lecture-quiz')) {
    } else if (event.target.closest('.section-trash')) {
        deleteSection(event.target.closest('.section-wrapper'));
        updateSectionNumbers();
        updateSectionIds();
        updateSectionFields();
        updateLectureFields();
        updateLectureCounts();
    } else if (event.target.closest('.lecture-trash')) {
        deleteLecture(event.target.closest('.lecture-wrapper'));
    }
});

function deleteSection(section) {
    section.remove();
}

function deleteLecture(lecture) {
    const section = lecture.closest('.accordion-body');
    lecture.remove();
    updateLectureNumbers(section);
    updateLectureIds(section);
    updateLectureFields();
    updateLectureCounts();
}

function showLectureOptions(button) {
    const section = button.closest('.section-wrapper');
    const buttonBox = section.querySelector('.button-box');
    button.classList.add('hidden');
    buttonBox.classList.remove('hidden');
}

function addLectureInputs(button, templateId) {
    const template = document.getElementById(templateId);
    const clone = template.content.cloneNode(true);
    const section = button.closest('.section-wrapper');
    const lectureContainer = section.querySelector('.lecture-container');

    // Count existing lectures in this section
    const existingLectures = lectureContainer.querySelectorAll('.inputs').length;
    const lectureNumber = existingLectures + 1;
    const sectionNumber = Array.from(section.parentElement.children).indexOf(section) + 1;

    // Update lecture number in the cloned template
    clone.querySelector('.lecture-number').textContent = lectureNumber;

    // Generate unique ID for the new lecture
    const newId = `section-${sectionNumber}-lecture-${lectureNumber}`;
    clone.querySelector('.inputs').setAttribute('id', newId);

    // Update IDs and names for input fields based on section and lecture numbers
    const inputs = clone.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        const fieldName = input.getAttribute('name');
        if (fieldName) {
            input.setAttribute('name', `section_${sectionNumber}_lecture_${lectureNumber}_${fieldName}`);
        }
        const fieldId = input.getAttribute('id');
        if (fieldId) {
            input.setAttribute('id', `section-${sectionNumber}-lecture-${lectureNumber}-${fieldId}`);
        }
    });

    lectureContainer.appendChild(clone);
    const buttonBox = section.querySelector('.button-box');
    buttonBox.classList.add('hidden');
    const addLectureBtn = section.querySelector('.add-lecture-btn');
    addLectureBtn.classList.remove('hidden');
    /*section.appendChild(addLectureBtn);*/
    lectureContainer.appendChild(addLectureBtn);

    // Call updateLectureFields after adding the lecture
    updateLectureFields();
    updateLectureCounts();
}

function updateLectureCounts() {
    const sections = document.querySelectorAll('.section-wrapper');
    sections.forEach(section => {
        // Find the number of lectures in the section
        const lectureCount = section.querySelectorAll('.inputs').length;

        // Find the small tag with class 'lectures-count'
        const lecturesCountTag = section.querySelector('.lectures-count');

        if (lecturesCountTag) {
            // Update the text content to show the number of lectures
            lecturesCountTag.textContent = `(${lectureCount} lectures)`;
        }
    });
}


/*function updateSectionNumbers() {
    const sections = document.querySelectorAll('.section-wrapper');
    sections.forEach((section, index) => {
        const button = section.querySelector('.accordion-button');
        button.innerText = `Section ${index + 1}:`;
    });
}*/

function updateSectionNumbers() {
    const sections = document.querySelectorAll('.section-wrapper');
    sections.forEach((section, index) => {
        const button = section.querySelector('.accordion-button');
        // Find the span with the class 'section-number' within the button
        const sectionNumberSpan = button.querySelector('.section-number');
        if (sectionNumberSpan) {
            sectionNumberSpan.textContent = `Section: ${index + 1}`;
        }
    });
}

function updateSectionIds() {
    const sections = document.querySelectorAll('.section-wrapper');
    sections.forEach((section, index) => {
        const newId = `accordion-section-${index + 1}`;
        const button = section.querySelector('.accordion-button');
        const collapse = section.querySelector('.accordion-collapse');
        button.setAttribute('data-bs-target', `#${newId}`);
        button.setAttribute('aria-controls', newId);
        collapse.setAttribute('id', newId);
    });
}

function updateSectionFields() {
    const sections = document.querySelectorAll('.section-wrapper');
    sections.forEach((section, index) => {
        const sectionNumber = index + 1;

        // Update section title and description IDs and names
        const titleInput = section.querySelector('.section-title');
        const descriptionInput = section.querySelector('.section-description');

        titleInput.setAttribute('id', `section-title-${sectionNumber}`);
        titleInput.setAttribute('name', `section_title_${sectionNumber}`);

        descriptionInput.setAttribute('id', `section-description-${sectionNumber}`);
        descriptionInput.setAttribute('name', `section_description_${sectionNumber}`);

        // Update accordion button text
        const button = section.querySelector('.accordion-button');
        button.setAttribute('data-bs-target', `#accordion-section-${sectionNumber}`);
        button.setAttribute('aria-controls', `accordion-section-${sectionNumber}`);
        /*button.innerText = `Section ${sectionNumber}:`;*/
        const sectionNumberSpan = button.querySelector('.section-number');
        if (sectionNumberSpan) {
            sectionNumberSpan.textContent = `Section: ${sectionNumber}`;
        }

        // Update collapse ID
        const collapse = section.querySelector('.accordion-collapse');
        collapse.setAttribute('id', `accordion-section-${sectionNumber}`);
    });
}

/*function updateLectureNumbers(section) {
    const lectures = section.querySelectorAll('.inputs');
    lectures.forEach((lecture, index) => {
        const lectureNumber = index + 1;
        lecture.querySelector('.lecture-number').textContent = lectureNumber;
    });
}*/

function updateLectureNumbers(section) {
    const lectures = section.querySelectorAll('.inputs');

    lectures.forEach((lecture, index) => {
        // Update the display of the lecture number
        const lectureNumber = index + 1;
        const lectureNumberElement = lecture.querySelector('.lecture-number');
        if (lectureNumberElement) {
            lectureNumberElement.textContent = lectureNumber;
        }
    });
}

function updateLectureIds(section) {
    const lectures = section.querySelectorAll('.inputs');
    lectures.forEach((lecture, index) => {
        const newId = `lecture-${index + 1}`;
        lecture.setAttribute('id', newId);
    });
}

function updateLectureFields() {
    // Get all sections
    const sections = document.querySelectorAll('.section-wrapper');
    sections.forEach((section, sectionIndex) => {
        // Update section number
        const sectionNumber = sectionIndex + 1;

        // Get all lectures in the section
        const lectures = section.querySelectorAll('.inputs');
        lectures.forEach((lecture, lectureIndex) => {
            // Update lecture number
            const lectureNumber = lectureIndex + 1;

            // Update lecture number text
            const lectureNumberElement = lecture.querySelector('.lecture-number');
            if (lectureNumberElement) {
                lectureNumberElement.textContent = lectureNumber.toString();
            }

            // Update IDs and names for input fields
            const inputs = lecture.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                const fieldName = input.getAttribute('name');
                if (fieldName) {
                    let newFieldName;
                    if (fieldName === 'article' || fieldName === 'video') {
                        newFieldName = `section_${sectionNumber}_lecture_${lectureNumber}_${fieldName}`;
                    } else {
                        const nameParts = fieldName.split('_');
                        newFieldName = `section_${sectionNumber}_lecture_${lectureNumber}_${nameParts.slice(-1).join('_')}`;
                    }
                    input.setAttribute('name', newFieldName);
                }

                const fieldId = input.getAttribute('id');
                if (fieldId) {
                    let newFieldId;
                    if (fieldId.includes('lecture-type')) {
                        newFieldId = `section-${sectionNumber}-lecture-${lectureNumber}-lecture-type`;
                    } else {
                        const idParts = fieldId.split('-');
                        newFieldId = `section-${sectionNumber}-lecture-${lectureNumber}-${idParts.slice(-1).join('-')}`;
                    }
                    input.setAttribute('id', newFieldId);
                }
            });
        });
    });
}

document.addEventListener('click', function(event) {
    const isClickInsideBox = event.target.closest('.button-box');
    const isClickOnAddLectureBtn = event.target.closest('.add-lecture-btn');

    if (!isClickInsideBox && !isClickOnAddLectureBtn) {
        document.querySelectorAll('.button-box').forEach(box => box.classList.add('hidden'));
        document.querySelectorAll('.add-lecture-btn').forEach(btn => btn.classList.remove('hidden'));
    }
});

/* course content end */


/* course objectives start */
document.querySelector('.add-more-objective').addEventListener('click', function() {
    addObjective();
});

function addObjective() {
    const objectiveContainer = document.querySelector('.objectives-container');
    const inputs = objectiveContainer.querySelectorAll('input');

    // Check if the last input is not empty before adding a new one
    if (inputs.length > 0) {
        const lastInput = inputs[inputs.length - 1];
        if (lastInput.value.trim() === '') {
            // Do not add if the last input is empty
            /*alert('Please fill in the previous objective before adding a new one.');*/
            return;
        }
    }

    // Count existing inputs
    const existingInputs = objectiveContainer.querySelectorAll('input').length;
    const newObjectiveNumber = existingInputs + 1;

    // Clone the template and set the new ID and name
    const template = document.getElementById('objective-template');
    const clone = template.content.cloneNode(true);
    const newInput = clone.querySelector('input');
    const deleteButton = clone.querySelector('.objective-trash');

    newInput.setAttribute('name', `course_objective_${newObjectiveNumber}`);
    newInput.setAttribute('id', `course-objective-${newObjectiveNumber}`);
    newInput.setAttribute('placeholder', `Enter objective ${newObjectiveNumber}`);

    // Attach the delete event listener to the new delete button
    deleteButton.addEventListener('click', function() {
        deleteObjective(this);
    });

    // Append the cloned input to the objectives container
    objectiveContainer.appendChild(clone);
}

function deleteObjective(button) {
    const objectiveContainer = document.querySelector('.objectives-container');
    const inputs = objectiveContainer.querySelectorAll('input');

    // Check if there is more than one input before deleting
    if (inputs.length > 3) {
        button.parentElement.remove();
        // Update the IDs and names of remaining inputs
        updateObjectiveInputs();
    }
}

function updateObjectiveInputs() {
    const objectiveContainer = document.querySelector('.objectives-container');
    const inputs = objectiveContainer.querySelectorAll('input');

    inputs.forEach((input, index) => {
        input.setAttribute('name', `course_objective_${index + 1}`);
        input.setAttribute('id', `course-objective-${index + 1}`);
        input.setAttribute('placeholder', `Enter objective ${index + 1}`);
    });
}

// Initial setup for existing delete buttons
document.querySelectorAll('.objective-trash').forEach(button => {
    button.addEventListener('click', function() {
        deleteObjective(this);
    });
});
/* course objectives end */


/* course prerequisites end */
document.querySelector('.add-more-prerequisite').addEventListener('click', function() {
    addPrerequisite();
});

function addPrerequisite() {
    const prerequisiteContainer = document.querySelector('.prerequisites-container');
    const inputs = prerequisiteContainer.querySelectorAll('input');

    // Check if the last input is not empty before adding a new one
    if (inputs.length > 0) {
        const lastInput = inputs[inputs.length - 1];
        if (lastInput.value.trim() === '') {
            // Do not add if the last input is empty
            /*alert('Please fill in the previous objective before adding a new one.');*/
            return;
        }
    }

    // Count existing inputs
    const existingInputs = prerequisiteContainer.querySelectorAll('input').length;
    const newObjectiveNumber = existingInputs + 1;

    // Clone the template and set the new ID and name
    const template = document.getElementById('prerequisite-template');
    const clone = template.content.cloneNode(true);
    const newInput = clone.querySelector('input');
    const deleteButton = clone.querySelector('.prerequisite-trash');

    newInput.setAttribute('name', `course_prerequisite_${newObjectiveNumber}`);
    newInput.setAttribute('id', `course-prerequisite-${newObjectiveNumber}`);
    newInput.setAttribute('placeholder', `Enter prerequisite ${newObjectiveNumber}`);

    // Attach the delete event listener to the new delete button
    deleteButton.addEventListener('click', function() {
        deletePrerequisite(this);
    });

    // Append the cloned input to the objectives container
    prerequisiteContainer.appendChild(clone);
}

function deletePrerequisite(button) {
    const prerequisiteContainer = document.querySelector('.prerequisites-container');
    const inputs = prerequisiteContainer.querySelectorAll('input');

    // Check if there is more than one input before deleting
    if (inputs.length > 0) {
        button.parentElement.remove();
        // Update the IDs and names of remaining inputs
        updatePrerequisiteInputs();
    }
}

function updatePrerequisiteInputs() {
    const prerequisiteContainer = document.querySelector('.prerequisites-container');
    const inputs = prerequisiteContainer.querySelectorAll('input');

    inputs.forEach((input, index) => {
        input.setAttribute('name', `course_prerequisite_${index + 1}`);
        input.setAttribute('id', `course-prerequisite-${index + 1}`);
        input.setAttribute('placeholder', `Enter prerequisite ${index + 1}`);
    });
}

// Initial setup for existing delete buttons
document.querySelectorAll('.prerequisite-trash').forEach(button => {
    button.addEventListener('click', function() {
        deletePrerequisite(this);
    });
});
/* course prerequisites end */
