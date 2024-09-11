@extends('layouts.course')

@section('title', 'Lecture - Video')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12 content-above-buttons" style="margin-bottom: 50px">
                    <div class="card card-round">
                        <div class="card-body p-5">
                            <h1>All Input Types</h1>
                            <form>
                                <!-- Text Input -->
                                <div class="mb-3">
                                    <label for="text-input" class="form-label">Text Input</label>
                                    <input type="text" class="form-control" id="text-input" name="text-input" placeholder="Enter text">
                                </div>

                                <!-- Email Input -->
                                <div class="mb-3">
                                    <label for="email-input" class="form-label">Email Input</label>
                                    <input type="email" class="form-control" id="email-input" name="email-input" placeholder="Enter email">
                                </div>

                                <!-- Number Input -->
                                <div class="mb-3">
                                    <label for="number-input" class="form-label">Number Input</label>
                                    <input type="number" class="form-control" id="number-input" name="number-input" placeholder="Enter number">
                                </div>

                                <!-- Date Input -->
                                <div class="mb-3">
                                    <label for="date-input" class="form-label">Date Input</label>
                                    <input type="date" class="form-control" id="date-input" name="date-input">
                                </div>

                                <!-- Time Input -->
                                <div class="mb-3">
                                    <label for="time-input" class="form-label">Time Input</label>
                                    <input type="time" class="form-control" id="time-input" name="time-input">
                                </div>

                                <!-- Color Input -->
                                <div class="mb-3">
                                    <label for="color-input" class="form-label">Color Input</label>
                                    <input type="color" class="form-control form-control-color" id="color-input" name="color-input" value="#563d7c">
                                </div>

                                <!-- File Input -->
                                <div class="mb-3">
                                    <label for="file-input" class="form-label">File Input</label>
                                    <input class="form-control" type="file" id="file-input" name="file-input">
                                </div>

                                <!-- Checkbox -->
                                <div class="mb-3">
                                    <label class="form-label">Checkbox</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkbox1" name="checkbox1" value="option1">
                                        <label class="form-check-label" for="checkbox1">Option 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkbox2" name="checkbox2" value="option2">
                                        <label class="form-check-label" for="checkbox2">Option 2</label>
                                    </div>
                                </div>

                                <!-- Radio Buttons -->
                                <div class="mb-3">
                                    <label class="form-label">Radio Buttons</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio1" name="radio-group" value="option1">
                                        <label class="form-check-label" for="radio1">Option 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio2" name="radio-group" value="option2">
                                        <label class="form-check-label" for="radio2">Option 2</label>
                                    </div>
                                </div>

                                <!-- Select Dropdown -->
                                <div class="mb-3">
                                    <label for="select-input" class="form-label">Select Dropdown</label>
                                    <select class="form-select" id="select-input" name="select-input">
                                        <option value="option1">Option 1</option>
                                        <option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option>
                                    </select>
                                </div>

                                <!-- Textarea -->
                                <div class="mb-3">
                                    <label for="textarea-input" class="form-label">Textarea</label>
                                    <textarea class="form-control" id="textarea-input" name="textarea-input" rows="4" placeholder="Enter text"></textarea>
                                </div>

                                <!-- Range Input -->
                                <div class="mb-3">
                                    <label for="range-input" class="form-label">Range Input</label>
                                    <input type="range" class="form-range" id="range-input" name="range-input" min="0" max="100">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="button-container">
                        <a class="btn btn-info">Next</a>
                        <a class="btn btn-info">Prev</a>
                    </div>
                </div>
            </div>
        </div>
        <style>

        </style>
    </div>
@endsection

