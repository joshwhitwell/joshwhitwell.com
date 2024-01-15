<script setup>
import QuoteLeft from "../../../Svg/QuoteLeft.vue";
import QuoteRight from "../../../Svg/QuoteRight.vue";

defineProps({
  quote: String,
  attribution: String,
});
</script>

<template>
  <section>
    <div class="neutral"></div>
    <blockquote class="quote">
      <QuoteLeft />
      <p>{{ quote }}</p>
      <QuoteRight />
      <footer>
        {{ attribution }}
      </footer>
    </blockquote>
  </section>
</template>

<style>
section {
  display: flex;
}

.neutral {
  background-color: var(--neutral-900);
  box-sizing: border-box;
  flex-shrink: 0;
  height: 150px;
  padding: 32px;
  width: 150px;
}

.quote {
  background-color: var(--neutral-100);
  display: flex;
  flex-direction: column;
  margin: 0;
  width: 100%;
}

.quote svg {
  color: var(--red-700);
  width: 32px;
  height: 32px;
  margin-left: -32px;
}

.quote > p {
  color: var(--red-700);
  font-weight: 600;
  margin: 0;
}

footer {
  align-items: center;
  display: flex;
}
</style>
