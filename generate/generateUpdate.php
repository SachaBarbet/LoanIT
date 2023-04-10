<?php
    require '../init.php';
    if (!$_SESSION['isAdmin']) header('location: ./index.php');
    
    # Pour chaque table
    if(isset($_GET["tableName"]) && isset($tablesStructNoID[$_GET["tableName"]])){
        $tableName = $_GET["tableName"];
        $tableNameLow = strtolower($tableName);
        echo '<form action="./php/update.php" method="post" class="form-update" id="form-update-' . $tableNameLow . '" onMouseOver="updateFormOverred();" onMouseOut="updateFormNotOverred();">';
        # Pour chaque colonne
        foreach ($tablesStructNoID[$tableName] as $tableRow) {
            $type = (strpos($tableRow, 'date') === 0) ? 'date' : 'text';
            $isID = (strpos($tableRow, 'ID')) ? true : false;
            if(!$isID) {
                echo "<input type='" . $type . "' placeholder='" . $tableRow . "' name='" . $tableRow . "' class='input-form-update'>";
            } else {
                $tableIDs = null;
                try {
                    $pdo = new PDO($connect);
                    $req = "SELECT " . $tableRow . " FROM " . $tableName . ";";
                    $tableIDs = $pdo->query($req);
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e);
                }
                echo "<select required class='select-form-update' name='" . $tableRow . "'>";
                echo "<option selected hidden disabled>Select " . $tableRow . "</option>";
                foreach($tableIDs as $tableID) {
                    echo "<option value='" . $tableID[$tableRow] . "'>" . $tableID[$tableRow] . "</option>";
                }
                echo "</select>";
            }
        }
        echo '<input type="hidden" name="table" value="' . $tableName . '" ><input type="hidden" name="rowID" value="" class="input-update-row">';
        echo '<input type="submit" value="UPDATE" class="button-form-update"></form>';
    }
?>