@extends('layouts.master')
@section('title','ILearn')

@section('CSS')
@endsection

@section('content')
<div id="index-page" class="container-fluid">
    <div class="row">
        <div id='app'></div>
        <!-- end: LOGIN BOX -->
        @vite(['resources/js/forgot_password.js'])
    </div>    
</div>
@endsection