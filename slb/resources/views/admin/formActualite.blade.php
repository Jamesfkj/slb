<x-dashboard>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    @if (Route::currentRouteName() === 'editCategorie')
                        Modifier une actualité
                    @else
                        Publier une actualité
                    @endif
                </h5>

                @if (session('success'))
                    <div class="alert alert-success custom-alert" id="success-message">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger custom-alert" id="error-message">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                            </div>
                        @endforeach
                    </ul>
                @endif

                @if (Route::currentRouteName() === 'formActualite')
                    <!-- Formulaire d'ajout -->
                    <form class="row g-3 needs-validation" action="{{ route('storeActualite') }}" method="POST">
                        @csrf
                        <div class="col-12">
                            <label for="nom" class="form-label">Titre de l'actualité</label>
                            <input type="text" name="titre" class="form-control" id="nom" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Contenu</label>
                            <textarea name="contenu" class="form-control" id="description" rows="4" required></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Plublier</button>
                        </div>
                    </form>
                @elseif(Route::currentRouteName() === 'editActualite')
                    <!-- Formulaire de modification -->
                    <form class="row g-3 needs-validation" action="{{ route('updateActualite', $actualite->id) }}"
                        method="POST">
                        @method('PUT')
                        @csrf
                        <div class="col-12">
                            <label for="nom" class="form-label">Titre de l'actualité</label>
                            <input type="text" name="titre" class="form-control" id="nom" value="{{ $actualite->titre }}"
                                required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Contenu</label>
                            <textarea name="contenu" class="form-control" id="description" rows="4"
                                required>{{ $actualite->contenu }}</textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Modifier l'actualité</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-dashboard>