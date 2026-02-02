@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="block">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3>Utilisateurs</h3>
        <a href="{{ route('admin.users.create') }}" style="padding:8px 16px;background:#556B2F;color:white;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;">
            + Ajouter
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding:12px;background:#d4edda;color:#155724;border-radius:8px;margin-bottom:16px;">
            {{ $message }}
        </div>
    @endif

    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:2px solid #e7e0db;background:#f7f7f4;">
                <th style="padding:12px;text-align:left;font-weight:600;">Nom</th>
                <th style="padding:12px;text-align:left;font-weight:600;">Téléphone</th>
                <th style="padding:12px;text-align:left;font-weight:600;">Date</th>
                <th style="padding:12px;text-align:center;font-weight:600;width:200px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr style="border-bottom:1px solid #e7e0db;">
                    <td style="padding:12px;">
                        <strong>{{ $user->name }}</strong>
                    </td>
                    <td style="padding:12px;">{{ $user->phone ?? '-' }}</td>
                    <td style="padding:12px;font-size:13px;color:#78716e;">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td style="padding:12px;text-align:center;font-size:13px;">
                        <a href="{{ route('admin.users.show', $user->id) }}" style="color:#8B4513;text-decoration:none;margin:0 4px;">voir</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" style="color:#8B4513;text-decoration:none;margin:0 4px;">afficher</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" style="color:#8B4513;text-decoration:none;margin:0 4px;">modifier</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:#d32f2f;background:none;border:none;cursor:pointer;font-size:13px;text-decoration:none;margin:0 4px;">sup</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding:20px;text-align:center;color:#78716e;">
                        Aucun utilisateur trouvé.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($users->hasPages())
        <div style="margin-top:20px;text-align:center;">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
