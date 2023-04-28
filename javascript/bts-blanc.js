// Se lance à chaque changement de table. Met à jour le contenu de la section update
// Affiche la section update ET mais l'id de la ligne à modifier dans l'input correspondant
function showUpdate() {
    document.getElementById("section-update").classList.add('show');
}

function hideUpdate() {
    document.getElementById("section-update").classList.remove('show');
}

// Affiche la section update ET mais l'id de la ligne à modifier dans l'input correspondant
function showReceive() {
    document.getElementById("section-receive").classList.add('show');
}

function hideReceive() {
    document.getElementById("section-receive").classList.remove('show');
}