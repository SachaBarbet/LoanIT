<?php require 'init.php';
    if (!$_SESSION['isAdmin']) {
        header('location: ./index.php');
        exit();
    }
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

        <title>LoanIT</title>
    </head>
    <body>
        <nav>
            <a href="./index.php"><< BACK</a>
            <p>Dashboard</p>
            <ul>
                <li>
                    <p>HOME</p>
                    <ul>
                        <li><button>Statistics</button></li>
                    </ul>
                </li>
                <li>
                    <p>INTERACTIONS</p>
                    <ul>
                        <li><button id="button-add-user">Add a user</button></li>
                        <li><button id="button-remove-user">Delete a user</button></li>
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
            <section id="section-stats">
                <article id="article-top">
                    <h2>Top Resources</h2>
                    <table>
                        <tbody>
                            <?php require './generate/generate_top.php'; ?>
                        </tbody>
                    </table>
                </article>

                <article id="article-stock">
                    <h2>Resources Status</h2>
                    <div id="tables-stock">
                        <table>
                            <tbody>
                                <?php require './generate/generate_stock.php'; ?>
                            </tbody>
                        </table>
                        
                        <table>
                            <tbody>
                                <?php require './generate/generate_no_stock.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </main>
        <div id="box-add-user" class="popup">
            <form action="./php/add_user.php" method="post">
                <h2>Add a user</h2>
                <input type="text" name="name" placeholder="User name" >
                <input type="password" name="password" placeholder="User password" >
                <select name="type" >
                    <option value="" disabled selected hidden>Select the user type</option>
                    <option value="0">0 - User with no type</option>
                    <option value="1">1 - Lender</option>
                    <option value="2">2 - Admin</option>
                </select>
                <input type="text" placeholder="Observation" name="observation">
                <input type="submit" value="ADD USER">
                <button class="button-close-popup" onclick="hidePopup('box-add-user');">click here to close this popup</button>
            </form>
        </div>
        <div id="box-remove-user" class="popup">
            <form action="./php/remove_user.php" method="post">
                <h2>Remove a user</h2>
                <select name="userID">
                    <option value="" hidden selected disabled>Select a user to remove</option>
                    <?php require './generate/generate_userid.php'; ?>
                </select>
                <input type="submit" value="DELETE USER">
                <button class="button-close-popup" onclick="hidePopup('box-remove-user');">click here to close this popup</button>
            </form>
        </div>
        <!--Javascript-->
        <script src="./javascript/popup.js"></script>
    </body>
</html>