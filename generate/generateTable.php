<?php
    require '../init.php';

    if(isset($_GET['tableName']) && isset($tablesStruct[$_GET['tableName']])) {
        $tableName = ucfirst($_GET['tableName']);
        
        try {
            $pdo = new PDO($connect);
            $tableRows = $pdo->query("SELECT * FROM " . ucfirst(strtolower($tableName)));
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }

        $tableLines = [];
        $tableHead = $tablesStruct[$tableName];
        # Pour chaque ligne de la table
        foreach($tableRows as $tableRow) {
            $line = "<tr>";
            # Pour chaque colonne de la ligne
            $skip = false;
            $isCell1 = true;
            foreach($tableRow as $cell) {
                if ($skip) {
                    $skip = !$skip;
                    continue;
                }
                $skip = !$skip;
                if ($isCell1) {
                    $cellID = $cell;
                    $isCell1 = false;
                }
                
                $line = $line . "<td>" . $cell . "</td>";
            }
            $line = $line . "<td class='td-button'><img src='./assets/images/pencil.png' class='image-update' onclick='updateBox(\"" . $tableName . "\", \"" . $cellID . "\");' /><form action='./php/delete.php' method='post'><input type='hidden' name='deleteID' value='" . $cellID . "'><input type='hidden' name='table' value='" . $tableName . "'><button class='button-sup' type='submit'><img src='./assets/images/delete.png' class='image-delete'></button></form></td>";
            $line = $line . "</tr>";
            array_push($tableLines, $line);
        }
    
        # Génération du HTML
        echo '<section id="table-' . strtolower($tableName) . '" class="section-table">';
        echo '<div class="form-box">';
        echo '<form action="./php/insert.php?insertTable=' . ucfirst(strtolower($tableName)) . '" method="post" class="form-insert" id="form-insert-' . strtolower($tableName) .'">';
        $inputRow = $tableHead;
        array_shift($inputRow);
        foreach($inputRow as $tableRow) {
            $type = (strpos($tableRow, 'date') === 0) ? 'date' : 'text';
            $isID = (strpos($tableRow, 'ID')) ? true : false;
            if(!$isID) {
                echo "<input type='" . $type . "' placeholder='" . $tableRow . "' name='" . $tableRow . "' class='input-insert-text'>";
            } else {
                $tableNameB = rtrim($tableRow, "ID") . "s";
                $tableIDs = null;
                if($tableNameB === "feedbacks" || $tableNameB === "loans") continue;
                try {
                    $pdo = new PDO($connect);
                    $req = "SELECT ".$tableRow.", name FROM " . $tableNameB . ";";
                    $tableIDs = $pdo->query($req);
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e);
                }
                echo "<select class='select-insert-id' name='" . $tableRow . "' required>";
                echo "<option value='' disabled selected hidden>Select " . $tableRow . "</option>";
                foreach($tableIDs as $tableID) {
                    echo "<option value='" . $tableID[$tableRow] . "'>" . $tableID[$tableRow] . " - " . $tableID["name"] . "</option>";
                }
                echo "</select>";
            }
        }
        echo '<input type="submit" value="INSERT" name="insert" class="button">';
        echo '</form>';
        echo '<form method="post" action="./php/delete.php" id="form-clear-table-' . strtolower($tableName) . '" class="form-clear-table">';
        echo '<input type="hidden" value="' . strtolower($tableName) . '" name="table">';
        echo '<input type="hidden" value="' . strtolower($tableName) . '" name="clear">';
        echo '<input type="submit" value="CLEAR" class="button">';
        echo '</form>';
        echo '</div>';
        echo "<table class='table-bdd' id=\"table-" . strtolower($tableName) . "\"><thead><tr>";
        foreach($tablesStruct[$tableName] as $key) {
            echo "<th>" . $key . "</th>";
        }
        echo "<th class='th-button'></th></tr></thead><tbody>";
        foreach ($tableLines as $tableLinebis) {
            echo $tableLinebis;
        }
        echo "</tbody></table></section>";
    }
?>