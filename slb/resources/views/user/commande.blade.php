<x-user_page>
    <x-slot name="header">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <!-- Logo and Site Name -->
            <a href="/" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('assets/temp/img/logo.png') }}" alt="Logo">
                <h1 class="sitename">SLB</h1>
            </a>

            <!-- Navigation Menu -->
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('welcome') }}">Accueil</a></li>
                    @if (Route::has('login'))
                        @auth
                            <!-- Panier Link -->
                            @if (!empty($verification))
                                <li><a href="{{ route('panier') }}">Mon panier <i class="bi bi-cart-fill"></i></a></li>
                            @endif

                            <!-- Mes Commandes Dropdown -->                          
                                <li class="dropdown">
                                    <a href="#">Mes commandes <i class="bi bi-chevron-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('mesCommandes', 'en cours') }}">En cours</a></li>
                                        <li><a href="{{ route('mesCommandes', 'payée') }}">Payée</a></li>
                                        <li><a href="{{ route('mesCommandes', 'toutes') }}">Toutes</a></li>
                                    </ul>
                                </li>
                            <!-- User Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="flex-container">
                                        <i class="bi bi-person-circle"></i>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li class="dropdown-item"><a href="{{route('monProfil', Auth::user()->id)}}">Profile</a></li>
                                    <li class="dropdown-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                Se déconnecter
                                            </x-dropdown-link>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    @endif  
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </x-slot>

    <!-- Messages Section -->
    <section id="values" class="values section hero1">
        <div class="container section-title" data-aos="fade-up">
            <h2>Mes commandes</h2>
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

        <!-- Commandes Table -->
        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><h5>Numéro de la commande</h5></th>
                        <th><h5>Date</h5></th>
                        <th><h5>Heure</h5></th>
                        <th><h5>Montant</h5></th>
                        <th><h5>Statut</h5></th>
                        <th><h5>Actions</h5></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commandes as $commande)
                        <tr>
                            <td><h6 class="num">{{ $commande->numero_commande }}</h6></td>
                            <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                            <td>{{ $commande->created_at->format('H:i') }}</td>
                            <td><h6 class="prix">{{ number_format($commande->montant, 2, ',', ' ') }} FCFA</h6></td>
                            <td>{{ $commande->etat }}</td>
                            <td>
                                <a href="{{ route('telechargerRecu', $commande->id) }}" class="btn btn-primary action">
                                    <i class="bi bi-download"> Reçu</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        td {
            font-weight: bold;
        }
        .prix {
            color: #4154f1;
        }
        .num {
            color: green;
            font-weight: bold;
        }
    </style>
</x-user_page>
