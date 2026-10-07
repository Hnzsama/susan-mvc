import { defineConfig } from 'vite';
import { resolve } from 'path';

// Plugin untuk menampilkan URL Web PHP & Full Reload saat file view .php diedit
function inainuPlugin() {
  return {
    name: 'inainu-plugin',
    configureServer(server) {
      server.httpServer?.once('listening', () => {
        setTimeout(() => {
          server.config.logger.info(`  \x1b[32m➜\x1b[0m  \x1b[1m\x1b[32mAPP_URL:\x1b[0m \x1b[36mhttp://127.0.0.1:8000/\x1b[0m \x1b[90m(Buka URL aplikasi ini di browser)\x1b[0m`);
        }, 100);
      });
    },
    handleHotUpdate({ file, server }) {
      if (file.endsWith('.php')) {
        server.ws.send({ type: 'full-reload' });
      }
    },
  };
}

export default defineConfig({
  plugins: [inainuPlugin()],
  build: {
    outDir: 'public/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        'resources/css/app.css': resolve(__dirname, 'resources/css/app.css'),
        'resources/js/app.js': resolve(__dirname, 'resources/js/app.js'),
      },
      output: {
        entryFileNames: 'assets/[name]-[hash].js',
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash].[ext]',
      },
    },
  },
  server: {
    host: '127.0.0.1',
    port: 5173,
    origin: 'http://127.0.0.1:5173',
    strictPort: true,
    cors: true,
  },
});
