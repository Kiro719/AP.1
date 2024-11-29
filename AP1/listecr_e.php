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

// Requête pour récupérer les élèves
$sql = "SELECT * FROM user WHERE idstatut = 2";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Élèves</title>
</head>
<body>
    <h1>Liste des Élèves</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Classe</th>
        </tr>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['nom']) . "</td>
                        <td>" . htmlspecialchars($row['prenom']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucun élève trouvé.</td></tr>";
        }

        // Libérer la mémoire et fermer la connexion
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
