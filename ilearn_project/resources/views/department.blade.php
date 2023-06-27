@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="department_vue"></div>
  

  @vite('resources/js/department.js')
@endsection

