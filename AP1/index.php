

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<!-- Formulaire de connexion -->
<form method="post" action="acceuil.php">
        <label for="login">Login:</label>
        <input type="text" name="login" required>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>
        <button type="submit" name="send_con">Connexion</button>

</form>

<!-- Lien vers la page de récupération de mot de passe -->
<form method="post" action="oubli.php">
    <input type="submit" value="Mot de passe oublié ?" name="send_password" class="forgot-password">
</form>

</body>
</html>
