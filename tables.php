<?php require 'init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/tables.css">

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">

        <script src="./javascript/table.js"></script>
        <script src="./javascript/update.js"></script>
        <noscript>Javascript isn't supported by your browser !</noscript>

        <title>Loans Management</title>
    </head>

    <?php
        if(isset($_GET["table"])) {
            require './init.php';
            if (isset($tablesStruct[ucfirst($_GET['table'])])) {
                $lowerTable = ucfirst(strtolower($_GET['table']));
                echo "<body onload='switchTable(\"{$lowerTable}\");'>";
            } else {
                header("location: ./tables.php");
            }
        } else {
            echo "<body>";
        }
    ?>
        <nav>
            <a href="./index.php"><< BACK</a>
            <ul>
                <li id="resources-link" class="link" onclick="switchTable('Resources');">RESOURCES</li>
                <li id="lenders-link" class="link" onclick="switchTable('Lenders');">LENDERS</li>
                <li id="loans-link" class="link" onclick="switchTable('Loans');">LOANS</li>
                <li id="feedbacks-link" class="link" onclick="switchTable('Feedbacks');">FEEDBACKS</li>
            </ul>
        </nav>

        <main>
            <div id="box-content">
                <p id="p-select">Select a table to display it !</p>
            </div>
            <section id="section-update" onclick="clearUpdateSection();">
            </section>
        </main>

        <div id="box-loading"><p>Loading data...</p><div></div></div>
    </body>
</html>