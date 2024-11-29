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

// Initialisation des champs
$date = date("Y-m-d");
$sujet = "";
$contenu = "";
$commentaire = "";
$vu = false;
$dateCreation = date("Y-m-d H:i:s"); // Ajout des heures, minutes et secondes
$dateModif = date("Y-m-d H:i:s");

// Charger les données si une date est fournie
if (isset($_POST['date_cr'])) {
    $date = $_POST['date_cr'];

    $stmt = mysqli_prepare($conn, "SELECT sujet, contenu, commentaire, vu, dateCreation, dateModif FROM cr WHERE dateCR = ? AND id_user = ?");
    mysqli_stmt_bind_param($stmt, 'si', $date, $id_eleve);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $sujet, $contenu, $commentaire, $vu, $dateCreation, $dateModif);
        mysqli_stmt_fetch($stmt);
    } else {
        echo "Aucun compte rendu trouvé pour cette date. Vous pouvez en créer un.";
    }

    mysqli_stmt_close($stmt);
}

// Traitement du formulaire d'insertion ou de mise à jour
if (isset($_POST['send_cr'])) {
    $sujet = htmlspecialchars($_POST['sujet']);
    $contenu = htmlspecialchars($_POST['contenu']);
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $vu = isset($_POST['vu']) ? 1 : 0;
    $dateModif = date("Y-m-d H:i:s"); // Mise à jour avec heures, minutes et secondes

    // Vérifier si un CR existe déjà pour cette date
    $stmt = mysqli_prepare($conn, "SELECT id FROM cr WHERE dateCR = ? AND id_user = ?");
    mysqli_stmt_bind_param($stmt, 'si', $date, $id_eleve);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // Si aucun CR n'existe, insérer un nouveau CR
        $stmt = mysqli_prepare($conn, "INSERT INTO cr (sujet, contenu, dateCR, commentaire, dateCreation, dateModif, vu, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssssii', $sujet, $contenu, $date, $commentaire, $dateCreation, $dateModif, $vu, $id_eleve);
        if (mysqli_stmt_execute($stmt)) {
            echo "Compte rendu ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout : " . mysqli_error($conn);
        }
    } else {
        // Si un CR existe déjà, le mettre à jour
        $stmt = mysqli_prepare($conn, "UPDATE cr SET sujet = ?, contenu = ?, commentaire = ?, dateModif = ?, vu = ? WHERE dateCR = ? AND id_user = ?");
        mysqli_stmt_bind_param($stmt, 'ssssisi', $sujet, $contenu, $commentaire, $dateModif, $vu, $date, $id_eleve);
        if (mysqli_stmt_execute($stmt)) {
            echo "Compte rendu mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
    }

    mysqli_stmt_close($stmt);
}

// Fermeture de la connexion
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer / Modifier un Compte Rendu</title>
</head>
<body>
    <h1>Créer / Modifier un Compte Rendu</h1>

    <form method="POST">
        <label for="date_cr">Date :</label>
        <input type="date" id="date_cr" name="date_cr" value="<?php echo $date; ?>" required>
        <button type="submit" name="load_cr">Charger</button><br><br>

        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" value="<?php echo htmlspecialchars($sujet); ?>" required><br><br>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($contenu); ?></textarea><br><br>

        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire"><?php echo htmlspecialchars($commentaire); ?></textarea><br><br>

        <label for="vu">Vu :</label>
        <input type="checkbox" id="vu" name="vu" <?php echo $vu ? 'checked' : ''; ?>><br><br>

        <button type="submit" name="send_cr">Enregistrer</button>
    </form>

    <br>
    <a href="eleve.php" style="display:inline-block; padding:10px 20px; background-color:#007BFF; color:white; text-decoration:none; border-radius:5px;">Retour à l'Accueil</a>
</body>
</html>
