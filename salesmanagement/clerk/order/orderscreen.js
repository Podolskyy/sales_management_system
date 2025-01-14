function toggleDrawer() {
    const drawer = document.getElementById('drawer');
    const mainContent = document.getElementById('main-content');
    drawer.classList.toggle('open');
    mainContent.classList.toggle('drawer-open');
}