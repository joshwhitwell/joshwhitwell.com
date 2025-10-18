<template>
    <div>
        <button
            v-if="canInstall"
            @click="installPwa"
            class="fixed right-4 bottom-4 flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-primary-foreground shadow-lg hover:opacity-90"
        >
            <span class="flex items-center">
                <Download class="mr-1 h-4 w-4" />
                Install App
            </span>
        </button>
    </div>
</template>

<script setup lang="ts">
import { Download } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

const canInstall = ref(false);
let deferredPrompt: any = null;

onMounted(() => {
    // Listen for the beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome from showing the default install prompt
        e.preventDefault();
        // Store the event for later use
        deferredPrompt = e;
        // Show our install button
        canInstall.value = true;
    });

    // Hide the button if the app is already installed
    window.addEventListener('appinstalled', () => {
        canInstall.value = false;
        deferredPrompt = null;
        console.log('PWA was installed');
    });

    // Check if app is already installed or running in standalone mode
    if (
        window.matchMedia('(display-mode: standalone)').matches ||
        window.navigator.standalone === true
    ) {
        canInstall.value = false;
    }
});

const installPwa = () => {
    if (!deferredPrompt) return;

    // Show the installation prompt
    deferredPrompt.prompt();

    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then((choiceResult: { outcome: string }) => {
        if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the install prompt');
            canInstall.value = false;
        } else {
            console.log('User dismissed the install prompt');
        }
        // Clear the saved prompt - it can only be used once
        deferredPrompt = null;
    });
};
</script>
