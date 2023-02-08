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
    <title>Modif Item</title>
</head>
<body>
    <?php
    try {

        if (isset($_GET["IdUpdate"])) $idUpdate = $_GET["IdUpdate"];

        if(isset($_POST["ItemSubmit"])){
            if(!empty($_POST["ItemNom"]) && !empty($_POST["ItemPrix"])){

                $ItemNom = $_POST["ItemNom"];
                
                
                $ItemPrix = $_POST["ItemPrix"];


                $ItemQuantiter = $_POST["ItemQuantiter"];


                $ItemImage = $_POST["ItemImage"];
                //$req = "INSERT INTO 'MEDECIN'('Nom','Prenom') VALUES ('".$ItemNom."','".$MdecinPrenom."')";
                $req = "UPDATE Item SET Nom ='".$ItemNom."', Prix='".$ItemPrix."', Quantiter='".$ItemQuantiter."', Image = '".$ItemImage."' WHERE id = ".$idUpdate.""; 
                
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "Reussite de la modification : ";
                        echo $ItemNom." à été modifier ";
                    }else{
                        echo "Erreur N°".$RequeteStatement->errorCode()." lors de la modification";
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
        echo " <H1>Modifier L'Item N°".$idUpdate."</h1> ";
        
        $req = "SELECT * FROM Item WHERE ID = ".$idUpdate." ";
        $RequeteStatement = $BasePDO->query($req);
        if($RequeteStatement){
            $Tab=$RequeteStatement->fetch();

            $Nom = $Tab["Nom"];
            $Prix = $Tab["Prix"];
            $Quantiter = $Tab["Quantiter"];
            $Image = $Tab["Image"];

            ?>
            <form action="" method="post" class="formAjout">
            <div class="form-example">
                    <label for="ItemNom">Nom : </label>
                    <input type="text" name="ItemNom" id="ItemNom" value="<?php echo $Nom ?>" required>
                </div>
                <div class="form-example">
                    <label for="ItemPrix">Prix : </label>
                    <input type="number" min="0" name="ItemPrix" id="ItemPrix" value="<?php echo $Prix ?>" required>
                </div>
                <div class="form-example">
                    <label for="ItemQuantiter">Quantiter : </label>
                    <select name="ItemQuantiter" id="ItemQuantiter"  required>
                        <?php
                        for($i=0;$i< 20 ;$i++){
                            if($i == $Quantiter){
                                echo "'<option selected value=".$i.">$i</option>";
                            }else{
                                echo "'<option value=".$i.">$i</option>";
                        }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-example">
                    <label for="ItemImage">Lien de l'Image : </label>
                    <input type="text" name="ItemImage" id="ItemImage" size="50" value="<?php echo $Image ?>">
                </div>
                <div class="form-example">
                    <input type="submit" name="ItemSubmit" value="Modifier l'Item" class="btnAjout">
                </div>
            </form>


      
        <?php
    }else{
        echo "Aucun ITEM a modifier";
    
    }
}
    echo"<a href='Stock.php'>Retour</a><br>";





    ?>
</body>
</html>