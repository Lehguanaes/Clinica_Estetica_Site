
function toggleContent() {
    const moreContent = document.querySelector('.ler-mais');
    const toggleText = document.querySelector('.alterar');
    if (moreContent.style.display === 'none') {
        moreContent.style.display = 'inline';
        toggleText.textContent = 'Ler menos';
    } else {
        moreContent.style.display = 'none';
        toggleText.textContent = 'Ler mais';
    }
}