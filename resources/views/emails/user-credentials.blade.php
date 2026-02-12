<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #9BAF0A;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .content h2 {
            color: #9BAF0A;
            margin-top: 0;
        }
        .credentials-box {
            background-color: #f9f9f9;
            border-left: 4px solid #9BAF0A;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .credentials-box p {
            margin: 10px 0;
            font-size: 14px;
        }
        .credentials-box strong {
            color: #9BAF0A;
        }
        .password-field {
            background-color: #fff;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            word-break: break-all;
            margin: 10px 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 14px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
        }
        .button {
            display: inline-block;
            background-color: #9BAF0A;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DON SALVADORE APP</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Bienvenue dans votre nouvel espace</p>
        </div>

        <div class="content">
            <h2>Bonjour {{ $user->name }},</h2>

            <p>Un compte administrateur a été créé pour vous. Vos identifiants de connexion sont ci-dessous :</p>

            <div class="credentials-box">
                <p><strong>Email :</strong></p>
                <p style="margin: 5px 0;">{{ $user->email }}</p>

                <p style="margin-top: 15px;"><strong>Mot de passe temporaire :</strong></p>
                <div class="password-field">{{ $password }}</div>
            </div>

            <div class="warning">
                <strong>⚠️ Important :</strong> Ce mot de passe est temporaire. Vous devez le changer lors de votre première connexion pour des raisons de sécurité.
            </div>

            <p>Pour accéder à votre compte, cliquez sur le bouton ci-dessous :</p>

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Se connecter</a>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Si vous n'avez pas demandé la création de ce compte ou si vous avez des questions, veuillez contacter l'administrateur.
            </p>
        </div>

        <div class="footer">
            <p>© 2026 Restaurant App. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
