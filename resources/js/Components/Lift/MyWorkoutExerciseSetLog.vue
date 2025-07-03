<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  setLog: Object,
  totalWarmUps: Number,
  isPreviewing: Boolean,
});

const setLogForm = useForm(props.setLog);

const warmUpPyramid = {
  1: ['60%'],
  2: ['50%', '70%'],
  3: ['45%', '65%', '85%'],
  4: ['40%', '50%', '60%', '70%'],
};

const getWarmUpPercentage = (setLog) => {
  const warmUpNumber = (setLog?.order || 0) - 1;
  return warmUpPyramid?.[props.totalWarmUps]?.[warmUpNumber] || '';
};
</script>

<template>
  <div class="set-log">
    <h3 class="set-name">
      {{ setLog.isWarmUp ? 'Warm Up' : 'Set' }}
      {{ setLog.order }}

      <small v-if="setLog.isOptional">(Optional)</small>
    </h3>

    <p v-if="!setLog.isWarmUp && setLog.repsRpeIntensity" class="rep-string">
      {{ setLog.repsRpeIntensity }}
    </p>
    <p v-else-if="setLog.isWarmUp" class="rep-string">
      {{ getWarmUpPercentage(setLog) }}
    </p>

    <div v-if="!isPreviewing" class="input-row">
      <label
        :for="'reps_' + setLog.id"
        :class="['label', { 'label--has-error': setLogForm.errors?.reps }]"
      >
        <span class="label-text">Reps</span>
        <input
          :id="'reps_' + setLog.id"
          name="reps"
          type="number"
          v-model="setLogForm.reps"
          @input="setLogForm.clearErrors('reps')"
          class="input"
        />
      </label>

      <label
        :for="'weight_' + setLog.id"
        :class="['label', { 'label--has-error': setLogForm.errors?.weight }]"
      >
        <span class="label-text">Weight</span>
        <input
          :id="'weight_' + setLog.id"
          name="weight"
          type="number"
          v-model="setLogForm.weight"
          @input="setLogForm.clearErrors('weight')"
          class="input"
        />
      </label>

      <div
        class="button-group"
        v-if="setLogForm.isDirty && !setLogForm.processing"
      >
        <button
          type="button"
          class="button button--outline"
          @click="
            setLogForm
              .transform((data) => ({
                ...data,
                _method: 'put',
              }))
              .post(route('lift.set-logs.update', setLog.id), {
                only: [],
                preserveScroll: true,
              })
          "
        >
          <span class="material-symbols-outlined"> check </span>
        </button>

        <button
          type="button"
          class="button button--outline"
          @click="setLogForm?.reset()"
        >
          <span class="material-symbols-outlined"> close </span>
        </button>
      </div>
    </div>

    <ul v-if="setLogForm.errors" class="errors">
      <li
        v-for="(error, index) in setLogForm.errors"
        :key="`error-${setLog.id}-${index}`"
      >
        {{ error }}
      </li>
    </ul>
  </div>
</template>

<style scoped>
.set-log {
  margin-block-end: var(--size-base);
}

.set-log:last-of-type {
  margin-block-end: 0;
}

.set-name {
  align-items: center;
  display: flex;
  font-size: var(--size-sm);
  margin-block-end: var(--size-6xs);
}

.set-name small {
  font-size: var(--size-xs);
  font-weight: 400;
  margin-inline-start: var(--size-6xs);
}

.rep-string {
  font-size: var(--size-xs);
  margin-block-end: var(--size-3xs);
}

.input-row {
  display: flex;
  align-items: flex-end;
}

label:first-of-type {
  margin-inline-end: var(--size-8xs);
}

.button-group {
  display: flex;
  margin-left: var(--size-4xs);
  column-gap: var(--size-8xs);
}

.button-group .button {
  height: var(--size-4xl);
  width: var(--size-4xl);
}

.button .material-symbols-outlined {
  font-size: var(--size-xl);
}

.errors {
  color: var(--color-red-600);
  font-size: var(--size-sm);
  list-style: none;
  margin: var(--size-5xs) 0 0;
  padding: 0;
}
</style>
