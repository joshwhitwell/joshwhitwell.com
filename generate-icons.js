// generate-icons.js
import path from 'path';
import sharp from 'sharp';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const SIZES = [192, 512];
const SOURCE_SVG = path.join(__dirname, 'public', 'icon-base.svg');

async function generateIcons() {
    try {
        console.log('Generating PWA icons...');

        // Generate regular icons
        for (const size of SIZES) {
            await sharp(SOURCE_SVG)
                .resize(size, size)
                .png()
                .toFile(path.join(__dirname, 'public', `icon-${size}.png`));

            console.log(`Generated icon-${size}.png`);
        }

        // Generate maskable icons with padding (for adaptive icons)
        for (const size of SIZES) {
            // For maskable icons, we add 10% padding around the image
            const padding = Math.floor(size * 0.1);
            const logoSize = size - padding * 2;

            await sharp(SOURCE_SVG)
                .resize(logoSize, logoSize)
                .extend({
                    top: padding,
                    bottom: padding,
                    left: padding,
                    right: padding,
                    background: { r: 255, g: 45, b: 32 }, // Laravel red
                })
                .png()
                .toFile(
                    path.join(__dirname, 'public', `icon-maskable-${size}.png`),
                );

            console.log(`Generated icon-maskable-${size}.png`);
        }

        console.log('All icons generated successfully!');
    } catch (error) {
        console.error('Error generating icons:', error);
        process.exit(1);
    }
}

generateIcons();
