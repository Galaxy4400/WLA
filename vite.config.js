import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/assets/admin/scss/style.scss'],
			refresh: true,
		}),
	],
});
