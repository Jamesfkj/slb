<x-dashboard>
    <hr>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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
            <td>
                {{ $commandes->id}}
            </td>
            <td>
                <h6 class="num"><strong></strong>{{ $commandes->numero_commande }}</strong></h6>
            </td>

            <td>
                <h6 class="prix">{{ $commandes->montant }} FCFA</h6>
            </td>
            @if ($commandes->etat == 'en cours')
                <td>
                    <form action="{{ route('validerCommande', $commandes->id) }}" method="POST" class="d-flex">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <select name="etat" class="form-select me-2">
                                <option value="{{ $commandes->etat }}">{{ $commandes->etat }}</option>
                                <option value="payée">payée</option>
                            </select>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check"></i>
                            </button>
                        </div>
                    </form>
                </td>
            @else
                <td>
                    <strong class="
                        @if($commandes->etat == 'payée')
                            etat-payee
                        @endif">{{ $commandes->etat }}</strong>
                </td>
            @endif
            <td>
                <a href="{{route('detailCommandeAdmin', $commandes->id)}}" class="btn btn-outline-info">
                    <i class="bi bi-info-circle"></i>
                </a>
            </td>
            <td>
                <a href="{{ route('telechargerRecu', $commandes->id) }}" class="btn btn-download">
                    <i class="bi bi-download"></i>
                </a>
            </td>
            </tr>
        </tbody>
    </table>
    </div>
    <style>
    </style>
</x-dashboard>