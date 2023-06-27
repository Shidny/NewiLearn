@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
    <div id="audit_trail_vue"></div>

    @vite('resources/js/audit_trail.js')
  @endsection

