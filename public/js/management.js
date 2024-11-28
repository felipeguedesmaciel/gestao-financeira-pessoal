document.addEventListener('DOMContentLoaded', function () {
    function clickMenu() {
        const itens = document.getElementById('itens');
        if (itens.style.display === 'none' || itens.style.display === '') {
            itens.style.display = 'block';
        } else {
            itens.style.display = 'none';
        }
    }

    // Torne a função disponível globalmente para o evento onclick
    window.clickMenu = clickMenu;
});

