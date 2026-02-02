<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login – Don Salvadore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:sans-serif; background:#f5f5f5">

<div style="max-width:400px;margin:80px auto;background:#fff;padding:30px;border-radius:8px">
    <h2 style="text-align:center">🍕 Don Salvadore</h2>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div style="margin-bottom:15px">
            <label>Email</label>
            <input type="email" name="email" required
                   style="width:100%;padding:8px">
        </div>

        <div style="margin-bottom:15px">
            <label>Mot de passe</label>
            <input type="password" name="password" required
                   style="width:100%;padding:8px">
        </div>

        @if($errors->any())
            <div style="color:red;margin-bottom:10px">
                {{ $errors->first() }}
            </div>
        @endif

        <button type="submit"
                style="width:100%;padding:10px;background:#111;color:#fff">
            Connexion
        </button>
    </form>
</div>

</body>
</html>
