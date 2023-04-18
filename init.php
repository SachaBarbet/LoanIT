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
    if (!isset($_SESSION['user'])) { $_SESSION['user'] = ['name' => '', 'lastname' => '', 'login' => '', 'lenderID' => '']; }

    //init database tables
    $connect = 'sqlite:../data/database.sqlite';
    $connectBis = 'sqlite:./data/database.sqlite';
    $connectUsers = 'sqlite:../data/users-data.sqlite';
    $tablesStruct = [
        "Resources" => ["resourceID", "name", "designation", "qtyStock", "qtyReserv", "qtyLend", "qtyLendTot"],
        "Lenders" => ["lenderID", "name", "observation", "userID", "activeLoan"],
        "Loans" => ["loanID", "lenderID", "resourceID", "qtyLent", "startDate", "endDate", "state"],
        "Feedbacks" => ["feedbackID", "loanID", "date", "feedback", "solution"]
    ];

    $tablesStructNoID = [
        "Resources" => ["name", "designation", "qtyStock", "qtyReserv", "qtyLend", "qtyLendTot"],
        "Lenders" => ["name", "observation", "userID", "activeLoan"],
        "Loans" => ["lenderID", "resourceID", "qtyLent", "startDate", "endDate", "state"],
        "Feedbacks" => ["loanID", "date", "feedback", "solution"]
    ];
?>