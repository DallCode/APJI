document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    sidebarToggle.addEventListener('click', function () {
        if (sidebar.classList.contains('show')) {
            sidebar.classList.remove('show'); // Tutup sidebar
        } else {
            sidebar.classList.add('show'); // Buka sidebar
        }
    });
});
