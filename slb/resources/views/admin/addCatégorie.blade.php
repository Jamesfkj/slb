<x-dashboard>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    @if (Route::currentRouteName() === 'editCategorie')
                        Modifier une catégorie
                    @else
                        Ajouter une nouvelle catégorie
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

                @if (Route::currentRouteName() === 'formCategorie')
                    <!-- Formulaire d'ajout -->
                    <form class="row g-3 needs-validation" action="{{ route('storeCategorie') }}" method="POST">
                        @csrf
                        <div class="col-12">
                            <label for="nom" class="form-label">Nom de la catégorie</label>
                            <input type="text" name="nom" class="form-control" id="nom" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4" required></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Ajouter la catégorie</button>
                        </div>
                    </form>
                @elseif(Route::currentRouteName() === 'editCategorie')
                    <!-- Formulaire de modification -->
                    <form class="row g-3 needs-validation" action="{{ route('updateCategorie', $categories->id) }}"
                        method="POST">
                        @method('PUT')
                        @csrf
                        <div class="col-12">
                            <label for="nom" class="form-label">Nom de la catégorie</label>
                            <input type="text" name="nom" class="form-control" id="nom" value="{{ $categories->nom }}"
                                required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4"
                                required>{{ $categories->description }}</textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Modifier la catégorie</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-dashboard>