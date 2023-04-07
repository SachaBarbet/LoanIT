// ------- EVENTS
// ----- REFRESH
document.getElementById('link-refresh').addEventListener('click', (event) => {
    const tableNameClick = document.getElementById('link-refresh').getAttribute('data');
});

// ----- INSERT
document.getElementById('link-insert').addEventListener('click', (event) => {
    // On récupère le nom de la table dans laquelle on souhaite insérer une nouvelle valeur
    const tableNameClick = document.getElementById('link-insert').getAttribute('data');
    
    if (document.getElementById('tr-insert') != null) return;

    // Création du form
    const insertForm = document.createElement('form');
    insertForm.setAttribute('method', 'post');
    insertForm.setAttribute('action', './php/insert.php');

    // Requete php pour generer la ligne insert
    

    // Création de la ligne insert
    const insertRow = document.createElement('tr');
    insertRow.setAttribute('id', 'tr-insert');

    // On rajoute la ligne dans le tBody
    const tBody = document.getElementById(`table-${tableNameClick.toLowerCase()}`).lastChild;
    tBody.appendChild(insertRow);
});


// ----- CLEAR
document.getElementById('link-clear').addEventListener('click', (event) => {
    // Le form est invisible donc on l'active avec la method submit()
    document.forms['form-clear-table'].submit();
    console.log('ok');
});



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