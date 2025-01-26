<x-dashboard>
    <p><strong>{{$titre}}</strong></p>
    <hr>
    @if (session('success'))
        <div class="alert alert-success custom-alert" id="success-message">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row gy-4">
            @foreach($produits as $produit)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="200">
                        <img class="image" src="{{ asset('storage/' . $produit->image) }}" class="card-img-top"
                            alt="{{ $produit->nom }}">
                        <div class="card-body">
                            <h6 class="nom">{{ $produit->nom }}</h6>
                            <p class="description"><strong>{{ number_format($produit->prix,2,',',' ')  }}</strong> FCFA</p>
                            @if($produit->qte_stock > 0)
                                <i class="etat-enstock">En stock :</i> {{ $produit->qte_stock }}
                            @else
                                <i class="etat-rupture">Rupture de stock</i>
                            @endif
                            <hr class="my-2">

                            <!-- Boutons Modifier et Supprimer -->
                            <div class=" d-flex justify-content-between mt-3">
                                <a href="{{route('editProduit',$produit->id)}}" class="btn btn-warning">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{route('deleteProduit', $produit->id)}}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ms-2">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div><!-- End Row -->
    </div>

    <style>
        .image {
            width: 70%;
            align-self: center;
            height: 150px;
            background-color: #dee2e6;
            margin-bottom: 15px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .nom {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .etat-enstock {
            color: #28a745;
            font-size: 0.9rem;
        }

        .etat-rupture {
            color: #dc3545;
            font-size: 0.9rem;
        }

        hr.my-2 {
            border-top: 1px solid #007bff;
            margin: 10px 0;
        }
    </style>
    <!-- End Container -->

    <!-- CSS personnalisé -->

</x-dashboard>