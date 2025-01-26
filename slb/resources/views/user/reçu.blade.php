<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu</title>
    <style>
        /* Importation d'une police Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'trebuchet';
            margin: 20px;
            color: #333;
        }

        .titre {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-top: 3px solid;
            border-bottom: 3px solid;
            background-color: #f4f4f4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: 700;
        }

        td {
            background-color: #fff;
        }

        .header-table th {
            width: 25%;
        }

        .header-table td {
            width: 25%;
        }

        .info-table th {
            width: 25%;
        }
    </style>
</head>

<body>
    <div>
        <table class="header-table">
            <tr>
                <th>Nom de la société:</th>
                <th>Email:</th>
                <th>Téléphone:</th>
                <th>Adresse:</th>
            </tr>
            <tr>
                <td>Société Lidao Best</td>
                <td>lidao@example.com</td>
                <td>90 23 32 33</td>
                <td>Agoè, Cacavéli</td>
            </tr>
        </table>
    </div>
    <div class="titre">
        <h1>Reçu de commande numéro : {{ $commande->numero_commande }}</h1>
    </div>
    <div>
        <table class="info-table">
            <tr>
                <th>Nom du client</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date et heure</th>
                <th>État</th>
            </tr>
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telephone }}</td>
                @if ($commande->etat == 'en cours')
                    <td>{{ $commande->created_at->format('d/m/Y') }} à {{ $commande->created_at->format('H:i') }}</td>
                @else
                    <td>{{ $commande->updated_at->format('d/m/Y') }} à {{ $commande->updated_at->format('H:i') }}</td>
                @endif
                <td>{{ $commande->etat }}</td>
            </tr>
        </table>
    </div>
    <h2>
        <span style="font-weight: bold;">Détails de la commande:</span>
    </h2>
    <table class="table table-bordered receipt-table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix Unitaire (FCFA)</th>
                <th>Total (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($articles as $article)
                @foreach ($produits as $produit)
                    @if ($article->produit_id == $produit->id)
                        @php
                            $ligneTotal = $article->qte_commande * $produit->prix;
                            $total += $ligneTotal;
                        @endphp
                        <tr>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $article->qte_commande }}</td>
                            <td style="text-align: right;">{{ number_format($article->prix_de_vente, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($ligneTotal, 2) }}</td>

                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($total, 2) }} </strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>