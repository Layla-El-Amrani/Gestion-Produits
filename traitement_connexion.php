<?php
require_once 'config.php';

try{
    $conn = new PDO("mysql:host=$serverename;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    die("Erreur de connexion :".$e->getMessage());
};
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stm = $conn->prepare("SELECT * FROM utilisateur WHERE login = :login AND  login = :password");
    $stm ->bindParam(':login',$login);
    $stm ->bindParam(':password',$password);
    $stm ->execute();

    if($stm->rowCount()>0){
    header("Location:index.php");
    exit;
    }
    else{
        header("Location:login.php?login=failed");

    }

}
$conn = null;



