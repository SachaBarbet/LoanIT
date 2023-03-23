document.getElementById('list-menu').style.display = 'none';

document.getElementById('img-user').addEventListener('click', () => {
    let listMenu = document.getElementById('list-menu');
    if (listMenu.style.display != 'flex') listMenu.style.display = 'flex'; else listMenu.style.display = 'none';
});