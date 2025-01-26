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
                    @if (!is_null($commande) && !empty($commande))
                        <li class="dropdown"><a href="">Mes commandes <i class="bi bi-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown"><a href="{{route('mesCommandes', 'en cours')}}">En cours</a></li>
                                <li class="dropdown"><a href="{{route('mesCommandes', 'payée')}}">Payée</a></li>
                                <li class="dropdown"><a href="{{route('mesCommandes', 'toutes')}}">Toutes</a></li>
                            </ul>
                        </li>
                    @endif
                    @if (Route::has('login'))
                                @auth
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
                                            <li class="dropdown-item"><a href="{{route('monProfil', Auth::user()->id)}}"> {{ __('Profile') }}</a></li>
                                            <li class="dropdown-item">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf

                                                    <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              this.closest('form').submit();">
                                                        {{ __('Se déconnecter') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                @endauth
                        </nav>
                    @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </x-slot>


    <!-- Affichage des messages d'erreur -->

    <section id="values" class="values section hero1">

        <div class="container section-title" data-aos="fade-up">
            <h2>{{ __('Mon panier') }}</h2>
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
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger custom-alert" id="error-message">
                            <i class="bi bi-exclamation-triangle-fill"></i>{{ $error }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="container">

            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            <h5>Article</h5>
                        </th>
                        <th scope="col">
                            <h5>Prix unitaire</h5>
                        </th>
                        <th scope="col">
                            <h5>Quantité</h5>
                        </th>
                        <th scope="col">
                            <h5>Total</h5>
                        </th>
                        <th scope="col">
                            <h5>Supprimer</h5>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                                        @php
                                            $quantite = isset($panier[$produit->id]['quantite']) ? $panier[$produit->id]['quantite'] : 1;
                                            $totalProduit = $produit->prix * $quantite;
                                        @endphp
                                        <tr>
                                            <td>
                                                <h5>{{ $produit->nom }}</h5>
                                            </td>
                                            <td>

                                                <h6 class="prix">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</h6>
                                            </td>
                                            <td>
                                                <form action="{{route('modifierQte', $produit->id)}}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input type="number" value="{{ $quantite }}" class="form-control me-2"
                                                            name="quantite">
                                                        <button type="submit" class="btn custom-btn-green">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                                </form>
                                            </td>
                                            <td>
                                                <h6 class="prix">{{ number_format($totalProduit, 2, ',', ' ') }} FCFA</h6>
                                            </td>
                                            <td>
                                                <form action="{{ route('retirerDuPanier', $produit->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">
                            <h5>Total à payer</h5>
                        </td>
                        <td colspan="2">
                            <h4 class=""><strong>{{ number_format($totalPanier, 2, ',', ' ') }} FCFA</strong></h3>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <!-- Bouton "Confirmez ma commande" à droite -->
                <form action="{{ route('creerCommande') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Confirmez ma commande</button>
                </form>
            </div>
        </div>
        </div>
        <style>
            .montant {
                font-weight: bold;
            }

            .custom-btn-green {
                background-color: #28a745;
                /* Couleur verte Bootstrap */
                border-color: #28a745;
                /* Assure que la bordure est de la même couleur */
                color: white;
            }

            .prix {
                color: #4154f1;
                ;
                font-weight: bold;
            }

            input[type="text"] {
                width: 80%;
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