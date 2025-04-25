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

:deep(.completed-tag) {
  align-items: flex-start;
  border: 2px solid var(--color-lime-600);
  border-radius: var(--size-base);
  color: var(--color-lime-600);
  display: flex;
  font-size: var(--size-base);
  font-weight: 100;
  justify-content: center;
  padding: var(--size-9xs);
  text-decoration: none;
}
</style>
