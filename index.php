<head>
<link rel="stylesheet" href="main.css">
</head>
<?php Session_start();
    include "BDD.php";
    include "fonction.php";
    Deconnexion();
    Verif();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="index.css">
</head>
<!--Page d'acceuil du Shop sur laquel on verifie (comme sur toute les pages) si la personne est connecter:
    -si c'est pas le cas on affiche le formulaire de connexion/inscription
    sinon la page s'affiche et le joueur peut poursuivre...  -->
<body>
<?php echo $_SESSION["Pseudo"]?>
    <form method=POST>
        <input type="submit" name="Exit" value="Se deconnecter">
    </form>
<div class="bourse">
    <?php
        Bourse();
    ?>
    <img src="bourse.jpg" style="width: 50px;"/>
</div>
<a href="panier.php" class="droite"><img src="caddie.jpg" style="width: 70px;"/></a>
    <H1>Bienvenue dans mon Shop, Aventurier !! </H1>

    <?php
    try {
        if(isset($_POST["Submit"])){
            if(!empty($_POST["IdItem"]) && !empty($_POST["ItemQuantiter"]) ){

                $IdItem = $_POST["IdItem"];
                $ItemQuantiter = $_POST["ItemQuantiter"];
                if($_POST["Ihave"] >= 1){           //si j'en ai 1 ou plus dans mon panier
                    $ItemQuantiter += $_POST["Ihave"];
                    $req = "UPDATE Transaction SET Quantiter ='".$ItemQuantiter."' WHERE IDUser = '".$_SESSION["ID"]."' AND IDItem = '".$IdItem."'";
                }else{
                    $req = "INSERT INTO Transaction(IDUser, IDItem, Quantiter) VALUES ('".$_SESSION['ID']."','".$IdItem."','".$ItemQuantiter."')";
                }
                
                $RequeteStatement = $BasePDO->query($req);

                if($RequeteStatement){
                    if($RequeteStatement->errorCode()=='00000'){
                        echo "Reussite de l'ajout au panier : ";
                        echo "Ajouter au panier" ;
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
                            <!--<td><a href="updateShop.php?IdUpdate=<?php echo $Tab["ID"]?>"><?php echo $Tab["ID"]?></a></td>-->
                            <td>&nbsp;<?php echo $Tab["Nom"] ?></td>
                            <td>&nbsp;<?php echo $Tab["Prix"] ?> Gold</td>
                            <td> &nbsp; En stock : <?php echo $Tab["Quantiter"] ?></td>
                            <td><img style="width: 64 px;height : 64px" src="<?php echo $Tab["Image"]?>" alt="Image de l'objet"></td>
                            <td>
                            <form action="" method="post">
                                <?php
                                   $req = "SELECT Quantiter FROM Transaction WHERE IDUser = '".$_SESSION["ID"]."' AND IDItem= '" .$Tab["ID"]."' ";
                                   $RocketStatement = $BasePDO->query($req);
                                   $Tob=$RocketStatement->fetch();
                                   $Ihave = 0 ;
                                   if($Tob){
                                       $Ihave= $Tob["Quantiter"];
                                       echo "Vous avez ".$Tob["Quantiter"]." X cet item dans votre panier.";
                                       $Tob["Quantiter"] = $Tab["Quantiter"] - $Tob["Quantiter"];
                                       
                                   }else{
                                       $Tob["Quantiter"] = $Tab["Quantiter"];
                                   }
                                ?>
                            <div class="form-example">
                                <label for="ItemQuantiter">Quantiter : </label>
                                <select name="ItemQuantiter" id="ItemQuantiter">
                                    <?php
                                    for($i=1;$i<= $Tob["Quantiter"] ;$i++){
                                        echo "'<option value=".$i.">$i</option>";
                                    }
                                    ?>
                                    <input type="submit" name="Submit" value="Ajouter au Panier">
                                    <input type="hidden" name="IdItem" value="<?php echo $Tab["ID"] ?>">
                                    <input type="hidden" name="Ihave" value = "<?php echo $Ihave ?>">
                                </select>
                            </div>
                            </form>
                            </td>
                            <!--<td><a href="deleteShop.php?IdDelete=<?php echo $Tab["ID"]?>">X</a></td>-->
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