<?php require './init.php';
if (!$_SESSION['isLogged'] || !$_SESSION['isLenderValid']) {
    header('location: ../index.php');
    exit();
}


// Contient les functions de générations de la page borrows
$currentDay = date("d/m/Y");
function generateBorrowsSection() {
    global $connectBis;

    try {
        $pdo = new PDO($connectBis);
        $resultReq = $pdo->query("SELECT * FROM Loans WHERE userID={$_SESSION['user']['userID']};");
        $loans = $resultReq->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    // Génération du tableau des emprunts
    if (count($loans) == 0) {
        echo "<p>You don't have any loan ! It's time to start !</p>";
    } else {
        echo '<table>';
        echo '<thead><tr><th>Resource</th><th>Quantity</th><th>Start date</th><th>End date</th><th>State</th><th></th></tr></thead>';
        echo '<tbody>';

        foreach($loans as $loan) {
            $lowerCaseState = strtolower($loan['state']);
            echo "<tr class='tr-state-{$lowerCaseState}'>";

            try {
                $pdo = new PDO($connectBis);
                $resultReq = $pdo->query("SELECT name FROM Resources WHERE resourceID={$loan['resourceID']};");
                $resource = $resultReq->fetchAll(PDO::FETCH_ASSOC)[0];
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
                        if (empty($loan['endDate'])) {
                            $buttonValue = "END BORROW";
                        }
                        break;
                    case 'Unsold':
                        $buttonValue = "SOLD";
                        break;
                    default:
                        break;
                }

                if ($buttonValue != '') {
                    $formCell = "<form method='post' action='./php/borrows_actions.php'><input type='hidden' name='loanID' value='{$loan['loanID']}'><input type='hidden' name='action' value='{$lowerCaseState}'><input type='submit' value='{$buttonValue}'></form>";
                }
            }
            echo "<td>{$resource['name']}</td>";
            echo "<td>{$loan['qtyLent']}</td>";
            echo "<td>{$loan['startDate']}</td>";
            echo "<td>{$loan['endDate']}</td>";
            echo "<td class='td-state'>{$loan['state']}</td>";
            echo "<td>{$formCell}</td>";
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

function generateFormToBorrow() {
    global $connectBis, $currentDay;

    try {
        $pdo = new PDO($connectBis);
        $req = $pdo->query("SELECT resourceID, name, qtyStock FROM Resources WHERE qtyStock > 0;");
        $resources = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e);
    }

    if (count($resources) == 0) {
        echo '<p>There is no resource available for a new borrow.</p>';
    } else {
        echo '<form action="./php/borrows_actions.php" method="post">';
        echo '<div>';
        echo '<label for="resourceID">Resource : </label>';
        echo '<select name="resourceID" required>';
        echo '<option disabled selected hidden>Select a resource</option>';

        foreach($resources as $resource) {
            echo "<option qty='{$resource['qtyStock']}' value='{$resource['resourceID']}'>{$resource['resourceID']} - {$resource['name']}</option>";
        }
        
        echo '</select></div>';
        echo "<div><label for='qtyLend'>Quantity : </label><input name='qtyLend' type='number' min='1' max='100' required></div>";
        echo "<div><label for='startDate'>Start date: </label><input name='startDate' type='date' min='{$currentDay}' required></div>";
        echo '<input name="action" value="add" type="hidden">';
        echo '<input type="submit" value="BORROW">';
        echo '</form>';   
    }
}
?>