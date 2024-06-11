document.getElementById('accept-terms').addEventListener('change', function() {
    const submitButton = document.getElementById('submit-button');
    submitButton.disabled = !this.checked;
});

document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
});

document.getElementById('sidebarClose').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('open');
});
