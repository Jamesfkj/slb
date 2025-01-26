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
                        @auth                       <div class="dropdown">
                                <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <div class="flex-container">
                                        <i class="bi bi-person-circle"></i>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li class="dropdown-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                Se déconnecter
                                            </x-dropdown-link>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    @endif                  </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </x-slot>

    <!-- Messages Section -->
    <section id="values" class="values section hero1">
        <div class="container section-title" data-aos="fade-up">
            <h2>Mon profil</h2>
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
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="row">
                    <!-- Card for Name -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card p-3 shadow-sm rounded" data-aos="fade-up">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-person-circle"></i> Nom complet
                                </h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $user->name) }}" placeholder="Nom complet">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card for Email -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card p-3 shadow-sm rounded" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-envelope"></i> Email
                                </h5>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $user->email) }}" placeholder="Email">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card for Phone -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card p-3 shadow-sm rounded" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-telephone"></i> Téléphone
                                </h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="telephone"
                                        value="{{ old('telephone', $user->telephone) }}" placeholder="Téléphone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary mb-4">Mettre à jour</button>
                    </div>
            </form>

            <div class="row">
                <!-- Form for Password Update -->
                <form method="post" action="{{ route('password.update') }}" class="col-lg-6 d-flex">
                    @csrf
                    @method('put')
                    <div class="card p-3 shadow-sm rounded flex-fill" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-lock"></i> Changer le mot de passe
                            </h5>
                            <div class="mb-4">
                                <input type="password" class="form-control" name="current_password"
                                    placeholder="Mot de passe actuel">
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Nouveau mot de passe">
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Confirmer le nouveau mot de passe">
                            </div>
                            <div class="d-flex justify-content-start ">
                                <button type="submit" class="btn btn-primary col-4 ">Enregistrer</button>
                            </div>

                        </div>
                    </div>
                </form>

                <!-- Card for Additional Info -->
                <div class="col-lg-6 d-flex">
                    <div class="card p-3 shadow-sm rounded flex-fill" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-info-circle"></i> Information sur mes activites
                            </h5>
                            <div class=" mt-4 d-flex justify-content-between">
                                <h6>Date d'inscription :</h6>
                                <p><strong>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</strong></p>
                            </div>
                            <div class=" d-flex justify-content-between">
                                <h6>Nombre de commandes :</h6>
                                <p><strong>{{ $nb_commande }}</strong></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6>Commandes en cours:</h6>
                                <p><strong>{{ $comm_en_cours }}</strong></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6>Commandes payées:</h6>
                                <p><strong>{{ $comm_payees }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Address -->
                <div class=" col-12 mb-4 mt-4">
                    <div class="card p-3 shadow-sm rounded" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body">
                            <h5 class="card-title" style="color:red">
                                <i class="bi bi-person-x"></i> Supprimer mon compte
                            </h5>
                            <div class="mb-3">
                                <h6>Une fois votre compte supprimé, toutes ses ressources et données seront
                                    définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger
                                    toutes les données ou informations que vous souhaitez conserver.</h6>
                            </div>
                            <form action="{{route('supprimerCompte', Auth::user()->id)}}" class="d-flex justify-content-start" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-danger col-2">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
    </section>
    <style>
        .card-title {
            color: #4154f1;
        }
    </style>
</x-user_page>