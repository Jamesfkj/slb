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
                    <li><a href="{{ route('welcome') }}">Accueil</a></li>
                    <li class="dropdown"><a href="">Catégories <i class="bi bi-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            @foreach ($categories as $category)
                                <li class="dropdown"><a
                                        href="{{route('consultProduit', $category->id)}}">{{$category->nom}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @if (Route::has('login'))
                        @auth
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
                            <!-- Bouton pour activer le menu déroulant -->
                            <div class="dropdown">
                                <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <div class="flex-container">
                                        <i class="bi bi-person-circle"></i>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li class="dropdown-item">
                                        <a href="{{route('monProfil', Auth::user()->id)}}">{{ __('Profile') }}</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Se déconnecter') }}
                                            </x-dropdown-link>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                <i class="bi bi-person-circle" id="icon1"></i>
                                <span id="login">Se connecter</span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    <button class="btn btn-primary">Inscription</button>
                                </a>
                            @endif
                        @endauth
                    @endif
                    <style>
                        #login {
                            color: #012970;
                        }
                    </style>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </x-slot>
    <section id="values" class="values section hero1">
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ __($categorie_name->nom) }}</h2><br><br>
            <div class="col-12">
                <div class="card top-selling overflow-auto">
                    <div class="card-body pb-0">
                        <h6 class="card-title">{{$categorie_name->description}}</h6>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success custom-alert" id="success-message">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger custom-alert" id="error-message">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="container">
            <div class="row gy-4">
                @foreach($produits as $produit)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card" data-aos="fade-up" data-aos-delay="200">
                            <img class="image" src="{{ asset('storage/' . $produit->image) }}" class="card-img-top"
                                alt="{{ $produit->nom }}">
                            <h6 class="nom">{{ $produit->nom }}</h6>
                            @if($produit->qte_stock > 0)
                                <i class="etat-enstock">En stock</i>
                            @else
                                <i class="etat-rupture">Rupture de stock</i>
                            @endif
                            <hr color="blue">
                            <div class="prix_div d-flex align-items-center justify-content-between">
                                <h6 class="prix">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</h6>
                                @if($produit->qte_stock > 0)
                                    <form action="{{ route('ajouterPanier') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                        <button type="submit" class="btn custom-btn-green">
                                            <i class="bi bi-bag-plus-fill"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary" disabled>
                                        <i class="bi bi-bag-plus-fill"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div><!-- End Row -->
        </div><!-- End Container -->
        <style>
            .custom-btn-green {
                background-color: #28a745;
                /* Couleur verte Bootstrap */
                border-color: #28a745;
                /* Assure que la bordure est de la même couleur */
                color: white;
            }

            .prix {
                color: salmon;
            }

            .image {
                width: 100%;
                align-self: center;
                height: 150px;
            }

            .nom {
                font-weight: bold;
            }

            .custom-btn-green:hover {
                background-color: #218838;
                border-color: #1e7e34;
                color: white;
                font-size: 20px;
            }
        </style>
        </div>
    </section>
</x-user_page>