<?php
function Deconnexion(){
    if (isset($_POST['Exit'])) {
        session_unset();
        session_destroy();
        }
}
function Verif(){
    if ((empty($_SESSION['ID'])) || (empty($_SESSION['Pseudo'])) || (empty($_SESSION['mdp']))) {
        header('Location: connexion.php');
    }
}
function Bourse(){
    echo "Bourse:'".$_SESSION["Bourse"]."' Gold";
    echo "<br>";
}
?>