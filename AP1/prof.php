<?php
session_start();

// Vérification de la session (professeur)
if (!isset($_SESSION['Sidstatut']) || $_SESSION['Sidstatut'] != '1') {
    // Si l'utilisateur n'est pas un "prof", rediriger
    header("Location: acceuil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Professeur</title>
</head>
<body>
    <header>
        <h1>Bienvenue Professeur</h1>
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['Slogin']); ?> !</p>
        <nav>
            <ul>
                <li><a href="listecr_e.php">Liste des Élèves</a></li>
                <li><a href="listecrprof.php">Liste des Comptes Rendus</a></li>
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
            <h2>Interface Professeur</h2>
            <p>Depuis cette interface, vous pouvez consulter les listes des élèves et de leurs comptes rendus.</p>
        </section>
    </main>
</body>
</html>
