<x-dashboard>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success custom-alert" id="success-message">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger custom-alert" id="">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}
                            </div>
                        @endforeach
                    </ul>
                @endif
                @if (Route::currentRouteName() == 'formProduit')
                    <h5 class="card-title">Ajouter un nouveau produit</h5>
                    <form class="row g-3 needs-validation" action="{{route('storeProduit')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Conteneur principal en flex -->
                        <div class="col-12">
                            <label for="catégorie">Catégorie du produit</label>
                            <select class="form-select" id="catégorie" name="categorie">
                                @foreach($categories as $categorie)
                                    <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="nom" class="form-label">Nom du Produit</label>
                            <input type="text" name="nom" class="form-control" id="nom">
                        </div>
                        <div class="col-12">
                            <label for="prix" class="form-label">Prix unitaire</label>
                            <input type="text" name="prix" class="form-control" id="prix">
                        </div>
                        <div class="col-12">
                            <label for="qte_stock" class="form-label">Qantité en stock</label>
                            <input type="text" name="qte_stock" class="form-control" id="qte_stock">
                        </div>
                        <div class="col-12">
                            <label for="image" class="form-label">Image du produit</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" name="description" class="form-control" id="description"></textarea>
                        </div>
                        <div><button class="btn btn-primary">Ajouter le produit</button></div>
                    </form>
                @elseif(Route::currentRouteName() == 'editProduit')
                    <h5 class="card-title">Modifier un produit</h5>
                    <form class="row g-3 needs-validation" action="{{ route('updateProduit', ['id' => $produits->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Utilisez la méthode PUT pour la mise à jour -->

                        <!-- Conteneur principal en flex -->
                        <div class="col-12">
                            <label for="categorie">Catégorie du produit</label>
                            <select class="form-select" id="categorie" name="categorie">
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ $produits->categorie_id == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="nom" class="form-label">Nom du Produit</label>
                            <input type="text" name="nom" class="form-control" id="nom"
                                value="{{ old('nom', $produits->nom) }}">
                        </div>
                        <div class="col-12">
                            <label for="prix" class="form-label">Prix unitaire</label>
                            <input type="text" name="prix" class="form-control" id="prix"
                                value="{{ old('prix', $produits->prix) }}">
                        </div>
                        <div class="col-12">
                            <label for="qte_stock" class="form-label">Quantité en stock</label>
                            <input type="text" name="qte_stock" class="form-control" id="qte_stock"
                                value="{{ old('qte_stock', $produits->qte_stock) }}">
                        </div>
                        <div class="col-12">
                            <label for="current_image" class="form-label">Image actuelle</label>
                            <div>
                                @if($produits->image)
                                    <img src="{{ Storage::url($produits->image) }}" alt="Image actuelle du produit"
                                        class="img-fluid" style="max-width: 200px;">
                                @else
                                    <p>Aucune image actuelle</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="image" class="form-label">Nouvelle image du produit (facultatif)</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"
                                id="description">{{ old('description', $produits->description) }}</textarea>
                        </div>
                        <div>
                            <button class="btn btn-primary">Modifier le produit</button>
                        </div>
                    </form>

                @endif
            </div>
        </div>
    </div>

</x-dashboard>