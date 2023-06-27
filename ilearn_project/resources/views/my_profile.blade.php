@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="my_profile_vue"></div>

  @vite('resources/js/my_profile.js')

  <script>    
    var entities={!!json_encode($user)!!};


  </script>



@endsection

