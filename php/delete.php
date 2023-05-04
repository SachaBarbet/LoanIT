<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ../index.php');
    exit();
}


// Suppression d'un élément dans l'une des tables de la base de données
$table = $_POST["table"];
$tableRedirect = "?table={$table}";

if(isset($tablesStruct[$table])) {
    if (isset($_POST["clear"])) {
        try {
            $pdo = new PDO($connect);
            $pdo->query("DELETE FROM {$table};");
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }
    } else {
        if(isset($_POST["deleteID"]) && !empty($_POST["deleteID"])) {
            $deleteID = $_POST["deleteID"];
            $tableID = rtrim($table, "s") . "ID";
            try {
                $pdo = new PDO($connect);
                $req = $pdo->prepare("DELETE FROM {$table} WHERE {$tableID}=?;");
                $req->execute(array($deleteID));
                $req->closeCursor();
                $pdo = null;
            } catch (PDOException $e) {
                die($e);
            }
        }
    }
}
header("location: ../tables.php{$tableRedirect}");
exit();
?>