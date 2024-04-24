<?php
	session_start();
	include 'config.php';
	if ($conn->connect_error) {
		die("Erreur de connexion à la base de données:" . $conn->connect_error);
	}
	if (!empty($_POST['id'])) {
		$id = $_POST['id'];
		$sql = 'DELETE FROM `message` WHERE id = ?';
		$rslt = $conn->prepare($sql);
		$rslt->bind_param("i", $id);
		$rslt->execute();
	}
	$sql = "SELECT M.id,M.contenu,M.exped,M.receuv,I1.pseudonyme AS receuvN,I2.pseudonyme AS expedN FROM `message` M JOIN `inscription` I1 JOIN `inscription` I2 ON I1.id=M.receuv AND I2.id=M.exped WHERE M.estSignale = 1";
	$resultat = $conn->query($sql);
?>
<!Doctype hml>
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
						<li class="supprU"><a href="suppressionU.php">Utilisateurs</a></li>
					</ul>
				</div>
			</nav>
		</center>

	</div>

	<h2>Gestion des messages :</h2>
	<?php

	if ($resultat->num_rows > 0) {
		?>
			<table border='1'>
			<tr><th>Expediteur</th><th>Receveur</th><th>Message</th><th>Action</th></tr>
		<?php
		while ($row = $resultat->fetch_assoc()) {
			?>
			<tr>
				<td><?= $row['exped']." : ".$row['expedN'] ?></td>
				<td><?= $row['receuv']." : ".$row['receuvN'] ?></td>
				<td><?= $row['contenu'] ?></td>
				<td>
					<form method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type='submit' name='suppression' value='Supprimer'>
                    </form>
				</td>
			</tr>
			<?php
		}
		?></table><?php
	} else {
		?><p>Aucun messages n'a était signalé !</p><?php
	}
	?>
</body>
</html>