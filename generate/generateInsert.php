<?php
    require '../init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');

    $tableName = $_GET['table'];

    foreach($tablesStructNoID[$tableName] as $tableRow) {
        $type = (strpos($tableRow, 'date') != 0) ? 'date' : 'text';
        $isID = (strpos($tableRow, 'ID')) ? true : false;
        if ($tableRow == "userID") $isID = false;
        // Si la colonne est une clé étrangère on récupère les valeurs ce cette table étrangère pour les proposer dans le insert avec un select, sinon un input normal
        if(!$isID) {
            echo "<input type='{$type}' placeholder='{$tableRow}' name='{$tableRow}'>";
        } else {
            $tableNameB = rtrim($tableRow, "ID") . "s";
            $tableIDs = null;
            try {
                $pdo = new PDO($connect);
                if ($tableNameB == "resourcesSuppliers") {
                    $req = "SELECT {$tableRow} FROM {$tableNameB};";
                } else {
                    $req = "SELECT {$tableRow}, name FROM {$tableNameB};";
                }
                $tableIDs = $pdo->query($req);
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