let formIsOverred = false;

const formBoxs = document.querySelectorAll(".popup form");
for (let index = 0; index < formBoxs.length; index++) {
    const element = formBoxs[index];
    element.addEventListener('mouseenter', () => {
        formIsOverred = true;
    });
    element.addEventListener('mouseleave', () => {
        formIsOverred = false;
    });
}

function showPopup(popup) {
    document.querySelector("#"+popup).classList.add("show");
    document.querySelector('main').classList.add('blur');
    document.querySelector('nav').classList.add('blur');
}

function hidePopup(popup = null) {
    if (!formIsOverred) {
        document.querySelector('main').classList.remove('blur');
        document.querySelector('nav').classList.remove('blur');
        if (popup == null) {
            let activePopup = new Array.from(document.getElementsByClassName('show'))
            activePopup[0].classList.remove('show')
        } else {
            document.querySelector("#"+popup).classList.remove("show");
        }
    }


}

document.getElementById("button-add-user").addEventListener('click', event => {
    showPopup("box-add-user");
});

document.getElementById("button-remove-user").addEventListener('click', event => {
    showPopup("box-remove-user");
});

document.getElementById("box-add-user").addEventListener('click', event => {
    hidePopup("box-add-user");
});

document.getElementById("box-remove-user").addEventListener('click', event => {
    hidePopup("box-remove-user");
});

window.addEventListener('keydown', (event) => {
    if (event.key == 'Escape') {
        hidePopup();
    }
});