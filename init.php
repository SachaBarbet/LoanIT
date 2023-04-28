<?php
    //init session
    //paramètres php
    if(session_status() != PHP_SESSION_ACTIVE) {
        if (ini_get('session.cookie_lifetime') != 0) { ini_set('session.cookie_lifetime', 0); }
        if (ini_get('session.use_only_cookies' != 1)) { ini_set('session.use_only_cookies', 1); }
        if (ini_get('session.cookie_samesite') != 'Lax') { ini_set('session.use_strict_mode', 'Lax'); }
        if (ini_get('session.use_strict_mode') != 1) { ini_set('session.use_strict_mode', 1); }
        session_start();
    }

    // paramètres session
    if (!isset($_SESSION['isLogged'])) { $_SESSION['isLogged'] = false; }
    if (!isset($_SESSION['isAdmin'])) { $_SESSION['isAdmin'] = false; }
    if (!isset($_SESSION['tryLogin'])) { $_SESSION['tryLogin'] = false; }
    if (!isset($_SESSION['isLenderValid'])) { $_SESSION['isLenderValid'] = false; }
    if (!isset($_SESSION['user'])) { $_SESSION['user'] = ['name' => '', 'login' => '', 'userID' => '']; }

    //init database tables
    $connect = 'sqlite:../data/database.sqlite';
    $connectBis = 'sqlite:./data/database.sqlite';
    $tablesStruct = [
        "Resources" => ["resourceID", "name", "designation", "qtyStock", "qtyReserv", "qtyLend", "qtyLendTot"],
        "Users" => ["userID", "name", "login", "password", "observation", "type", "activeLoan"],
        "Loans" => ["loanID", "userID", "resourceID", "qtyLent", "startDate", "endDate", "state"],
        "Suppliers" => ["supplierID", "name"],
        "Resourcessuppliers" => ["resourcesSupplierID", "resourceID", "supplierID", "price"],
        "Purchasehistory" => ["purchaceHistoryID", "resourcesSupplierID", "quantity", "priceTot", "priceU", "dateOrdered", "dateReceived", "userID"],
    ];

    $tablesStructNoID = [
        "Resources" => ["name", "designation", "qtyStock", "qtyReserv", "qtyLend", "qtyLendTot"],
        "Users" => ["name", "login", "password", "observation", "type", "activeLoan"],
        "Loans" => ["userID", "resourceID", "qtyLent", "startDate", "endDate", "state"],
        "Suppliers" => ["name"],
        "Resourcessuppliers" => ["resourceID", "supplierID", "price"],
        "Purchasehistory" => ["resourcesSupplierID", "quantity", "priceTot", "priceU", "dateOrdered", "dateReceived", "userID"],
    ];
?>