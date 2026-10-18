<script>
    (function () {
        document.documentElement.classList.add('dark');
        localStorage.removeItem('theme');
        var accent = localStorage.getItem('accent') || document.documentElement.dataset.accent || '#2f7cff';
        if (accent) {
            document.documentElement.style.setProperty('--accent', accent);
        }
    })();
</script>
