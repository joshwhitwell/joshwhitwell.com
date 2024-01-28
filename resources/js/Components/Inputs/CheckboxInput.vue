<script setup>
import { defineProps, defineModel } from "vue";
defineProps({
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: null,
  },
  help: {
    type: String,
    default: null,
  },
  required: {
    type: Boolean,
    default: false,
  },
  autofocus: {
    type: Boolean,
    default: false,
  },
  error: {
    type: String,
    default: null,
  },
});
const checked = defineModel();
</script>

<template>
  <div class="input-container">
    <div :class="['input-mask', { checked }]">
      <input
        :id="name"
        :name="name"
        type="checkbox"
        :required="required"
        :autofocus="autofocus"
        class="input"
        v-model="checked"
      />
    </div>
    <div>
      <label class="input-label" v-if="label" :for="name">{{ label }}</label>
      <p v-if="help" class="input-help">{{ help }}</p>
      <small class="input-error" v-show="error">{{ error }}</small>
    </div>
  </div>
</template>

<style scoped>
.input-container {
  display: flex;
  flex-direction: row;
  align-items: center;
}
.input-mask {
  align-items: center;
  border: 2px solid var(--neutral-200);
  display: flex;
  flex-direction: row;
  flex-shrink: 0;
  height: 1.5rem;
  justify-content: center;
  margin-right: 1rem;
  width: 1.5rem;
}
.checked {
  background-color: var(--red-600);
}
input {
  height: 100%;
  margin: 0;
  opacity: 0;
  width: 100%;
}
</style>
