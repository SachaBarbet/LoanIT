const tablesName = ["table-resources", "table-lenders", "table-loans", "table-feedbacks"];

async function getTable(tableID = null) {
    if (tableID === null) return;

    if (document.getElementById("table-"+tableID.toLowerCase()) === null) {
        const fetchTable = await fetch(`../generate/generateTable.php?tableName=${tableID}`);
        const tableText = await fetchTable.text();
    
        const contentBox = document.getElementById("box-content").innerHTML;
        document.getElementById("box-content").innerHTML = contentBox + tableText;
    }
}

async function switchTable(tableID = null) {
    if (tableID === null) return;

    if (document.getElementById("table-" + tableID.toLowerCase()) === null) {
        document.getElementById('box-loading').classList.add('show');
        await getTable(tableID);
    }
    
    setInteractionBar(tableID);
    setUpdate(tableID);

    const sectionList = document.getElementsByClassName("section-table");
    for(let i = 0; i < sectionList.length; i++) {
        sectionList[i].classList.remove('show');
    }

    if (document.getElementById('form-insert') != null) document.getElementById("form-insert").remove();
    document.getElementById("p-select").classList.remove('show');
    document.getElementById("section-"+tableID.toLowerCase()).classList.add('show');
    setTimeout(() => {
        document.getElementById('box-loading').classList.remove('show');
    }, 200);
    
    // on doit changer l'url quand on change de table, pour que le reload de la table soit plus simple
    let url = window.location.href.split('/');
    window.history.pushState({}, '', `${url[0]}/tables.php?table=${tableID}`);
}

function clearTable(tableID) {
    if (document.getElementById("section-"+tableID.toLowerCase()) != null) document.getElementById("section-"+tableID.toLowerCase()).remove();
    switchTable(tableID);
}