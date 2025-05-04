<li class="nav-item" x-data="setTheme">
    <button class="nav-link" href="#" @click="toggleTheme">
        <i :class="icon"></i>
    </button>
</li>

<script>
    function setTheme() {
        return {
            theme: localStorage.getItem('theme') ?? 'light',
            icon: localStorage.getItem('theme') === 'dark' ? 'bi bi-moon-fill' : 'bi bi-brightness-high-fill',

            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.theme);
                document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') ?? 'light');
                this.setThemeIcon();
            },

            setThemeIcon() {
                if (localStorage.getItem('theme') === 'dark') {
                    this.icon = 'bi bi-moon-fill';
                } else {
                    this.icon = 'bi bi-brightness-high-fill';
                }
            }

        }
    }


</script>
