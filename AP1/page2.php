<?php 
include "_conf.php";

if (isset($_POST['send_connexion'])) {
    echo "<p>Send connexion envoyé <hr></p>";
    
    // 1. Connectez-vous d'abord à la base de données
    $connexion = mysqli_connect($servername, $username, $password, $dbname);

    if ($connexion) {
        echo "<p>Félicitations, vous êtes connecté à la BDD</p>";
        
        // 2. Capture et échappe les entrées utilisateur après la connexion
        $varlogin = mysqli_real_escape_string($connexion, $_POST['login']);
        $varmdp = mysqli_real_escape_string($connexion, $_POST['mdp']); 

        echo "<p>Login: $varlogin <br> Mot de passe: $varmdp</p>";
        
        // 3. Utilisez une requête préparée pour éviter les injections SQL
        $requete = "SELECT * FROM user WHERE login = ? AND mdp = ?";
        $stmt = mysqli_prepare($connexion, $requete);
        mysqli_stmt_bind_param($stmt, 'ss', $varlogin, $varmdp);
        mysqli_stmt_execute($stmt);
        $resultat = mysqli_stmt_get_result($stmt);

        // 4. Vérifiez si un utilisateur a été trouvé
        if ($donnees = mysqli_fetch_assoc($resultat)) {
            $montype = $donnees['type'];
            
            if ($montype == 1) {
                echo "<p>Bonjour PROF</p>";
            } else {
                echo "<p>Bonjour ÉLÈVE</p>";
            }
        } else {
            echo "<p class='message'>Connexion échouée. Login ou mot de passe incorrect.</p>";
        }

        // 5. Fermez la requête et la connexion
        mysqli_stmt_close($stmt);
        mysqli_close($connexion);

    } else {
        // En cas d'erreur de connexion
        echo "<p class='message'>Erreur : connexion à la base de données échouée.</p>";
    }
}
?>
