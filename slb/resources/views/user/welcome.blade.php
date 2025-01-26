<x-user_page>
  <x-slot name="header">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="/" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{asset('assets/temp/img/logo.png')}}" alt="">
        <h1 class="sitename">SLB</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Acceuil<br></a></li>
          <li><a href="#about">À propos</a></li>
          <li><a href="#services">Services</a></li>
          <li class="dropdown"><a href="">Catégories <i class="bi bi-chevron-down"></i></a>
            <ul class="dropdown-menu">
              @foreach ($categories as $category)
          <li class="dropdown"><a href="{{route('consultProduit', $category->id)}}">{{$category->nom}}</a></li>
        @endforeach
            </ul>
          </li>
          <li><a href="#contact">Contacts</a></li>
          @if (Route::has('login'))
          @auth
        <!-- Bouton pour activer le menu déroulant -->
        @if(!empty($verification))
      <li><a href="{{route('panier')}}">Mon panier <i class="bi bi-cart-fill"></i></a></li>
    @endif
        @if (!is_null($commande) && !empty($commande))
      <li class="dropdown"><a href="">Mes commandes <i class="bi bi-chevron-down"></i></a>
      <ul class="dropdown-menu">
      <li class="dropdown"><a href="{{route('mesCommandes', 'en cours')}}">En cours</a></li>
      <li class="dropdown"><a href="{{route('mesCommandes', 'payée')}}">Payée</a></li>
      <li class="dropdown"><a href="{{route('mesCommandes', 'toutes')}}">Toutes</a></li>
      </ul>
      </li>
    @endif
        <div class="dropdown">
        <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div class="flex-container">
        <i class="bi bi-person-circle"></i>
        <i class="bi bi-chevron-down"></i>
        </div>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li class="dropdown-item"><a href="{{route('monProfil', Auth::user()->id)}}"> {{ __('Profile') }}</a></li>
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
      </a>
    @endif
    @endauth
        </nav>
      @endif
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </x-slot>

  <section id="hero" class="hero section">
    <div class="container">
      @if ($actualites->isNotEmpty())
      <div class="card col-12 mb-4 p-3 shadow-sm rounded">
      <ul class="list-unstyled">
        @foreach ($actualites as $actualite)
      <li class="border-bottom pb-2 mb-2">
      <p class="mb-1"><strong>{{$actualite->contenu}}</strong></p>
      <small class="text-muted">Publié le {{ $actualite->updated_at}}</small>
      </li>
    @endforeach
      </ul>
      </div>
    @endif



      <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          @if (session('success'))
        <div class="col-12" id="success-message">
        <div id="reportsChart">
          <div class="alert alert-success custom-alert">
          <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
          </div>
        </div>
        </div>
      @endif
          @if (session('error'))
        <div class="col-12" id="error-message">
        <div id="reportsChart">
          <div class="alert alert-danger custom-alert">
          <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
          </div>
        </div>
        </div>
      @endif
          <h1 data-aos="fade-up">Réinventez votre bureau et votre manière de travailler avec notre collection innovante
            de produits de qualité.</h1>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
          <img src="{{ asset('assets/temp/img/matburaeu.jpg') }}" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>
  </section>
  <!-- /Hero Section -->

  <!-- About Section -->
  <section id="about" class="about section">

    <div class="container" data-aos="fade-up">
      <div class="row gx-0">

        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <div class="content">
            <h3>Qui sommes nous?</h3>
            <h2>Fondée en 2010, SLB s'est engagée à offrir des articles bureautiques de qualité à des prix compétitifs. Aujourd'hui, nous avons le privilège de servir des centaines de clients à travers le pays.
            </h2>
            <p>
              Notre mission est de faciliter le travail de nos clients en leur offrant des produits de bureau de haute
              qualité. Nous valorisons l'intégrité, la satisfaction du client et l'innovation..
            </p>

          </div>
        </div>

        <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
          <img src="{{ asset('assets/temp/img/articles.jpeg') }}" class="img-fluid" alt="">
        </div>

      </div>
    </div>

  </section><!-- /About Section -->

  <!-- Values Section -->
  <section id="values" class="values section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Nos valeurs</h2>
      <p>Que préconisons nous commes valeurs?<br></p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card">
            <img src="{{asset('assets/temp/img/qualité.png')}}" class="img-fluid" alt="">
            <h3>La qualité</h3>
            <p>Offrir des produits de bureau de haute qualité pour garantir la satisfaction et la productivité des
              clients.</p>
          </div>
        </div><!-- End Card Item -->

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card">
            <img src="{{asset('assets/temp/img/fiabilité2.png')}}" class="img-fluid" alt="">
            <h3>La fiabilité</h3>
            <p>Assurer des services fiables pour répondre aux attentes des clients en vue de les satisfaire.</p>
          </div>
        </div><!-- End Card Item -->

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
          <div class="card">
            <img src="{{asset('assets/temp/img/innovation.png')}}" class="img-fluid" alt="">
            <h3>L' innovation</h3>
            <p>S'efforcer d'innover continuellement pour proposer des solutions modernes et efficaces aux besoins de
              bureau.</p>
          </div>
        </div><!-- End Card Item -->

      </div>

    </div>

  </section>
  <section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Services</h2>
      <p>Les services que nous offrons<br></p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="service-item item-red position-relative">
            <i class="bi bi-bag-check icon"></i>
            <h3>Vente d'Articles de bureau en boutique</h3>
            <p>Fourniture de papeterie, fournitures de bureau, matériel informatique, et mobilier de bureau.</p>
          </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item item-cyan position-relative">
            <i class="bi bi-cart-fill icon"></i>
            <h3>Vente d'article de bureau en ligne</h3>
            <p>Plateforme en ligne permettant de commander facilement tous les articles de bureau nécessaires avec un
              système de paiement sécurisé.</p>
          </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-item item-teal position-relative">
            <i class="bi bi-info-circle-fill icon"></i>
            <h3>Assistance client</h3>
            <p>Service client réactif pour répondre aux questions, résoudre les problèmes, et fournir des informations
              sur les produits.</p>
          </div>
        </div><!-- End Service Item -->

      </div>

    </div>

  </section>
  <section id="clients" class="clients section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Clients</h2>
      <p>Nos partenaires<br></p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="swiper init-swiper">
        <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 40
            },
            "480": {
              "slidesPerView": 3,
              "spaceBetween": 60
            },
            "640": {
              "slidesPerView": 4,
              "spaceBetween": 80
            },
            "992": {
              "slidesPerView": 6,
              "spaceBetween": 120
            }
          }
        }
      </script>
        <div class="swiper-wrapper align-items-center">
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-1.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-2.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-3.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-4.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-5.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-6.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-7.png')}}" class="img-fluid"
              alt=""></div>
          <div class="swiper-slide"><img src="{{asset('assets/temp/img/clients/client-8.png')}}" class="img-fluid"
              alt=""></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>
</x-user_page>