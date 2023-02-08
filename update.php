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
    $ipServerSQL ="localhost";
    $NomBase = "Medecin";
    $UserBDD = "root";
    $PassBDD = "root";

   


    try {
        $BasePDO = new PDO('mysql:host='.$ipServerSQL.';dbname='.$NomBase.';port=3306',$UserBDD, $PassBDD);

        if (isset($_GET["IdUpdate"])) $idUpdate = $_GET["IdUpdate"];

        if(isset($_POST["MedecinSubmit"])){
            if(!empty($_POST["MedecinNom"]) && !empty($_POST["MedecinPrenom"])){

                $MedecinNom = $_POST["MedecinNom"];
                $MedecinPrenom = $_POST["MedecinPrenom"];

                //$req = "INSERT INTO 'MEDECIN'('Nom','Prenom') VALUES ('".$MedecinNom."','".$MdecinPrenom."')";
                $req = "UPDATE Medecin SET nom ='".$MedecinNom."', prenom='".$MedecinPrenom."' WHERE id = ".$idUpdate.""; 
                
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "Reussite de l'insertion : ";
                        echo $MedecinNom." ".$MedecinPrenom. " àété modifier ";
                    }else{
                        echo "Erreur N°".$RequeteStatement->errorCode()." lors de l'insertion";
                    }
                }else{
                    echo "Erreur dans le format de la requete";
                }

            }
        }
    
    } catch (Exception $e) {
        echo $e->getMessage();
    } if (isset($_GET["IdUpdate"])) {
        $idUpdate = $_GET["IdUpdate"];
        echo " <H1>Modifier Medecin N°".$_GET["IdUpdate"]."</h1> ";

        ?>
    <form action="" method="post" class="formAjout">
        <div class="form-example">
            <label for="MedecinNom">Nom : </label>
            <input type="text" name="MedecinNom" id="MedecinNom" required>
        </div>
        <div class="form-example">
            <label for="MedecinPrenom">Prenom : </label>
            <input type="text" name="MedecinPrenom" id="MedecinPrenom" required>
        </div>
        <div class="form-example">
            <input type="submit" name="MedecinSubmit" value="Modifier le Medecin N°<?php echo $idUpdate ?>" class="btnAjout">
        </div>
    </form>



        <?php
    }else{
        echo "Aucun Medecin a modifier";
    }
    





    ?>
</body>
</html>