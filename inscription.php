<?php
session_start();
include 'config.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (isset($_POST['soumettre'])){
        $pseudonyme=$_POST['pseudonyme'];
        $sexe=$_POST['sexe'];
        $orientation=$_POST['orient'];
        $email=$_POST['email'];
        $dateInscription=date("Y-m-d H:i:s");
        $datedeNaissance=$_POST['datedeNaissance'];
        $pays=$_POST['pays'];
        $ville=$_POST['ville'];
        $msg=$_POST['msg'];
        $interet=$_POST['interet'];
        $img_name=$_FILES['photo']['name'];
        $tmp_name=$_FILES['photo']['tmp_name'];
        $folder='imgs_membres/'.$img_name;
        $mdp=$_POST['mdp'];
        if(move_uploaded_file($tmp_name,$folder)){
            echo "image téléchargée avec succés";
        }else{
            echo "Erreur lors du téléchargement de l'image";
        }
        $stmt=$conn->prepare("INSERT INTO inscription (pseudonyme,sexe,orientation,email,dateInscription,datedeNaissance,pays,ville,msg,interet,photo,mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss",$pseudonyme,$sexe,$orientation,$email,$dateInscription,$datedeNaissance,$pays,$ville,$msg,$interet,$img_name,$mdp);
        if($stmt->execute()){
            echo "Inscription établie!";
            header("Location: connexion.php");
            exit();
        }else{
            echo "Erreur lors de l'inscription".$stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <LINK rel="stylesheet" href="inscription.css">
    <title> Site De Rencontre </title>
</head>
<body>
    <div class="head">
        <a href="index.php">Retour à l'accueil</a>
        <section>
            <h1> Inscription </h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <label for="username">Pseudonyme :</label><br>
                <input type="text" id="username" name="pseudonyme" required><br>
                <label for="sexe">Genre :</label>
                <select id="sexe" name="sexe" required>
                    <option name="sexe"  value="femme">Femme</option>
                    <option name="sexe"  value="Homme">Homme</option>
                    <option name="sexe"  value="nonbinaire">Non binaire</option>
                    <option name="sexe"   value="autre">autre</option>
                </select><br>
                <label for="orientation">Orientation :</label>
                <select id="orientation" name="orient" required>
                    <option name="orient"  value="straight">Straight</option>
                    <option name="orient"  value="gay">gay</option>
                    <option name="orient"  value="lesbian">lesbienne</option>
                    <option name="orient"   value="bi">bisexuel</option>
                    <option name="orient"   value="poly">polyamoureux</option>
                    <option name="orient"   value="autre">autre</option>
                </select><br>
                <label for="email">Email :</label><br>
                <input type="text" id="email" name="email"><br>
                <label for="Date de naissance">Date de naissance:</label>
                <input type="date" id="datedeNaissance" name="datedeNaissance" required><br>
                <p>Lieu de résidence :</p>
                <label for="pays">Pays :</label><br>
                <input type="text" id="pays" name="pays" required><br>
                <label for="ville">Ville :</label><br>
                <input type="text" id="ville" name="ville"><br>
                <p>Informations personnelles :</p>
                <label for='msg'> Message d'accueil : </label>
                <input type="text" id='msg' name='msg'><br>
                <label for="interet" required>Centre d'intérêt :</label>
                <input type="text" id="interet" name="interet" placeholder="insère ton centre d'intérêt favori"><br>
                <p>Photos</p>
                <input type="file" name="photo" enctype="multipart/form-data"><br>
                <label for="password">Mot de passe :</label><br>
                <input type="password" id="password" name="mdp" required><br>
                <button type="submit" name="soumettre" value="Soumettre">Soumettre</button>
            </form>
        </section>
    </div>
</body>
</html>