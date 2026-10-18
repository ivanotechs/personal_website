<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('toast', {
            items: [],
            push(message, type = 'success') {
                const id = Date.now() + Math.random();
                this.items.push({ id, message, type });
                setTimeout(() => this.dismiss(id), 4200);
            },
            hold(message, type = 'info') {
                sessionStorage.setItem('pending-toast', JSON.stringify({ message, type }));
            },
            dismiss(id) {
                this.items = this.items.filter((item) => item.id !== id);
            },
        });

        const pending = sessionStorage.getItem('pending-toast');
        if (pending) {
            sessionStorage.removeItem('pending-toast');
            const data = JSON.parse(pending);
            setTimeout(() => Alpine.store('toast').push(data.message, data.type || 'info'), 40);
        }

        const flashed = document.getElementById('session-toast');
        if (flashed) {
            const data = JSON.parse(flashed.textContent);
            setTimeout(() => Alpine.store('toast').push(data.message, data.type || 'success'), 40);
        }

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
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('toast', (payload) => {
            const data = Array.isArray(payload) ? payload[0] : payload;
            Alpine.store('toast').push(data.message, data.type || 'success');
        });
    });
</script>
