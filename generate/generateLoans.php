<?php
    require './init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');

    try {
        $pdo = new PDO($connect);
        $req = "SELECT lenderID, name FROM Lenders;";
        $tableIDs = $pdo->query($req);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }
    echo "<option value='' disabled selected hidden>Select {$tableRow}</option>";
    foreach($tableIDs as $tableID) {
        echo "<option value='{$tableID[$tableRow]}'>{$tableID['name']}</option>";
    }
    echo "</select>";
?>
