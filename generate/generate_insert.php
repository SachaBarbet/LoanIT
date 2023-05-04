<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ./index.php');
    exit();
}


// Génère le form pour insert de nouvelles données dans une table
// Est appelé dynamiquement en Javascript dans tables.php
$tableName = $_GET['table'];
foreach($tablesStructNoID[$tableName] as $tableRow) {
    $type = (strpos($tableRow, 'Date')) ? 'date' : 'text';
    $isID = (strpos($tableRow, 'ID')) ? true : false;

    // Si la colonne est une clé étrangère on récupère les valeurs ce cette table étrangère pour les proposer dans le insert avec un select, sinon un input normal
    if(!$isID) {
        echo "<input type='{$type}' placeholder='{$tableRow}' name='{$tableRow}'>";
    } else {
        $tableNameB = rtrim($tableRow, "ID") . "s";
        $tableIDs = null;
        try {
            $pdo = new PDO($connect);
            $req = "SELECT {$tableRow}, name FROM {$tableNameB};";
            $reqResult = $pdo->query($req);
            $tableIDs = $reqResult->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }
        echo "<select name='{$tableRow}' required>";
        echo "<option value='' disabled selected hidden>Select {$tableRow}</option>";
        echo "<option value='0'>0 - Empty</option>";
        foreach($tableIDs as $tableID) {
            echo "<option value='{$tableID[$tableRow]}'>{$tableID[$tableRow]} - {$tableID['name']}</option>";
        }
        echo "</select>";
    }
}
echo "<input type='hidden' value='{$tableName}' name='table'><div onclick='validInsert();'><span class='material-symbols-outlined'>add</span></div><div onclick='closeInsert();'><span class='material-symbols-outlined'>close</span></div>";
?>