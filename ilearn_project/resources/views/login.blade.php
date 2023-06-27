@extends('layouts.master')
@section('title','ILearn')

@section('CSS')
@endsection

@section('content')
<div id="index-page" class="container-fluid">
    <div class="row">
        <div id='app'></div>
        <!-- end: LOGIN BOX -->
        @vite(['resources/js/login_form.js'])
    </div>    
</div>
@endsection