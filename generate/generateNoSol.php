<?php
    require './init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');
    
    try {
        $pdo = new PDO($connectBis);
        $req = "SELECT Resources.name FROM Resources INNER JOIN Loans ON Resources.resourceID=Loans.resourceID INNER JOIN Feedbacks ON Loans.loanID=Feedbacks.loanID WHERE Feedbacks.solution IS NULL OR Feedbacks.solution=' ';";
        $tableIDs = $pdo->query($req);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }
    $count = 0;

    foreach($tableIDs as $tableID) {
        echo '<tr><td>'.$tableID["name"].'</td></tr>';
        $count++;
    }
    
    if($count < 1) {
        echo '<tr><td>NO DATA</td></tr>';
    }
?>