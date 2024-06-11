document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
});

document.getElementById('sidebarClose').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('open');
});
