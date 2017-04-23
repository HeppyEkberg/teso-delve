var menu = document.querySelector(".action-sidebar-open");

menu.addEventListener('click', toggleMenu);


function toggleMenu() {
    var sidebar = document.querySelector('.sidebar');
    var content = document.querySelector('.content');

    sidebar.classList.toggle('hidden-xs');
    content.classList.toggle('no-margin');

}

