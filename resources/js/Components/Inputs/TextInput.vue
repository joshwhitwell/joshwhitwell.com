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
  type: {
    type: String,
    default: "text",
  },
  required: {
    type: Boolean,
    default: false,
  },
  autofocus: {
    type: Boolean,
    default: false,
  },
  autocomplete: {
    type: String,
    default: null,
  },
  error: {
    type: String,
    default: null,
  },
});
const model = defineModel();
</script>

<template>
  <div class="input-container">
    <label class="input-label h6" v-if="label" :for="name">{{ label }}</label>
    <p class="input-help" v-if="help">{{ help }}</p>
    <input
      :id="name"
      :name="name"
      :type="type"
      :required="required"
      :autofocus="autofocus"
      :autocomplete="autocomplete"
      class="input"
      v-model="model"
    />
    <small class="input-error" v-show="error">{{ error }}</small>
  </div>
</template>
