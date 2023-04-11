document.getElementById('list-menu').style.display = 'none';

document.getElementById('img-user').addEventListener('click', () => {
    let listMenu = document.getElementById('list-menu');
    if (listMenu.style.display != 'flex') listMenu.style.display = 'flex'; else listMenu.style.display = 'none';
});

function welcomeMsg() {
    const boxPopup = document.getElementById('box-popup-login');

    setTimeout(() => {
        boxPopup.classList.add('show');
        setTimeout(() => {
            boxPopup.classList.remove('show');
        }, 3000);
    }, 1000);
}