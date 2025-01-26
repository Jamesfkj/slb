<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SLB</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- Favicons -->
  <link href="{{asset('assets/temp/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/temp/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
  <!-- Fonts -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/temp/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/temp/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/temp/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/temp/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/temp/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <!-- Main CSS File -->
  <link href="{{asset('assets/temp/css/main.css')}}" rel="stylesheet">
  <link href="{{asset('assets/temp/css/index.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    {{$header}}
  </header>

  <main class="main">
    {{$slot}}
  </main>
  <footer id="footer" class="footer">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Rejoignez notre Newsletter</h4>
            <p>Abonnez-vous à notre newsletter et recevez les dernières nouvelles sur nos produits et services !</p>
            <form action="" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="S'abonner">
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-3 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">Société Lidao Best</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Lomé, TOGO</p>
            <p>Agoè-Cacaveli</p>
            <p class="mt-3"><strong>Phone:</strong> <span>90 23 32 33</span></p>
            <p><strong>Email:</strong> <span>lidao@example.com</span></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 footer-links">
          <h4>Nos services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i>Vente d'articles en ligne</li>
            <li><i class="bi bi-chevron-right"></i>Vente d'articles en boutique</li>
            <li><i class="bi bi-chevron-right"></i>Assistance client</li>
          </ul>
        </div>

        <div class="col-lg-3">
          <div class="info-item footer-links">
            <h4>Heure d'ouverture</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i>Lundi - Vendredi</li>
              <li><i class="bi bi-chevron-right"></i>7:00 - 18:30</li>
            </ul>
          </div>
        </div><!-- End Info Item -->

        <div class="col-lg-3 col-md-12">
          <h4>Suivez-nous !</h4>
          <p>Nous partageons régulièrement des informations importantes sur nos produits et services.</p>

          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>
  </footer>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/temp/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('assets/temp/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/temp/js/main.js')}}"></script>

</body>

</html>