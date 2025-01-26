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
        <p><strong>Liste des actualites</strong></p>
        <hr>
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
        <div class="container mt-5">
            <table class="table table-hover table-striped">
                <thead id="head">
                    <tr>
                        <th>
                            <h6>Titre</h6>
                        </th>
                        <th>
                            <h6>Contenu</h6>
                        </th>
                        <th>
                            <h6>Etat</h6>
                        </th>
                        <th>
                            <h6>Date de publication</h6>
                        </th>
                        <th class="">
                            <h6>Actions</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actualites as $actualite)
                        <tr>
                            <td>
                                {{ $actualite->titre }}
                            </td>
                            <td>
                            {{ $actualite->contenu }}
                            </td>
                            <td>
                            {{ $actualite->etat }}
                            </td>
                            <td>{{ $actualite->created_at->format('d/m/Y à H:i') }}</td>
                            
                            <td class="td1">
                                <div class="div1">
                                    <style>
                                        .div1 {
                                            display: flex;
                                            justify-content: center;
                                            gap: 10px
                                        }
                                    </style>
                                    <form action="{{route('editActualite', $actualite->id)}}" method="PUT">
                                        @method('PUT')
                                        @csrf
                                        <button type="submit" class="btn btn-warning"><i class="bi bi-pencil"></i></button>
                                    </form>
                                    @if ($actualite->etat=='visible')
                                    <form action="{{route('deleteActualite', $actualite->id)}}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette actualité ?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                    @else
                                    <form action="{{route('afficherActualite', $actualite->id)}}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir publier cette actualité ?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success"><i class="bi bi-check"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-dashboard>