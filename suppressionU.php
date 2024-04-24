<?php
	session_start();
	include 'config.php';

	if ($conn->connect_error) {
		die("Erreur de connexion à la base de données:" . $conn->connect_error);
	}
	if (isset($_POST['suppression'])) {
		$id = $_POST['id'];
		$sql = "DELETE FROM inscription WHERE id= $id";
		$conn->query($sql);
	}
	$sql = "SELECT * FROM inscription WHERE estSignale = 1";
	$resultat = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Site De Rencontre</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="head">
		<img src="Rimberio.png" style="width:7%">
		<center>
			<nav>
				<div class="table">
					<ul>
						<li class="acceuil"><a href="index.php">Se déconnecter</a></li>
						<li class="admin"><a href="admin_acc.php">Accueil</a></li>
						<li class="supprM"><a href="suppressionM.php">Messages</a></li>
					</ul>
				</div>
			</nav>
		</center>
	</div>

	<h2>Gestion des utilisateurs :</h2>

	<?php
	
	if ($resultat->num_rows > 0) {
		?>
		<table border='1'>
			<tr><th>id</th><th>Utilisateurs</th><th>Action</th></tr>
		<?php
		while ($row = $resultat->fetch_assoc()) {
			?>
			<tr>
				<td><?= $row['id'] ?></td>
				<td><?= $row['pseudonyme'] ?></td>
				<td>
					<form method="post">
						<input type="hidden" name="id" value="<?= $row['id'] ?>">
						<input type='submit' name='suppression' value='Supprimer'>
					</form>
				</td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	} else {
		?><p>Aucun utilisateur signalé</p><?php
	}
	?>
</body>

</html>