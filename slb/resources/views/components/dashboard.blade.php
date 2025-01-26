<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SLB - Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('lien/img/favicon.png" rel="icon')}}">
  <link href="{{asset('lien/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('lien/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('lien/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('lien/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('lien/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('lien/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('lien/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('lien/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('lien/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center">
        <img src="{{asset('lien/img/logo.png')}}" alt="">
        <span class="d-none d-lg-block">SLB</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <li class="nav-item dropdown pe-3">

          @if (Route::has('login'))
          @auth
        <!-- Bouton pour activer le menu déroulant -->
        <div class="dropdown">
        <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        aria-expanded="false">
        <style>
        #dropdownMenuButton {
          background-color: #4154f1;
          color: white;
        }

        .btn-primary {
          background-color: #4154f1;
          color: white;
        }
        </style>
        <div class="flex-container">
        <i class="bi bi-person-circle"></i>
        <span>{{ Auth::user()->name }}</span>
        <i class="bi bi-chevron-down"></i>
        <style>
          .flex-container {
          display: flex;
          align-items: center;
          padding-right: 3px;
          }

          .flex-container i {
          margin-right: 3px;
          /* Espacement entre l'icône et le texte */
          }
        </style>
        </div>

        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li class="dropdown-item"><a href="{{route('profile.edit')}}"><span>{{ __('Profile') }}</span></a></li>
        <li class="dropdown-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <x-dropdown-link :href="route('logout')"
          onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</x-dropdown-link>
        </form>
        </li>
        </ul>
        </div>

      @else
      <a href="{{ route('login') }}"
      class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
      <i class="bi bi-person-circle" id="icon1"> </i>
      <style>
      #icon1 {
      font-size: 20px;
      color: #012970;
      margin-right: 5px;
      }
      </style>
      <span id="login">Se connecter</span>
      <style>
      #login {
      color: #012970;
      }
      </style>
      </a>

      @if (Route::has('register'))
      <a href="{{ route('register') }}"
      class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
      <button class="btn btn-primary">Inscription</button>
      <style>
      .btn-primary {
      background-color: #012970;
      color: white;
      }
      </style>
      </a>
    @endif
    @endauth
      </nav>
    @endif
    <!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

    </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin')}}">
          <i class="bi bi-grid"></i>
          <span>Aujoud'hui</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-activity"></i><span>Activité</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('surIntervalle')}}">
              <i class="bi bi-circle"></i><span>Intervalle de date</span>
            </a>
          </li>
          <li>
            <a href="{{route('surLeMois')}}">
              <i class="bi bi-circle"></i><span>Sur le mois</span>
            </a>
          </li>
          <li>
            <a href="{{route('surAnnee')}}">
              <i class="bi bi-circle"></i><span>Sur l'année</span>
            </a>
          </li>
          <li>
            <a href="{{route('toutesActivite')}}">
              <i class="bi bi-circle"></i><span>Toutes les activités</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bag"></i><span>Commandes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('consultCommandeAdmin', 'en cours')}}">
              <i class="bi bi-circle"></i><span>En cours</span>
            </a>
          </li>
          <li>
            <a href="{{route('consultCommandeAdmin', 'payée')}}">
              <i class="bi bi-circle"></i><span>Payé</span>
            </a>
          </li>
          <li>
            <a href="{{route('consultCommandeAdmin', 'toutes')}}">
              <i class="bi bi-circle"></i><span>Toutes</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-plus-circle"></i><span>Ajouter</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('formCategorie')}}">
              <i class="bi bi-circle"></i><span>Catégorie</span>
            </a>
          </li>
          <li>
            <a href="{{route('formProduit')}}">
              <i class="bi bi-circle"></i><span>Produit</span>
            </a>
          </li>
          <li>
            <a href="{{route('formActualite')}}">
              <i class="bi bi-circle"></i><span>Actualité</span>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-view-list"></i><span>Consulter</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('consultCategorie')}}">
              <i class="bi bi-circle"></i><span>Catégorie</span>
            </a>
          </li>
          <li>
            <a href="{{route('tousProduits')}}">
              <i class="bi bi-circle"></i><span>Produit</span>
            </a>
          </li>
          <li>
            <a href="{{route('tousActualite')}}">
              <i class="bi bi-circle"></i><span>Actualités</span>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>Listes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('listeInscrits')}}">
              <i class="bi bi-circle"></i><span>Liste des inscrits</span>
            </a>
          </li>
          <li>
            <a href="{{route('listeClients')}}">
              <i class="bi bi-circle"></i><span>Liste des clients</span>
            </a>
          </li>
        </ul>
      </li>



      <li class="nav-heading">Pages</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('profile.edit')}}">
          <i class="bi bi-person"></i>
          <span>Profil</span>
        </a>
      </li><!-- End Profile Page Nav -->


  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <section class="section dashboard">
      {{$slot}}
    </section>
  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
  </footer><!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="{{asset('lien/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('lien/vendor/bootstrap/js/bootstrap.bundle.min.j')}}s"></script>
  <script src="{{asset('lien/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('lien/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('lien/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('lien/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('lien/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('lien/vendor/php-email-form/validate.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('lien/js/main.js')}}"></script>
</body>

</html>