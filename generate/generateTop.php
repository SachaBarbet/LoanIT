<?php
    require "./init.php";

    try {
        $pdo = new PDO($connectBis);
        $qteReq = $pdo->query("SELECT resourceID, name, qtyLendTot FROM Resources ORDER BY qtyLendTot DESC");
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    $count = 0;
    foreach ($qteReq as $qte) {
        $count++;
        if($count > 3) break;
        echo "<tr id=\"td-top-{$count}\"><td>{$count} - {$qte['name']}</td><td>Amont Lent : {$qte['qtyLendTot']}</td></tr>";
    }

    if($count < 1) echo "<tr><td>NO DATA</td><td></td></tr>";
?>