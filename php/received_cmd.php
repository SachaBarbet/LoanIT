<?php
    require '../init.php';

    if (!$_SESSION['isAdmin']) header('location: ../index.php');

    $currentDate = date('d/m/Y');
    $purchaseHistory = $_POST['purchaseHistoryID'];

    try {
        $pdo = new PDO($connect);
        $req = "UPDATE PurchaseHistory SET dateReceived=? WHERE pruchaceHistoryID=?;";
        $reqpre = $pdo->prepare($req);
        $reqpre->execute([$currentDate, $purchaseHistory]);
        $pdo = null;
    } catch (PDOException $e) {
        die($e);
    }

    $rescourceID = '';
    $quantity = 0;

    try {
        $pdo = new PDO($connect);
        $req = "SELECT P.quantity, R.resourceID FROM PurchaseHistory P INNER JOIN ResourcesSuppliers R ON R.resourcesSupplierID=P.resourcesSupplierID WHERE pruchaceHistoryID={$purchaseHistory};";
        $data = $pdo->query($req)->fetchAll(PDO::FETCH_ASSOC)[0];
    } catch (PDOException $e) {
        die($e);
    }

    $rescourceID = $data['resourceID'];
    $quantity = $data['quantity'];

    try {
        $pdo = new PDO($connect);
        $req = "UPDATE Resources SET qtyStock=qtyStock+? WHERE resourceID=?;";
        $reqpre = $pdo->prepare($req);
        $reqpre->execute([$quantity, $rescourceID]);
    } catch (PDOException $e) {
        die($e);
    }

    header("location: ../dashboard.php");
?>