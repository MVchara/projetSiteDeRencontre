<?php 
include 'config.php';
session_start();

if ($conn->connect_error){
die("Erreur de connexion à la base de données:".$conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudonyme = $_POST['pseudonyme'];
    $mdp = $_POST['mdp'];

    $sql = "SELECT * FROM inscription WHERE pseudonyme = ? AND mdp = ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ss",$pseudonyme,$mdp);
    $stmt->execute();
    $resultat=$stmt->get_result();

    if ($resultat && $resultat->num_rows > 0) {
        $utilisateur=$resultat->fetch_assoc();
        if($utilisateur['pseudonyme']=='admin' && $utilisateur['mdp']=='admin1234'){
        echo "Connexion rÃ©ussie !";
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $utilisateur['pseudonyme'];
        header("Location: admin_acc.php");
        exit();
        }else {
        echo "Vous n'êtes pas autorisés à accéder à la page";
        }
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
                    <h1>Espace de Connexion Admin</h1>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <label for="username">Pseudonyme</label><br>
                        <input type="text" id="username" name="pseudonyme" required><br>
                        <label for="password">Mot de passe:</label><br>
                        <input type="password" id="password" name="mdp" required><br>
                        <button type="submit" value="Valider">Valider</button>
                        </form>
                </section>
            </header>
        </div>
    </body>
</html>
