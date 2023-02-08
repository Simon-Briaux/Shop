<style>
body {
    background-color: #f2f2f2;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
  }
  
  .form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
    width: 500px;
    text-align: center;
  }
  
  h1 {
    font-size: 36px;
    margin-bottom: 400px;
      }    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border-radius: 10px;
        border: 2px solid #ccc;
        font-size: 18px;
      }
      
      input[type="submit"] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border-radius: 10px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        font-size: 18px;
        cursor: pointer;
      }
      
      input[type="submit"]:hover {
        background-color: #3e8e41;
      }
</style>
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
    if(isset($_POST["inscriptionSubmit"])){
        if(!empty($_POST["Pseudo"]) && !empty($_POST["mdp"])){

            $Pseudo = $_POST["Pseudo"];
            $mdp = $_POST["mdp"];

            $req = "INSERT INTO User (Pseudo,mdp) VALUES ('".$Pseudo."','".$mdp."')";
            $RequeteStatement = $BasePDO->query($req);
            
            if($RequeteStatement){
                if($RequeteStatement->errorCode()=='00000'){
                    header("Location: index.php");
            }
        }
    }
}    
    ?>
    <H1>Inscription </H1>

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
            <input type="submit" name="inscriptionSubmit" value="S'inscrire" class="btnConnexion">
        </div>

        <div class="form-example">
            <a href="connexion.php">Retour</a>
        </div>
    </form>
</body>
</html>