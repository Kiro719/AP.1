<?php

session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['Sid'])) {
    header('Location: index.html');
    exit();
}

// Connexion à la base de données
 $conn = new PDO('mysql:host=localhost;dbname=projet_dubuis', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldEmail = ($_POST['old_email']);
    $newEmail = ($_POST['new_email']);
    $oldPassword = ($_POST['old_password']);
    $newPassword = ($_POST['new_password']);

    // Vérification du mot de passe actuel
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = :id AND mdp = :oldPassword");
    $stmt->bindParam(':id', $_SESSION['Sid']);
    $stmt->bindParam(':oldPassword', $oldPassword);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // Mettre à jour les informations
        $updateStmt = $conn->prepare("UPDATE user SET email = :email, mdp = :newPassword WHERE id = :id");
        $updateStmt->bindParam(':email', $newEmail);
        $updateStmt->bindParam(':newPassword', $newPassword);
        $updateStmt->bindParam(':id', $_SESSION['Sid']);
        
        $updateStmt->execute();
        echo "Mise à jour effectuée.";
        
    }
    } else {
        echo "Erreur : mot de passe actuel incorrect.";
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Perso</title>
</head>
<body>
    <form action="" method="POST">
        <label>Email :</label>
        <input type="email" name="old_email" required>
        <label>Nouveau  email :</label>
        <input type="email" name="new_email" required>
        <label>Ancien mot de passe :</label>
        <input type="password" name="old_password" required>
        <label>Nouveau mot de passe :</label>
        <input type="password" name="new_password" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
