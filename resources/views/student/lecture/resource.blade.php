@extends('layouts.course')

@section('title', 'Lecture - Video')

@section('content')
    <style>
        .pdf {
            width: 100%;
            aspect-ratio: 4 / 3;
        }
        .pdf,
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>

    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12 content-above-buttons" style="margin-bottom: 50px">
                    <div class="card card-round">
                        <div class="card-body p-5">
                            <h1>Course Resources</h1>
                            <h3>this resource is important for the course.</h3>
                            <iframe class="pdf"
                                    src="https://pdfobject.com/pdf/sample.pdf"
                                    width="800" height="500">
                            </iframe>
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

