<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert medecin</title>
    <link rel="stylesheet" type='text/css' media='screen' href="main.css">
</head>
<body>
    <H1>Ajouter un medecin </H1>

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
            <input type="submit" name="MedecinSubmit" value="Ajouter un Medecin" class="btnAjout">
        </div>
    </form>
    <?php
    session_start();

    $ipServerSQL ="localhost";
    $NomBase = "Medecin";
    $UserBDD = "root";
    $PassBDD = "root";

    try {
        $BasePDO = new PDO('mysql:host='.$ipServerSQL.';dbname='.$NomBase.';port=3306',$UserBDD, $PassBDD);
    
        if(isset($_POST["MedecinSubmit"])){
            if(!empty($_POST["MedecinNom"]) && !empty($_POST["MedecinPrenom"])){

                $MedecinNom = $_POST["MedecinNom"];
                $MedecinPrenom = $_POST["MedecinPrenom"];

                $req = "INSERT INTO Medecin(nom,prenom) VALUES ('".$MedecinNom."','".$MedecinPrenom."')";
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "Reussite de l'insertion : ";
                        echo $MedecinNom." ".$MedecinPrenom. " est le nouveau medecin ";
                    }else{
                        echo "Erreur N°".$RequeteStatement->errorCode()." lors de l'insertion";
                    }
                }else{
                    echo "Erreur dans le format de la requete";
                }

            }
        }

        $req = "SELECT * FROM Medecin ORDER BY id DESC";
        $RequeteStatement = $BasePDO->query($req);
        if($RequeteStatement){
            ?>
            <table border='1'>
                <?php
                while($Tab=$RequeteStatement->fetch()){
                    ?>
                        <tr>
                            <td><a href="update.php?IdUpdate=<?php echo $Tab["id"]?>"><?php echo $Tab["id"]?></a></td>
                            <td><?php echo $Tab["nom"] ?></td>
                            <td><?php echo $Tab["prenom"] ?></td>
                            <td><a href="delete.php?IdDelete=<?php echo $Tab["id"]?>">X</a></td>
                        </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
    
    } catch (Exception $e) {
        echo $e->getMessage();
    }?>

    
</body>
</html>