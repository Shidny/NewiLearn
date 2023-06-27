@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
	<div id="link_form_vue">
        
    </div>

  <script>
    var entities = {!! json_encode($data_sp) !!};
    // console.log(entities);
  </script>
    @vite('resources/js/link_form.js')
@endsection

