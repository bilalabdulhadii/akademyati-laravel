@extends('layouts.course')

@section('title', 'Lecture - Video')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12 content-above-buttons" style="margin-bottom: 50px">
                    <div class="card card-round">
                        <div class="card-body p-5">
                            <h1>Download File Example</h1>
                            <a href="{{ asset('assets/home/images/clip-04.jpg') }}" download="custom_filename.jpg">Download File</a>
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

