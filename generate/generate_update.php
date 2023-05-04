<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ./index.php');
    exit();
}

// Génère le form pour l'update des valeurs d'un élément d'une table
// Pour chaque table
if(isset($_GET["tableName"]) && !empty($_GET["tableName"])){
    $tableName = $_GET["tableName"];
    $tableNameLow = strtolower($tableName);
    // Pour chaque colonne
    echo '<form action="./php/update.php" method="post" id="form-update">';
    foreach ($tablesStructNoID[$tableName] as $tableRow) {
        $type = (strpos($tableRow, 'date')) ? 'date' : 'text';
        $isID = (strpos($tableRow, 'ID')) ? true : false;
        if(!$isID) {
            echo "<input type='" . $type . "' placeholder='" . $tableRow . "' name='" . $tableRow . "'>";
        } else {
            // Dans le cas où c'est une clé externe on génère un select
            $tableIDs = null;
            $tableNameB = rtrim($tableRow, "ID") . "s";
            try {
                $pdo = new PDO($connect);
                $req = "SELECT {$tableRow}, name FROM {$tableNameB};";
                $resultReq = $pdo->query($req);
                $tableIDs = $resultReq->fetchAll(PDO::FETCH_ASSOC);
                $pdo = null;
            } catch (PDOException $e) {
                die($e);
            }
            echo "<select required name='{$tableRow}'>";
            echo "<option selected hidden disabled>Select {$tableRow}</option>";
            echo "<option value='0'>0 - Empty</option>";
            foreach($tableIDs as $tableID) {
                echo "<option value='{$tableID[$tableRow]}'>{$tableID[$tableRow]} - {$tableID['name']}</option>";
            }
            echo "</select>";
        }
    }
    echo "<input type='hidden' name='table' value='{$tableName}'><input id='input-update-row' type='hidden' name='rowID' value=''>";
    echo '</form><div class="last"><button onclick="validUpdate();">EDIT</button></div>';
}
?>