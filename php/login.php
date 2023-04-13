<?php
    require '../init.php';

    if ($_SESSION['isLogged']) { header('location: ../index.php'); }

    $id = $_POST['id'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO($connectUsers);
        $users = $pdo->query("SELECT userID, name, lastname, login, password, type, lenderID FROM Users WHERE login='{$id}';");
        foreach($users as $user) {
            $passwordHashed = $user['password'];
            $userType = $user['type'];
            $lenderID = $user['lenderID'];
            $userIDsrc = $user['userID'];
            $userName = $user['name'];
            $userLastname = $user['lastname'];
            $userLogin = $user['login'];
            break;
        }
        $pdo = null;
    } catch (PDOException $e) {
        die("An error was occured : {$e}");
    }

    if (password_verify($password, $passwordHashed)) {
        // Check s'il y a besoins de redéfinir le hash selon si l'algo a changer
        if (password_needs_rehash($passwordHashed, PASSWORD_DEFAULT)) {
            include './changePassword.php';
        }

        // Check si l'utilisateur est dans la liste des emprunteurs et donc s'il peut emprunter
        if (isset($lenderID)) {
            try {
                $pdo = new PDO($connect);
                $users = $pdo->query("SELECT userID FROM Lenders WHERE lenderID={$lenderID};");
                foreach($users as $user) {
                    $userLendID = $user["userID"];
                    break;
                }
            } catch (PDOException $e) {
                die($e);
            }
            $_SESSION['isLenderValid'] = $userIDsrc === $userLendID;
        }

        // Mise à jour de la session si l'utilisateur se login
        if ($userType == 1) {
            $_SESSION['isAdmin'] = true;
        }
        $_SESSION['isLogged'] = true;
        $_SESSION['user'] = [
            'name' => $userName,
            'lastname' => $userLastname,
            'login' => $userLogin,
            'lenderID' => $lenderID
        ];
    }
    $_SESSION['tryLogin'] = true;

    header('location: ../index.php');
?>