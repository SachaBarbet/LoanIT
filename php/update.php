<?php
    require '../init.php';

    if (!$_SESSION['isAdmin']) header('location: ../index.php');

    if(!isset($_POST["table"]) || !isset($tablesStruct[$_POST["table"]])) {
        header("location: ../tables.php");
        exit();
    }

    $table = $_POST["table"];
    $rowID = $_POST["rowID"];

    $reqLine = "UPDATE {$table} SET ";

    $updateList = [];
    $isFirst = true;
    foreach($tablesStructNoID[$table] as $row) {
        if(isset($_POST[$row]) && (!empty($_POST[$row]) || $_POST[$row] == 0)) {
            $element = htmlspecialchars($_POST[$row]);
            if(!$isFirst) {$reqLine .= ", ";}
            $reqLine .= "{$row}=?";
            array_push($updateList, $element);
            $isFirst = false;
        }
    }
    
    if(!isset($updateList[0])) {
        header("location: ../tables.php?table={$table}");
        exit();
    }

    $tableNameBis = strtolower(rtrim($table, "s")) . 'ID';
    $reqLine .= " WHERE {$tableNameBis}=?;";
    array_push($updateList, $rowID);
    echo $reqLine;
    try {
        $pdo = new PDO($connect);
        $req = $pdo->prepare($reqLine);
        $req->execute($updateList);
        $req->closeCursor();
        $pdo = null;
        header("location: ../tables.php?table={$table}");
        exit;
    } catch (PDOException $e) {
        die("Error : {$e}");
    }

?>