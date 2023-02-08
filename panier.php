<?php
session_start();	// Nous connect à la base de donnee
include "BDD.php";
include "fonction.php";

Deconnexion();

Verif();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link rel="stylesheet" type='text/css' media='screen' href="main.css">
</head>
<body>
<form method=POST>
    <input type="submit" name="Exit" value="Se deconnecter">
</form>
<?php
try{
    if(isset($_POST["Encaissement"])){          //Si le bouton Encaissment est appuyer
        $req = "SELECT Item.Prix, Item.ID, Item.Quantiter AS QuantiterDispo, Transaction.Quantiter AS QuantiterPanier, User.Bourse FROM User,Item,Transaction WHERE Transaction.IDUser = ".$_SESSION['ID']." AND Transaction.IDItem = Item.ID AND Transaction.IDUser = User.ID";
        $RequeteStatement = $BasePDO->query($req);
        if($RequeteStatement){
            $PrixTotal=0;
            while($Tab=$RequeteStatement->fetch()){             //calcul de la somme total du panier
                //prix*quantiter
                $PrixTotal += $Tab["QuantiterPanier"] * $Tab["Prix"] ;
            }
        }
        if($_SESSION["Bourse"] >= $PrixTotal){  //si tu possede les moyen de payer
            $RequeteStatement = $BasePDO->query($req);
            if($RequeteStatement){
                
                while($Tab=$RequeteStatement->fetch()){
                    //prix*quantiter
                    $PrixTotal = $Tab["QuantiterPanier"] * $Tab["Prix"] ;
                    //MAJ Panier
                    $QuantiterRestante = $Tab["QuantiterDispo"] - $Tab["QuantiterPanier"];   //calcul de la quantiter restante aprés l'achet
                    $req = "DELETE FROM Transaction WHERE Transaction.IDItem = '".$Tab["ID"]."' AND Transaction.Quantiter > '".$QuantiterRestante."' ";//condition on retire du panier des user qui on plus d'item qu'il ne va en rester
                    $BasePDO->query($req);
                    
                    $req = "UPDATE Item SET Quantiter='".$QuantiterRestante."' WHERE ID = ".$Tab["ID"]."";  //Mise a jour des quantiter disponible dans le Shop
                    $BasePDO->query($req);

                    $NouveauSolde = $_SESSION["Bourse"] - $PrixTotal ;
                    $req = "UPDATE User SET Bourse ='".$NouveauSolde."' WHERE ID = ".$_SESSION["ID"]."";  //Mise a jour de la Bourse du User aprés Encaissement
                    $BasePDO->query($req);

                    $req = "DELETE FROM Transaction WHERE Transaction.IDItem = '".$Tab["ID"]."' AND Transaction.IDUSer = '".$_SESSION["ID"]."'";//Suppresion de chaque Item 1 par 1 dans le panier du User
                    $BasePDO->query($req);
                    
                    $_SESSION["Bourse"]=$NouveauSolde;
                
                }
            }
        }else{
            echo "Vous êtes pauvre allez farmer des slimes nul";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
Bourse();
?>
<a href="index.php">Shop</a>
    <H1>Panier </H1>
<?php
/*prix*quantiter
    MAJ la Bourse
MAJ quantiterShop
MAJ Panier*/
    try {
        if(isset($_POST["Submit"])){
            if(!empty($_POST["IdItem"]) && !empty($_POST["ItemQuantiter"]) ){

                $IdItem = $_POST["IdItem"];
                $ItemQuantiter = $_POST["ItemQuantiter"];
                $req = "UPDATE Transaction SET Quantiter ='".$ItemQuantiter."' WHERE IDUser = '".$_SESSION["ID"]."' AND IDItem = '".$IdItem."'";
                
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "MAJ" ;
                    }else{
                        echo "Erreur N°".$RequeteStatement->errorCode()." lors de l'insertion";
                    }
                }else{
                    echo "Erreur dans le format de la requete";
                }

            }
        }

        $req = "SELECT Item.Nom, Item.Prix, Item.Image, Item.ID, Item.Quantiter AS QuantiterDispo, Transaction.Quantiter FROM Item,Transaction WHERE Transaction.IDUser = ".$_SESSION['ID']." AND Transaction.IDItem = Item.ID ORDER BY Transaction.ID DESC";
        $RequeteStatement = $BasePDO->query($req);
        if($RequeteStatement){
            ?>
            <table border='1'>
                <?php
                while($Tab=$RequeteStatement->fetch()){
                    ?>
                        <tr>
                            <td><?php echo $Tab["Nom"] ?></td>
                            <td><?php echo $Tab["Prix"] ?> Gold/u</td>
                            <td>
                            <form action="" method ="POST">
                                <div class="form-example">
                                    <label for="ItemQuantiter">Quantiter : </label>
                                    <select name = "ItemQuantiter" id="ItemQuantiter"  required>
                                    <?php
                                    for($i = 1; $i <= $Tab["QuantiterDispo"] ;$i++){
                                        if($i == $Tab["Quantiter"]){
                                            echo "'<option selected value=".$i.">$i</option>";
                                        }else{
                                            echo "'<option value=".$i.">$i</option>";
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="submit" name="Submit" value="MAJ">
                                    <input type="hidden" name="IdItem" value="<?php echo $Tab["ID"] ?>">
                                </div>
                            </form>    
                            
                            
                            <?php echo $Tab["Quantiter"] ?>
                            
                            </td>
                            <td><img style="width: 64 px;height : 64px" src="<?php echo $Tab["Image"]?>" alt="Image de l'objet"></td>
                            
                            <td><a href="deleteCart.php?IdDelete=<?php echo $Tab["ID"]?>">X</a></td>
                        </tr>
                    <?php
                }
                ?>
            </table>

            <form action="" method="post">
                <input type="submit" name="Encaissement" value="Acheter">
            </form>
            <?php
        }
    
    
    } catch (Exception $e) {
        echo $e->getMessage();
    }?>

    
</body>
</html>