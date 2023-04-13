<?php
    require './init.php';

    if (!$_SESSION['isLogged'] || !$_SESSION['isLenderValid']) header('../index.php');

    function generateBorrowsSection() {
        global $connectBis;
        try {
            $pdo = new PDO($connectBis);
            $req = $pdo->prepare("SELECT * FROM Loans WHERE lenderID=?;");
            $req->execute([$_SESSION['user']['lenderID']]);
            $loans = $req->fetchAll();
        } catch (PDOException $e) {
            die($e);
        }

        if (count($loans) === 0) {
            echo '<p>You don\'t have any loan ! It\'s time to start !</p>';
        } else {
            foreach($req as $loan) {
                echo "{$loan}";
            }
        }
    }

    function generateResourcesSection() {

    }

    function soldBollow() {

    }
?>