<?php
    require '../init.php';

    if (!$_SESSION['isAdmin']) header('location: ../index.php');

    $currentDate = date('d/m/Y');

    $resourceSupp = $_POST['resourcesSupplierID'];
    $userID = $_SESSION['user']['userID'];
    $quantity = $_POST['quantity'];
    $prices = getPrices($resourceSupp, $quantity);

    try {
        $pdo = new PDO($connect);
        $req = "INSERT INTO PurchaseHistory (resourcesSupplierID, quantity, priceTot, priceU, dateOrdered, userID) VALUES (?, ?, ?, ?, ?, ?);";
        $reqpre = $pdo->prepare($req);
        $reqpre->execute([$resourceSupp, $quantity, $prices[0], $prices[1], $currentDate, $userID]);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    function getPrices($bar, $ricard) :array {
        global $connect;
        $output = [0, 0];
        $price = 0;
        $ricard = intval($ricard);
        try {
            $pdo = new PDO($connect);
            $result = $pdo->query("SELECT price FROM ResourcesSuppliers WHERE resourcesSupplierID={$bar};");
            $out = $result->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;
        } catch (\PDOException $e) {
            die($e);
        }
        foreach($out as $element) {
            $price = $element['price'];
            break;
        }

        $output = [($price * $ricard), $price];
        
        return $output;
    }

    header("location: ../dashboard.php");
?>