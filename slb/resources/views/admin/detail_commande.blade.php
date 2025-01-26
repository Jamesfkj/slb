<x-dashboard>
    <h4>Numero de commande : <strong class="titre">{{ $commande->numero_commande }}</strong></h4>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <div class="client-info">
            <div class="line-info">
                <p>Nom du client : </p>
                <h4>{{ $user->name }}</h4>
            </div>
            <div class="line-info">
                <p>Date de naissance : </p>
                <h4>{{ $newDateStr}}</h4>
            </div>
            <div class="line-info">
                <p>Numéro de téléphone : </p>
                <h4>{{ $user->telephone }}</h4>
            </div>
            <div class="line-info">
                <p>Email : </p>
                <h4>{{ $user->email }}</h4>
            </div>
        </div>
        <div>
            <div class="commande-info">
                <p>Etat : </p>
                <h4>{{ $commande->etat }}</h4>
            </div>
            <div class="commande-info">
                <p>Montant : </p>
                <h4>{{number_format($commande->montant,2,',',' ')}} FCFA</h4>
            </div>
            <div class="commande-info">
                <p>Date et heure de la commande : </p>
                <h4>{{ $commande->created_at->format('d/m/Y') }} à {{ $commande->created_at->format('H:i') }}</h4>
            </div>
            @if ($commande->etat == 'payée')
                <div class="commande-info">
                    <p>Date et heure de payement : </p>
                    <h4>{{ $commande->updated_at->format('d/m/Y') }} à {{ $commande->updated_at->format('H:i') }}</h4>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <h4><strong>Produits commandés</strong></h4>
    @if($articlesCommandes->isEmpty())
        <p>Aucun article commandé trouvé pour cette commande.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <h6>Produit</h6>
                    </th>
                    <th>
                        <h6>Quantité Commandée</h6>
                    </th>
                    <th>
                        <h6>Prix unitaire</h6>
                    </th>
                    <th>
                        <h6>Prix de Vente</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalGeneral = 0;
                @endphp
                @foreach($articlesCommandes as $article)
                        @php
                            $totalArticle = $article->qte_commande * $article->prix_de_vente;
                            $totalGeneral += $totalArticle;
                        @endphp
                        <tr>
                            <td>{{ $article->produit->nom }}</td>
                            <td>{{ $article->qte_commande }}</td>
                            <td>{{ number_format($article->prix_de_vente, 2, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($totalArticle, 2, ',', ' ') }} FCFA</td>
                        </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>
                            <h6>Total Général</h6>
                        </strong></td>
                    <td><strong>{{$commande->montant}} FCFA</strong></td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <div>
            <h4 class="telechargement"><strong>Télecharger le reçu :</strong> <a href="{{ route('telechargerRecu', $commande->id) }}"
                    class="btn btn-download"><i class="bi bi-download"></i></a></h4>
        </div>

        <hr>
    @endif
</x-dashboard>