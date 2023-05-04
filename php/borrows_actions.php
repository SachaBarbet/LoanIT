<?php require '../init.php';
if (!$_SESSION['isLogged'] || !$_SESSION['isLenderValid']) {
    header('location: ../index.php');
    exit();
}


// Contient les fonctions pour chaque actions sur les emprunts par un utilisateur (Ajout Modification Annulation Solder ...)

// Nouvel emprunt
function addBorrow() {
    global $connect, $currentDay;
    if (!isset($_POST['resourceID']) || empty($_POST['resourceID'])) {
        return;
    }

    $resourceID = $_POST['resourceID'];
    $userID = $_SESSION['user']['userID'];
    $qtyLend = $_POST['qtyLend'];
    $startDate = $_POST['startDate'];
    $startDateList = explode("-", $startDate);
    $startDate = "{$startDateList['2']}/{$startDateList['1']}/{$startDateList['0']}";

    if (strtotime($startDate) <= strtotime($currentDay)) {
        return;
    }

    try {
        $pdo = new PDO($connect);
        $resource = $pdo->query("SELECT qtyStock FROM Resources WHERE resourceID={$resourceID};")->fetchAll(PDO::FETCH_ASSOC)[0];
        $qtyAvailable = $resource["qtyStock"];
        if($qtyAvailable >= $qtyLend) {
            $test = $pdo->prepare("INSERT INTO Loans (resourceID, userID, qtyLent, startDate) VALUES (?, ?, ?, ?);")->execute([$resourceID, $userID, $qtyLend, $startDate]);
            if ($test) {
                $pdo->prepare("UPDATE Resources SET qtyStock=qtyStock-?, qtyReserv=qtyReserv+? WHERE resourceID=?;")->execute([$qtyLend, $qtyLend, $resourceID]);
            }
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }
}

// Annule l'emprunt s'il n'a pas encore commencé
function cancelBorrow() {
    global $connect;
    $loanID = $_POST['loanID'];

    try {
        $pdo = new PDO($connect);
        $resultReq = $pdo->query("SELECT resourceID, qtyLent, state FROM Loans WHERE loanID={$loanID};");
        $loan = $resultReq->fetchAll(PDO::FETCH_ASSOC);

        if (!$loan || !isset($loan[0]['resourceID'])) {
            $pdo = null;
            return;
        }

        if ($loan[0]['state'] != "Inactive") {
            $pdo = null;
            return;
        }

        $pdo->prepare("UPDATE Resources SET qtyStock=qtyStock+?, qtyReserv=qtyReserv-? WHERE resourceID=?;")->execute([$loan[0]['qtyLent'], $loan[0]['qtyLent'], $loan[0]['resourceID']]);
        $pdo->prepare("DELETE FROM Loans WHERE loanID=?;")->execute([$loanID]);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }
}

// Si l'emprunt est en cours, termine l'emprunt
function endBorrow() {
    global $connect, $currentDay;
    $loanID = $_POST['loanID'];

    try {
        $pdo = new PDO($connect);
        $resultReq = $pdo->query("SELECT endDate, state FROM Loans WHERE loanID={$loanID};");
        $loan = $resultReq->fetchAll(PDO::FETCH_ASSOC);

        if (!$loan || !isset($loan[0])) {
            $pdo = null;
            return;
        }

        if ($loan[0]['state'] != "Active") {
            $pdo = null; 
            return;
        }

        if ($loan[0]['endDate'] != "") {
            $pdo = null;
            return;
        }

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
        $resultReq = $pdo->query("SELECT resourceID, qtyLent, state FROM Loans WHERE loanID={$loanID};");
        $loan = $resultReq->fetchAll(PDO::FETCH_ASSOC);
        if (!$loan || !isset($loan[0]['resourceID'])) {
            $pdo = null;
            return;
        }

        if ($loan[0]['state'] != "Unsold") {
            $pdo = null;
            return;
        }

        $pdo->prepare("UPDATE Resources SET qtyStock=qtyStock+?, qtyLend=qtyLend-? WHERE resourceID=?;")->execute([$loan[0]['qtyLent'], $loan[0]['qtyLent'], $loan[0]['resourceID']]);
        $pdo->prepare("UPDATE Loans SET state=? WHERE loanID=?;")->execute(["Solded", $loanID]);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }
}


$currentDay = date("d/m/Y");

if (!isset($_POST['action']) || empty($_POST['action'])) {
    header('location: ../borrows.php');
    exit();
}

$action = $_POST['action'];

if ($action !== 'add' && (!isset($_POST['loanID']) || empty($_POST['loanID']))) {
    header('location: ../borrows.php');
    exit();
}

switch ($action) {
    case 'active': endBorrow(); break;
    case 'inactive': cancelBorrow(); break;
    case 'unsold': soldBorrow(); break;
    case 'add': addBorrow(); break;
    default:
        break;
}

header('location: ../borrows.php');
exit();
?>