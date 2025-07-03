<script setup>
const props = defineProps({
  workoutExerciseLog: Object,
});
</script>

<template>
  <details v-if="workoutExerciseLog.pastLogs.length" class="exercise-history">
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
          v-for="pastExerciseLog in workoutExerciseLog.pastLogs"
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
</template>

<style scoped>
.exercise-history {
  font-size: var(--size-sm);
  margin-block: var(--size-base);
}

.exercise-history summary {
  font-size: var(--size-base);
}

.exercise-history table {
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
</style>
