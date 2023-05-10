<?php require 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">

        <noscript>Javascript isn't supported by your browser !</noscript>

        <title>Loans Management</title>
    </head>
    
    <body>
        <header>
            <ul id="list-nav">
                <?php
                    if ($_SESSION['isLogged'] && $_SESSION['isLenderValid']) {
                        echo '<li class="link"><a href="borrows.php">MY BORROWS</a></li>';
                    }
                ?>
            </ul>
            <div id="li-list-menu">
                <img src="./assets/images/utilisateur.png" alt="profile icon" id="img-user">
                <ul id="list-menu">
                    <?php
                        if ($_SESSION['isLogged']) {
                            if ($_SESSION['isAdmin']) {
                                echo '<li><a href="./dashboard.php" id="link-dashboard">DASHBOARD</a></li>';
                            }
                            echo '<li><a href="./php/logout.php" id="link-logout">LOGOUT</a></li>';
                        } else {
                            echo '<li><a id="link-login">LOGIN</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </header>
    
        <main>
            <section id="section-main">
                <h1 class="text-animation fade-in-bottom">Welcome on <strong>Loans Management</strong></h1>
                <h4 class="text-animation fade-in-bottom">Through this website, you can manage resources, users and loans.</h4>
            </section>
        </main>
        
        <footer>
            <p class="text-animation fade-in-bottom">developed by BARBET Sacha</p>
        </footer>
        <canvas id="dot-box"></canvas>
        <script src="./javascript/loginMenu.js"></script>
        <?php
            // Ajoute les scripts js en fonction de l'etat de login
            if (!$_SESSION['isLogged']) {
                echo '<script src="javascript/login.js"></script>';

                if ($_SESSION['isAdmin']) {
                    echo '<script src="javascript/addLender.js"></script>';
                }

                if ($_SESSION['tryLogin']) {
                    echo '<script>clickOnLinkLogin(true);</script>';
                }
            } else if ($_SESSION['tryLogin']) {
                echo "<div id='box-popup-login'><span class='material-symbols-outlined'>waving_hand</span><p>Welcome {$_SESSION['user']['name']} !</p></div>";
                echo "<script>welcomeMsg();</script>";
            }

            $_SESSION['tryLogin'] = false;
        ?>
        <!--Javascript-->
        <script src="./javascript/floating_dot.js"></script>
    </body>
</html>