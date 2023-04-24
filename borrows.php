<?php require './php/borrows_functions.php'; require './php/daily_functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/borrows.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">
        <noscript>Javascript isn't supported by your browser !</noscript>

        <title>Loans Management</title>
    </head>
    <body>
        <main>
            <div id="box-back"><a href="./index.php"><< BACK</a></div>
            <div id="box-sections">
                <section id="section-borrows">
                    <h3>Your Borrows</h3>
                    <?php generateBorrowsSection(); ?>
                </section>
                <section id="section-resources">
                    <h3>Add a new borrow</h3>
                    <?php generateFormToBorrow(); ?>
                </section>
            </div>
        </main>
        <script src="./javascript/addBorrow.js"></script>
    </body>
</html>