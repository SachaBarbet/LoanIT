<?php
    echo '<div class="form-box">'; // Form insert et clear
    echo "<form action=\"./php/insert.php?insertTable={$firstLetterTableName}\" method=\"post\" class=\"form-insert\" id=\"form-insert-{$lowerCaseTableName}\">";
    $inputRow = $tableHead;
    array_shift($inputRow);
    foreach($inputRow as $tableRow) {
        $type = (strpos($tableRow, 'date') === 0) ? 'date' : 'text';
        $isID = (strpos($tableRow, 'ID')) ? true : false;
        if(!$isID) {
            echo "<input type=\"{$type}\" placeholder=\"{$tableRow}\" name=\"{$tableRow}\" class=\"input-insert-text\">";
        } else {
            $tableNameB = rtrim($tableRow, "ID") . "s";
            $tableIDs = null;
            if($tableNameB === "feedbacks" || $tableNameB === "loans" || $tableNameB === "users") continue;
            try {
                $pdo = new PDO($connect);
                $req = "SELECT {$tableRow}, name FROM {$tableNameB};";
                $tableIDs = $pdo->query($req);
                $pdo = null;
            } catch (PDOException $e) {
                die($e);
            }
            echo "<select class='select-insert-id' name=\"{$tableRow}\" required>";
            echo "<option value='' disabled selected hidden>Select {$tableRow}</option>";
            foreach($tableIDs as $tableID) {
                echo "<option value=\"{$tableID[$tableRow]}\">{$tableID[$tableRow]} - {$tableID['name']}</option>";
            }
            echo "</select>";
        }
    }
    echo '<input type="submit" value="INSERT" name="insert" class="button">';
    echo '</form>';
    echo '</div>';
?>