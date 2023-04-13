var formIsOverred = false;

document.getElementById('link-login').addEventListener('click', () => {
    clickOnLinkLogin();
});

function clickOnLinkLogin(isFailed = false) {
    let boxLogin = document.getElementById('box-login');
    if (boxLogin === null) boxLogin = createBoxLogin(isFailed);
    document.querySelector('header').classList.add('blur');
    document.querySelector('main').classList.add('blur');
    boxLogin.classList.add('show');
}

function createBoxLogin(isFailed) {
    // create elements
    let elementBody = document.getElementsByTagName('body')[0];
    let boxLogin = document.createElement('div');
    let formLogin = document.createElement('form');
    let titleLogin = document.createElement('h2');
    let inputId = document.createElement('input');
    let inputPassword = document.createElement('input');
    let inputConnect = document.createElement('input');
    let buttonCloseLogin = document.createElement('p');

    // configure elements
    boxLogin.setAttribute('id', 'box-login');
    boxLogin.setAttribute('class', '');

    formLogin.setAttribute('id', 'form-login');
    formLogin.setAttribute('method', 'post');
    formLogin.setAttribute('action', './php/login.php');

    titleLogin.innerHTML = 'Connection';

    inputId.setAttribute('type', 'text');
    inputId.setAttribute('name', 'id');
    inputId.setAttribute('placeholder', 'Login id');

    inputPassword.setAttribute('type', 'password')
    inputPassword.setAttribute('name', 'password');
    inputPassword.setAttribute('placeholder', 'Password');

    inputConnect.setAttribute('type', 'submit');
    inputConnect.setAttribute('value', 'LOGIN');

    buttonCloseLogin.setAttribute('id' , 'button-close');
    buttonCloseLogin.innerHTML = 'return to the home page'
    buttonCloseLogin.addEventListener('click', () => {
        hideBoxLogin();
    });

    // append elements
    formLogin.appendChild(titleLogin);
    formLogin.appendChild(inputId);
    formLogin.appendChild(inputPassword);
    if (isFailed) {
        let pFailed = document.createElement('p');
        pFailed.setAttribute('id', 'login-failed');
        pFailed.innerHTML = 'Login and password doesn\'t match ! Retry !';
        formLogin.appendChild(pFailed);
    }
    formLogin.appendChild(inputConnect);
    formLogin.appendChild(buttonCloseLogin);
    boxLogin.appendChild(formLogin);
    elementBody.appendChild(boxLogin);

    //event on click + echap key boxlogin -> close login window
    formLogin.addEventListener('mouseenter', () => { formIsOverred = true; });
    formLogin.addEventListener('mouseleave', () => { formIsOverred = false; });
    boxLogin.addEventListener('click', () => { if (!formIsOverred) { hideBoxLogin(); } });
    window.addEventListener('keydown', (event) => { if (event.key == 'Escape') { hideBoxLogin(); } });

    return boxLogin;
}

function hideBoxLogin() {
    document.getElementById('box-login').classList.remove('show');
    document.querySelector('header').classList.remove('blur');
    document.querySelector('main').classList.remove('blur');
}