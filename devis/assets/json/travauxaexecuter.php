<?php

include('../includes/connexion.php');

$requete = "SELECT DISTINCT(travauxaexecuter_commande) as titretravaux FROM commandes";
$res = $connexion->query($requete);
$array = array();
while($row = $res->fetch(PDO::FETCH_ASSOC)){
    $array[] = $row['titretravaux'];
}

echo json_encode($array);

?>