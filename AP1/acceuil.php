<?php
session_start();

// Vérifiez si le formulaire a été soumis
if (isset($_POST['send_con'])) {
    // Récupération des identifiants
    $login = $_POST['login'];
    $password = $_POST['password']; 
    // Connexion à la base de données avec mysqli
    $conn = mysqli_connect('localhost', 'u937355202_QuentinD', 'Quent2840&', 'u937355202_QuentinDBDD');
    
    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    // Préparation de la requête pour vérifier le couple login/mot de passe
    $stmt = mysqli_prepare($conn, "SELECT id, login, idstatut FROM user WHERE login = ? AND mdp = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $login, $password);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Vérification si l'utilisateur existe dans la base de données
    if (mysqli_stmt_num_rows($stmt) == 1) {
        // L'utilisateur existe, création des variables de session
        mysqli_stmt_bind_result($stmt, $id, $login, $idstatut);
        mysqli_stmt_fetch($stmt);

        $_SESSION['Sid'] = $id;
        $_SESSION['Slogin'] = $login;
        $_SESSION['Sidstatut'] = $idstatut;

        // Redirection selon le statut
        if ($_SESSION['Sidstatut'] == '1') {
            header("Location: prof.php");
            exit;
        } elseif ($_SESSION['Sidstatut'] == '2') {
            header("Location: eleve.php");
            exit;
        }
    } else {
        // Affichage d'une erreur si les identifiants sont incorrects
        echo "Erreur de mot de passe.";
        exit;
    }

    // Fermeture de la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
