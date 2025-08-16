document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const sidemenu = document.getElementById('sidemenu');
    const mainContent = document.querySelector('main');

    hamburger.addEventListener('click', () => {
        // Toggle the side menu classes
        if (sidemenu.classList.contains('lg:col-span-2')) {
            sidemenu.classList.remove('col-span-12', 'sm:col-span-3', 'lg:col-span-2');
            sidemenu.classList.add('col-span-0', 'sm:col-span-1');
            mainContent.classList.remove('col-span-12','sm:col-span-9' ,'lg:col-span-10');
            mainContent.classList.add('col-span-12', 'sm:col-span-11');
        } else {
            sidemenu.classList.remove('col-span-0','sm:col-span-1');
            sidemenu.classList.add('col-span-12', 'sm:col-span-3', 'lg:col-span-2');
            mainContent.classList.remove('col-span-12', 'sm:col-span-11');
            mainContent.classList.add('col-span-12','sm:col-span-9' ,'lg:col-span-10');
        }

        // Toggle visibility of menu items
        sidemenu.querySelectorAll('#sidemenu-header, #sidemenu-list').forEach(item => {
            item.classList.toggle('hidden');
        });
    });
});
