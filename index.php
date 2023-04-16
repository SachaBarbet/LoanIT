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
            <h1 id="title">Loans Management</h1>
            <ul id="list-nav">
                <?php
                    if ($_SESSION['isLogged'] && $_SESSION['isLenderValid']) {
                        echo '<li class="link"><a href="borrows.php">MY BORROWS</a></li>';
                        //echo '<li class="link"><a href="feedbacks.php">MY FEEDBACKS</a></li>';
                    }
                ?>
            </ul>
            <div id="li-list-menu">
                <img src="./assets/images/utilisateur.png" alt="profile icon" id="img-user">
                <ul id="list-menu">
                    <?php
                        if ($_SESSION['isLogged']) {
                            if ($_SESSION['isAdmin']) {
                                echo '<li><a href="tables.php" id="link-tables">TABLES</a></li>';
                                //echo '<li><a id="link-add-lender">ADD LENDER</a></li>';
                                //echo '<li><a id="link-add-user">ADD USER</a></li>';
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
                <div>
                    <h2>Welcome on <strong>Loans Management</strong></h2>
                    <p>Through this website, you can manage resources, lenders and loans.</p>
                </div>
                <article>
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#17202A" d="M45.7,-36.8C57.8,-21.4,65,-2.5,62,15.6C59,33.6,45.8,50.7,27.5,60.9C9.3,71.1,-14.1,74.5,-29.9,65.5C-45.7,56.6,-54,35.4,-59.4,13.2C-64.8,-9.1,-67.2,-32.3,-56.9,-47.3C-46.5,-62.3,-23.2,-69,-3.2,-66.5C16.9,-64,33.7,-52.1,45.7,-36.8Z" transform="translate(100 100)" />
                    </svg>
                    <div id="box-svg-content">
                        <h2>Title content</h2>
                        <p>content</p>
                    </div>
                </article>
            </section>

            <div class="box-separator-hori"></div>

            <section id="section-actu">
                <article id="article-top">
                    <h2>Top Resources</h2>
                    <table>
                        <tbody>
                            <?php require './generate/generateTop.php'; ?>
                        </tbody>
                    </table>
                </article>

                <article id="article-stock">
                    <h2>Resources Status</h2>
                    <div id="tables-stock">
                        <table>
                            <tbody>
                                <?php require './generate/generateStock.php'; ?>
                            </tbody>
                        </table>

                        <div class="box-separator-vert"></div>
                        
                        <table>
                            <tbody>
                                <?php require './generate/generateNoStock.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
                <?php
                    if ($_SESSION['isAdmin']) {
                        echo '<article id="article-no-solution">';
                        echo '<h2>Resources with a problem and without any solution !</h2>';
                        echo '<table>';
                        echo '<tbody>';
                        require './generate/generateNoSol.php';
                        echo '</tbody>';
                        echo '</table>';
                        echo '</article>';
                    }
                ?>
            </section>
        </main>
        
        <footer>
            <p>developed by BARBET Sacha</p>
        </footer>
        <script src="javascript/loginMenu.js"></script>
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
    </body>
</html>