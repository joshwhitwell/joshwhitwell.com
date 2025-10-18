// generate-icons.js
import fs from 'fs/promises';
import path from 'path';
import sharp from 'sharp';
import toIco from 'to-ico';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const SIZES = [192, 512];
const SOURCE_SVG = path.join(__dirname, 'public', 'favicon.svg');

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
                    background: { r: 0, g: 0, b: 0, alpha: 0 }, // Transparent background
                })
                .png()
                .toFile(
                    path.join(__dirname, 'public', `icon-maskable-${size}.png`),
                );

            console.log(`Generated icon-maskable-${size}.png`);
        }

        // Generate apple-touch-icon.png (180x180 is standard size)
        await sharp(SOURCE_SVG)
            .resize(180, 180)
            .png()
            .toFile(path.join(__dirname, 'public', 'apple-touch-icon.png'));

        console.log('Generated apple-touch-icon.png');

        // Generate favicon.ico (multiple sizes: 16x16, 32x32, 48x48)
        const faviconSizes = [16, 32, 48];
        const faviconBuffers = await Promise.all(
            faviconSizes.map((size) =>
                sharp(SOURCE_SVG).resize(size, size).png().toBuffer(),
            ),
        );

        // Convert PNG buffers to ICO
        const icoBuffer = await toIco(faviconBuffers);

        // Write the ICO file
        await fs.writeFile(
            path.join(__dirname, 'public', 'favicon.ico'),
            icoBuffer,
        );

        console.log('Generated favicon.ico');

        console.log('All icons generated successfully!');
    } catch (error) {
        console.error('Error generating icons:', error);
        process.exit(1);
    }
}

generateIcons();
