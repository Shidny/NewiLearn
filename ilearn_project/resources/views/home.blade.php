@extends('layouts.main')
@section('title','Ilearn Portal')

@section('CSS')
  <style>
    .tns-controls {
        display: none;
    }

    .tns-nav {
        display: none;
    }

#container {
  border: 3px solid rgb(128, 125, 125);
  padding: 10px;
  width: 20em;
  height: 50%;
  max-width: 100%;
  max-height: 50%;
  border-radius: 15px;
}

#slider_size{
  width: 100%;
  max-width: 100%;
  object-fit: contain;
  max-height: 100%
  max-width: 114rem;
  height: 80vh;
  position: relative;
  box-shadow: 0 0.6rem 1.2rem rgba(0, 0, 0, 0.15);
}
</style>
@endsection

@section('content')
<div class="pagetitle">
  <div id="search_vue"></div>
  @vite('resources/js/search_bar.js')
</div><!-- End Page Title -->

@yield('content')
{{-- <section class="section dashboard"> --}}
  <div class="my-slider mb-4">
    <?php foreach ($dashboard_item as $key => $value) {
    ?>
      <div id="container"> 
        <center><img id="slider_size" src="<?= $value->S3_url?>"></center>
      </div>
    <?php    
    }
    ?>
  </div>


{{-- </section> --}}

<div id="home_vue"></div>

<script>
  var category_array = {!! json_encode($category_array) !!};
</script>

@vite('resources/js/home.js')
    @endsection


