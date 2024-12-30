// Toggle the drawer menu
function toggleDrawer() {
    const drawer = document.getElementById('drawer');
    const mainContent = document.getElementById('main-content');
    drawer.classList.toggle('open');
    mainContent.classList.toggle('drawer-open');
}

// Close the drawer when a link is clicked
document.querySelectorAll('.drawer nav a').forEach(link => {
    link.addEventListener('click', () => {
        const drawer = document.getElementById('drawer');
        const mainContent = document.getElementById('main-content');
        drawer.classList.remove('open');
        mainContent.classList.remove('drawer-open');
    });
});