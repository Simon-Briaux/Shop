<?php
session_start();	// Nous connect à la base de donnee
include "BDD.php";

if ((!empty($_SESSION['ID'])) AND (!empty($_SESSION['Pseudo'])) AND (!empty($_SESSION['mdp'])))
{	//si l'utilisateur est connecte a une session
	header("Location: index.php");	//renvoie vers la page d'accueil
}?>
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
    try {
        $BasePDO = new PDO('mysql:host='.$ipServerSQL.';dbname='.$NomBase.';port=3306',$UserBDD, $PassBDD);

            if (isset($_GET["IdDelete"])) $idDelete = $_GET["IdDelete"];
             echo " <H1>Suppresion de l'Item N°".$_GET["IdDelete"]."</h1> ";
             echo"<a href='Stock.php'>Retour</a><br>";


                //$req = "INSERT INTO 'MEDECIN'('Nom','Prenom') VALUES ('".$MedecinNom."','".$MdecinPrenom."')";
                $req = "DELETE FROM Item WHERE id=".$idDelete.""; 
                
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "Reussite de la suppresion ";
                        echo "L'Item a été supprimer ";
                    }else{
                        echo "Erreur N°".$RequeteStatement->errorCode()." lors de l'insertion";
                    }
                }else{
                    echo "Erreur dans le format de la requete";
                }

    }catch (Exception $e) {
    echo $e->getMessage();
    }
    ?>
</body>
</html>