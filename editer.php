<?php
session_start();
$moi = $_SESSION['identifiant'];
include "config.php";
$query = "SELECT * FROM inscription WHERE id='$moi'";
$infoA = $conn -> query($query);
$infos = $infoA -> fetch_assoc();




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mdp = $_POST['mdp'];
    if($mdp==$infos['mdp']){
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
        if(move_uploaded_file($tmp_name,$folder)){
            echo "image téléchargée avec succés";
        }else{
            echo "Erreur lors du téléchargement de l'image";
        }
        $stmt=$conn->prepare('UPDATE inscription
                                SET pseudonyme = ?,
                                sexe = ?,
                                orientation = ?,
                                email = ?,
                                datedeNaissance = ?,
                                pays = ?,
                                ville = ?,
                                msg = ?,
                                interet = ?,
                                photo = ?
                                WHERE id = ?');
        $stmt->bind_param("ssssssssssi",$pseudonyme,$sexe,$orientation,$email,$datedeNaissance,$pays,$ville,$msg,$interet,$img_name,$moi);
        if($stmt->execute()){
            echo "Inscription établie!";
            header("Location: profil.php");
            exit();
        }else{
            echo "Erreur lors de la modification".$stmt->error;
        }
        $stmt->close();
    }else{
        echo "Mot de passe incorrect.";
    }
}


?>

<!Doctype html>
<html lang="fr">
	<head>
		<title>Site De Rencontre</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="profil.css">
	</head>
	<body>
		<div class="head">
			<img src="Rimberio.png"style="width:7%">
			<center>
				<nav>
					<div class="table">
						<ul>
							<li class="acceuil"><a href="contacter.php">Ma Messagerie</a></li>
							<li class="amicale"><a href="index.php">Se déconnecter</a></li>
							<li class="connexion"><a href="profil.php">Mon Profil</a></li>
						</ul>
					</div>
				</nav>
			</center>
		</div>
		<div id="Centre">
			<div id="profil">
				<img src="<?php echo 'imgs_membres/'.$infos['photo']?>" id="image_profil"><br>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                    <input type="file" name="photo" enctype="multipart/form-data" value="<?php echo 'imgs_membres/'.$infos['photo']?>" required><br>
				    <p>Date d'inscription : <?php echo $infos['dateInscription'];?></p>
				    <div class="Qui">
				    	<p>Pseudo : </p>
                        <input type="text" id="username" name="pseudonyme" value="<?php echo $infos['pseudonyme'];?>" required>
				    	<p>Sexe : </p>
                        <select id="sexe" name="sexe" value="<?php echo $infos['sexe'];?>"required>
                            <option name="sexe"  value="femme">Femme</option>
                            <option name="sexe"  value="Homme">Homme</option>
                            <option name="sexe"  value="nonbinaire">Non binaire</option>
                            <option name="sexe"   value="autre">autre</option>
                        </select>
				    	<p>Date de naissance : </p>
                    <input type="date" id="datedeNaissance" name="datedeNaissance" value="<?php echo $infos['datedeNaissance'];?>" required>
                       <p>Orientation : </p>
                       <select id="orientation" name="orient" value="<?php echo $infos['orient'];?>">
                           <option name="orient"  value="straight">Straight</option>
                            <option name="orient"  value="gay">gay</option>
                            <option name="orient"  value="lesbian">lesbienne</option>
                            <option name="orient"   value="bi">bisexuel</option>
                            <option name="orient"   value="poly">polyamoureux</option>
                            <option name="orient"   value="autre">autre</option>
                        </select>
				    	<p>Email : </p>
                        <input type="text" id="email" name="email" value="<?php echo $infos['email'];?>" required><br><br>
				    </div>
				    <div class="Qui">
				    	<p>Pays : </p>
                        <input type="text" id="pays" name="pays" value="<?php echo $infos['pays'];?>" required><br>
				    	<p>Ville : </p>
                        <input type="text" id="ville" name="ville" value="<?php echo $infos['ville'];?>"required><br><br>
				    </div>
				    <div class="Qui">
				    	<p>Message d'accueil: </p>
                        <input type="text" id='msg' name='msg' value="<?php echo $infos['msg'];?>" required><br>
				    	<p>Centres d'intérêts : </p>
                        <input type="text" id="interet" name="interet" value="<?php echo $infos['interet'];?>"><br><br>
				    </div>
                    <div>
                        <p>Mot de passe :</p>
                        <input type="password" id="password" name="mdp" required><br><br>
                        <button type="submit" name="soumettre" value="Soumettre">Soumettre</button>
                    </div>
                </form>
			</div>
		</div>
	</body>
</html>
