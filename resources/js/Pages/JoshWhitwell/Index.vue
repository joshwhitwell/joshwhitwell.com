<script setup>
import InspiringQuote from "./Partials/InspiringQuote.vue";

defineProps({
  quote: String,
  attribution: String,
});
</script>

<template>
  <InspiringQuote :quote="quote" :attribution="attribution" />
</template>
