<?php
    require './init.php';

    try {
        $pdo = new PDO($connectBis);
        $qteReq = $pdo->query("SELECT name FROM Resources WHERE qtyStock=0;");
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    $count = 0;

    foreach ($qteReq as $qte) {
        echo "<tr><td>{$qte['name']}</td><td id=\"td-out-stock\">OUT OF STOCK</td></tr>";
        $count++;
    }
    if($count < 1) {
        echo '<tr><td>NO DATA</td></tr>';
    }
?>