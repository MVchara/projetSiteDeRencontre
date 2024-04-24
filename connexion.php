<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudonyme = $_POST['pseudonyme'];
    $mdp = $_POST['mdp'];

    $sql = "SELECT * FROM inscription WHERE pseudonyme = '$pseudonyme' AND mdp = '$mdp'";
    $resultat = $conn->query($sql);

    if ($resultat && $resultat->num_rows > 0) {

        echo "Connexion réussie !";
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $moi = $resultat -> fetch_assoc();
        $_SESSION['identifiant'] = $moi['id'];
        header("Location: profil.php");
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <LINK rel="stylesheet" href="connexion.css">
    <title> Site De Rencontre </title>
</head>
<body>
    <div class="head">
        <a href="index.php">Retour à l'accueil</a>
        <header>
            <section> 
                <h1> Connexion </h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <label for="username">Pseudonyme</label><br>
                    <input type="text" id="username" name="pseudonyme" required><br>
                    <label for="password">Mot de passe:</label><br>
                    <input type="password" id="password" name="mdp" required><br>
                    <button type="submit" value="Valider">Valider</button>
                </form>
                <p>Pas encore inscrit? <a href="inscription.php">Inscrivez vous</a></p>
            </section>
        </header>
    </div>
</body>
</html>
