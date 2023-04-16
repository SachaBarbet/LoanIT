<?php
    try {
        require './init.php';
    } catch (\Throwable $th) {
        require '../init.php';
    }
    

    if (!$_SESSION['isLogged'] || !$_SESSION['isLenderValid']) header('location: ../index.php');

    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        if (!isset($_POST['loanID']) || empty($_POST['loanID'])) return;
        switch ($action) {
            case 'active': endBorrow(); break;
            case 'inactive': cancelBorrow(); break;
            case 'unsold': soldBorrow(); break;
            default:
                break;   
        }
        header('location: ../borrows.php');
    }

    $currentDay = date("d/m/Y");

    function generateBorrowsSection() {
        global $connectBis;
        try {
            $pdo = new PDO($connectBis);
            $req = $pdo->prepare("SELECT * FROM Loans WHERE lenderID=?;");
            $req->execute([$_SESSION['user']['lenderID']]);
            $loans = $req->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }

        // Génération du tableau des emprunts
        if (count($loans) === 0) {
            echo '<p>You don\'t have any loan ! It\'s time to start !</p>';
        } else {
            echo '<table>';
            echo '<thead><tr><th>Resource</th><th>Quantity</th><th>Start date</th><th>End date</th><th></th></tr></thead>';
            echo '<tbody>';
            foreach($loans as $loan) {
                $lowerCaseState = strtolower($loan['state']);
                echo "<tr class='state-{$lowerCaseState}'>";
                try {
                    $pdo = new PDO($connectBis);
                    $req = $pdo->prepare("SELECT name FROM Resources WHERE resourceID=?;");
                    $req->execute([$loan['resourceID']]);
                    $res = $req->fetchAll(PDO::FETCH_ASSOC);
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e);
                }
                $formCell = '';
                $actionList = array('Inactive', 'Active', 'Unsold');
                if (in_array($loan['state'], $actionList)) {
                    $buttonValue = '';
                    switch ($loan['state']) {
                        case 'Inactive':
                            $buttonValue = "CANCEL";
                            break;
                        case 'Active':
                            $buttonValue = "END BORROW";
                            break;
                        case 'Unsold':
                            $buttonValue = "SOLD";
                            break;
                        default:
                            break;
                    }
                    $formCell = "<form method='post' action='./php/borrows_functions.php'><input type='hidden' name='loanID' value='{$loan['loanID']}'><input type='hidden' name='action' value='{$lowerCaseState}'><input type='submit' value='{$buttonValue}'></form>";
                }
                echo "<td>{$res[0]['name']}</td>";
                echo "<td>{$loan['qtyLent']}</td>";
                echo "<td>{$loan['startDate']}</td>";
                echo "<td>{$loan['endDate']}</td>";
                echo "<td>{$formCell}</td>";
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
    }

    function generateResourcesSection() {
        global $connectBis;
        try {
            $pdo = new PDO($connectBis);
            $req = $pdo->query("SELECT * FROM Resources WHERE qtyStock > 0;");
            $resources = false;
            if ($req != false) {
                $resources = $req->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die($e);
        }

        if (!$resources || count($resources) === 0) {
            echo '<p>There is no resource available for a new borrow.</p>';
        } else {
            echo '<table>';
            echo '<tbody>';
            foreach($resources as $resource) {
                echo '<tr>';
                foreach($resource as $value) {
                    echo "<td>{$value}</td>";
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
    }

    // Nouvel emprunt
    function addBorrow() {
        global $connectBis, $currentDay;
        if (!isset($_POST['resourceID']) || empty($_POST['resourceID'])) header('location: ../borrows.php');
        $resourceID = $_POST['resourceID'];
        $userID = $_SESSION['user']['lenderID'];
        $qtyLend = $_POST['qtyLend'] || header('location: ../borrows.php');
        $startDate = $_POST['startDate'] || header('location: ../borrows.php');
        if ($startDate <= $currentDay) return;
        $resource = $pdo->query("SELECT qtyStock FROM Resources WHERE resourceID={$resourceID};")->fetchAll(PDO::FETCH_ASSOC)[0];
        $qtyAvailable = $resource["qtyStock"];
        if($qtyAvailable >= $qtyLend) {
            try {
                $pdo = new PDO($connectBis);
                $pdo->prepare("INSERT INTO Loans (resourceID, lenderID, qtyLent, startDate) VALUES (?, ?, ?, ?);")->execute([$resourceID, $userID, $qtyLend, $startDate]);
                $pdo->prepare("UPDATE Resources SET qtyStock=qtyStock-?, qtyReserv=qtyReserv+? WHERE resourceID=?;")->execute([$qtyToReserv, $qtyToReserv, $resourceID]);
                $pdo = null;
            } catch (PDOException $e) {
                die($e);
            }
        } 
        header('location: ../borrows.php');
    }

    // Annule l'emprunt s'il n'a pas encore commencé
    function cancelBorrow() {
        global $connectBis;
        $loanID = $_POST['loanID'];
        try {
            $pdo = new PDO($connectBis);
            $req = $pdo->prepare("SELECT resourceID, qtyLent, state FROM Loans WHERE loanID=?;")->execute([$loanID]);
            $loan = $req->fetchAll(PDO::FETCH_ASSOC);
            if (!$loan || !isset($loan[0])) $pdo = null; return;
            if ($loan[0]['state'] != "Inactive") $pdo = null; return;
            $pdo->prepare("UPDATE Resources SET qtyStock=qtyStock+?, qtyReserv=qtyReserv-? WHERE resourceID=?;")->execute([$loan[0]['qtyLend'], $loan[0]['qtyLend'], $loan[0]['resourceID']]);
            $pdo->prepare("DELETE FROM Loans WHERE loanID=?;")->execute([$loanID]);
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }
    }

    // Si l'emprunt est en cours, termine l'emprunt
    function endBorrow() {
        global $connectBis, $currentDay;
        $loanID = $_POST['loanID'];
        try {
            $pdo = new PDO($connectBis);
            $req = $pdo->prepare("SELECT endDate, state FROM Loans WHERE loanID=?;")->execute([$loanID]);
            $loan = $req->fetchAll(PDO::FETCH_ASSOC);
            if (!$loan || !isset($loan[0])) $pdo = null; return;
            if ($loan[0]['state'] != "Active") $pdo = null; return;
            if ($loan[0]['endDate'] != "") $pdo = null; return;
            $pdo->prepare("UPDATE Loans SET endDate=? WHERE loanID=?;")->execute([$currentDay, $loanID]);
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }
    } 

    // Permet de définir l'emprunt comme totalement soldé (payer par exemple, ou alors que les ressources sont récupérées)
    function soldBorrow() {
        global $connect;
        $loanID = $_POST['loanID'];
        try {
            $pdo = new PDO($connect);
            $req = $pdo->prepare("SELECT resourceID, qtyLent, state FROM Loans WHERE loanID=?;");
            $req->execute([$loanID]);
            $loan = $req->fetchAll(PDO::FETCH_ASSOC);
            if (!$loan || !isset($loan[0])) $pdo = null; return;
            if ($loan[0]['state'] != "Unsold") $pdo = null; return;
            $pdo->prepare("UPDATE Resources SET qtyStock=qtyStock+?, qtyLend=qtyLend-? WHERE resourceID=?;")->execute([$loan[0]['qtyLend'], $loan[0]['qtyLend'], $loan[0]['resourceID']]);
            $pdo->prepare("UPDATE Loans SET state=? WHERE loanID=?;")->execute(["Solded", $loanID]);
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }
    }
?>