import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Povolení připojení z jiných zařízení
        port: 5173,      // Výchozí port Vite
        strictPort: true,
        cors: true,      // Povolení CORS
        hmr: {
            host: '192.168.1.131', // Nahraď IP adresou svého PC
            protocol: 'ws',
        },
    },
});
