@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="user_management_vue"></div>

  <script>
    var entities = {!! json_encode($entities) !!};
</script>

  @vite('resources/js/user_management.js')
@endsection

