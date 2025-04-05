function toggleMenu() {
    const menu = document.getElementById('menu-down');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.getElementById('admin-logo').addEventListener('click', function () {
    const menuDown = document.getElementById('menu-down');
    menuDown.classList.toggle('active'); 
});