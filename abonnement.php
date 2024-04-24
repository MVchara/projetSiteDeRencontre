<?php 
session_start();
include 'config.php';
if ($conn->connect_error){
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudonyme = $_POST['pseudonyme'];
    $mdp = $_POST['mdp'];
    $codeabonnement=$_POST['codeabonnement'];

    $sql = "SELECT * FROM inscription WHERE pseudonyme = ? AND mdp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $pseudonyme, $mdp);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $utilisateur = $result->fetch_assoc();
        if ($utilisateur['pseudonyme'] == 'admin' && $utilisateur['mdp'] == 'admin1234') {
            echo "Connexion réussie !";
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $utilisateur['pseudonyme'];
            header( "Location: admin_acc.php");
            exit();
        }
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $utilisateur['pseudonyme'];
        $_SESSION['identifiant'] = $utilisateur['id'];
        if ($codeabonnement=="lhoub2024" ){
            $updateabonnement= 'UPDATE inscription SET abonnement=1  WHERE id = ?';
            $codeA = $conn->prepare($updateabonnement);
            $codeA->bind_param("s", $_SESSION['identifiant']);
            $codeA -> execute();
            header("Location: profil.php");
            exit();
            

        }
    }
     else {
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
                    <h1>Espace de Connexion Admin</h1>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <label for="username">Pseudonyme</label><br>
                        <input type="text" id="username" name="pseudonyme" required><br>
                        <label for="password">Mot de passe:</label><br>
                        <input type="password" id="password" name="mdp" required><br>
                        <label for="codeabonnement"> Code d'abonnement:  </label>
                        <input type="text" id="codeabonnement" name="codeabonnement" required><br>
                        <button type="submit" value="Valider">Valider</button>
                        </form>
                </section>
            </header>
        </div>
    </body>
</html>
