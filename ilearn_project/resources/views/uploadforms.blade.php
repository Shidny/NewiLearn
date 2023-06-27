@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="uploadforms_vue"></div>
    @vite('resources/js/uploadforms.js')
@endsection

