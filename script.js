const menuIcon = document.getElementById('menu-icon');
const navList = document.querySelector('.navlist');

menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('active');
    navList.classList.toggle('active');
});


