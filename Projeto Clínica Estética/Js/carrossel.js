var radio = document.querySelector('.btn_manu');
var cont = 1;

document.getElementById('radio1').checked = true;

setInterval(() => {
    proxImg()
}, 5000);

function proxImg() {
    cont++

    if (cont > 3) {
        cont = 1
    }
    document.getElementById('radio' + cont).checked = true;
}