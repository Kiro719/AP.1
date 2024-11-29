<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    
</head>
<body>

<h2>Mot de passe oublié</h2>

<?php
function passgen1($nbChar) {
    $chaine = "mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
    srand((double)microtime()*1000000);
    $pass = '';
    for($i = 0; $i < $nbChar; $i++) {
        $pass .= $chaine[rand() % strlen($chaine)];
    }
    return $pass;
}

if (isset($_POST['email'])) 

    $lemail = $_POST['email'];
    $servername = "localhost";  
  $username = "u937355202_QuentinD";        
  $password = "Quent2840&";             
  $dbname = "u937355202_QuentinDBDD";     ;           
  

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lemail); 
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        echo "L'email " . htmlspecialchars($lemail) . " a été trouvé dans la base de données.";

        
     // Génère un nouveau mot de passe
$mdpnew = passgen1(10);
echo "<p>Nouveau mot de passe généré : " . htmlspecialchars($mdpnew) . "</p>";

// Met à jour le mot de passe dans la base de données
$updateSql = "UPDATE user SET mdp = ? WHERE email = ?";
$updateStmt = $conn->prepare($updateSql);
$hashedPassword = password_hash($mdpnew, PASSWORD_DEFAULT);
$updateStmt->bind_param("ss", $hashedPassword, $lemail);
$updateStmt->execute();

// Prépare l'email avec le nouveau mot de passe
$subject = "Réinitialisation de votre mot de passe";
$message = "Bonjour,\n\nVotre nouveau mot de passe est : $mdpnew\n\nConnectez-vous et changez-le pour plus de sécurité.";
$headers = "From: no-reply@gmail.com";


// Envoie l'email
if (mail($lemail, $subject, $message, $headers)) {
    echo "<p>Un email avec votre nouveau mot de passe a été envoyé.</p>";
} else {
    echo "<p>L'envoi de l'email a échoué.</p>";
}


// Ferme les connexions
$updateStmt->close();
$conn->close();

} else {
?>

    <form action="oubli.php" method="POST">
        <label for="email">Adresse email :</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Confirmer">
    </form>
    <a href="index.php" style="display:inline-block; padding:10px 20px; background-color:#007BFF; color:white; text-decoration:none; border-radius:5px;">Retour </a>

<?php
}
?>

</body>
</html>
