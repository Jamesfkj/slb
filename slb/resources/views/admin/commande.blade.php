<x-dashboard>
    <hr>
    @if (session('success'))
        <div class="alert alert-success custom-alert" id="success-message">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger custom-alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{$error}}
                </div>
            @endforeach
        </ul>
    @endif
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="titre"><strong>{{ $titre }}</strong></h2>
        <div class="col-6 ">
            <form action="{{ route('rechercherCommande', $etat) }}" method="GET" class="d-flex">
                @csrf
                <input class="form-control me-2" type="text" name="query" placeholder="{{$placeholder}}"
                    value="{{ request()->input('query') }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
    <hr>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Numéro de la commande</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Détails</th>
                <th>Reçu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($commandes as $commande)
                <tr>
                    <td>
                        {{ $commande->id }}
                    </td>
                    <td>
                        <h6 class="num"><strong>{{ $commande->numero_commande }}</strong></h6>
                    </td>

                    <td>
                        <h6 class="prix">{{ number_format($commande->montant, 2, ',', ' ') }} FCFA</h6>
                    </td>
                    <td><strong class="
                                        @if($commande->etat == 'en cours')
                                            etat-en-cours
                                        @elseif($commande->etat == 'payée')
                                            etat-payee
                                        @endif">{{ $commande->etat }}</strong></td>
                    <td>
                        <a href="{{route('detailCommandeAdmin', $commande->id)}}" class="btn btn-outline-info">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('telechargerRecu', $commande->id) }}" class="btn btn-download">
                            <i class="bi bi-download"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune commande trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Liens de pagination -->
    <div class="paginate d-flex">
        @if ($commandes->hasPages())
            <div class="btn-group" role="group" aria-label="Page navigation">
                @if ($commandes->currentPage() > 1)
                    <a href="{{ $commandes->previousPageUrl() }}" class="btn btn-outline-info">Précédent</a>
                @endif
                @for ($page = 1; $page <= $commandes->lastPage(); $page++)
                    @if ($commandes->currentPage() == $page)
                        <span class="btn btn-outline-info active">{{ $page }}</span>

                    @else
                        <a href="{{ $commandes->url($page) }}" class="btn btn-outline-info">{{ $page }}</a>
                    @endif
                @endfor
                @if ($commandes->currentPage() < $commandes->lastPage())
                    <a href="{{ $commandes->nextPageUrl() }}" class="btn btn-outline-info">Suivant</a>
                @endif
                <span class="btn btn-dark">Page {{ $commandes->currentPage() }} sur {{ $commandes->lastPage() }}</span>
        @endif          </div>
        <style>

        </style>
</x-dashboard>