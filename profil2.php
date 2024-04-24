<?php
session_start();
include "config.php";

if(isset($_GET['receuv'])){
    $pers = $_GET['receuv'];
}


$moi = $_SESSION['identifiant'];
$query = "SELECT * FROM inscription WHERE id='$pers'";
$infoA = $conn -> query($query);
$infos = $infoA -> fetch_assoc();





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
							<li class="chat"><a href="contacter.php">Ma Messagerie</a></li>
							<li class="acceuil"><a href="index.php">Se déconnecter</a></li>
							<li class="profil"><a href="profil.php">Mon Profil</a></li>
						</ul>
					</div>
				</nav>
			</center>
		</div>
		<div id="Centre">
		<div class="recherche">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
				<input type="search" name="s" placeholder="Rechercher un profil"><br>
				<input type="search" name="c" placeholder="Rechercher un centre d'interet"><br>
				<label for="orientation">Sélectionner une Orientation :</label>
				<select id="orientation" name="o">
					<option name="orient" value="straight">Straight</option>
					<option name="orient" value="gay">gay</option>
					<option name="orient" value="lesbian">lesbienne</option>
					<option name="orient" value="bi">bisexuel</option>
					<option name="orient" value="poly">polyamoureux</option>
					<option name="orient" value="autre">autre</option>
				</select><br>
				<button type="submit">Rechercher</button>
			</form>
		</div>


<?php
if ($conn->connect_errno){
	die("Erreur de connexion à la base de données:" . $conn->connect_error);
	exit();
}
function search($conn, $s = null, $o = null, $c = null) {
	$query = "SELECT * FROM inscription WHERE 1";

	if ($s) {
		$query .= " AND pseudonyme LIKE '%$s%' ";
	}
	if ($c) {
		$query .= " AND interet LIKE '%$c%' ";
	}
	if ($o) {
		$query .= " AND orientation LIKE '%$o%' ";
	}
	$resultat = $conn->query($query);
	if ($resultat->num_rows > 0) {
		echo "<h1>Résultats de recherche</h1>";
		echo"<div  class='les_contacts'>";
		echo "<ul>";
		while ($row = $resultat->fetch_assoc()) {
			echo "<li><a href='profil2.php?receuv=".$row['id']."'>".$row['pseudonyme']."</a></li>";
			echo " ";
			echo "<li><a href='messagerie.php?receuv=".$row['id']."'>Parler</a></li>";
		}
		echo "</ul>";
		echo "</div>";
	} else {
		echo "Aucun résultat trouvé";
	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$s = $_POST['s'] ?? null;
	$o = $_POST['o'] ?? null;
	$c = $_POST['c'] ?? null;
	search($conn, $s, $o, $c);
}
?>


<br>
<center>
			<div id="profil">
				<img src="<?php echo 'imgs_membres/'.$infos['photo']?>" id="image_profil">
				<p>date d'inscription : <?php echo $infos['dateInscription'];?></p>
				<div class="Qui">
					<p>Pseudo : <?php echo $infos['pseudonyme'];?></p>
					<p>Sexe : <?php echo $infos['sexe'];?></p>
					<p>Orientation : <?php echo $infos['orientation'];?></p>
					<p>Date de naissance : <?php echo $infos['datedeNaissance'];?></p>
					<p>Email : <?php echo $infos['email'];?></p>
				</div>
				<div class="Qui">
					<p>Pays : <?php echo $infos['pays'];?></p>
					<p>Ville : <?php echo $infos['ville'];?></p>
				</div>
				<div class="Qui">
					<p>Message d'accueil: <?php echo $infos['msg'];?></p>
					<p>Centres d'intérêts : <?php echo $infos['interet'];?></p>
				</div>
			</div>
			</center>
		</div>

	</body>
</html>