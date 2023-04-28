<?php
    require '../init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');
    
    # Pour chaque table
    if(isset($_GET["tableName"])){
        $tableName = $_GET["tableName"];
        $tableNameLow = strtolower($tableName);
        # Pour chaque colonne
        echo '<form action="./php/update.php" method="post" id="form-update">';
        foreach ($tablesStructNoID[$tableName] as $tableRow) {
            $type = (strpos($tableRow, 'date') != 0) ? 'date' : 'text';
            $isID = (strpos($tableRow, 'ID')) ? true : false;
            if ($tableRow == "userID") $isID = false;
            if(!$isID) {
                echo "<input type='" . $type . "' placeholder='" . $tableRow . "' name='" . $tableRow . "'>";
            } else {
                $tableIDs = null;
                $tableNameB = rtrim($tableRow, "ID") . "s";
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