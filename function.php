<?php
include 'config.php';
session_start();
if(!empty($_POST['id_messageS']) && !empty($_POST['pers'])){
    $cmd = 'DELETE FROM `message`WHERE id = ?';
    $rslt = $conn -> prepare($cmd);
    $rslt -> bind_param("i",$_POST['id_messageS']);
    $rslt->execute();
    header("Location: messagerie.php?receuv=".$_POST['pers']);
    exit();
}

if(!empty($_POST['id_messageR']) && !empty($_POST['pers'])){
    $cmd = 'UPDATE `message`SET estSignale = 1 WHERE id = ?';
    $rslt = $conn -> prepare($cmd);
    $rslt -> bind_param("i",$_POST['id_messageR']);
    $rslt->execute();
    header("Location: messagerie.php?receuv=".$_POST['pers']);
    exit();
}


if(!empty($_POST['id'])){
    $cmd = 'UPDATE `inscription`SET estSignale = 1 WHERE id = ?';
    $rslt = $conn -> prepare($cmd);
    $rslt -> bind_param("i",$_POST['id']);
    $rslt->execute();
    header("Location: messagerie.php?receuv=".$_POST['id']);
    exit();
}


?>

