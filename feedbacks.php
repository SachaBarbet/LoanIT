<?php require 'init.php';
    if (!$_SESSION['isLogged']) header('location: ./index.php');
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/feedbacks.css">

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">

        <script src="./javascript/functions.js"></script>
        <script src="./javascript/btsblanc.js"></script>
        <noscript>Javascript isn't supported by your browser !</noscript>

        <title>Loans Management</title>
    </head>

    <body>

        <main>
            <div>
                <a href="./tables.php"><< BACK</a>
            </div>
            <form action="./php/insert.php?insertTable=3" method="post" id="form-feedback">
                <select name="loanID" id="select-feedback-loan">
                    <?php
                        require './init.php';
                        
                        try {
                            $pdo = new PDO($connect);
                            $req = "SELECT Loans.loanID, Lenders.name FROM Loans INNER JOIN Lenders ON Loans.lenderID=Lenders.lenderID;";
                            $tableIDs = $pdo->query($req);
                            $pdo = null;
                        } catch (PDOException $e) {
                            die($e);
                        }
                        echo "<option value='' disabled selected hidden>Select {$tableRow}</option>";
                        foreach($tableIDs as $tableID) {
                            echo "<option value='{$tableID['loanID']}'>{$tableID['loanID']} - {$tableID['name']}</option>";
                        }
                        echo "</select>";
                    ?>
                </select>
                <input type="date" placeholder='date' name='date' class='input-feedback-text' id="input-date" >
                <input type="text" placeholder='feedback' name='feedback' class='input-feedback-text' id="input-feedback">
                <input type="submit" value="SUBMIT" class="button">
            </form>
        </main>
    </body>
</html>