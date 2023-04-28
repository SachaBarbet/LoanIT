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
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/add_cmd.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">

        <script src="./javascript/bts-blanc.js"></script>

        <noscript>Javascript isn't supported by your browser !</noscript>

        <title>Loans Management</title>
    </head>
    <body>
        <nav>
            <a href="./index.php"><< BACK</a>
            <p>Dashboard</p>
            <ul>
                <li>
                    <p>HOME</p>
                    <ul>
                        <li><button>Terminal</button></li>
                        <li><button>Statistics</button></li>
                    </ul>
                </li>
                <li>
                    <p>INTERACTIONS</p>
                    <ul>
                        <li><button>Add a user</button></li>
                        <li><button>Delete a user</button></li>
                        <li><button onclick="showUpdate();">New command</button></li>
                        <li><button onclick="showReceive();">Receive command</button></li>
                    </ul>
                </li>
                <li>
                    <p>LINKS</p>
                    <ul>
                        <li><a href="./tables.php">Tables</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <main>
        </main>
        <section id="section-update">
            <div class="first">
                <button onclick="hideUpdate();"><span class="material-symbols-outlined">close</span></button>
            </div>
            <h3 id='title-update'>Add Command</h3>
            <form action="./php/add_cmd.php" method="post" id="form-addcmd">
                <input type="number" name="quantity">
                <input type="submit" value="ADD">   
                <select required name="resourcesSupplierID" id="select-cmd">
                    <?php 
                        $tableIDs = [];
                        try {
                            $pdo = new PDO($connectBis);
                            $req = "SELECT resourcesSupplierID FROM ResourcesSuppliers;";
                            $tableIDs = $pdo->query($req)->fetchAll(PDO::FETCH_ASSOC);
                            $pdo = null;
                        } catch (PDOException $e) {
                            die($e);
                        }

                        echo "<option selected hidden disabled>Select ResourcesSupplier</option>";
                        foreach($tableIDs as $tableID) {
                            echo "<option value='{$tableID['resourcesSupplierID']}'>{$tableID['resourcesSupplierID']}</option>";
                        }
                    ?>
                </select>
            </form>
        </section>
        <section id="section-receive">
            <div class="first">
                <button onclick="hideReceive();"><span class="material-symbols-outlined">close</span></button>
            </div>
            <h3 id='title-update'>Receive Command</h3>
            <form action="./php/received_cmd.php" method="post" id="form-cmd">
                <input type="submit" value="ADD">
                <select required name="purchaseHistoryID" id="select-cmd-rec">
                    <?php
                        $tableIDs = [];
                        try {
                            $pdo = new PDO($connectBis);
                            $req = "SELECT pruchaceHistoryID FROM PurchaseHistory WHERE dateReceived='' or dateReceived IS NULL;";
                            $tableIDs = $pdo->query($req)->fetchAll(PDO::FETCH_ASSOC);
                            $pdo = null;
                        } catch (PDOException $e) {
                            die($e);
                        }
                        echo "<option selected hidden disabled>Select Command</option>";
                        foreach($tableIDs as $tableID) {
                            echo "<option value='{$tableID['pruchaceHistoryID']}'>{$tableID['pruchaceHistoryID']}</option>";
                        }
                    ?>
                </select>
            </form>
        </section>
    </body>
</html>