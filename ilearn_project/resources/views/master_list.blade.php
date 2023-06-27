@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
  {{-- append or mount --}}
	<div id="master_list_vue"></div>

  <script>
    var entities = {!! json_encode($entities) !!};
    // console.log(entities);
  </script>

  {{-- connection or brige --}}
  @vite('resources/js/master_list.js')
@endsection

