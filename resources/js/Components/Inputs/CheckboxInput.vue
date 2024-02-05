<script setup>
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
      <label class="input-label h6" v-if="label" :for="name">{{ label }}</label>
      <p v-if="help" class="input-help">{{ help }}</p>
      <small class="input-error" v-show="error">{{ error }}</small>
    </div>
  </div>
</template>

<style scoped>
.input-container {
  align-items: center;
  display: flex;
  flex-direction: row;
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
.checked:after {
  background-color: var(--neutral-500);
  content: "";
  height: 0.75rem;
  position: absolute;
  width: 0.75rem;
}
input {
  height: 100%;
  margin: 0;
  opacity: 0;
  width: 100%;
}
</style>
