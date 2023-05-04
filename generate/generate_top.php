<?php require "./init.php";


// Génère un top 3 des ressources selon la quantité totale emprunter
try {
    $pdo = new PDO($connectBis);
    $resultReq = $pdo->query("SELECT resourceID, name, qtyLendTot FROM Resources ORDER BY qtyLendTot DESC");
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
$count = 0;
foreach ($qteReq as $qte) {
    $count++;
    if($count > 3) break;
    echo "<tr id=\"td-top-{$count}\"><td>{$count} - {$qte['name']}</td><td>Amont Lent : {$qte['qtyLendTot']}</td></tr>";
}
?>