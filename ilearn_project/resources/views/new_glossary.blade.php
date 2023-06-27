@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="new_glossary_vue"></div>

  @vite('resources/js/new_glossary.js')
@endsection

