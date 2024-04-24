<?php 
session_start();

if(isset($_GET['receuv'])){
    $pers = $_GET['receuv'];
}


include "config.php";
$query = "SELECT * FROM inscription";
$users = $conn -> query($query);
if ($users && $users -> num_rows > 0) {
    $valide = true;
} else{
    $valide = false;
}




?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="messagerie.css">
        <title>Messagerie</title>
    </head>
    <body>
        <header class="head">
            <img src="Rimberio.png">
            <nav class="table">
                    <ul>
                        <li class="acceuil"><a href="index.php">Accueil</a></li>
                        <li class="amicale"><a href="profil.php">Profil</a></li>
                    </ul>
            </nav>
        </header>
        <div id="contacter">
            <h1 id="Titre">Contacter</h1>
            <div class="les_contacts">
                <?php
                if($valide){
                    while($row = $users -> fetch_assoc()){
                        echo "<a href='profil2.php?receuv=".$row['id']."'>".$row['pseudonyme']."</a>";
                        echo " ";
                        echo "<a href='messagerie.php?receuv=".$row['id']."'>Parler</a>";
                        echo "<br><br><br><br>";
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>