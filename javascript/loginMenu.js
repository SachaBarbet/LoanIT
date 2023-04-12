document.getElementById('list-menu').style.display = 'none';

document.getElementById('img-user').addEventListener('click', () => {
    const listMenu = document.getElementById('list-menu');
    //const body = document.getElementById('body');
    
    if (listMenu.style.display != 'flex'){
        listMenu.style.display = 'flex';
        //body.classList.add('blur');
    } else {
        listMenu.style.display = 'none';
        //body.classList.remove('blur');
    }
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