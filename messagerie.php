<?php 
session_start();

if(isset($_GET['receuv'])){
    $pers = $_GET['receuv'];
}else {
    echo "<h1>kestufé, tu parles à qui ?</h1>";
}

$moi = $_SESSION['identifiant'];
include "config.php";
$query = "SELECT * FROM inscription";
$users = $conn -> query($query);
if ($users && $users -> num_rows > 0) {
    $valide = true;
} else{
    $valide = false;
}

$query2 = "SELECT * FROM  `message` WHERE receuv = $moi AND exped = $pers OR receuv = $pers AND exped = $moi ORDER BY id";
$messages = $conn -> query($query2);

if (!empty($_POST['message']) & isset($_POST['message'])){
    $cont = htmlspecialchars($_POST['message']);
    $insert = $conn->prepare('INSERT INTO `message` (exped, receuv, contenu) VALUES (?, ?, ?)');
    $insert -> execute(array($moi, $pers, $cont));
    if($insert){
        header("Location: messagerie.php?receuv=$pers");
        exit();
    }
}


$query3 = "SELECT pseudonyme FROM inscription WHERE id=$pers";
$resQ3 = $conn -> query($query3);
$pseudonyme = $resQ3 -> fetch_assoc();


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
            <img src="Rimberio.png"style="width:7%">
            <ul>
                <li class="acceuil"><a href="index.php">Accueil</a></li>
                <li class="amicale"><a href="profil.php">Profil</a></li>
            </ul>
        </header>
        <div id="Centre">
            <div class="gauche_contacts">
                <h1 id="Titre">Contacts</h1>
                <div class="les_contacts">
                <?php
                if($valide){
                    while($row = $users -> fetch_assoc()){
                        echo "<a href='profil2.php?receuv=".$row['id']."'>".$row['pseudonyme']."</a>";
                        echo " ";
                        if ($row['id'] == $pers){
                            echo "<a id='relou' href='messagerie.php?receuv=".$row['id']."' >Parler</a>";
                        }else {
                            echo "<a href='messagerie.php?receuv=".$row['id']."'>Parler</a>";
                        }
                        echo "<br><br><br><br>";
                    }
                } else {
                    echo "P E R S O N N E";
                }
                ?>
                </div>
            </div>
            <div id="droite_chat">
                
                <div id="Name">
                    <form method="POST" action="function.php">
                        <input type="hidden" name="id" value="<?=$pers?>">
                        <button type="submit">report</button>
                    </form>
                    <h1>
                        <?=$pseudonyme['pseudonyme']?>
                    </h1>
                </div>
                <div class="messages">
                    <div>
                        <?php
                        while($row = $messages -> fetch_assoc()){
                            if($row['receuv'] == $pers){
                                ?>
                                <div id="flexEnvois">
                                   <p class="envoyes"><?php echo $row['contenu'] ?></p>
                                   <form method="POST" action="function.php">
                                        <input type="hidden" name="id_messageS" value="<?=$row['id']?>">
                                        <input type="hidden" name="pers" value="<?=$pers?>">
                                        <button type="submit">suppr</button>
                                   </form>
                                </div>
                                <?php
                            } else{
                                ?>
                                <div id="flexRecu">
                                    <form method="POST" action="function.php">
                                        <input type="hidden" name="id_messageR" value="<?=$row['id']?>">
                                        <input type="hidden" name="pers" value="<?=$pers?>">
                                        <button type="submit">report</button>
                                    </form>
                                   <p class="recus"><?php echo $row['contenu'] ?></p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <form method="POST" action="messagerie.php?receuv=<?=$pers;?>">
                    <input type="text" name="message" placeholder="Veuillez écrire ici...">
                </form>
            </div>
        </div>
    </body>
</html>