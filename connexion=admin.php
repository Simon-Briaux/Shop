<?php
session_start();	// Nous connect à la base de donnee
include "BDD.php";

if ((!empty($_SESSION['ID'])) AND (!empty($_SESSION['Pseudo'])) AND (!empty($_SESSION['mdp'])))
{	//si l'utilisateur est connecte a une session
	header("Location: index.php");	//renvoie vers la page d'accueil
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_POST["connexionSubmit"])){
        if(!empty($_POST["mdp"])){

            $mdp = $_POST["mdp"];

            
            $UserData = $RequeteStatement->fetch();
            if(!empty($UserData['mdp'])){
                $_SESSION['ID'] = $UserData['ID'];
                $_SESSION['Pseudo'] = $UserData['Pseudo'];
                $_SESSION['mdp'] = $UserData['mdp'];
                header("Location: index.php");

            }else{
                echo "Mauvais Identifiant et/ou Mot De Passe";
            }
           
        }
    }    
    ?>
    <H1>Connexion </H1>

    <form action="" method="post" class="formConnexion">
    <div class="form-example">
            <label for="Pseudo">Pseudo : </label>
            <input type="text" name="Pseudo" id="Pseudo" required>
        </div>
        <div class="form-example">
            <label for="mdp">Mot de passe : </label>
            <input type="password" name="mdp" id="mdp" required>
        </div>
        <div class="form-example">
            <input type="submit" name="connexionSubmit" value="Se connecter" class="btnConnexion">
        </div>

        <div class="form-example">
            <a href="inscription.php">S'inscrire</a>
        </div>
    </form>
</body>
</html>