<?php
    require './init.php';

    if (!$_SESSION['isLogged'] || !$_SESSION['isLenderValid']) header('location: ../index.php');

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
                    $formCell = "<form method='post' action='./borrows_functions.php'><input type='hidden' name='loanID' value='{$loan['loanID']}'><input type='hidden' name='action' value='{$lowerCaseState}'><input type='submit' value='{$buttonValue}'></form>";
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
            foreach($resources as $loan) {
                echo '<tr>';
                foreach($loan as $value) {
                    echo "<td>{$value}</td>";
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
    }

    function soldBollow() {

    }
?>