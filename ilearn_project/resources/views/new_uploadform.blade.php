@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="new_uploadforms_vue"></div>
    @vite('resources/js/new_uploadforms.js')
@endsection

