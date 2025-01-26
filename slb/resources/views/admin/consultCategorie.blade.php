<x-dashboard>
    <style>
        /* Styles pour la table */
        .title {
            text-align: center;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }




        .view-description {
            position: relative;
            display: inline-block;
        }

        .view-description a {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .view-description .description-card {
            display: none;
            position: absolute;
            bottom: 100%;
            /* Change "top" to "bottom" */
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 300px;
            z-index: 10;
            max-height: 300px;
            overflow-y: auto;
            /* Permettre le défilement si le contenu est trop grand */
        }

        .view-description:hover .description-card {
            display: block;
        }
    </style>
    <section id="hero" class="hero1 section">
        <p><strong>Liste des catégories</strong></p>
        <hr>
        @if (session('message'))
            <div class="alert alert-success" id="success-message">
                {{ session('message') }}
            </div>
        @endif
        <div class="container mt-5">
            <table class="table table-hover table-striped">
                <thead id="head">
                    <tr>
                        <th>
                            <h6>Nom de la catégorie</h6>
                        </th>
                        <th>
                            <h6>Description</h6>
                        </th>
                        <th>
                            <h6>Voir les produits</h6>
                        </th>
                        <th class="">
                            <h6>Actions</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                {{ $category->nom }}
                            </td>
                            <td>
                                <div class="view-description">
                                    <a href="javascript:void(0)">
                                        Voir la description <i class="bi bi-caret-up-fill"></i>
                                    </a>
                                    <div class="description-card">
                                        {{ $category->description }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{route('consultProduitAdmin',$category->id)}}" method="GET">
                                    @csrf
                                    <button class="btn btn-info"><i class="bi bi-info"></i></button>
                                </form>
                            </td>
                            <td class="td1">
                                <div class="div1">
                                    <style>
                                        .div1 {
                                            display: flex;
                                            justify-content: center;
                                            gap: 10px
                                        }
                                    </style>
                                    <form action="{{route('editCategorie', $category->id)}}" method="PUT">
                                        @method('PUT')
                                        @csrf
                                        <button type="submit" class="btn btn-warning"><i class="bi bi-pencil"></i></button>
                                    </form>
                                    <form action="{{route('deleteCategorie', $category->id)}}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-dashboard>