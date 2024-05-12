const Menu = document.querySelector('.box-menu');
const MenuList = document.querySelector('.menu-list');
const none = MenuList.querySelector('.none')
const Drop = Menu.querySelector('i');
console.log(none);
Drop.onclick = function() {
    none.classList.toggle('none');
}