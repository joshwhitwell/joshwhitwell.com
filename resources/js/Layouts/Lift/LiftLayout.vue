<script setup></script>

<template>
  <div class="page">
    <nav v-if="$slots.navigation">
      <slot name="navigation" />
    </nav>

    <main>
      <slot />
    </main>
  </div>
</template>

<style scoped>
.page {
  padding: 0 var(--size-base);
}

.page * {
  max-width: 65ch;
}

:deep(.back-link) {
  align-items: center;
  display: flex;
  color: var(--color-lime-500);
  font-size: var(--size-base);
  margin-block-start: var(--size-base);
  text-decoration: none;
}

:deep(.page-title) {
  font-size: var(--size-5xl);
  margin-block: var(--size-5xl);
}

:deep(.lift-background-gradient) {
  background: linear-gradient(
    to top left,
    var(--color-lime-400) 0%,
    var(--color-neutral-50) 100%
  );
}

:deep(.input) {
  font-family: var(--font-family-mono);
}

:deep(.status-pill) {
  border: 2px solid var(--color-neutral-950);
  border-radius: var(--size-base);
  font-size: var(--size-xs);
  font-weight: 600;
  flex-shrink: 0;
  text-transform: uppercase;
  letter-spacing: -0.25px;
  padding: var(--size-4xs) var(--size-2xs);
}

:deep(.status-pill--in_progress) {
  border-color: var(--color-yellow-500);
  color: var(--color-yellow-500);
}

:deep(.status-pill--completed) {
  border-color: var(--color-lime-500);
  color: var(--color-lime-500);
}

:deep(.status-pill--skipped) {
  border-color: var(--color-blue-400);
  color: var(--color-blue-400);
}
</style>
