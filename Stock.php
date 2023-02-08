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
    <title>Stock</title>
    <link rel="stylesheet" type='text/css' media='screen' href="main.css">
</head>
<body>
    <H1>Ajouter un Item </H1>

    <form action="" method="post" class="formAjout">
    <div class="form-example">
            <label for="ItemNom">Nom : </label>
            <input type="text" name="ItemNom" id="ItemNom" required>
        </div>
        <div class="form-example">
            <label for="ItemPrix">Prix : </label>
            <input type="number" min="0" name="ItemPrix" id="ItemPrix" required>
        </div>
        <div class="form-example">
            <label for="ItemQuantiter">Quantiter : </label>
            <select name="ItemQuantiter" id="ItemQuantiter" required>
                <?php
                for($i=0;$i< 20 ;$i++){
                    echo "'<option value=".$i.">$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-example">
            <label for="ItemImage">Lien de l'Image : </label>
        </div>
        <div class="form-example">
            <textarea name="ItemImage" id="ItemImage" placeholder="Lien de l'Image" required></textarea>
        </div>
        <div class="form-example">
            <input type="submit" name="ItemSubmit" value="Ajouter un Item" class="btnAjout">
        </div>
    </form>
    <?php


    try {
        if(isset($_POST["ItemSubmit"])){
            if(!empty($_POST["ItemNom"]) && !empty($_POST["ItemPrix"]) && !empty($_POST["ItemQuantiter"]) && !empty($_POST["ItemImage"])){

                $ItemNom = $_POST["ItemNom"];
                $ItemPrix = $_POST["ItemPrix"];
                $ItemQuantiter = $_POST["ItemQuantiter"];
                $ItemImage = $_POST["ItemImage"];

                $req = "INSERT INTO Item(Nom,Prix,Quantiter,Image) VALUES ('".$ItemNom."','".$ItemPrix."','".$ItemQuantiter."','".$ItemImage."')";
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "Reussite de l'insertion : ";
                        echo $ItemNom." est ajouter a l'inventaire de la boutique ";
                    }else{
                        echo "Erreur N°".$RequeteStatement->errorCode()." lors de l'insertion";
                    }
                }else{
                    echo "Erreur dans le format de la requete";
                }

            }
        }

        $req = "SELECT * FROM Item ORDER BY ID DESC";
        $RequeteStatement = $BasePDO->query($req);
        if($RequeteStatement){
            ?>
            <table border='1'>
                <?php
                while($Tab=$RequeteStatement->fetch()){
                    ?>
                        <tr>
                            <td><a href="updateShop.php?IdUpdate=<?php echo $Tab["ID"]?>"><?php echo $Tab["ID"]?></a></td>
                            <td><?php echo $Tab["Nom"] ?></td>
                            <td><?php echo $Tab["Prix"] ?></td>
                            <td><?php echo $Tab["Quantiter"] ?></td>
                            <td><img style="width: 64 px;height : 64px" src="<?php echo $Tab["Image"]?>" alt="Image de l'objet"></td>
                            <td><a href="deleteShop.php?IdDelete=<?php echo $Tab["ID"]?>">X</a></td>
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