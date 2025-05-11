<script setup>
import { ref } from 'vue';
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
  programLog: Object,
  workoutLog: Object,
});

const page = usePage();

const liftStatus = page.props.liftStatus;

function initSetLogForms() {
  return (
    props?.workoutLog?.workoutExerciseLogs?.reduce?.(
      (setLogForms, workoutExerciseLog) => {
        workoutExerciseLog?.setLogs?.forEach((setLog) => {
          setLogForms[setLog.id] = useForm(setLog);
        });
        return setLogForms;
      },
      {}
    ) || {}
  );
}

const setLogForms = ref(initSetLogForms());

function submitStatusForm(status) {
  router.post(
    route('lift.my.programs.workouts.update', [
      props.programLog.id,
      props.workoutLog.id,
    ]),
    {
      _method: 'put',
      status,
    },
    {
      preserveState: false,
    }
  );
}

const warmUpPyramid = {
  1: ['60%'],
  2: ['50%', '70%'],
  3: ['45%', '65%', '85%'],
};

const getWarmUpPercentage = (workoutExerciseLog, setLog) => {
  const totalWarmUps =
    workoutExerciseLog?.setLogs?.filter((setLog) => setLog?.isWarmUp)?.length ||
    0;
  const warmUpNumber = (setLog?.order || 0) - 1;

  return warmUpPyramid?.[totalWarmUps]?.[warmUpNumber] || '';
};
</script>

<template>
  <Layout>
    <template #navigation>
      <Link
        :href="route('lift.my.programs.show', programLog.id)"
        class="back-link"
      >
        <span class="material-symbols-outlined"> arrow_back_ios </span>
        Back to program
      </Link>
    </template>

    <header class="page-header">
      <h1 class="page-title">
        <span v-if="workoutLog.order" class="day-number"
          >Day {{ workoutLog.order }}</span
        >
        {{ workoutLog.name }}
      </h1>
      <form
        v-if="workoutLog.status === liftStatus.NotStarted"
        @submit.prevent="submitStatusForm(liftStatus.InProgress)"
        class="start-workout-form"
      >
        <button type="submit" class="button button--green">
          Start Workout
        </button>
      </form>
      <p
        v-else-if="workoutLog.status === liftStatus.InProgress"
        class="completed-at"
      >
        <em>Started on </em> {{ workoutLog.startedAt }}
      </p>
      <p
        v-else-if="workoutLog.status === liftStatus.Completed"
        class="completed-at"
      >
        <em>Completed on </em> {{ workoutLog.completedAt }}
      </p>
      <p
        v-else-if="workoutLog.status === liftStatus.Skipped"
        class="completed-at"
      >
        <em>Skipped on </em> {{ workoutLog.completedAt }}
      </p>
    </header>

    <div
      v-for="workoutExerciseLog in workoutLog.workoutExerciseLogs"
      :key="workoutExerciseLog.id"
      class="workout-exercise-log lift-background-gradient"
    >
      <div class="exercise-details">
        <h2 class="exercise-name">
          {{ workoutExerciseLog.name }}
        </h2>

        <p v-if="workoutExerciseLog.notes" class="exercise-notes">
          {{ workoutExerciseLog.notes }}
        </p>

        <a
          v-if="workoutExerciseLog.videoUrl"
          :href="workoutExerciseLog.videoUrl"
          class="video-url"
          target="_blank"
        >
          <span class="material-symbols-outlined"> play_arrow </span>
          Watch
        </a>

        <ul
          v-if="
            workoutExerciseLog?.substitutionOne ||
            workoutExerciseLog?.substitutionTwo
          "
          class="substitutions"
        >
          Substitutions:
          <li v-if="workoutExerciseLog.substitutionOne">
            <a
              v-if="workoutExerciseLog.substitutionOne.videoUrl"
              :href="workoutExerciseLog.substitutionOne.videoUrl"
              class="substitution-url"
              target="_blank"
            >
              {{ workoutExerciseLog.substitutionOne.name }}
            </a>
            <span v-else>
              {{ workoutExerciseLog.substitutionOne.name }}
            </span>
          </li>
          <li v-if="workoutExerciseLog.substitutionTwo">
            <a
              v-if="workoutExerciseLog.substitutionTwo.videoUrl"
              :href="workoutExerciseLog.substitutionTwo.videoUrl"
              class="substitution-url"
              target="_blank"
            >
              {{ workoutExerciseLog.substitutionTwo.name }}
            </a>
            <span v-else>
              {{ workoutExerciseLog.substitutionTwo.name }}
            </span>
          </li>
        </ul>
      </div>

      <details
        v-if="workoutExerciseLog.pastLogs.length"
        class="exercise-history"
      >
        <summary>History</summary>

        <table style="text-align: left">
          <thead>
            <tr>
              <th>Set</th>
              <th style="text-align: right">Reps</th>
              <th style="text-align: right">Weight</th>
              <th style="text-align: right">Volume</th>
            </tr>
          </thead>

          <tbody>
            <template
              v-for="(
                pastExerciseLog, pastExerciseLogIndex
              ) in workoutExerciseLog.pastLogs"
              :key="pastExerciseLog.id"
            >
              <tr>
                <td colspan="3">
                  <strong>{{ pastExerciseLog.label }}</strong>
                </td>
              </tr>
              <tr
                v-for="(setLog, setLogIndex) in pastExerciseLog.setLogs"
                :key="setLog.id"
              >
                <td>
                  {{
                    typeof setLog.order === 'undefined'
                      ? ''
                      : setLog.isWarmUp
                      ? 'Warm Up'
                      : 'Set'
                  }}
                  {{ typeof setLog.order === 'undefined' ? '' : setLog.order }}
                </td>
                <td style="text-align: right" class="font-monospace">
                  {{
                    typeof setLog.reps === 'undefined'
                      ? ''
                      : setLog.reps === null
                      ? '-'
                      : setLog.reps
                  }}
                </td>
                <td style="text-align: right" class="font-monospace">
                  <span>{{
                    typeof setLog.weight === 'undefined'
                      ? ''
                      : setLog.weight === null
                      ? '-'
                      : setLog.weight
                  }}</span>
                </td>
                <td
                  :class="[
                    'font-monospace',
                    {
                      'font-weight-700':
                        setLogIndex === pastExerciseLog.setLogs.length - 1,
                    },
                  ]"
                  style="text-align: right"
                >
                  <span>
                    {{
                      typeof setLog.volume === 'undefined'
                        ? ''
                        : setLog.volume === null
                        ? '-'
                        : setLog.volume
                    }}
                  </span>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </details>

      <div
        v-for="setLog in workoutExerciseLog.setLogs"
        :key="setLog.id"
        class="set-log"
      >
        <h3 class="set-name">
          {{ setLog.isWarmUp ? 'Warm Up' : 'Set' }}
          {{ setLog.order }}

          <small v-if="setLog.isOptional">(Optional)</small>
        </h3>

        <p
          v-if="!setLog.isWarmUp && setLog.repsRpeIntensity"
          class="rep-string"
        >
          {{ setLog.repsRpeIntensity }}
        </p>
        <p v-else-if="setLog.isWarmUp" class="rep-string">
          {{ getWarmUpPercentage(workoutExerciseLog, setLog) }}
        </p>

        <div class="input-row">
          <label
            :for="'reps_' + setLog.id"
            :class="[
              'label',
              { 'label--has-error': setLogForms[setLog.id].errors?.reps },
            ]"
          >
            <span class="label-text">Reps</span>
            <input
              :id="'reps_' + setLog.id"
              name="reps"
              type="number"
              v-model="setLogForms[setLog.id].reps"
              @input="setLogForms[setLog.id].clearErrors('reps')"
              class="input"
            />
          </label>

          <label
            :for="'weight_' + setLog.id"
            :class="[
              'label',
              { 'label--has-error': setLogForms[setLog.id].errors?.weight },
            ]"
          >
            <span class="label-text">Weight</span>
            <input
              :id="'weight_' + setLog.id"
              name="weight"
              type="number"
              v-model="setLogForms[setLog.id].weight"
              @input="setLogForms[setLog.id].clearErrors('weight')"
              class="input"
            />
          </label>

          <div
            class="button-group"
            v-if="
              setLogForms[setLog.id].isDirty &&
              !setLogForms[setLog.id].processing
            "
          >
            <button
              type="button"
              class="button"
              @click="
                setLogForms[setLog.id]
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
              class="button button--neutral"
              @click="setLogForms[setLog.id]?.reset()"
            >
              <span class="material-symbols-outlined"> close </span>
            </button>
          </div>
        </div>

        <ul v-if="setLogForms[setLog.id].errors" class="errors">
          <li
            v-for="(error, index) in setLogForms[setLog.id].errors"
            :key="`error-${setLog.id}-${index}`"
          >
            {{ error }}
          </li>
        </ul>
      </div>
    </div>

    <form
      @submit.prevent="
        submitStatusForm(
          workoutLog.status === liftStatus.Completed
            ? liftStatus.NotStarted
            : liftStatus.Completed
        )
      "
      class="complete-workout-form"
    >
      <button
        :class="[
          'button',
          {
            'button--outline button--red':
              workoutLog.status === liftStatus.Completed,
          },
        ]"
      >
        {{
          workoutLog.status === liftStatus.Completed
            ? 'Mark Workout Incomplete'
            : 'Complete Workout'
        }}
      </button>
    </form>
    <form
      v-if="
        workoutLog.status !== liftStatus.Completed &&
        workoutLog.status !== liftStatus.Skipped
      "
      @submit.prevent="submitStatusForm(liftStatus.Skipped)"
      class="complete-workout-form"
    >
      <button type="submit" class="button button--blue button--outline">
        Skip Workout
      </button>
    </form>
  </Layout>
</template>

<style scoped>
.page-title {
  display: flex;
  flex-direction: column;
  margin-block-end: var(--size-6xs);
}

.day-number {
  color: var(--color-neutral-500);
  font-size: var(--size-base);
  font-weight: 600;
}

.completed-at {
  margin-block-end: var(--size-3xs);
}

.page-header {
  margin-block-end: var(--size-5xl);
}

.exercise-details {
  margin-block-end: var(--size-base);
}

.exercise-name {
  align-items: center;
  display: flex;
  font-size: var(--size-lg);
  column-gap: var(--size-xs);
  margin-block-end: var(--size-7xs);
}

.exercise-notes {
  font-size: var(--size-sm);
  margin-block-end: var(--size-3xs);
}

.rest-string {
  font-size: var(--size-sm);
  margin-block-end: var(--size-3xs);
}

.video-url {
  align-items: center;
  background-color: transparent;
  border: 1px solid var(--color-neutral-950);
  border-radius: var(--size-base);
  font-size: var(--size-sm);
  font-weight: 500;
  display: flex;
  margin-block-end: var(--size-3xs);
  padding: var(--size-8xs) var(--size-xs);
  text-decoration: none;
  width: fit-content;
}

.substitutions {
  font-size: var(--size-sm);
  font-weight: 500;
  list-style-position: inside;
}

.substitutions li {
  font-weight: 400;
}

.video_url .material-symbols-outlined {
  font-size: var(--size-base);
  margin-inline-end: var(--size-8xs);
}

.exercise-history {
  font-size: var(--size-sm);
  margin-block-end: var(--size-base);
  margin-block-start: var(--size-base);
}

.exercise-history summary {
  font-size: var(--size-base);
}

.exercise-history table {
  margin-block-start: var(--size-3xs);
}

.past-exercise {
  margin-block-start: var(--size-3xs);
}

.exercise-history td:not(:last-child),
.exercise-history th:not(:last-child) {
  padding-right: var(--size-base);
}

.exercise-history td:not(:first-child) {
  white-space: nowrap;
  text-align: right;
}

.workout-exercise-log {
  border-radius: var(--size-base);
  padding: var(--size-base);
  margin-block-end: var(--size-5xl);
}

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

.complete-workout-form {
  margin-block-end: var(--size-5xl);
}

.complete-workout-form .button {
  width: 100%;
}
</style>
