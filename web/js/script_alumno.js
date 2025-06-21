document.addEventListener("DOMContentLoaded", function () {

    const menuIcon = document.querySelector('.navbar .material-symbols-outlined');
    const navbar = document.querySelector('.navbar');
    
    if (menuIcon) {
        menuIcon.addEventListener('click', function() {
            navbar.classList.toggle('collapsed');
        });
    }
});
