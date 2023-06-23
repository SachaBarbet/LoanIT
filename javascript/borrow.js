function popupBorrow() {
    const boxPopup = document.getElementById('box-popup');

    setTimeout(() => {
        boxPopup.classList.add('show');
        setTimeout(() => {
            boxPopup.classList.remove('show');
        }, 3000);
    }, 1000);
}