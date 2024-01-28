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
  height: 140px;
  padding: 28px;
  width: 140px;
}

.quote {
  background-color: var(--neutral-100);
  display: flex;
  flex-direction: column;
  font-weight: 500;
  margin: 0;
  width: 100%;
}

svg {
  width: 28px;
  height: 28px;
  margin-left: -28px;
}

path {
  color: var(--red-700);
}

.quote > p {
  color: var(--red-700);
  margin: 0;
}

footer {
  align-items: center;
  display: flex;
}
</style>
