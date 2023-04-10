// ------- FONCTIONS
function interactionBar(tableName) {
    // On affiche la bar si ce n'est pas déjà fait
    if(document.getElementById('box-interaction-bar').style.display != 'flex') document.getElementById('box-interaction-bar').style.display = 'flex';

    // Mise à jour des noms de tables dans la bar d'interaction quand on change de table
    document.getElementById('input-clear-table').setAttribute('value', tableName);
    document.getElementById('input-clear-clear').setAttribute('value', tableName);
    document.getElementById('link-insert').setAttribute('data', tableName);
    document.getElementById('link-refresh').setAttribute('data', tableName);
}


// ----- REFRESH
function clickRefresh() {
    const tableNameClick = document.getElementById('link-refresh').getAttribute('data');
    clearTable(tableNameClick);
}


// ----- INSERT
function clickInsert() {
    // On récupère le nom de la table dans laquelle on souhaite insérer une nouvelle valeur
    const tableNameClick = document.getElementById('link-insert').getAttribute('data');
    
    if (document.getElementById('form-insert') != null) return;
 
    // Création du form
    const insertForm = document.createElement('form');
    insertForm.setAttribute('method', 'post');
    insertForm.setAttribute('action', './php/insert.php');
    insertForm.setAttribute('id', 'form-insert');
    // Création de la ligne insert

    // Requete php pour generer la ligne insert
    fetch("http://localhost/generate/generateInsert.php?table="+tableNameClick).then((insertRowValue) => {
        insertRowValue.text().then((value) => {
            insertForm.innerHTML = value;
        });
    });    

    // On rajoute la ligne dans le tBody
    const table = document.getElementById(`section-${tableNameClick.toLowerCase()}`);
    table.appendChild(insertForm);
}

// -- CLOSE INSERT
function closeInsert() {
    if (document.getElementById('form-insert') != null) document.getElementById('form-insert').remove();
}

// -- VALID INSERT
function validInsert() {
    document.forms['form-insert'].submit();
}

// ----- CLEAR
function clickClear() {
    document.forms['form-clear-table'].submit();
}