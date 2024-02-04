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
  height: 160px;
  padding: 32px;
  width: 160px;
}

.quote {
  background-color: var(--neutral-100);
  display: flex;
  flex-direction: column;
  margin: 0;
  width: 100%;
}

svg {
  width: 32px;
  height: 32px;
  margin-left: -32px;
}

path {
  color: var(--red-700);
}

.quote > p {
  color: var(--red-700);
  margin: 0;
  height: 32px;
  display: flex;
  align-items: center;
}

footer {
  align-items: center;
  color: var(--neutral-900);
  display: flex;
  height: 32px;
}
</style>
