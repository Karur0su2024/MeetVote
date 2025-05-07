<li class="nav-item" x-data="setTheme">
    <button class="nav-link" href="#" @click="toggleTheme">
        <i :class="icon" id="darkmode-toggle-icon"></i>
    </button>
</li>

<script>
    function setTheme() {
        return {
            theme: document.documentElement.getAttribute('data-bs-theme'),
            icon: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'bi bi-moon-fill' : 'bi bi-brightness-high-fill',

            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                document.cookie = `theme=${this.theme}`;
                document.documentElement.setAttribute('data-bs-theme', this.theme);
                this.setThemeIcon();
            },

            setThemeIcon() {
                if (this.theme === 'dark') {
                    this.icon = 'bi bi-moon-fill';
                } else {
                    this.icon = 'bi bi-brightness-high-fill';
                }
            }

        }
    }


</script>
