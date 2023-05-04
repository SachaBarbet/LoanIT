<?php require './init.php';


// Génère une liste des articles qui sont en stock
try {
    $pdo = new PDO($connectBis);
    $resultReq = $pdo->query("SELECT resourceID, name, qtyStock FROM Resources WHERE qtyStock>0 ORDER BY qtyStock;");
    $qteReq = $resultReq->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
} catch (PDOException $e) {
    die($e);
}

// Si pas de données
if (count($qteReq) == 0) {
    echo '<tr><td>NO DATA</td></tr>';
    exit();
}

// Sinon
foreach ($qteReq as $qte) {
    echo "<tr><td>{$qte['name']}</td><td id=\"td-in-stock\">IN STOCK</td></tr>";
}
?>