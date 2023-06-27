<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description"/>
		<meta content="" name="author"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="" name="description">
    <meta content="" name="keywords">

  <!-- Favicons -->
    
    <link href="{{ URL::asset('assets/img/iLearn.png'); }}" rel="icon">
    <link href="{{ URL::asset('assets/img/apple-touch-icon.png'); }}" rel="apple-touch-icon">
    <link href="{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/vendor/bootstrap-icons/bootstrap-icons.css'); }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css" rel="stylesheet">  
    <link href="{{ URL::asset('assets/css/style.css'); }}" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" rel="stylesheet">
    
    
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous')'}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
  
		@yield('CSS')
</head>
  
<body oncontextmenu="return false">
<div id="app">	

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    
    <!-- logo -->
    <div class="d-flex align-items-center justify-content-between">
      <i>
        <img src="{{ URL::asset('assets/img/iLearn.png'); }}" alt=""  width="15%" style="margin-left: 30px">
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </i>
    </div><!-- End Logo -->
    
      {{-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar --> --}}

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            {{-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> --}}
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ session('user')->firstname.' '.session('user')->lastname }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header"></li>
            <li><hr class="dropdown-divider"></li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/my_profile">
                <i class="bi bi-person"></i><span>My Profile</span>
              </a>
            </li>
            
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/home">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <?php 
        if ($user->role_id == 1 || $user->role_id == 2){
      ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>System Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/categories">
              <i class="bi bi-circle"></i><span class="title"> Categories </span>
            </a>
          </li>
          <li>
            <a href="/policy">
              <i class="bi bi-circle"></i><span class="title"> Policy </span>
            </a>
          </li>
          <li>
            <a href="/new_glossary">
              <i class="bi bi-circle"></i><span class="title"> Glossary </span>
            </a>
          </li>
          <li>
            <a href="/annoucement">
              <i class="bi bi-circle"></i><span class="title"> Announcements Management </span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-menu-button-wide"></i><span>User Management </span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="/user_management">
                  <i class="bi bi-circle"></i><span class="title"> New User </span>
                </a>
              </li>

              <li>
                <a href="/section">
                  <i class="bi bi-circle"></i><span class="title"> New Section </span>
                </a>
              </li>

              <li>
                <a href="/department">
                  <i class="bi bi-circle"></i><span class="title"> New Department </span>
                </a>
              </li>
            </ul>
          </li>
          
          
         <li>
            <a href="/audit_trail">
              <i class="bi bi-circle"></i><span class="title"> Audit Trail Management </span>
            </a>
          </li>
          <li>
            <a href="/newuploadforms">
              <i class="bi bi-circle"></i><span class="title"> Forms </span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link " href="/masterlist">
          <i class="bi bi-grid"></i>
          <span>Master File</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="/glossary">
          <i class="bi bi-grid"></i>
          <span>Glossary</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="/uploadforms">
          <i class="bi bi-grid"></i>
          <span>View Forms</span>
        </a>
      </li>
    </ul>  

    </ul>
  </aside><!-- End Sidebar-->
  <main id="main" class="main">
    @yield('content')
  </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
		<!-- Vendor JS Files -->

<script src="{{ URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>    
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="{{ URL::asset('https://code.jquery.com/jquery-3.6.3.min.js'); }}"></script>
<script src="{{ URL::asset('vendor/jquery.sparkline/jquery.sparkline.min.js'); }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
<script src="{{ URL::asset('assets/js/index.js'); }}"></script>
<script src="{{ URL::asset('assets/js/main.js'); }}"></script>
<script src="{{ URL::asset('assets/jsss/main.js'); }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://malsup.github.io/jquery.blockUI.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="assets/js/multiple-select.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  
<script>
			jQuery(document).ready(function() {
				Main.init();
				Index.init();

				var e = window.location, 
				
				i = $("ul.d-flex align-items-center a").filter(function() {
					return this.href == e
				}).parent("li").addClass("active").parent("ul").css("display","block").parent("li").addClass("open").parent("ul").css("display","block").parent("li").addClass("open").parent("ul").css("display","block").parent("li").addClass("open");
			
				
        var slider = tns({
					container: '.my-slider',
					items: 1,
					mouseDrag: true,
					slideBy: 'page',
					autoplay: true,
					autoplayButtonOutput: false,
					autoplayTimeout: 5000,
				});
			});

      $(document).ready(function() {
        $("optgroup.opt_group").click(function(e) {
          $(this).children().attr('selected','selected');
        });
        
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['fontname', ['fontname']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['height', ['height']],
                ['view', ['fullscreen', 'help']],
            ],
        });
        

       });
		
        // $(document).ready(function() {
        //   $('body').bind('cut copy paste', function(event) {
        //     event.preventDefault();
        //   });
        // });

  </script>
  
</body>
</html>