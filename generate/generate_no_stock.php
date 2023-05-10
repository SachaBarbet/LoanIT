<?php require './init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ./index.php');
    exit();
}

// Génère une liste des articles qui ne sont plus en stock
try {
    $pdo = new PDO($connectBis);
    $resultReq = $pdo->query("SELECT name FROM Resources WHERE qtyStock=0;");
    $qteReq = $resultReq->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
} catch (PDOException $e) {
    die($e);
}

// Si pas de données
if (count($qteReq) == 0) {
    echo '<tr><td>NO DATA</td></tr>';
}

// Sinon
foreach ($qteReq as $qte) {
    echo "<tr><td>{$qte['name']}</td><td id=\"td-out-stock\">OUT OF STOCK</td></tr>";
}
?>