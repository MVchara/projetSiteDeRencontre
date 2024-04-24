
<!Doctype html>
<html lang="fr">
	<head>
		<title>Site De Rencontre</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
<div class="head">
<img src="Rimberio.png"style="width:7%">
<center>
<nav>
<div class="table">
<ul>
<li class="chat"><a href="chat.php">Ma Messagerie</a></li>
<li class="acceuil"><a href="index.php">Se déconnecter</a></li>
<li class="profil"><a href="profilbg.php">Mon Profil</a></li>
</ul>
</div>
</nav>
</center>
</div>
<div class="recherche">
<h2>Résultats de la recherche</h2>
<?php 
if(isset($_GET['s'])){
$query=$_GET['s'];
$stmt="SELECT * FROM inscription WHERE pseudonyme  LIKE '%$query%' ";
$resultat=$conn->query($stmt);
if($resultat->num_rows>0){
while ($row = $resultat->fetch_assoc()){
echo "<p>profil:".$row['pseudonyme']."</p>";
}
}else{
echo "Aucun résultat trouvé";
}
$conn->close();
}else{
echo "Veuillez entrer un pseudonyme";
}
?>
</body>
</html>
