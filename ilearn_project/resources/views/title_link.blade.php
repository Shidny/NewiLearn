@extends('layouts.main')
  @section('title','Ilearn Portal')

  @section('CSS')
  @endsection

  @section('content')
  <div id="title_link_vue"></div>

  <script>
      var entities = {!! json_encode($entities) !!};

      var multi_attachment = {!! json_encode($data_attachemnt) !!};
  </script>
    @vite('resources/js/title_link.js')
  @endsection
  
