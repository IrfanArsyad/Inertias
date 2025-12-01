import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import fs from 'fs';
import path from 'path';

// Function to scan modules directory for CSS and JS files
function getModuleEntries() {
    const modulesPath = resolve(__dirname, 'modules');
    const entries = {};

    if (!fs.existsSync(modulesPath)) {
        return entries;
    }

    const modules = fs.readdirSync(modulesPath);

    modules.forEach(module => {
        // Check for JS files in resources/assets/js/
        const jsPath = path.join(modulesPath, module, 'resources/assets/js');
        if (fs.existsSync(jsPath)) {
            const jsFiles = fs.readdirSync(jsPath).filter(file => file.endsWith('.js'));
            jsFiles.forEach(file => {
                const filePath = path.join(jsPath, file);
                const fileName = file.replace('.js', '');
                entries[`modules/${module}/js/${fileName}`] = filePath;
            });
        }

        // Check for CSS files in resources/assets/css/
        const cssPath = path.join(modulesPath, module, 'resources/assets/css');
        if (fs.existsSync(cssPath)) {
            const cssFiles = fs.readdirSync(cssPath).filter(file => file.endsWith('.css'));
            cssFiles.forEach(file => {
                const filePath = path.join(cssPath, file);
                const fileName = file.replace('.css', '');
                entries[`modules/${module}/css/${fileName}`] = filePath;
            });
        }
    });

    return entries;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...Object.values(getModuleEntries())
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
            interval: 100,
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
            '@modules': '/modules',
            'ziggy-js': '/vendor/tightenco/ziggy',
            'inertia-modal': path.resolve(__dirname, 'vendor/emargareten/inertia-modal'),
        },
    },
    build: {
        target: 'es2015',
        minify: 'terser',
        cssMinify: true,
        reportCompressedSize: false,
        chunkSizeWarningLimit: 1000,
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
                pure_funcs: ['console.log'],
            },
        },
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    // Vendor chunks
                    if (id.includes('node_modules')) {
                        if (id.includes('vue')) {
                            return 'vue-vendor';
                        }
                        if (id.includes('@inertiajs')) {
                            return 'inertia-vendor';
                        }
                        if (id.includes('axios')) {
                            return 'axios-vendor';
                        }
                        return 'vendor';
                    }
                    // Component chunks
                    if (id.includes('/Components/')) {
                        return 'components';
                    }
                    if (id.includes('/Layouts/')) {
                        return 'layouts';
                    }
                },
                // Optimize chunk names
                chunkFileNames: 'js/[name]-[hash].js',
                entryFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/\.(png|jpe?g|svg|gif|tiff|bmp|ico)$/i.test(assetInfo.name)) {
                        return `images/[name]-[hash][extname]`;
                    }
                    if (/\.(woff2?|eot|ttf|otf)$/i.test(assetInfo.name)) {
                        return `fonts/[name]-[hash][extname]`;
                    }
                    if (ext === 'css') {
                        return `css/[name]-[hash][extname]`;
                    }
                    return `assets/[name]-[hash][extname]`;
                },
            },
        },
    },
    optimizeDeps: {
        include: [
            'vue',
            '@inertiajs/vue3',
            'axios',
        ],
    },
});