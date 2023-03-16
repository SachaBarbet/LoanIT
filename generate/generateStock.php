<?php
    require './init.php';

    try {
        $pdo = new PDO($connectBis);
        $qteReq = $pdo->query("SELECT resourceID, name, qtyStock FROM Resources WHERE qtyStock>0 ORDER BY qtyStock;");
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    $count = 0;

    foreach ($qteReq as $qte) {
        echo '<tr><td>'.$qte["name"].'</td><td id="td-in-stock">IN STOCK</td></tr>';
        $count++;
    }

    if($count < 1) {
        echo '<tr><td>NO DATA</td></tr>';
    }
?>