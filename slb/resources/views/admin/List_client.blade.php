<x-dashboard>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Listes des clients <span class="text-muted small pt-2 ps-1">| Personnes ayant
                        effectuées des commandes</span></h5>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th>
                                <h6>ID</h6>
                            </th>
                            <th>
                                <h6>Nom</h6>
                            </th>
                            <th>
                                <h6>Email</h6>
                            </th>
                            <th>
                                <h6>Téléphone</h6>
                            </th>
                            <th>
                                <h6>Date d'inscription</h6>
                            </th>
                            <th>
                                <h6>Commandes</h6>
                            </th>
                            <th>
                                <h6>Voir les commandes</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                                <td>{{ $user->command_count }}</td>
                                <td>
                                    <form action="{{route('commandesClient',$user->id)}}">
                                        <button class="btn btn-info"><i class="bi bi-info"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate d-flex">
                    @if ($users->hasPages())
                        <div class="btn-group" role="group" aria-label="Page navigation">
                            @if ($users->currentPage() > 1)
                                <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-info">Précédent</a>
                            @endif
                            @for ($pages = 1; $pages <= $users->lastPage(); $pages++)
                                @if ($users->currentPage() == $pages)
                                    <span class="btn btn-outline-info active">{{ $pages }}</span>

                                @else
                                    <a href="{{ $users->url($pages) }}" class="btn btn-outline-info">{{ $pages }}</a>
                                @endif
                            @endfor
                            @if ($users->currentPage() < $users->lastPage())
                                <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-info">Suivant</a>
                            @endif
                            <span class="btn btn-dark">Page {{$users->currentPage() }} sur
                                {{ $users->lastPage() }}</span>
                    @endif  

                  </div>
                </div>
            </div>
</x-dashboard>