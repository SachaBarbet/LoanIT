var isOverred = false;

function updateFormOverred() {
    isOverred = true;
}

function updateFormNotOverred() {
    isOverred = false;
}

function clearUpdateSection() {
    if (!isOverred) document.getElementById("section-update").style.display = "none";
}

function updateBox(table, rowID) {
    document.getElementById("section-update").style.display = "flex";

    const updateFormList = document.getElementsByClassName("form-update");
    for (let i = 0; i < updateFormList.length; i++) {
        updateFormList[i].style.display = "none";
    }

    document.getElementById("form-update-" + table.toLowerCase()).style.display = "flex";
    const rowInputList = document.getElementsByClassName("input-update-row");
    for (let i = 0; i < rowInputList.length; i++) {
        rowInputList[i].value = rowID;
    }
}