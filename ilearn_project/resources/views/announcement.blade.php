@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')

    <div id="announcement_vue"></div>
    @vite('resources/js/announcement.js')
  @endsection

