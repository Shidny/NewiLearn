@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="policy_vue"></div>

  <script>
    var entities = {!! json_encode($entities) !!};
    // console.log(entities);
  </script>
    @vite('resources/js/policy_v1.js')
@endsection

