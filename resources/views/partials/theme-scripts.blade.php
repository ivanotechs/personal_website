<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('ui', {
            menu: false,
            accent: localStorage.getItem('accent') || '#2f7cff',
            accents: ['#2f7cff', '#7c5cff', '#14b8c4', '#1f9d6a'],
            setAccent(color) {
                this.accent = color;
                document.documentElement.style.setProperty('--accent', color);
                localStorage.setItem('accent', color);
            },
        });
    });
</script>
@livewireScripts
