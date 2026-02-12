@extends('layouts.admin')

@section('title', $user->name)

@section('content')
<div class="block" style="max-width:700px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3>{{ $user->name }}</h3>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.users.edit', $user->id) }}" style="padding:8px 16px;background:#9BAF0A;color:white;border-radius:4px;text-decoration:none;font-size:14px;font-weight:600;">
                Modifier
            </a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:8px 16px;background:#d32f2f;color:white;border:none;border-radius:4px;cursor:pointer;font-size:14px;font-weight:600;">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding:12px;background:#d4edda;color:#155724;border-radius:8px;margin-bottom:16px;">
            {{ $message }}
        </div>
    @endif

    <div style="background:#f9f9f9;padding:16px;border-radius:8px;margin-bottom:16px;">
        <div style="text-align:center;margin-bottom:20px;">
            <img src="{{ $user->profile_photo ? asset('storage/profile-photos/' . $user->profile_photo) : asset('images/default-avatar.svg') }}" 
                 alt="{{ $user->name }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #ddd;">
        </div>
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <strong style="color:#666;font-size:13px;text-transform:uppercase;">Nom</strong>
                <p style="margin:6px 0 0 0;font-size:15px;">{{ $user->name }}</p>
            </div>
            <div>
                <strong style="color:#666;font-size:13px;text-transform:uppercase;">Téléphone</strong>
                <p style="margin:6px 0 0 0;font-size:15px;">{{ $user->phone ?? '-' }}</p>
            </div>
            <div style="grid-column:1/-1;">
                <strong style="color:#666;font-size:13px;text-transform:uppercase;">Email</strong>
                <p style="margin:6px 0 0 0;font-size:15px;">{{ $user->email }}</p>
            </div>
            <div style="grid-column:1/-1;">
                <strong style="color:#666;font-size:13px;text-transform:uppercase;">Date d'inscription</strong>
                <p style="margin:6px 0 0 0;font-size:15px;">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if ($user->branch)
                <div style="grid-column:1/-1;">
                    <strong style="color:#666;font-size:13px;text-transform:uppercase;">Succursale</strong>
                    <p style="margin:6px 0 0 0;font-size:15px;">{{ $user->branch->name }}</p>
                </div>
            @endif
        </div>

        @if ($user->roles->count())
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid #e7e0db;">
                <strong style="color:#666;font-size:13px;text-transform:uppercase;">Rôles</strong>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
                    @foreach ($user->roles as $role)
                        <span style="padding:6px 12px;background:#9BAF0A;color:white;border-radius:4px;font-size:13px;font-weight:600;">{{ $role->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <a href="{{ route('admin.users.index') }}" style="color:#666;text-decoration:none;font-size:14px;font-weight:600;">
        ← Retour à la liste
    </a>
</div>
@endsection
