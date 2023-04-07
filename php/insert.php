<?php
    // Si l'utilisateur qui insert est admin, et si la table existe
    $table= $_GET["insertTable"];
    require '../init.php';

    if (!$_SESSION['isAdmin']) header('location: ../index.php');

    if(isset($tablesStruct[$table])) {
        $insertList = [];
        // Variable qui contient la requete
        $reqStart = "INSERT INTO {$table} (";
        $reqEnd = ") VALUES (";

        $isFirst = true;
        $qteEmprunts = 0;
        $resID = "";
        foreach($tablesStructNoID[$table] as $tableRows) {
            if(!isset($_POST[$tableRows])) continue;
            $element = str_replace("<", "'<'", $_POST[$tableRows]);
            if($table === "Loans") {
                if($tableRows === "qtyLent") {
                    $qteEmprunts = $element;
                }
                if($tableRows === "resourceID") {
                    $resID = $element;
                }
            }
            array_push($insertList, $element);
            if($isFirst) {
                $isFirst = false;
                $reqStart = "{$reqStart}{$tableRows}";
                $reqEnd = "{$reqEnd}?";
            } else {
                $reqStart = "{$reqStart}, {$tableRows}";
                $reqEnd = "{$reqEnd}, ?";
            }
        }

        if ($table === "Loans") {

            $qteDispo = 0;
            $qteEmprunter = 0;
            
            // Comme on est en SQLite, on établi les règles en PHP et non SQL alors quand on ajoute un empreint
            // On prend la quantité empreinté, en l'enlève de la valeur stock et on l'ajoute à la valeur nombre emprunté dans la table ressources
            try {
                $pdo = new PDO($connect);
                $qteStockQuerys = $pdo->query("SELECT qtyStock, qtyLend FROM Resources WHERE resourceID={$resID};");
                foreach($qteStockQuerys as $qteStockQuery) {
                    $qteDispo = $qteStockQuery["qtyStock"];
                    $qteEmprunter = $qteStockQuery["qtyLend"];
                }
                $pdo = null;
            } catch (PDOException $e) {
                die("Error : " . $e);
            }

            if($qteDispo >= $qteEmprunts) {
                $pdo = new PDO($connect);
                $updateReq = $pdo->prepare("UPDATE Resources SET qtyStock=?, qtyLend=? WHERE resourceID={$resID};");
                $updateReq->execute(array(($qteDispo - $qteEmprunts), $qteEmprunts));
                $pdo = null;
            } else {
                header("location: ../tables.php?table={$table}");
                exit;
            }
        }

        $req = $reqStart . $reqEnd . ");";

        try {
            $pdo = new PDO($connect);
            $req = $pdo->prepare($req);
            $req->execute($insertList);
            $req->closeCursor();
            $pdo = null;
            header("location: ../tables.php?table={$table}");
            exit;
        } catch (PDOException $e) {
            die("Error : " . $e);
        }

    } else {
        header("location: ../tables.php");
        exit();
    }
?>