<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Dashboard')</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="admin-wrap">
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/don-salvadore-logo.png') }}" alt="Don Salvadore">
        </div>

        <nav class="nav">
            <a class="active" href="{{ route('admin.dashboard') }}"><span class="icon">🏠</span>Dashboard</a>
            <a href="#"><span class="icon">🍽️</span>Restaurants</a>
            <a href="{{ route('admin.users.index') }}"><span class="icon">👥</span>Utilisateurs</a>
            <a href="#"><span class="icon">📋</span>Menu / Plats</a>
            <a href="#"><span class="icon">🧾</span>Commandes</a>
            <a href="#"><span class="icon">💳</span>Paiements</a>
            <a href="#"><span class="icon">📊</span>Statistiques</a>
            <a href="#"><span class="icon">📦</span>Stocks / Inventaire</a>
            <a href="#"><span class="icon">📅</span>Réservations</a>
            <a href="#"><span class="icon">⚙️</span>Paramètres</a>

            <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer;width:100%;">
                    <div style="padding:10px 10px;border-radius:10px;display:flex;gap:10px;align-items:center;">
                        <span class="icon">🔒</span>Déconnexion
                    </div>
                </button>
            </form>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div class="avatar"></div>
                <div class="welcome">
                    <span>Bienvenue</span>
                    <strong>@if(auth()->check()) {{ auth()->user()->name }} @else Nom d'utilisateur @endif</strong>
                    <span class="badge">online</span>
                </div>
            </div>

            <div class="topbar-right">
                <a class="link" href="#" title="Notifications">🔔</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link" style="background:none;border:none;cursor:pointer">
                        Deconnexion
                    </button>
                </form>
            </div>
        </div>

        @yield('content')
    </main>
</div>

</body>
</html>
