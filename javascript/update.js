// Affiche la section update ET mais l'id de la ligne à modifier dans l'input correspondant
function showUpdate(rowID) {
    document.getElementById("input-update-row").setAttribute('value', rowID);
    document.getElementById("title-update").innerHTML = `Edit row with ID : ${rowID}`;
    document.getElementById("section-update").classList.add('show');
}

function hideUpdate() {
    document.getElementById("section-update").classList.remove('show');
}

// Se lance à chaque changement de table. Met à jour le contenu de la section update
function setUpdate(tableID) {
    // On clear la section et on ajoute l'entete
    document.getElementById("section-update").innerHTML = `<div class="first"><button onclick="hideUpdate();"><span class="material-symbols-outlined">close</span></button></div><h3 id='title-update'></h3>`;
    //Form
    fetch(`../generate/generate_update.php?tableName=${tableID}`).then(fetchVal => {
        fetchVal.text().then(value => document.getElementById("section-update").innerHTML += value);
    });
    // le bouton edit est dans le code php
}

function validUpdate() {
    document.forms['form-update'].submit();
}