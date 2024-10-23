import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/joshwhitwell.css",
                "resources/css/lift.css",
                "resources/js/app.js",
                "resources/js/lift.js",
            ],
            refresh: true,
        }),
    ],
});
