<?php
    //init session
    if(session_status() != PHP_SESSION_ACTIVE) {
        if (ini_get('session.cookie_lifetime') != 0) { ini_set('session.cookie_lifetime', 0); }
        if (ini_get('session.use_only_cookies' != 1)) { ini_set('session.use_only_cookies', 1); }
        if (ini_get('session.cookie_samesite') != 'Lax') { ini_set('session.use_strict_mode', 'Lax'); }
        if (ini_get('session.use_strict_mode') != 1) { ini_set('session.use_strict_mode', 1); }
        session_start();
    }

    if (!isset($_SESSION['isLogged'])) { $_SESSION['isLogged'] = false; }
    if (!isset($_SESSION['isAdmin'])) { $_SESSION['isAdmin'] = false; }
    if (!isset($_SESSION['tryLogin'])) { $_SESSION['tryLogin'] = false; }
    if (!isset($_SESSION['user'])) { $_SESSION['user'] = ['name' => '', 'lastname' => '', 'login' => '']; }

    //init database tables
    $connect = 'sqlite:../data/database.sqlite';
    $connectBis = 'sqlite:./data/database.sqlite';
    $connectUsers = 'sqlite:../data/users-data.sqlite';
    $tablesStruct = [
        "Resources" => ["resourceID", "name", "designation", "qtyStock", "qtyLend"],
        "Lenders" => ["lenderID", "name", "observation", "activeLoan"],
        "Loans" => ["loanID", "resourceID", "qtyLent","lenderID", "startDate", "endDate", "trueEndDate"],
        "Feedbacks" => ["feedbackID", "loanID", "date", "feedback", "solution"]
    ];

    $tablesStructNoID = new ArrayObject($tablesStruct);
    foreach($tablesStructNoID as $tableRows) { array_shift($tableRows); }
?>