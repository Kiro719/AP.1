<?php
session_start();
if (!isset($_SESSION['Sidstatut']) || $_SESSION['Sidstatut'] != '1') {
    header("Location: acceuil.php");
    exit;
}

// Connexion à la base de données
$conn = mysqli_connect('localhost', 'u937355202_QuentinD', 'Quent2840&', 'u937355202_QuentinDBDD');

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$sql = "SELECT 
            cr.id,
            cr.sujet,
            cr.contenu,
            cr.dateCR,
            cr.commentaire,
            cr.dateCreation,
            cr.dateModif,
            cr.vu,
            user.nom AS nom_user,
            user.prenom AS prenom_user
        FROM 
            cr
        INNER JOIN 
            user 
        ON 
            cr.id_user = user.id";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Comptes Rendus</title>
</head>
<body>
    <h1>Liste des Comptes Rendus</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Sujet</th>
            <th>Contenu</th>
            <th>Date CR</th>
            <th>Commentaire</th>
            <th>Date Création</th>
            <th>Date Modification</th>
            <th>Vu</th>
            <th>Nom Élève</th>
            <th>Prénom Élève</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['sujet']) . "</td>
                        <td>" . htmlspecialchars($row['contenu']) . "</td>
                        <td>" . htmlspecialchars($row['dateCR']) . "</td>
                        <td>" . htmlspecialchars($row['commentaire']) . "</td>
                        <td>" . htmlspecialchars($row['dateCreation']) . "</td>
                        <td>" . htmlspecialchars($row['dateModif']) . "</td>
                        <td>" . ($row['vu'] ? 'Oui' : 'Non') . "</td>
                        <td>" . htmlspecialchars($row['nom_user']) . "</td>
                        <td>" . htmlspecialchars($row['prenom_user']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Aucun compte rendu trouvé.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
