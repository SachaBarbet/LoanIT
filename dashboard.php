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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">

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
    </body>
</html>