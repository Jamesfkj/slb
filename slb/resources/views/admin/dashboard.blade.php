<x-dashboard>
    <!-- Alertes -->
    @if (session('success'))
        <div class="alert alert-success custom-alert" id="success-message">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger custom-alert" id="error-message">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}
                </div>
            @endforeach
        </ul>
    @endif

    <!-- Filtrage -->
    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center w-100 justify-content-between">
            <p class="mb-0"><strong>{{ $titre }}</strong></p>
            <div>
                @if (in_array(Route::currentRouteName(), ['surLeMois', 'moisActivite']))
                    <form action="{{ route('moisActivite') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('POST')
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <select name="mois" class="form-select" placeholder="Choisir un mois">
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ (request('mois') == $month || (!request('mois') && $month == date('n'))) ? 'selected' : '' }}>
                                            {{ (new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM'))->format(DateTime::createFromFormat('!m', $month)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="me-2">
                                <select name="annee" class="form-select" placeholder="Choisir une année">
                                    @foreach(array_reverse(range(date('Y') - 10, date('Y'))) as $year)
                                        <option value="{{ $year }}" {{ request('annee') == $year || (!request('annee') && $year == date('Y')) ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                @elseif (in_array(Route::currentRouteName(), ['admin', 'activite_date', 'toutesActivite']))
                    <form action="{{ route('activite_date') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        <input class="form-control me-2" type="date" name="date" placeholder="" value="{{ request('date') }}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                @elseif (in_array(Route::currentRouteName(), ['anneeActivite', 'surAnnee']))
                    <form action="{{ route('anneeActivite') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('POST')
                        <div class="d-flex align-items-center">
                            <div class="me-1">
                                <select name="annee" class="form-select" placeholder="Choisir une année">
                                    @foreach(array_reverse(range(date('Y') - 10, date('Y'))) as $year)
                                        <option value="{{ $year }}" {{ request('annee') == $year || (!request('annee') && $year == date('Y')) ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                @elseif (in_array(Route::currentRouteName(), ['surIntervalle', 'intervalleActivite']))
                    <form action="{{ route('intervalleActivite') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('POST')
                        <div class="d-flex align-items-center">
                            <div class="me-1">
                                <input type="date" class="form-control" name="annee1" value="{{ request('annee1') }}">
                            </div>
                            <div class="me-1">
                                <input type="date" class="form-control" name="annee2" value="{{ request('annee2') }}">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <hr>

    <!-- Cards -->
    <div class="row">
        <!-- Nombres d'inscrit -->
        <div class="col-xxl-4 col-xl-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Nombres d'inscrit</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $nb_inscrit }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Clients <span>| Les inscrits ayant effectués une commande</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $client }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toutes les commandes -->
        <div class="col-xxl-4 col-xl-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Toutes les commandes</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $commandes }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenus -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Revenus <span>| FCFA</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($total, 2, ',', ' ') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes en cours -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Commandes <span>| En cours</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart4"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $comm_en_cours }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes payées -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Commandes <span>| Payées</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart-check-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $comm_paye }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Commandes passées -->
    <div class="col-12">
        <div class="card top-selling overflow-auto">
            <div class="card-body pb-0">
                <h5 class="card-title">Commandes passées <span>| Commandes payées ou en cours passées sur la période</span></h5>
                <table class="table table-borderless table-striped table-custom">
                    <thead>
                        <tr>
                            <th><h6>Numéro</h6></th>
                            <th><h6>Client</h6></th>
                            <th><h6>Montant (FCFA)</h6></th>
                            <th><h6>Etat</h6></th>
                            <th><h6>Date</h6></th>
                            <th><h6>Heure</h6></th>
                            <th><h6>Détails</h6></th>
                            <th><h6>Reçu</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes_en_cours as $comm_en_cours)
                            @php
                                $user = \App\Models\User::find($comm_en_cours->users_id);
                                $client = $user ? $user->name : 'Inconnu';
                            @endphp
                            <tr>
                                <td>{{ $comm_en_cours->numero_commande }}</td>
                                <td>{{ $client }}</td>
                                <td>{{ number_format($comm_en_cours->montant, 2, ',', ' ') }}</td>
                                <td>{{ $comm_en_cours->etat }}</td>
                                <td>{{ $comm_en_cours->updated_at->format('d/m/Y') }}</td>
                                <td>{{ $comm_en_cours->updated_at->format('H:i') }}</td>
                                <td>
                                    <a href="{{ route('detailCommandeAdmin', $comm_en_cours->id) }}" class="btn btn-outline-info">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('telechargerRecu', $comm_en_cours->id) }}" class="btn btn-download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
</div>

            </div>
        </div>
    </div>

    <!-- Commandes payées -->
    <div class="col-12">
        <div class="card top-selling overflow-auto">
            <div class="card-body pb-0">
                <h5 class="card-title">Commandes payées</h5>
                <table class="table table-borderless table-striped table-custom">
                    <thead>
                        <tr>
                            <th><h6>Numéro</h6></th>
                            <th><h6>Client</h6></th>
                            <th><h6>Montant (FCFA)</h6></th>
                            <th><h6>Etat</h6></th>
                            <th><h6>Date</h6></th>
                            <th><h6>Heure</h6></th>
                            <th><h6>Détails</h6></th>
                            <th><h6>Reçu</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes_payee as $comm_payee)
                            @php
                                $user = \App\Models\User::find($comm_payee->users_id);
                                $client = $user ? $user->name : 'Inconnu';
                            @endphp
                            <tr>
                                <td>{{ $comm_payee->numero_commande }}</td>
                                <td>{{ $client }}</td>
                                <td>{{ number_format($comm_payee->montant, 2, ',', ' ') }}</td>
                                <td>{{ $comm_payee->etat }}</td>
                                <td>{{ $comm_payee->updated_at->format('d/m/Y') }}</td>
                                <td>{{ $comm_payee->updated_at->format('H:i') }}</td>
                                <td>
                                    <a href="{{ route('detailCommandeAdmin', $comm_payee->id) }}" class="btn btn-outline-info">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('telechargerRecu', $comm_payee->id) }}" class="btn btn-download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              

            </div>
        </div>
    </div>

    <!-- Liste des inscrits -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Listes des inscrits</h5>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th><h6>ID</h6></th>
                            <th><h6>Nom</h6></th>
                            <th><h6>Email</h6></th>
                            <th><h6>Téléphone</h6></th>
                            <th><h6>Date d'inscription</h6></th>
                            <th><h6>Actions</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                                <td>
                                    <form action="">
                                        <button class="btn btn-danger"><i class="bi bi-person-x-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard>
