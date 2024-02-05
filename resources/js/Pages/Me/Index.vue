<script setup>
import Notes from "./Partials/Notes.vue";
import { ref, onMounted } from "vue";
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
  <div class="me">
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
  </div>
</template>

<style scoped>
.me {
  margin: 0 auto;
  max-width: 85ch;
  padding: calc(var(--vertical-spacing) * 2) var(--vertical-spacing);
}
header {
  margin-bottom: calc(var(--vertical-spacing) * 3);
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
