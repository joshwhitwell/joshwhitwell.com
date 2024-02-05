<script setup>
import { onMounted, ref } from "vue";
import Notes from "./Partials/Notes.vue";
defineProps({
  notes: {
    type: Array,
    default: () => [],
  },
});
const now = ref(new Date());
onMounted(() => {
  setInterval(() => {
    now.value = new Date();
  }, 60000);
});
</script>

<template>
  <header>
    <h2>
      {{
        now.toLocaleString("en-US", {
          weekday: "long",
        })
      }}
    </h2>
    <h1>
      {{
        now.toLocaleString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
        })
      }}
    </h1>
    <h2>
      {{
        now.toLocaleTimeString("en-US", {
          hour: "numeric",
          minute: "numeric",
        })
      }}
    </h2>
  </header>
  <Notes :notes="notes" />
</template>

<style scoped>
header {
  margin-bottom: calc(var(--spacing) * 3);
}
h1,
h2 {
  margin: 0;
}
h2 {
  color: var(--neutral-400);
}
h1 + h2 {
  color: var(--neutral-300);
}
</style>
