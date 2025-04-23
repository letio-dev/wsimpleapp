import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import glob from "fast-glob";
import fs from 'fs';

const cssFiles = glob.sync("resources/css/**/*.css");
const jsFiles = glob.sync("resources/js/**/*.js");
const venodrFiles = glob.sync([
    "resources/vendor/**/*.css",
    "resources/vendor/**/*.js",
]);
// const venodrCSSFiles = glob.sync("resources/vendor/**/*.css");
// const venodrJSFiles = glob.sync("resources/vendor/**/*.js");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                ...jsFiles,
                ...venodrFiles,
                // ...venodrCSSFiles,
                // ...venodrJSFiles,
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            "@vendor": "/resources/vendor",
        },
    },
    // server: {
    //     // host: "0.0.0.0",
    //     port: 5175, // atau port lain jika 5173 bentrok
    //     // strictPort: true,
    //     host: true,
    //     origin: 'https://f1d3-103-119-141-109.ngrok-free.app',
    //     hmr: {
    //         protocol: 'wss', // gunakan WebSocket secure
    //         host: "f1d3-103-119-141-109.ngrok-free.app", // IP lokal kamu
    //     },
    //     allowedHosts: 'all',
    //     // https: {
    //     //     key: fs.readFileSync("./2e7e-103-119-141-109.ngrok-free.app-key.pem"),
    //     //     cert: fs.readFileSync("./2e7e-103-119-141-109.ngrok-free.app.pem"),
    //     // },
    // },
});
