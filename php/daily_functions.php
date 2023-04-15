<?php
    require './init.php';

    $settings = json_decode(file_get_contents('./data/settings.json'), true);
    $currentDay = date("d/m/Y");
    if ($settings[0]["dateUpdate"] != $currentDay) {
        $settings[0]["dateUpdate"] = $currentDay;
    }

    function updateBorrowsState() {
        global $connectBis, $currentDay;
        
        // récupération des emprunts et mise à jour
        try {
            $pdo = new PDO($connectBis);
            $loans = $pdo->query("SELECT * FROM Loans;")->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }

        foreach ($loans as $loan) {
            switch ($loan['state']) {
                case 'Inactive':
                    if ($currentDay >= $loan['startDate']) $loan['state'] = "Active";
                    break;
                case 'Active':
                    if ($currentDay > $loan['endDate']) $loan['state'] = "Unsold";
                    break;
                default:
                    break;
            }
        }
    }

?>