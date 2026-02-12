@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="block">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3>Utilisateurs</h3>
        <a href="{{ route('admin.users.create') }}" style="padding:8px 16px;background:#9BAF0A;color:white;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;">
            + Ajouter
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding:12px;background:#d4edda;color:#155724;border-radius:8px;margin-bottom:16px;">
            {{ $message }}
        </div>
    @endif

    <!-- Formulaire de filtrage -->
    <div style="background:#f9f8f6;padding:16px;border-radius:8px;margin-bottom:20px;border:1px solid #e7e0db;">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;font-size:13px;color:#555;">Rechercher</label>
                <input type="text" name="search" placeholder="Nom ou email..." value="{{ request('search') }}" 
                       style="width:100%;padding:8px 12px;border:1px solid #d4ccc5;border-radius:6px;font-size:13px;box-sizing:border-box;">
            </div>
            <div style="flex:0 0 auto;">
                <label style="display:block;font-weight:600;margin-bottom:6px;font-size:13px;color:#555;">Statut</label>
                <select name="status" style="padding:8px 12px;border:1px solid #d4ccc5;border-radius:6px;font-size:13px;background:white;cursor:pointer;">
                    <option value="">Tous</option>
                    <option value="1" @selected(request('status') === '1')>Actif</option>
                    <option value="0" @selected(request('status') === '0')>Inactif</option>
                </select>
            </div>
            <div style="flex:0 0 auto;display:flex;gap:8px;">
                <button type="submit" style="padding:8px 16px;background:#9BAF0A;color:white;border:none;border-radius:6px;font-weight:600;font-size:13px;cursor:pointer;">
                    Filtrer
                </button>
                <a href="{{ route('admin.users.index') }}" style="padding:8px 16px;background:#cccccc;color:#333;border:none;border-radius:6px;font-weight:600;font-size:13px;text-decoration:none;text-align:center;">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:2px solid #e7e0db;background:#f7f7f4;">
                <th style="padding:12px;text-align:left;font-weight:600;width:60px;">Photo</th>
                <th style="padding:12px;text-align:left;font-weight:600;">Nom</th>
                <th style="padding:12px;text-align:left;font-weight:600;">Téléphone</th>
                <th style="padding:12px;text-align:left;font-weight:600;">Date</th>
                <th style="padding:12px;text-align:center;font-weight:600;width:200px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr style="border-bottom:1px solid #e7e0db;">
                    <td style="padding:12px;text-align:center;">
                        <img src="{{ $user->profile_photo ? asset('storage/profile-photos/' . $user->profile_photo) : asset('images/default-avatar.svg') }}" 
                             alt="{{ $user->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ddd;">
                    </td>
                    <td style="padding:12px;">
                        <strong>{{ $user->name }}</strong>
                    </td>
                    <td style="padding:12px;">{{ $user->phone ?? '-' }}</td>
                    <td style="padding:12px;font-size:13px;color:#78716e;">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td style="padding:12px;text-align:center;font-size:16px;">
                        <a href="{{ route('admin.users.show', $user->id) }}" title="Voir" style="color:#8B4513;text-decoration:none;margin:0 6px;display:inline-block;transition:0.3s;"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" title="Modifier" style="color:#8B4513;text-decoration:none;margin:0 6px;display:inline-block;transition:0.3s;"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Supprimer" style="color:#d32f2f;background:none;border:none;cursor:pointer;font-size:16px;text-decoration:none;margin:0 6px;transition:0.3s;padding:0;"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding:20px;text-align:center;color:#78716e;">
                        Aucun utilisateur trouvé.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($users->hasPages())
        <div style="margin-top:24px;display:flex;justify-content:center;align-items:center;gap:8px;flex-wrap:wrap;">
            {{-- Previous Page Link --}}
            @if ($users->onFirstPage())
                <span style="padding:8px 12px;color:#ccc;border-radius:6px;border:1px solid #e7e0db;font-size:13px;font-weight:600;">← Précédent</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" style="padding:8px 12px;color:#333;text-decoration:none;border-radius:6px;border:1px solid #d4ccc5;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.3s;">← Précédent</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if ($page == $users->currentPage())
                    <span style="padding:8px 12px;background:#9BAF0A;color:white;border-radius:6px;font-size:13px;font-weight:600;border:1px solid #9BAF0A;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:8px 12px;color:#333;text-decoration:none;border-radius:6px;border:1px solid #d4ccc5;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.3s;">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" style="padding:8px 12px;color:#333;text-decoration:none;border-radius:6px;border:1px solid #d4ccc5;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.3s;">Suivant →</a>
            @else
                <span style="padding:8px 12px;color:#ccc;border-radius:6px;border:1px solid #e7e0db;font-size:13px;font-weight:600;">Suivant →</span>
            @endif

            <span style="margin-left:12px;font-size:12px;color:#78716e;">
                Page {{ $users->currentPage() }} sur {{ $users->lastPage() }} ({{ $users->total() }} utilisateurs)
            </span>
        </div>
    @endif
</div>
@endsection
