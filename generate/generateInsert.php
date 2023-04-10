<?php
    require '../init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');

    $tableName = $_GET['table'];

    foreach($tablesStructNoID[$tableName] as $tableRow) {
        $type = (strpos($tableRow, 'date')) ? 'date' : 'text';
        $isID = (strpos($tableRow, 'ID')) ? true : false;
        if ($tableRow == "userID") $isID = false;
        if(!$isID) {
            echo "<input type='{$type}' placeholder='{$tableRow}' name='{$tableRow}'>";
        } else {
            $tableNameB = rtrim($tableRow, "ID") . "s";
            $tableIDs = null;
            try {
                $pdo = new PDO($connect);
                $req = "SELECT {$tableRow}, name FROM {$tableNameB};";
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
    echo "<input type='hidden' value='{$tableName}' name='table'><div onclick='validInsert();'><span class='material-symbols-outlined'>add</span><p>INSERT</p></div><div onclick='closeInsert();'><span class='material-symbols-outlined'>close</span><p>CLOSE</p></div>";
?>