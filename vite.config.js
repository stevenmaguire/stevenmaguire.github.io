import jigsaw from '@tighten/jigsaw-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        jigsaw({
            input: ['source/_assets/js/scripts.js', 'source/_assets/scss/style.scss'],
            refresh: true,
        }),
    ],
});
