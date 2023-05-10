<?php require './init.php';


// Sont les fonctions qui ne sont executées qu'une fois par jour 
$settings = json_decode(file_get_contents('./data/settings.json'), true);
$currentDay = date("d/m/Y");

function updateBorrowsState() {
    global $connectBis, $currentDay;
    
    // récupération des emprunts et mise à jour
    try {
        $pdo = new PDO($connectBis);
        $loans = $pdo->query("SELECT loanID, resourceID, qtyLent, startDate, endDate, state FROM Loans;")->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    foreach ($loans as $loan) {
        switch ($loan['state']) {
            case 'Inactive':
                if ($currentDay >= $loan['startDate']) {
                    try {
                        $pdo = new PDO($connectBis);
                        $pdo->prepare("UPDATE Loans SET state=? WHERE loanID=?;")->execute(["Active", $loan['loanID']]);
                        $pdo->prepare("UPDATE Resources SET qtyLend=qtyLend+?, qtyLendTot=qtyLendTot+?, qtyReserv=qtyReserv-? WHERE resourceID=?;")->execute([$loan['qtyLent'], $loan['qtyLent'], $loan['qtyLent'], $loan['resourceID']]);
                        $pdo = null;
                    } catch (PDOException $e) {
                        die($e);
                    }
                }
                break;
            case 'Active':
                if ($currentDay > $loan['endDate']) {
                    try {
                        $pdo = new PDO($connectBis);
                        $pdo->prepare("UPDATE Loans SET state=? WHERE loanID=?;")->execute(["Unsold", $loan['loanID']]);
                        $pdo = null;
                    } catch (PDOException $e) {
                        die($e);
                    }
                }
                break;
            default:
                break;
        }
    }
}


if ($settings[0]["dateUpdate"] != $currentDay) {
    $settings[0]["dateUpdate"] = $currentDay;
    $jsonEncode = json_encode($settings);
    file_put_contents('./data/settings.json', $jsonEncode);
    updateBorrowsState();
}
?>