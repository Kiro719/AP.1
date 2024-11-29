<?php
session_start();


if (!isset($_SESSION['Sidstatut']) || $_SESSION['Sidstatut'] != '2') {
    // Si l'utilisateur n'est pas un "eleve", rediriger vers la page de connexion ou une autre page
    header("Location: acceuil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Élève</title>
</head>
<body>
    <header>
        <h1>Bienvenue Élève</h1>
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['Slogin']); ?> !</p>
        <nav>
            <ul>
                <li><a href="liste_cr.php">Liste des Comptes Rendus</a></li>
                <li><a href="createcr.php">Créer un Compte Rendu</a></li>
                <li>
                    <form action="deconnexion.php" method="POST" style="display:inline;">
                        <button type="submit" name="logout">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Interface Élève</h2>
            <p>Sur cette page, vous pouvez accéder à vos comptes rendus et en créer de nouveaux.</p>
        </section>
    </main>
</body>
</html>
