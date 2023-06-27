@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="glossary_vue"></div>

  @vite('resources/js/glossary.js')
@endsection

