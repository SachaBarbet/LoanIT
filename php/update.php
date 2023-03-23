<?php
    $table = $_POST["table"];
    $rowID = $_POST["rowID"];

    require '../init.php';

    if (!$_SESSION['isAdmin']) header('location: ../index.php');

    if(!isset($table)) {
        header("location: ../tables.php");
        exit();
    }

    $reqLine = "UPDATE {$table} SET ";

    $updateList = [];
    $isFirst = true;
    foreach($tablesStructNoID[$table] as $row) {
        if(isset($_POST[$row])) {
            $element = str_replace("<", "'<'", $_POST[$row]);
            if(!empty($element)) {
                if(!$isFirst) {
                    $reqLine = "{$reqLine}, ";
                }
                $reqLine = "{$reqLine}{$row}=?";
                array_push($updateList, $element);
                $isFirst = false;
            }
        }
    }
    
    if(!isset($updateList[0])) {
        header("location: ../tables.php?table={$table}");
        exit();
    }

    $tableNameBis = strtolower(rtrim($table, "s"));
    $reqLine = "{$reqLine} WHERE {$tableNameBis} ID=?;";
    array_push($updateList, $rowID);

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