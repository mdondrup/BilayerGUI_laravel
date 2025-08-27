<?php

use App\Http\Controllers\StatisticsController;
?>
<!doctype html>
<html class="welcome" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<script>
    // Referencia: http://www.html5rocks.com/en/tutorials/speed/animations/
    var last_known_scroll_position = 0;
    var ticking = false;

    function doSomething(scroll_pos) {
        // Hacer algo con la posición del scroll
        //console.log("scrolleo " + scroll_pos + "  " + window.innerHeight);
        if (scroll_pos > 100 && scroll_pos < (window.innerHeight - 80)) {
            $('footer').fadeOut();
        } else {
            $('footer').fadeIn();
        }


    }
    /*
    window.addEventListener('scroll', function(e) {
      last_known_scroll_position = window.scrollY;

      if (!ticking) {
        window.requestAnimationFrame(function() {
          doSomething(last_known_scroll_position);
          ticking = false;
        });
      }
      ticking = true;
    });
    */
</script>

<body id="page-top">

    <!-- Fonts
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
-->
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">NMRlipids Databank</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">

                    <!--  <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>-->
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <!--<li class="nav-item"><a class="nav-link" href="#portfolio">Project</a></li>-->
                    <!--  @if (Route::has('login'))
<li class="nav-item">
                  @auth
                                                                          <a class="nav-link" href="{{ url('/home') }}">Home</a>
@else
    <a  class="nav-link" href="{{ route('login') }}">Login</a>
                  @endauth
                </li>
@endif-->
                </ul>
            </div>
        </div>
    </nav>


   

    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">NMRlipids Databank</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 mb-4 txt_desc">
                        
     <h3 class="text-white mt-0">Showing details for lipid: {{ $lipid['name'] }}</h2>
     </p>
</div>
     <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-left">
                    <p class="text-white-75 mb-4 txt_desc">
<div class="text-white-75 mb-4 txt_desc">   
     <ul>
        @foreach ( $lipid as $key => $value )
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
           
     </ul>
   
</div>
                    </p>

                </div>
            </div>
        </div>
    </section>



   

 <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy;{{ date('Y') }} - NMRlipids</div></div> 

    </footer>
  </body>
</html>




