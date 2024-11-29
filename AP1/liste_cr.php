<?php
session_start();

// Vérifiez si l'utilisateur est connecté et de type "élève"
if (!isset($_SESSION['Sidstatut']) || $_SESSION['Sidstatut'] != '2') {
    header("Location: acceuil.php");
    exit;
}

$id_eleve = $_SESSION['Sid']; // ID de l'élève depuis la session

// Connexion à la base de données
$conn = mysqli_connect('localhost', 'u937355202_QuentinD', 'Quent2840&', 'u937355202_QuentinDBDD');
    
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Récupérer la liste des comptes rendus de l'élève
$stmt = mysqli_prepare($conn, "SELECT sujet, contenu, dateCR, commentaire, dateCreation, dateModif, vu FROM cr WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_eleve);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Lier les colonnes à des variables distinctes
mysqli_stmt_bind_result($stmt, $sujet, $contenu, $dateCR, $commentaire, $dateCreation, $dateModif, $vu);

// Affichage du tableau
echo "<h1>Liste des Comptes Rendus</h1>";
echo "<table border='1'>";
echo "<tr>
        <th>Date</th>
        <th>Sujet</th>
        <th>Contenu</th>
        <th>Commentaire</th>
        <th style='text-align:right;'>Date Création</th>
        <th style='text-align:right;'>Date Modification</th>
        <th>Vu</th>
      </tr>";

// Parcourir les résultats
while (mysqli_stmt_fetch($stmt)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($dateCR) . "</td>";
    echo "<td>" . htmlspecialchars($sujet) . "</td>";
    echo "<td>" . htmlspecialchars($contenu) . "</td>";
    echo "<td>" . htmlspecialchars($commentaire) . "</td>";
    echo "<td style='text-align:right;'>" . htmlspecialchars($dateCreation) . "</td>";
    echo "<td style='text-align:right;'>" . htmlspecialchars($dateModif) . "</td>";
    echo "<td>" . ($vu ? "Oui" : "Non") . "</td>"; // Affichage lisible pour "Vu"
    echo "</tr>";
}

echo "</table>";

// Libérer la mémoire et fermer la requête
mysqli_stmt_close($stmt);

// Fermeture de la connexion
mysqli_close($conn);
?>

<!-- Bouton Retour -->
<br>
<a href="eleve.php" style="display:inline-block; padding:10px 20px; background-color:#007BFF; color:white; text-decoration:none; border-radius:5px;">Retour à l'Accueil</a>
