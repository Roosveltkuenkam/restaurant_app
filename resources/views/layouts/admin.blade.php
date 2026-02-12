<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Dashboard')</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_products.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<div class="admin-wrap">
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/don-salvadore-logo.png') }}" alt="Don Salvadore">
        </div>

        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" @if(Route::is('admin.dashboard')) class="active" @endif><span class="icon">🏠</span>Dashboard</a>
            <a href="#" @if(Route::is('admin.restaurants.index')) class="active" @endif><span class="icon">🍽️</span>Restaurants</a>
            <a href="{{ route('admin.users.index') }}" @if(Route::is('admin.users.*')) class="active" @endif><span class="icon">👥</span>Utilisateurs</a>
            <a href="#" @if(Route::is('admin.menu.*')) class="active" @endif><span class="icon">📋</span>Menu / Plats</a>
            <a href="{{ route('orders.index') }}" @if(Route::is('orders.*')) class="active" @endif><span class="icon">🧾</span>Commandes</a>
            <a href="#" @if(Route::is('admin.payments.*')) class="active" @endif><span class="icon">💳</span>Paiements</a>
            <a href="#" @if(Route::is('admin.statistics.*')) class="active" @endif><span class="icon">📊</span>Statistiques</a>
            <a href="{{ route('admin.products.index') }}" @if(Route::is('admin.products*')) class="active" @endif><span class="icon">📦</span>Stocks / Inventaire</a>
            <a href="#" @if(Route::is('admin.reservations.*')) class="active" @endif><span class="icon">📅</span>Réservations</a>
            <a href="#" @if(Route::is('admin.settings.*')) class="active" @endif><span class="icon">⚙️</span>Paramètres</a>

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
                @if(session('user'))
                    @php
                        $user = \App\Models\User::find(session('user')['id']);
                    @endphp
                    <img src="{{ $user && $user->profile_photo ? asset('storage/profile-photos/' . $user->profile_photo) : asset('images/default-avatar.svg') }}" 
                         alt="Avatar" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                @else
                    <div class="avatar"></div>
                @endif
                <div class="welcome">
                    <span>Bienvenue</span>
                    <strong>@if(session('user')) {{ session('user')['name'] }} @else Nom d'utilisateur @endif</strong>
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
