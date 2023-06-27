@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="search_vue"></div>

  <script>
    var entities = {!! json_encode($entities) !!};
    // console.log(entities);
  </script>
    @vite('resources/js/search_bar.js')
@endsection

